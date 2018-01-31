<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RFMChartController extends Controller
{
    public function index()
    {
        return view('rfm.index');
    }
}
