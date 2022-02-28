<?php

declare(strict_types = 1)
;

namespace App\Repository\Eloquent;

use App\Model\Team;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\TeamRepository as TeamRepositoryInterface;
use App\Repository\MinistryRepository;
use App\Model\User;

class TeamRepository implements TeamRepositoryInterface
{
    private Team $teamModel;
    private MinistryRepository $ministryRepository;

    public function __construct(Team $teamModel, MinistryRepository $ministryRepository)
    {
        $this->teamModel = $teamModel;
        $this->ministryRepository = $ministryRepository;
    }

    public function all()
    {
        return $this->teamModel
            ->orderBy('name', 'asc')
            ->with(['coworkers' => function ($query) {
            $query
                ->distinct()
                ->orderBy('surname')
                ->orderBy('name');
        }])
            ->whereHas('users', function ($q) {
            $q->where('users.id', Auth::id());
        })->paginate(10);
    }

    public function store($name)
    {
        $team = new Team();
        $team->name = $name;
        $team->save();

        return $team->id;
    }

    public function addCurrentUserToTeam($team_id, $user_id)
    {
        $team = Team::find($team_id);
        $team->users()->attach($user_id);
        $team->coworkers()->attach(User::find($user_id)->coworker_id);
    }

    public function addCoworkersToTeam($coworkers, $team_id)
    {
        $team = Team::find($team_id);

        foreach ($coworkers ?? [] as $coworker) {
            $team->coworkers()->attach($coworker);
        }

        $usersInMinistry = $this->ministryRepository->usersInMinistry($coworkers);

        foreach ($usersInMinistry ?? [] as $userInMinistry) {
            $team->users()->attach(User::where('coworker_id', $userInMinistry)->first()->id);
        }
    }

    public function edit(string $new_name, array $new_coworkers, Team $team)
    {
        $team->name = $new_name;
        $team->save();

        $team->coworkers()->sync($new_coworkers);

        $usersInMinistry = $this->ministryRepository->usersInMinistry($new_coworkers);

        foreach ($usersInMinistry ?? [] as $userInMinistry) {
            $team->users()->sync(User::where('coworker_id', $userInMinistry)->first()->id);
        }
    }

    public function destroy(Team $team)
    {
        foreach ($team->coworkers ?? [] as $coworker) {
            $team->coworkers()->detach($coworker->id);
        }

        foreach ($team->users ?? [] as $user) {
            $team->users()->detach($user->id);
        }

        $team->delete();
    }
}
