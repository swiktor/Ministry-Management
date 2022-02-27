<?php

namespace App\Http\Controllers;

use App\Model\Coworker;
use App\Http\Requests\AddCoworker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        if (!empty($request->get('congregation'))) {
            $congregation = $request->get('congregation');
        }
        else {
            $congregation = Auth::user()->congregation_id;
        }

        $coworkers = $this->coworkerRepository->allActivePaginated($congregation, 10);
        $congregations = $this->congregationRepository->all();

        return view('coworker.index', [
            'coworkers' => $coworkers,
            'congregations' => $congregations,
            'congregation_selected' => $congregation,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $congregations = $this->congregationRepository->all();
        return view('coworker.create', [
            'congregations' => $congregations
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AddCoworker  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCoworker $request)
    {
        $data = $request->validated();

        $this->coworkerRepository->add($data);

        return redirect()
            ->route('coworker.index')
            ->with('success', 'Dodano nowego współpracownika');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Coworker  $coworker
     * @return \Illuminate\Http\Response
     */
    public function show(Coworker $coworker)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Coworker  $coworker
     * @return \Illuminate\Http\Response
     */
    public function edit(Coworker $coworker)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Coworker  $coworker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coworker $coworker)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Coworker  $coworker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coworker $coworker)
    {
    //
    }

    public function never()
    {
        $coworkers = $this->coworkerRepository->neverActivePaginated(10);

        return view('coworker.never', [
            'coworkers' => $coworkers,
        ]);
    }

    public function linkForm()
    {
        $user_coworker_id = 0;

        if (Auth::user()->coworker_id != null) {
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
