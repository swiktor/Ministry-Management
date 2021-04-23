<?php

namespace App\Http\Controllers;

use App\Repository\MinistryRepository;
use Illuminate\Http\Request;

class MinistryController extends Controller
{
    private MinistryRepository $ministryRepository;

    public function __construct(MinistryRepository $repository)
    {
        $this->ministryRepository = $repository;
    }

    public function dashboard()
    {
        return view('ministry.dashboard');
    }

    public function list()
    {
        $ministries = $this->ministryRepository->allActivePaginated(10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }

    public function add()
    {
        return view('ministry.add');
    }


}
