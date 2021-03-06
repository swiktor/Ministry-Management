<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Ministry;
use Illuminate\Support\Collection;

interface MinistryRepository
{
    public function updateModel(Ministry $ministry, array $data): void;

    public function all(): Collection;

    public function get(int $id);

    public function allPaginated($month, $year, $limit);

    public function listForCoworker(int $id);

    public function listForCoworkerPaginated(int $id, int $limit);

    public function add($data);

    public function setInGoogleCalendar($ministry_id, $user);

    public function deleteFromGoogleCalendar($ministry_id);

    public function compare($data);

    public function edit($data);

    public function deleteCoworkersFromMinistry(Ministry $ministry_db, $coworkers_id_db);

    public function delete(int $id);

    public function ministryProposalForUser($coworkers, $ministry_id, $coworkerRepository, $reportRepository);

    public function ministryProposalList($user_id, $limit);

    public function ministryProposalAccept($ministry_id, $reportRepository);

    public function ministryProposalReject($ministry_id);

    public function usersInMinistry($coworkers);
}
