<?php

namespace App\Http\Controllers;

use App\Repository\CoworkerRepository;
use Illuminate\Http\Request;

class CoworkerController extends Controller
{

    private CoworkerRepository $coworkerRepository;

    public function __construct(CoworkerRepository $repository)
    {
        $this->coworkerRepository = $repository;
    }

    public function list()
    {
        $coworkers = $this->coworkerRepository->allActivePaginated(10);

        return view('coworker.list', [
            'coworkers' => $coworkers,
        ]);
    }

    public function never()
    {
        return view('coworker.never');
    }

    public function add()
    {
        return view('coworker.add');
    }
}
