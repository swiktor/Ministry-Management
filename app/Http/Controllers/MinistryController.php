<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repository\CoworkerRepository;
use App\Repository\MinistryRepository;
use App\Repository\TypeRepository;

class MinistryController extends Controller
{
    private MinistryRepository $ministryRepository;
    private CoworkerRepository $coworkerRepository;
    private TypeRepository $typeRepository;

    public function __construct(MinistryRepository $ministryRepository, CoworkerRepository $coworkerRepository, TypeRepository $typeRepository)
    {
        $this->ministryRepository = $ministryRepository;
        $this->coworkerRepository = $coworkerRepository;
        $this->typeRepository = $typeRepository;
    }

    public function dashboard()
    {
        return view('ministry.dashboard');
    }

    public function list()
    {
        $ministries = $this->ministryRepository->allPaginated(10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }

    public function addForm()
    {
        $coworkers = $this->coworkerRepository->allActive();
        $types = $this->typeRepository->all();

        return view('ministry.add', [
            'coworkers' => $coworkers,
            'types' => $types,
        ]);
    }

    public function add(Request $request)
    {
        $data = $request->toArray();
        dd($data);
    }

    public function listForCoworker(int $id)
    {
        $ministries = $this->ministryRepository->listForCoworkerPaginated($id, 10);

        return view('ministry.list', [
            'ministries' => $ministries,
        ]);
    }
}
