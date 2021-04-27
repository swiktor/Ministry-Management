<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Coworker;
use Illuminate\Support\Collection;

interface CoworkerRepository
{
    public function updateModel(Coworker $coworker, array $data): void;

    public function allActive(): Collection;

    public function get(int $id);

    public function allActivePaginated(int $limit);

    public function neverActive();

    public function neverActivePaginated(int $limit);
}
