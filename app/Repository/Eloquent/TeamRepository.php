<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Team;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\TeamRepository as TeamRepositoryInterface;

class TeamRepository implements TeamRepositoryInterface
{
    private Team $teamModel;

    public function __construct(Team $teamModel)
    {
        $this->teamModel = $teamModel;
    }

    public function all()
    {
        return $this->teamModel
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->with(['users' => function ($query) {
                $query
                    ->where('user_id', Auth::id());
            }])
            ->orderBy('name', 'asc')
            ->paginate(10);
    }

    public function add($name)
    {
        $team = new Team();
        $team->name = $name;
        $team->save();

        return $team->id;
    }

    public function addUserToTeam($team_id, $user_id)
    {
        DB::table('users_teams')->insert([
            'user_id' => $user_id,
            'team_id' => $team_id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
