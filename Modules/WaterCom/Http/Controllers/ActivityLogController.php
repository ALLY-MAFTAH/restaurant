<?php

namespace Modules\Watercom\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
     /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:watercom');
    }
    public function index()
    {
        $logs = ActivityLogHelper::logActivityLists();

        return view('watercom::activity_logs', compact('logs'));
    }

    public function postLog()
    {
        ActivityLogHelper::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }
}
