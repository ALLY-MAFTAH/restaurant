<?php


namespace App\Helpers;

use App\Models\ActivityLog;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLogHelper
{

    public static function addToLog($subject)
    {

        $log = [];

        if (Auth::guard('watercom')->check())
            $log['module'] = 'watercom';
        elseif (Auth::guard('icecream')->check())
            $log['module'] = 'icecream';
        else
            $log['module'] = 'gas';
        $log['subject'] = $subject;
        $log['time'] = Carbon::now();
        $log['url'] = Request::fullUrl();
        $log['method'] = Request::method();
        $log['ip'] = Request::ip();
        $log['agent'] = Request::header('user-agent');
        $log['user_id'] = auth()->check() ? auth()->user()->id : 1;
        ActivityLog::create($log);
    }

    public static function logActivityLists()
    {
        return ActivityLog::latest()->get();
    }
}
