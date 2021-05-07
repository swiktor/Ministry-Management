<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\EditReport;
use App\Repository\ReportRepository;

class ReportController extends Controller
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $repository)
    {
        $this->reportRepository = $repository;
    }

    public function list(Request $request)
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

        $reports = $this->reportRepository->allPaginated($month, $year, 10);

        return view('report.list', [
            'ministries' => $reports,
            'when' => $when
        ]);
    }

    public function edit(EditReport $request)
    {
        $data = $request->validated();
        $this->reportRepository->edit($data);

        return redirect()
            ->route('report.list')
            ->with('success', 'Pomyślenie zmieniono sprawozdanie');
    }

    public function editForm(int $id)
    {
        $report = $this->reportRepository->get($id);
        return view('report.edit',['report'=> $report]);
    }

}
