<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditReport;
use App\Repository\ReportRepository;

class ReportController extends Controller
{
    private ReportRepository $reportRepository;

    public function __construct(ReportRepository $repository)
    {
        $this->reportRepository = $repository;
    }


    public function dashboard()
    {
        return view('report.dashboard');
    }

    public function list()
    {
        $reports = $this->reportRepository->allPaginated(10);

        return view('report.list', [
            'ministries' => $reports,
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
