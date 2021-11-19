<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Congregation;
use Illuminate\Support\Collection;
use App\Repository\CongregationRepository as CongregationRepositoryInterface;

class CongregationRepository implements CongregationRepositoryInterface
{
    private Congregation $congregationModel;

    public function __construct(Congregation $congregationModel)
    {
        $this->congregationModel = $congregationModel;
    }

    public function all(): Collection
    {
        return $this->congregationModel
            ->orderBy('name')
            ->get();
    }
}
