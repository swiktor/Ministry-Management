<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCoworker;
use App\Model\Coworker;
use App\Repository\CoworkerRepository;

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
        $coworkers = $this->coworkerRepository->neverActivePaginated(10);

        return view('coworker.list', [
            'coworkers' => $coworkers,
        ]);
    }

    public function add(AddCoworker $request)
    {
        $data = $request->validated();

        $this->coworkerRepository->add($data);

        return redirect()
            ->route('coworker.list')
            ->with('success', 'Dodano nowego współpracownika');
    }

    public function addForm()
    {
        return view('coworker.add');
    }
}
