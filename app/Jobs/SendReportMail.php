<?php

namespace App\Jobs;

use App\Model\User;
use App\Mail\ReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use App\Repository\DashboardRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendReportMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    // protected DashboardRepository $dashboardRepository;

    public function __construct()
    {
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $dashboardRepository = \App::make('App\Repository\DashboardRepository');
        $ministryRepository = \App::make('App\Repository\MinistryRepository');
        $coworkerRepository = \App::make('App\Repository\CoworkerRepository');
        $reportRepository = \App::make('App\Repository\ReportRepository');
        $date['month'] = Carbon::now()->month;
        $date['year'] = Carbon::now()->year;

        $users = User::all();

        foreach ($users as $user) {
            $report_mail = $dashboardRepository->monthSum($date['month'], $date['year'], $user['id']);
            $hours_minutes = explode(":", $report_mail[0]->s_hours);
            $report_mail[0]->s_hours = $hours_minutes[0] . ":00";
            Mail::to($user['email'])->send(new ReportMail($user, $report_mail, $date));

            $ministry['when'] = Carbon::now()->endOfMonth();
            $ministry['type'] = 8;
            $ministry['user_id'] = $user['id'];
            $ministry['coworker'][0] = $user['coworker_id'];
            $ministry['status'] = 'transfer';

            $ministry_id = $ministryRepository->add($ministry);
            $coworkerRepository->addToMinistry($ministry['coworker'], $ministry_id);

            $report_subtract['id'] = $reportRepository->add($ministry_id);
            $report_subtract['hours'] = "-00:" . $hours_minutes[1] . ":00";

            DB::table('reports')
                ->where('id', $report_subtract['id'])
                ->update(['hours' => $report_subtract['hours']]);

            $ministry['when'] = Carbon::now()->startOfMonth()->addMonth();
            $ministry['status'] = 'accepted';

            $ministry_id = $ministryRepository->add($ministry);
            $coworkerRepository->addToMinistry($ministry['coworker'], $ministry_id);
            $ministryRepository->setInGoogleCalendar($ministry_id, $user);

            $report_addition['id'] = $reportRepository->add($ministry_id);
            $report_addition['hours'] = "00:" . $hours_minutes[1] . ":00";

            DB::table('reports')
                ->where('id', $report_addition['id'])
                ->update(['hours' => $report_addition['hours']]);
        }
    }
}
