<?php

namespace App\Http\Controllers;

use App\Model\Team;
use Illuminate\Http\Request;
use App\Repository\TeamRepository;
use Illuminate\Support\Facades\Auth;
use App\Repository\CoworkerRepository;

class TeamController extends Controller
{
    private TeamRepository $teamRepository;
    private CoworkerRepository $coworkerRepository;
    public function __construct(TeamRepository $teamRepository, CoworkerRepository $coworkerRepository)
    {
        $this->teamRepository = $teamRepository;
        $this->coworkerRepository = $coworkerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $teams = $this->teamRepository->all();
        return view('team.index', ['teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $coworkers = $this->coworkerRepository->allActive();

        return view('team.create', [
            'coworkers' => $coworkers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\View\View
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $coworkers = $request->input('coworker');

        $team_id = $this->teamRepository->add($name);
        $this->teamRepository->addUserToTeam($team_id, Auth::id());
        $this->coworkerRepository->addCoworkersToTeam($coworkers, $team_id);

        return redirect()
            ->route('team.index')
            ->with('success', 'Pomyślnie dodano nową grupę');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
    //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
    //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
    //
    }
}
