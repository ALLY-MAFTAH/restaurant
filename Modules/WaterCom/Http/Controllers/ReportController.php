<?php

namespace Modules\Watercom\Http\Controllers;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(){
        return view('watercom::reports');
    }
}
