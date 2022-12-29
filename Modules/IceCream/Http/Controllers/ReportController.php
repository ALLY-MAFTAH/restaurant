<?php

namespace Modules\IceCream\Http\Controllers;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        return view('icecream::reports');
    }
}
