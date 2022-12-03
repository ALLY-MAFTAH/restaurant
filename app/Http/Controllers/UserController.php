<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

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
        $roles=Role::where('status',1)->get();

        $users = User::all();

        return view('users.index', compact('users','roles'));
    }
    public function showUser(Request $request, User $user)
    {

        $users = User::where('status', 1)->get();

        return view('users.show', compact('user', 'users'));
    }
    public function postUser(Request $request)
    {

        notify()->success('You have successful added user');

        return Redirect::back();
    }
    public function putUser(Request $request, User $user)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'quantity' => 'required',
            'unit' => 'required',
            'cost' => 'required',
        ]);

        $user->update($attributes);

        notify()->success('You have successful edited user');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, User $user)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $user->update($attributes);

        notify()->success('You have successfully updated user status');
        return back();
    }
    public function deleteUser(Request $request, User $user)
    {

        $itsName = $user->name;
        $user->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
