<?php

namespace App\Jobs;

use App\Model\User;
use App\Mail\ReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
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

        // $users = User::all();

        // foreach ($users as $user) {
        //     $report = $dashboardRepository->monthSum($date['month'], $date['year'], $user['id']);
        //     Mail::to($user['email'])->send(new ReportMail($user, $report, $date));
        // }

        $user = User::find(14);

        //

        $report_mail = $dashboardRepository->monthSum($date['month'], $date['year'], $user['id']);
        $hours_minutes = explode(":", $report_mail[0]->s_hours);
        $report_mail[0]->s_hours = $hours_minutes[0] . ":00";
        // Mail::to($user['email'])->send(new ReportMail($user, $report_mail, $date));

        $ministry_subtract['when'] = Carbon::now();
        $ministry_subtract['type'] = 8;
        $ministry_subtract['user_id'] = $user['id'];
        $ministry_subtract['coworker'][0] = $user['coworker_id'];

        $ministry_subtract_id = $ministryRepository->add($ministry_subtract);
        $coworkerRepository->addToMinistry($ministry_subtract['coworker'], $ministry_subtract_id);
        $ministryRepository->setInGoogleCalendar($ministry_subtract_id, $user);

        $report_subtract['id'] = $reportRepository->add($ministry_subtract_id);
        $report_subtract['hours'] = "-00:". $hours_minutes[1].":00";
        // $report_subtract['placements'] = 0
        // $report_subtract['videos'] = 0
        // $report_subtract['returns'] = 0
        // $report_subtract['studies'] = $data['studies'];
dump($report_subtract);

        $reportRepository->edit($report_subtract);
    }
}
