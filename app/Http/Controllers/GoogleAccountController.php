<?php

namespace App\Http\Controllers;

use App\Services\Google;
use App\Model\GoogleAccount;
use Illuminate\Http\Request;

class GoogleAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
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
                'token' => trim(($google->getAccessToken())["access_token"], '"'),
            ]
        );

        return redirect()->route('google.index');
    }

    public function destroy(GoogleAccount $googleAccount, Google $google)
    {
        $googleAccount->delete();

        $google->revokeToken($googleAccount->token);

        return redirect()->back();
    }
}
