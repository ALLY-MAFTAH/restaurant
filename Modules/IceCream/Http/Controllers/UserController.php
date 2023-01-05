<?php

namespace Modules\Icecream\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use App\Models\Role;
use App\Models\Icecream;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = Role::where('status', 1)->get();

        $icecreams = Icecream::all();

        return view('icecream::users.index', compact('icecreams', 'roles'));
    }
    public function showUser(Request $request, Icecream $icecream)
    {

        $roles = Role::where('status', 1)->get();

        return view('icecream::users.show', compact('icecream', 'roles'));
    }
    public function postUser(Request $request)
    {
        try {
            $attributes = $request->validate([
                'name' => 'required',
                'email' => ['required', 'unique:icecreams,email,NULL,id,deleted_at,NULL'],
                'role_id' => ['required', 'exists:roles,id'],
            ]);

            $attributes['password'] = bcrypt('12312345');
            $attributes['status'] = true;

            $icecream = Icecream::create($attributes);

            $role = Role::find($request->role_id);
            $role->icecreams()->save($icecream);
            ActivityLogHelper::addToLog('Added new icecream user: ' . $icecream->name);
        } catch (QueryException $th) {
            notify()->error('Failed to add icecream user. "' . $request->name . '" already exists.');
            return back();
        }

        notify()->success('You have successful added new icecream user');
        return redirect()->back();
    }

    public function putUser(Request $request, Icecream $icecream)
    {

        session()->flash('user_id', $icecream->id);
        $attributes = $request->validateWithBag('update', [
            'name' => 'required',
            'email' => ['sometimes', Rule::unique('icecreams')->ignore($icecream->id)->whereNull('deleted_at')],
            'role_id' => ['sometimes', 'exists:roles,id'],
        ]);

        $icecream->update($attributes);
        ActivityLogHelper::addToLog('Updated icecream user: ' . $icecream->name);

        notify()->success('You have successful edited icecream user');
        return back();
    }

    public function toggleStatus(Request $request, Icecream $icecream)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $icecream->update($attributes);
        ActivityLogHelper::addToLog('Switched icecream user ' . $icecream->name . ' status ');

        notify()->success('You have successfully updated icecream user status');
        return back();
    }
    public function deleteUser(Request $request, Icecream $icecream)
    {

        $itsName = $icecream->name;
        $icecream->delete();
        ActivityLogHelper::addToLog('Deleted icecream user: ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
