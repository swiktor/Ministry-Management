<?php

namespace App\Http\Controllers;

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

    public function list()
    {
        $teams = $this->teamRepository->all();
        return view('team.list', ['teams' => $teams]);
    }

    public function addForm()
    {
        $coworkers = $this->coworkerRepository->allActive();

        return view('team.add', [
            'coworkers' => $coworkers,
        ]);
    }

    public function add(Request $request)
    {
        $name = $request->input('name');
        $coworkers = $request->input('coworker');

        $team_id = $this->teamRepository->add($name);
        $this->teamRepository->addUserToTeam($team_id, Auth::id());
        $this->coworkerRepository->addCoworkersToTeam($coworkers, $team_id);

        return redirect()
            ->route('team.list')
            ->with('success', 'Pomyślnie dodano nową grupę');
    }

    public function editForm()
    {

    }
}
