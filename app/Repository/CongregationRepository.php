<?php

declare(strict_types=1);

namespace App\Repository;

use Illuminate\Support\Collection;

interface CongregationRepository
{
    public function all(): Collection;

    public function allPaginated($limit);

    public function add($data);
}
