<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\DashboardRepository;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{

    private DashboardRepository $dashboardRepository;

    public function __construct(DashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function report(Request $request)
    {
        if (!empty($request->get('when'))) {
            $when = $request->get('when');
            $monthYear = explode('-', $when);
            $year = $monthYear[0];
            $month = $monthYear[1];
        } else {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $when = $year . '-' . $month;
        }

        $monthSum = $this->dashboardRepository->monthSum($month, $year);

        return view('dashboard.report', ['monthSum' => $monthSum,'when' => $when]);
    }

    public function ministry()
    {
        $ministries = $this->dashboardRepository->incomingMinistries(10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }

    public function coworker(Request $request)
    {
        if (!empty($request->get('when'))) {
            $when = $request->get('when');
            $monthYear = explode('-', $when);
            $year = $monthYear[0];
            $month = $monthYear[1];
        } else {
            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');
            $when = $year . '-' . $month;
        }

        $coworkers = $this->dashboardRepository->coworkersBalance($month, $year, 10);

        return view('dashboard.coworker', ['coworkers' => $coworkers, 'when' =>$when]);
    }
}
