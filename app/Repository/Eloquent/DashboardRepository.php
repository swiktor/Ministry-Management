<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Report;
use App\Model\Ministry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repository\DashboardRepository as DashboardRepositoryInterface;

class DashboardRepository implements DashboardRepositoryInterface
{
    private Ministry $ministryModel;
    private Report $reportModel;

    public function __construct(Ministry $ministryModel, Report $reportModel)
    {
        $this->ministryModel = $ministryModel;
        $this->reportModel = $reportModel;
    }

    public function incomingMinistries(int $limit = 10)
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
            ->whereRaw("datediff(ministries.when, CURRENT_TIMESTAMP) >=0 ")
            ->orderBy('when', 'asc')
            ->paginate($limit);
    }

    public function coworkersBalance($month, $year, $limit)
    {
        return DB::table('coworkerministries')
        ->select(['coworkerministries.coworker_id','name','surname'])
        ->selectRaw("count(coworkerministries.coworker_id) as count")
        ->join('coworkers', 'coworkerministries.coworker_id', '=', 'coworkers.id')
        ->join('ministries', 'coworkerministries.ministry_id', '=', 'ministries.id')
        ->join('reports', 'reports.ministry_id','=', 'ministries.id')
        ->where('ministries.user_id', Auth::id())
        ->whereRaw("reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
        ->groupBy("coworkerministries.coworker_id")
        ->orderBy('count', 'desc')
        ->orderBy('surname','asc')
        ->orderBy('name','asc')
        ->paginate($limit);
    }

    public function monthSum($month, $year)
    {
        $monthSum =  DB::table('reports')
            ->select(
                DB::raw("
                    sum(placements) as s_placements,
                    sum(videos) as s_videos,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))), '%H:%i') as s_hours,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(duration))), '%H:%i') as s_types,
                    sum(studies) as s_studies,
                    sum(returns) as s_returns,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))-sum(time_to_sec(duration))), '%H:%i') as balance_expectations_real,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(duration))-(time_to_sec(quantum))), '%H:%i') as balance_s_types_quantum,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours)) - time_to_sec(goals.quantum)), '%H:%i') as hour_difference,
                    TIME_FORMAT(ceil(sec_to_time((sum(time_to_sec(hours)) - time_to_sec(goals.quantum)) / (DAYOFMONTH(LAST_DAY(CURRENT_TIMESTAMP())) - DAY(CURRENT_TIMESTAMP())+1)*-1)), '%H:%i') as real_day_destination,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))-ceil(time_to_sec(goals.quantum) / DAYOFMONTH(LAST_DAY(CURRENT_TIMESTAMP())))*DAY(CURRENT_TIMESTAMP())), '%H:%i') as real_balance
                    ")
            )
            ->join('ministries', 'reports.ministry_id', '=', 'ministries.id')
            ->join('types', 'ministries.type_id', '=', 'types.id')
            ->join('users', 'ministries.user_id', '=', 'users.id')
            ->join('goals', 'users.goal_id', '=', 'goals.id')
            ->where('ministries.user_id', Auth::id())
            ->whereRaw("reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
            ->get();

        return $monthSum;
    }
}
