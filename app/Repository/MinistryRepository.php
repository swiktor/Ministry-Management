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

    public function allPaginated(int $limit);

    public function listForCoworker(int $id);

    public function listForCoworkerPaginated(int $id, int $limit);
}
