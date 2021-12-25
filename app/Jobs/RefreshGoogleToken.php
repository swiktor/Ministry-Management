<?php

namespace App\Jobs;

use App\Model\User;
use App\Services\Google;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class RefreshGoogleToken implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct()
    {

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Google $google)
    {
        $user = User::find(14);



        $google->authenticate($user->googleAccounts[0]->token['refresh_token']);
        $account = $google->service('Oauth2')->userinfo->get();
        // $token=$google->getAccessToken();
        // dd($token);





    }
}
