<?php

namespace Modules\Gas\Http\Controllers;
use Illuminate\Routing\Controller;

use anlutro\LaravelSettings\Facades\Setting;
use App\Helpers\ActivityLogHelper;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:gas');
    }

    public function index(Request $request)
    {
        $settings = Setting::all();

        return view('gas::settings', compact('settings'));
    }

    public function postSetting(Request $request)
    {
        Setting::set($request->key, $request->value);
        Setting::save();
        ActivityLogHelper::addToLog('Added new setting pair');

        notify()->success('New settings added successfully');
        return back();
    }
    public function putSetting(Request $request)
    {
        setting([$request->key => ""])->save();

        ActivityLogHelper::addToLog('Updated setting: ' . $request->key);
        notify()->success('Settings updated successfully');
        return back();
    }
    public function deleteSetting(Request $request)
    {
        Setting::set($request->key, "");
        Setting::save();
        ActivityLogHelper::addToLog('Deleted setting pair');

        notify()->success('Settings deleted successfully');
        return back();
    }
}
