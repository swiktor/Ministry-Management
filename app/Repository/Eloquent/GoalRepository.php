<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Goal;
use Illuminate\Support\Collection;
use App\Repository\GoalRepository as GoalRepositoryInterface;

class GoalRepository implements GoalRepositoryInterface
{
    private Goal $goalModel;

    public function __construct(Goal $goalModel)
    {
        $this->goalModel = $goalModel;
    }

    public function all(): Collection
    {
        return $this->goalModel
            ->orderBy('quantum')
            ->orderBy('name')
            ->get();
    }
}
