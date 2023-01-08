<?php

namespace Modules\Watercom\Http\Controllers;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

class WatercomReportController extends Controller
{
    public function index(){
        return view('watercom::reports');
    }
}
