<?php

namespace App\Http\Controllers;

use App\Model\Calendar;
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
        $calendars = null;
        $accounts = auth()->user()->googleAccounts;
        if (!$accounts->isEmpty()) {
            $calendars = auth()->user()->googleAccounts[0]->calendars()->get();
        }

        return view('google.accounts', [
            'accounts' => $accounts,
            'calendars' => $calendars
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

        $calendar = Calendar::where('google_id','=', $account->email)->firstOrFail();

        $user = Auth::user();
        $user->calendar_id = $calendar->id;
        $user->save();

        return redirect()->route('google.index');
    }

    public function destroy(GoogleAccount $googleAccount, Google $google)
    {
        $user = Auth::user();
        $user->calendar_id = null;
        $user->save();

        $googleAccount->calendars()->delete();
        $googleAccount->delete();

        $google->revokeToken($googleAccount->token);

        return redirect()->back();
    }

    public function select(Calendar $googleCalendar)
    {
        $user = Auth::user();
        $user->calendar_id = $googleCalendar->id;
        $user->save();

        return redirect()->back()->with('success', 'Pomyślnie ustawiono kalendarz');
    }
}
