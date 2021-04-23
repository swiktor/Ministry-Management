<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Ministry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\Repository\MinistryRepository as MinistryRepositoryInterface;


class MinistryRepository implements MinistryRepositoryInterface
{
    private Ministry $ministryModel;

    public function __construct(Ministry $ministryModel)
    {
        $this->ministryModel = $ministryModel;
    }

    public function updateModel(Ministry $ministry, array $data): void
    {
        $ministry->user_id = $data['user_id'] ?? $ministry->user_id;
        $ministry->type_id = $data['type_id'] ?? $ministry->type_id;
        $ministry->when = $data['when'] ?? $ministry->when;

        $ministry->save();
    }

    public function allActive(): Collection
    {
        return $this->ministryModel
            ->where('user_id',Auth::id())
            ->orderBy('when')
            ->get();
    }

    public function allActivePaginated(int $limit = 1)
    {
        return $this->ministryModel
            ->where('user_id', Auth::id())
            ->orderBy('when')
            ->paginate($limit);
    }

    public function get(int $id): Ministry
    {
        return $this->ministryModel->find($id);
    }
}
