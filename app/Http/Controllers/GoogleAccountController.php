<?php

namespace App\Http\Controllers;

use App\Services\Google;
use App\Model\GoogleAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoogleAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // $googleAccount = auth()->user()->googleAccounts[0];

        // dd($googleAccount);

        return view('google.accounts', [
            'accounts' => auth()->user()->googleAccounts,
        ]);
    }

    public function store(Request $request, Google $google)
    {
        if (!$request->has('code')) {
            return redirect($google->createAuthUrl());
        }

        $google->authenticate($request->get('code'));
        $account = $google->service('Oauth2')->userinfo->get();

        auth()->user()->googleAccounts()->updateOrCreate(
            [
                'google_id' => $account->id,
            ],
            [
                'name' => $account->email,
                'token' => $google->getAccessToken(),
            ]
        );

        return redirect()->route('google.index');
    }

    public function destroy(GoogleAccount $googleAccount, Google $google)
    {
        $googleAccount->calendars()->delete();
        $googleAccount->delete();

        $google->revokeToken($googleAccount->token);

        return redirect()->back();
    }
}
