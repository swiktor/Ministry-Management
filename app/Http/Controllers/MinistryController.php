<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function dashboard()
    {
        return view('ministry.dashboard');
    }

    public function list()
    {
        return view('ministry.list');
    }

    public function add()
    {
        return view('ministry.add');
    }


}
