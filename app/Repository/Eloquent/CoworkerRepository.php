<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Coworker;
use App\Repository\CoworkerRepository as CoworkerRepositoryInterface;
use Illuminate\Support\Collection;


class CoworkerRepository implements CoworkerRepositoryInterface
{
    private Coworker $coworkerModel;

    public function __construct(Coworker $coworkerModel)
    {
        $this->coworkerModel = $coworkerModel;
    }

    public function updateModel(Coworker $coworker, array $data): void
    {
        $coworker->name = $data['name'] ?? $coworker->name;
        $coworker->surname = $data['surname'] ?? $coworker->surname;
        $coworker->active = $data['active'] ?? $coworker->active;

        $coworker->save();
    }

    public function allActive(): Collection
    {
        return $this->coworkerModel
            ->orderBy('surname')
            ->orderBy('name')
            ->where('active', 1)
            ->get();
    }

    public function allActivePaginated(int $limit = 10)
    {
        return $this->coworkerModel
            ->orderBy('surname')
            ->orderBy('name')
            ->where('active', 1)
            ->paginate($limit);
    }

    public function get(int $id): Coworker
    {
        return $this->coworkerModel->find($id);
    }
}
