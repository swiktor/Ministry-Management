<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Coworker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
use App\Repository\CoworkerRepository as CoworkerRepositoryInterface;


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
            ->with('congregations')
            ->orderBy('surname')
            ->orderBy('name')
            ->where('active', 1)
            ->get();
    }

    public function allActivePaginated($congregation, int $limit = 10)
    {
        return $this->coworkerModel
            ->orderBy('surname')
            ->orderBy('name')
            ->where('congregation_id', $congregation)
            ->where('active', 1)
            ->paginate($limit);
    }

    public function get(int $id): Coworker
    {
        return $this->coworkerModel->find($id);
    }

    public function neverActive()
    {
        $ids = DB::table('coworkers_ministries')
            ->select('coworker_id')
            ->distinct()
            ->pluck('coworker_id')
            ->toArray();

        return $this->coworkerModel
            ->orderBy('surname')
            ->orderBy('name')
            ->where('active', 1)
            ->whereNotIn('id', $ids)
            ->get();
    }

    public function neverActivePaginated(int $limit = 10)
    {
        $ids = DB::table('coworkers_ministries')
            ->select('coworker_id')
            ->distinct()
            ->pluck('coworker_id')
            ->toArray();

        return $this->coworkerModel
            ->orderBy('surname')
            ->orderBy('name')
            ->where('active', 1)
            ->whereNotIn('id', $ids)
            ->paginate($limit);
    }

    public function add($data)
    {
        $coworker = new Coworker();
        $coworker->name = $data['name'];
        $coworker->surname = $data['surname'];
        $coworker->congregation_id = $data['congregation'];

        $coworker->save();
    }

    public function addToMinistry($coworkers, $ministry_id)
    {
        foreach ($coworkers ?? [] as $coworker) {
            DB::table('coworkers_ministries')->insert([
                'coworker_id' => $coworker,
                'ministry_id' => $ministry_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
