<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Requests\EditReport;
use App\Repository\GoalRepository;
use App\Repository\ReportRepository;

class ReportController extends Controller
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $reportRepository)
    {
        $this->reportRepository = $reportRepository;
    }

    public function edit(EditReport $request)
    {
        $data = $request->validated();
        $this->reportRepository->edit($data);

        return redirect()
            ->route('ministry.list')
            ->with('success', 'Pomyślenie zmieniono sprawozdanie');
    }

    public function editForm(int $id)
    {
        $report = $this->reportRepository->get($id);
        return view('report.edit', ['report' => $report]);
    }
}
