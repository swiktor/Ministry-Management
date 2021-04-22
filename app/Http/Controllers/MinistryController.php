<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MinistryController extends Controller
{
    public function list()
    {
        return view('ministry.list');
    }
}
