<?php

namespace Modules\Icecream\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $roles = Role::where('status', 1)->get();

        $users = User::all();

        return view('icecream::users.index', compact('users', 'roles'));
    }
    public function showUser(Request $request, User $user)
    {

        $roles = Role::where('status', 1)->get();

        return view('icecream::users.show', compact('user', 'roles'));
    }
    public function postUser(Request $request)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'email' => ['required', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'role_id' => ['required', 'exists:roles,id'],
        ]);

        $role_id = $request->role_id;

        $attributes['password'] = bcrypt('TangaRaha');
        $attributes['status'] = true;

        $user = User::create($attributes);

        $role = Role::find($role_id);
        $role->users()->save($user);
        ActivityLogHelper::addToLog('Added new user: '.$user->name);

        notify()->success('You have successful added new user');
        return redirect()->back();
    }

    public function putUser(Request $request, User $user)
    {

        session()->flash('user_id', $user->id);
        $attributes = $this->validateWithBag('update', $request, [
            'name' => 'required',
            'email' => ['sometimes', Rule::unique('users')->ignore($user->id)->whereNull('deleted_at')],
            'role_id' => ['sometimes', 'exists:roles,id'],
        ]);

        $user->update($attributes);
        ActivityLogHelper::addToLog('Updated user: '.$user->name);

        notify()->success('You have successful edited user');
        return back();
    }

    public function toggleStatus(Request $request, User $user)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $user->update($attributes);
        ActivityLogHelper::addToLog('Switched user '.$user->name.' status ');

        notify()->success('You have successfully updated user status');
        return back();
    }
    public function deleteUser(Request $request, User $user)
    {

        $itsName = $user->name;
        $user->delete();
        ActivityLogHelper::addToLog('Deleted user: '.$itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
