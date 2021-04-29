<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\DashboardRepository;

class DashboardController extends Controller
{

    private DashboardRepository $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function ministry()
    {
        return view('dashboard.ministry');
    }

    public function report()
    {
        return view('dashboard.report');
    }

}
