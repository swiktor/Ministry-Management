<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Calendar as ModelCalendar;
use App\Model\Type;
use App\Model\Report;
use App\Model\Ministry;
use App\Services\Google;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\MinistryRepository as MinistryRepositoryInterface;
use Google\Service\Calendar\Calendar;

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
            ->orderBy('when', 'desc')
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
        $ministry->user_id = $data['user_id'];
        $ministry->save();

        return $ministry->id;
    }

    public function setInGoogleCalendar($ministry_id, $user)
    {
        $ministry = $this->get($ministry_id)[0];

        $coworkers = "";

        for ($i = 0; $i < sizeof($ministry->coworkers); $i++) {
            if ($i == 0) {
                $coworkers = $ministry->coworkers[$i]->name . ' ' . $ministry->coworkers[$i]->surname;
            } else {
                $coworkers = $coworkers . ", " . $ministry->coworkers[$i]->name . ' ' . $ministry->coworkers[$i]->surname;
            }
        }

        $type_name = Type::find($ministry->type_id)->name;

        $type_duration = strtotime(Type::find($ministry->type_id)->duration->toTimeString());
        $ministry_when_duration = strtotime($ministry->when->toTimeString()) + $type_duration;
        $ministry_end_time_helper = date_create();
        date_timestamp_set($ministry_end_time_helper, $ministry_when_duration);
        $ministry_end_time = $ministry->when->toDateString() . " " . date_format($ministry_end_time_helper, 'H:i:s');

        $startDateTime = new Carbon($ministry->when->toDateTimeString(), 'Europe/Warsaw');
        $endDateTime = new Carbon($ministry_end_time, 'Europe/Warsaw');

        $google =
            app(Google::class)
            ->connectUsing($user->googleAccounts[0]->token)
            ->service('Calendar');

        $event = new \Google_Service_Calendar_Event(array(
            'summary' => $coworkers,
            'description' => $type_name,
            'start' => array(
                'dateTime' => $startDateTime,
                'timeZone' => 'Europe/Warsaw',
            ),
            'end' => array(
                'dateTime' => $endDateTime,
                'timeZone' => 'Europe/Warsaw',
            ),

        ));

        $calendar = ModelCalendar::find($user->calendar_id);

        $event = $google->events->insert($calendar->google_id, $event);

        $ministry = Ministry::find($ministry_id);
        $ministry->event_id = $event->id;
        $ministry->save();
    }

    public function deleteFromGoogleCalendar($ministry_id)
    {
        $google =
            app(Google::class)
            ->connectUsing(Auth::user()->googleAccounts[0]->token)
            ->service('Calendar');

        $ministry = Ministry::find($ministry_id);
        $calendar = ModelCalendar::find(auth()->user()->calendar_id);

        $google->events->delete($calendar->google_id, $ministry->event_id);
        return 1;
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

    public function delete(int $ministry_id)
    {
        $ministry_db =
            $this->ministryModel
            ->with('coworkers')
            ->where('id', $ministry_id)
            ->get();

        $ministry_db = $ministry_db[0];

        $coworkers_id_db = [];

        foreach ($ministry_db['coworkers'] as $coworker) {
            array_push($coworkers_id_db, $coworker['id']);
        }

        if (($this->deleteCoworkersFromMinistry($ministry_db, $coworkers_id_db))
            && ($this->deleteFromGoogleCalendar($ministry_id))
            && (Report::where('ministry_id', '=', [$ministry_id])->delete())
            && (Ministry::find($ministry_id)->delete())
        ) {
            return 1;
        } else {
            return 0;
        }
    }
}
