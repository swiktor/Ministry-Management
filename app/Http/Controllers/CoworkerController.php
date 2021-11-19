<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCoworker;
use App\Repository\CongregationRepository;
use App\Repository\CoworkerRepository;

class CoworkerController extends Controller
{
    private CoworkerRepository $coworkerRepository;
    private CongregationRepository $congregationRepository;

    public function __construct(CoworkerRepository $coworkerRepository, CongregationRepository $congregationRepository)
    {
        $this->coworkerRepository = $coworkerRepository;
        $this->congregationRepository = $congregationRepository;
    }

    public function list(Request $request)
    {
        if (!empty($request->get('congregation'))) {
            $congregation = $request->get('congregation');
        } else {
            $congregation = "1";
        }

        $coworkers = $this->coworkerRepository->allActivePaginated($congregation, 10);
        $congregations = $this->congregationRepository->all();

        return view('coworker.list', [
            'coworkers' => $coworkers,
            'congregations' => $congregations,
            'congregation_selected' => $congregation,
        ]);
    }

    public function never()
    {
        $coworkers = $this->coworkerRepository->neverActivePaginated(10);

        return view('coworker.never', [
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
        $congregations = $this->congregationRepository->all();
        return view('coworker.add', [
            'congregations' => $congregations
        ]);
    }
}
