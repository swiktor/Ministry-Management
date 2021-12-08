<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddCoworker;
use Illuminate\Support\Facades\Auth;
use App\Repository\CoworkerRepository;
use App\Repository\CongregationRepository;

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
            $congregation = Auth::user()->congregation_id;
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

    public function addForm()
    {
        $congregations = $this->congregationRepository->all();
        return view('coworker.add', [
            'congregations' => $congregations
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

    public function linkForm()
    {
        $user_coworker_id = 0;

        if (Auth::user()->coworker_id != null)
        {
            $user_coworker_id = Auth::user()->coworker_id;
        }

        $coworkers = $this->coworkerRepository->allActive();
        return view('coworker.link', [
            'coworkers' => $coworkers,
            'user_coworker_id' => $user_coworker_id,
        ]);
    }

    public function link(Request $request)
    {
        $user = Auth::user();
        $user->coworker_id = $request->get('coworker');
        $user->save();

        return redirect()
            ->route('dashboard.ministry')
            ->with('success', 'Pomyślnie połączono konto');
    }
}
