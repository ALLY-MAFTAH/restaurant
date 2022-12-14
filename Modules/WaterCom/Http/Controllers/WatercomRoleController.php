<?php

namespace Modules\Watercom\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class WatercomRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('watercom::roles.index', compact('roles'));
    }
    public function showRole(Request $request, Role $role)
    {

        $users = User::where('status', 1)->get();

        return view('watercom::roles.show', compact('role', 'users'));
    }
    public function postRole(Request $request)
    {

        $attributes = $request->validate( [
            'name' => 'required',
            'description' => 'required',
        ]);

        $attributes['status'] = true;
        $role = Role::create($attributes);
        ActivityLogHelper::addToLog('Added role ' . $role->name);

        notify()->success('You have successful added role');

        return Redirect::back();
    }
    public function putRole(Request $request, Role $role)
    {
        $attributes = $request->validate( [
            'name' => 'required',
            'description' => 'required',

        ]);

        $role->update($attributes);
        ActivityLogHelper::addToLog('Updated role ' . $role->name);

        notify()->success('You have successful edited role');
        return redirect()->back();
    }
    public function toggleStatus(Request $request, Role $role)
    {

        $attributes = $request->validate( [
            'status' => ['required', 'boolean'],
        ]);

        $role->update($attributes);
        ActivityLogHelper::addToLog('Switched role '.$role->name.' status ');

        notify()->success('You have successfully updated role status');
        return back();
    }
    public function deleteRole(Request $request, Role $role)
    {

        $itsName = $role->name;
        $role->delete();
        ActivityLogHelper::addToLog('Deleted role '.$itsName);

        notify()->success('You have successful deleted ' . $itsName . '.');
        return back();
    }
}
