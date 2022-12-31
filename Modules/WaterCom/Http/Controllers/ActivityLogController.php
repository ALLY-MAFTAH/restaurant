<?php

namespace Modules\Icecream\Http\Controllers;
use Illuminate\Routing\Controller;

use App\Helpers\ActivityLogHelper;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLogHelper::logActivityLists();

        return view('icecream::activity_logs', compact('logs'));
    }

    public function postLog()
    {
        ActivityLogHelper::addToLog('My Testing Add To Log.');
        dd('log insert successfully.');
    }
}
