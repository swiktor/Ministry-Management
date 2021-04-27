<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Coworker;
use App\Model\Ministry;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\MinistryRepository as MinistryRepositoryInterface;


class MinistryRepository implements MinistryRepositoryInterface
{
    private Ministry $ministryModel;
    private Coworker $coworkerModel;

    public function __construct(Ministry $ministryModel, Coworker $coworkerModel)
    {
        $this->ministryModel = $ministryModel;
        $this->coworkerModel = $coworkerModel;
    }

    public function updateModel(Ministry $ministry, array $data): void
    {
        $ministry->user_id = $data['user_id'] ?? $ministry->user_id;
        $ministry->type_id = $data['type_id'] ?? $ministry->type_id;
        $ministry->when = $data['when'] ?? $ministry->when;

        $ministry->save();
    }

    public function all(): Collection
    {
        return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->where('user_id', Auth::id())
            ->orderBy('when', 'desc')
            ->get();
    }

    public function allPaginated(int $limit = 10)
    {
        return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->where('user_id', Auth::id())
            ->orderBy('when', 'desc')
            ->paginate($limit);
    }

    public function get(int $id): Ministry
    {
        return $this->ministryModel->find($id);
    }

    public function listForCoworker(int $id)
    {
        return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->where('user_id', Auth::id())
            ->orderBy('when', 'desc')
            ->get();
    }

    public function listForCoworkerPaginated(int $id, int $limit = 10)
    {
        $ministry_ids = array_column(DB::table('coworkerministries')
        ->select('ministry_id')
        ->where('coworker_id', $id)
        ->get()
        ->toArray(), 'ministry_id');

        return $this->ministryModel
            ->with('types')
            ->with(['coworkers' => function ($query) use ($id) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->where('user_id', Auth::id())
            ->whereIn('id', $ministry_ids)
            ->orderBy('when', 'desc')
            ->paginate($limit);
    }

    public function add($data)
    {
        $ministry = new Ministry();
        $ministry->type_id = $data['type'];
        $ministry->when = $data['when'];
        $ministry->user_id = Auth::id();
        $ministry->save();

        return $ministry->id;
    }
}
