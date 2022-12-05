<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }
    public function showRole(Request $request, Role $role)
    {

        $users = User::where('status', 1)->get();

        return view('roles.show', compact('role', 'users'));
    }
    public function postRole(Request $request)
    {

        $attributes = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
        ]);

        $attributes['status'] = true;
        $role = Role::create($attributes);

        notify()->success('You have successful added role');

        return Redirect::back();
    }
    public function putRole(Request $request, Role $role)
    {
        $attributes = $this->validate($request, [
            'name' => 'required',
            'description' => 'required',

        ]);

        $role->update($attributes);

        notify()->success('You have successful edited role');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Role $role)
    {

        $attributes = $this->validate($request, [
            'status' => ['required', 'boolean'],
        ]);

        $role->update($attributes);

        notify()->success('You have successfully updated role status');
        return back();
    }
    public function deleteRole(Request $request, Role $role)
    {

        $itsName = $role->name;
        $role->delete();

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
