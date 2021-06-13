<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Coworker;
use App\Model\Ministry;
use App\Model\Report;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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

    public function allPaginated($month, $year, $limit)
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
            ->whereRaw("id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
            ->orderBy('when', 'asc')
            ->paginate($limit);
    }

    public function get(int $id)
    {
        return $this->ministryModel
            ->with('coworkers')
            ->where('id', $id)
            ->get();
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
        $ministry_ids = array_column(DB::table('coworkers_ministries')
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

    public function compare(Ministry $ministry_form)
    {
        $ministry_db =
            $this->ministryModel
            ->with('coworkers')
            ->where('id', $ministry_form['id'])
            ->get();

        $ministry_db = $ministry_db[0];

        $coworkers_id_form = $ministry_form['coworkers'];
        $coworkers_id_db = [];

        foreach ($ministry_db['coworkers'] as $coworker) {
            array_push($coworkers_id_db, $coworker['id']);
        }

        if (
            $ministry_form['id'] == (int) $ministry_db['id']
            && $ministry_form['type_id'] == (int) $ministry_db['type_id']
            && $ministry_form['when'] == $ministry_db['when']
            && $ministry_form['user_id'] == $ministry_db['user_id']
            && $coworkers_id_form == $coworkers_id_db
        ) {
            return 0;
        } else {
            return 1;
        }
    }

    public function edit(Ministry $ministry_form)
    {
        $ministry_db =
            $this->ministryModel
            ->with('coworkers')
            ->where('id', $ministry_form['id'])
            ->get();

        $ministry_db = $ministry_db[0];

        $coworkers_id_form = $ministry_form['coworkers'];
        $coworkers_id_db = [];

        foreach ($ministry_db['coworkers'] as $coworker) {
            array_push($coworkers_id_db, $coworker['id']);
        }

        if (
            $ministry_form['type_id'] != (int) $ministry_db['type_id']
        ) {
            $ministry_db->type_id = $ministry_form['type_id'];
        } elseif ($ministry_form['when'] != $ministry_db['when']) {
            $ministry_db->when = $ministry_form['when'];
        } elseif (!$coworkers_id_form != $coworkers_id_db) {
            $this->deleteCoworkersFromMinistry($ministry_db, $coworkers_id_db);
            foreach ($coworkers_id_form as $key => $value) {
                $ministry_db->coworkers()->attach($value);
            }
        }
        if ($ministry_db->save()) {
            return 1;
        } else {
            return 0;
        }
    }

    public function deleteCoworkersFromMinistry(Ministry $ministry_db, $coworkers_id_db)
    {
        foreach ($coworkers_id_db as $key => $value) {
            $ministry_db->coworkers()->detach($value);
        }
        return 1;
    }

    public function delete(int $id)
    {
        $ministry_db =
            $this->ministryModel
            ->with('coworkers')
            ->where('id', $id)
            ->get();

        $ministry_db = $ministry_db[0];

        $coworkers_id_db = [];

        foreach ($ministry_db['coworkers'] as $coworker) {
            array_push($coworkers_id_db, $coworker['id']);
        }

        if (($this->deleteCoworkersFromMinistry($ministry_db, $coworkers_id_db)) && (Report::where('ministry_id', '=', [$id])->delete()) && (Ministry::find($id)->delete())) {
            return 1;
        } else {
            return 0;
        }
    }
}
