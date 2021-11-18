<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Repository\GoalRepository;
use App\Repository\DashboardRepository;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    private DashboardRepository $dashboardRepository;
    private GoalRepository $goalRepository;

    public function __construct(DashboardRepository $dashboardRepository, GoalRepository $goalRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
        $this->goalRepository = $goalRepository;
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
        $goals = $this->goalRepository->all();
        $goal_id = Auth::user()->goal_id;

        if ($request['goal'] !== null) {
            $goal_id = (int) $request['goal'];
            $user = Auth::user();
            $user->goal_id = $goal_id;
            $user->save();

            return redirect()
                ->route('dashboard.report', ['monthSum' => $monthSum, 'when' => $when, 'goals' => $goals, 'goal_id'=> $goal_id])
                ->with('success', 'Pomyślnie zmieniono cel godzinowy!');
        }

        return view('dashboard.report', ['monthSum' => $monthSum, 'when' => $when, 'goals' => $goals, 'goal_id' => $goal_id]);
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

        return view('dashboard.coworker', ['coworkers' => $coworkers, 'when' => $when]);
    }
}
