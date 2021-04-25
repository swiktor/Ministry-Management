<?php

namespace App\Http\Controllers;

use App\Repository\ReportRepository;
use Illuminate\Http\Request;

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

    public function add()
    {
        return view('report.add');
    }
}
