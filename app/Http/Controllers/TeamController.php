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

        $team_id = $this->teamRepository->store($name);
        $this->teamRepository->addCurrentUserToTeam($team_id, Auth::id());
        $this->teamRepository->addCoworkersToTeam($coworkers, $team_id);

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
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Team $team)
    {
        $team_db = Team::where('id', $team->id)->first();
        $coworkers = $this->coworkerRepository->allActive();

        return view('team.edit', [
            'team' => $team_db,
            'coworkers' => $coworkers,
        ]);

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
        $new_name = $request->name;
        $new_coworkers = $request->coworkers;
        $this->teamRepository->edit($new_name, $new_coworkers, $team);

        return redirect()
            ->route('team.index')
            ->with('success', 'Pomyślnie zaktualizowano grupę');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $this->teamRepository->destroy($team);

        return redirect()
            ->route('team.index')
            ->with('success', 'Pomyślnie usunięto grupę');
    }

    public function ministryWithTeam(Team $team)
    {
        $coworkers = $this->coworkerRepository->allActive();

        return view('ministry.create', [
            'coworkers' => $coworkers,
            'title' => 'Umów grupową',
            'team' => $team,

        ]);
    }
}
