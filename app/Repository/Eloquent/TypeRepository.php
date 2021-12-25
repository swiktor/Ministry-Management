<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Type;
use Illuminate\Support\Collection;
use App\Repository\TypeRepository as TypeRepositoryInterface;

class TypeRepository implements TypeRepositoryInterface
{
    private Type $typeModel;

    public function __construct(Type $typeModel)
    {
        $this->typeModel = $typeModel;
    }

    public function updateModel(Type $type, array $data): void
    {
        $type->name = $data['name'] ?? $type->name;
        $type->duration = $data['duration'] ?? $type->duration;

        $type->save();
    }

    public function all(): Collection
    {
        return $this->typeModel
            ->orderBy('duration', 'asc')
            ->get();
    }

    public function allPaginated(int $limit = 10)
    {
        return $this->typeModel
            ->orderBy('duration', 'asc')
            ->paginate($limit);
    }

    public function get(int $id): Type
    {
        return $this->typeModel->find($id);
    }

}
