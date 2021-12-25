<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Type;
use Illuminate\Support\Collection;

interface TypeRepository
{
    public function updateModel(Type $type, array $data): void;

    public function all(): Collection;

    public function get(int $id);

    public function allPaginated(int $limit);
}
