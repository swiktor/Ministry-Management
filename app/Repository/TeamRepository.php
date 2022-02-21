<?php

declare(strict_types=1);

namespace App\Repository;

interface TeamRepository
{
    public function all();
    public function add($name);
    public function addUserToTeam($team_id, $user_id);
}
