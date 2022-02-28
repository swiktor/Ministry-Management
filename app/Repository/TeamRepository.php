<?php

declare(strict_types = 1)
;

namespace App\Repository;

use App\Model\Team;

interface TeamRepository
{
    public function all();
    public function store($name);
    public function addCurrentUserToTeam($team_id, $user_id);
    public function addCoworkersToTeam($coworkers, $team_id);
    public function edit(string $new_name, array $new_coworkers, Team $team);
    public function destroy(Team $team);


}
