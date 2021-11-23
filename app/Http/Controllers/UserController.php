<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    public function get_google_calendar_id()
    {
        require __DIR__ . '/vendor/autoload.php';
        $client = new Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(Google_Service_Calendar::CALENDAR_READONLY);
        $client->setAuthConfig('credentials.json');
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');
    }
}
