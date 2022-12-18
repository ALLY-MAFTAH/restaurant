<?php

namespace App\Http\Controllers;

use anlutro\LaravelSettings\Facades\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
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

    public function index(Request $request)
    {
        $settings = Setting::all();

        return view('settings', compact('settings'));
    }

    public function postSetting(Request $request)
    {
        Setting::set($request->key, $request->value);
        Setting::save();

        notify()->success('New settings added successfully');
        return back();

    }
    public function putSetting(Request $request)
    {
        setting([$request->key => ""])->save();

        notify()->success('Settings updated successfully');
        return back();
    }
    public function deleteSetting(Request $request)
    {
        Setting::set($request->key,"");
        Setting::save();

        notify()->success('Settings deleted successfully');
        return back();
    }
}
