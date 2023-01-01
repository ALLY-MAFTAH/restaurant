<?php

namespace Modules\Watercom\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use App\Models\Role;
use App\Models\Watercom;
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

        $watercoms = Watercom::all();

        return view('watercom::users.index', compact('watercoms', 'roles'));
    }
    public function showUser(Request $request, Watercom $watercom)
    {

        $roles = Role::where('status', 1)->get();

        return view('watercom::users.show', compact('watercom', 'roles'));
    }
    public function postUser(Request $request)
    {
        try {
            $attributes = $request->validate([
                'name' => 'required',
                'email' => ['required', 'unique:watercoms,email,NULL,id,deleted_at,NULL'],
                'role_id' => ['required', 'exists:roles,id'],
            ]);

            $attributes['password'] = bcrypt('12312345');
            $attributes['status'] = true;

            $watercom = Watercom::create($attributes);

            $role = Role::find($$request->role_id);
            $role->watercoms()->save($watercom);
            ActivityLogHelper::addToLog('Added new watercom user: ' . $watercom->name);
        } catch (QueryException $th) {
            notify()->error('Failed to add watercom user. "' . $request->name . '" already exists.');
            return back();
        }

        notify()->success('You have successful added new watercom user');
        return redirect()->back();
    }

    public function putUser(Request $request, Watercom $watercom)
    {

        session()->flash('user_id', $watercom->id);
        $attributes = $request->validateWithBag('update', [
            'name' => 'required',
            'email' => ['sometimes', Rule::unique('watercoms')->ignore($watercom->id)->whereNull('deleted_at')],
            'role_id' => ['sometimes', 'exists:roles,id'],
        ]);

        $watercom->update($attributes);
        ActivityLogHelper::addToLog('Updated watercom user: ' . $watercom->name);

        notify()->success('You have successful edited watercom user');
        return back();
    }

    public function toggleStatus(Request $request, Watercom $watercom)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $watercom->update($attributes);
        ActivityLogHelper::addToLog('Switched watercom user ' . $watercom->name . ' status ');

        notify()->success('You have successfully updated watercom user status');
        return back();
    }
    public function deleteUser(Request $request, Watercom $watercom)
    {

        $itsName = $watercom->name;
        $watercom->delete();
        ActivityLogHelper::addToLog('Deleted watercom user: ' . $itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
