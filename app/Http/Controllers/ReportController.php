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
        return view('ministry.dashboard');
    }

    public function list()
    {

        $reports = $this->reportRepository->allActivePaginated(10);
        dd($reports->toSql());

        return view('report.list');
    }

    public function add()
    {
        return view('report.add');
    }
}
