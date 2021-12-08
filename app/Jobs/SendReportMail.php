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
        // $dashboardRepository = new DashboardRepository();
        $dashboardRepository = \App::make('App\Repository\DashboardRepository');

        $date['month']= Carbon::now()->month;
        $date['year']= Carbon::now()->year;

        $users = User::all();

        foreach ($users as $user) {
            $report = $dashboardRepository->monthSum($date['month'], $date['year'], $user['id']);
            Mail::to($user['email'])->send(new ReportMail($user, $report, $date));
        }
    }
}
