<?php

declare(strict_types=1);

namespace App\Repository\Eloquent;

use App\Model\Report;
use App\Model\Ministry;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\User;
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
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->where('user_id', Auth::id())
            ->where('status', 'accepted')
            ->whereRaw("datediff(ministries.when, CURRENT_TIMESTAMP) >=0 ")
            ->orderBy('when', 'desc')
            ->paginate($limit);
    }

    public function coworkersBalance($month, $year, $limit)
    {
        return DB::table('coworkers_ministries')
            ->select(['coworkers_ministries.coworker_id', 'name', 'surname'])
            ->selectRaw("count(coworkers_ministries.coworker_id) as count")
            ->join('coworkers', 'coworkers_ministries.coworker_id', '=', 'coworkers.id')
            ->join('ministries', 'coworkers_ministries.ministry_id', '=', 'ministries.id')
            ->join('reports', 'reports.ministry_id', '=', 'ministries.id')
            ->where('ministries.user_id', Auth::id())
            ->where('ministries.status', 'accepted')
            ->whereRaw("reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
            ->groupBy("coworkers_ministries.coworker_id")
            ->orderBy('count', 'desc')
            ->orderBy('surname', 'asc')
            ->orderBy('name', 'asc')
            ->paginate($limit);
    }

    public function monthSum($month, $year, $user_id)
    {
        $monthSum =  DB::table('reports')
            ->select(
                DB::raw("
                    sum(placements) as s_placements,
                    sum(videos) as s_videos,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))-(select IFNULL(sum(time_to_sec(hours)),'00:00:00') from `reports` inner join `ministries` on `reports`.`ministry_id` = `ministries`.`id`
                     inner join `users` on `ministries`.`user_id` = `users`.`id`
                     inner join `goals` on `users`.`goal_id` = `goals`.`id`
                     where `ministries`.`user_id` = $user_id and reports.ministry_id
                     in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)
                     and `ministries`.`status` = 'transfer')), '%H:%i') as s_hours,
                    sum(studies) as s_studies,
                    sum(returns) as s_returns,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))-(select IFNULL(sum(time_to_sec(hours)),'00:00:00') from `reports` inner join `ministries` on `reports`.`ministry_id` = `ministries`.`id` inner join `users` on `ministries`.`user_id` = `users`.`id` inner join `goals` on `users`.`goal_id` = `goals`.`id` where `ministries`.`user_id` = $user_id and reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year) and `ministries`.`status` = 'transfer') - time_to_sec(goals.quantum)), '%H:%i') as hour_difference,
                    TIME_FORMAT(ceil(sec_to_time((sum(time_to_sec(hours)) - time_to_sec(goals.quantum)) / (DAYOFMONTH(LAST_DAY(CURRENT_TIMESTAMP())) - DAY(CURRENT_TIMESTAMP())+1)*-1)), '%H:%i') as real_day_destination,
                    TIME_FORMAT(sec_to_time(sum(time_to_sec(hours))-(select IFNULL(sum(time_to_sec(hours)),'00:00:00') from `reports` inner join `ministries` on `reports`.`ministry_id` = `ministries`.`id` inner join `users` on `ministries`.`user_id` = `users`.`id` inner join `goals` on `users`.`goal_id` = `goals`.`id` where `ministries`.`user_id` = $user_id and reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year) and `ministries`.`status` = 'transfer')-ceil(time_to_sec(goals.quantum) / DAYOFMONTH(LAST_DAY(CURRENT_TIMESTAMP())))*DAY(CURRENT_TIMESTAMP())), '%H:%i') as real_balance
                    ")
            )
            ->join('ministries', 'reports.ministry_id', '=', 'ministries.id')
            ->join('users', 'ministries.user_id', '=', 'users.id')
            ->join('goals', 'users.goal_id', '=', 'goals.id')
            ->where('ministries.user_id', $user_id)
            ->whereRaw("reports.ministry_id in (select id from ministries where MONTH(ministries.when) = $month AND YEAR(ministries.when) = $year)")
            ->where('ministries.status', 'accepted')
            ->get();

        return $monthSum;
    }

    public function ministryProposalUserList($user)
    {
        return $this->ministryModel
            ->with(['coworkers' => function ($query) {
                $query
                    ->distinct()
                    ->orderBy('surname')
                    ->orderBy('name');
            }])
            ->with('users_original')
            ->where('user_id', Auth::id())
            ->where('status', 'waiting')
            ->groupBy('user_id_original')
            ->get();
    }
    public function incompleteReportFind($user)
    {
        return DB::table('ministries')
            ->select('ministries.when', 'reports.id')
            ->join('reports', 'reports.ministry_id', '=', 'ministries.id')
            ->where('ministries.user_id', $user->id)
            ->where('ministries.status', 'accepted')
            ->whereRaw('ministries.id in (select reports.ministry_id from reports where reports.hours = "00:00:00")')
            ->get();
    }
}
