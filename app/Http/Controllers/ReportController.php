<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function dashboard()
    {
        return view('ministry.dashboard');
    }

    public function list()
    {
        return view('report.list');
    }

    public function add()
    {
        return view('report.add');
    }


}
