<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public $report;
    public $date;

    public function __construct($user, $report, $date)
    {
        $this->user = $user;
        $this->report = $report;
        $this->date = $date;
    }



    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject("Twoje miesięczne sprawozdanie")->view('emails.pl.report');
    }
}
