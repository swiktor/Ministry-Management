<?php

namespace App\Model;

use App\Model\Calendar;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\SynchronizeGoogleCalendars;

class GoogleAccount extends Model
{

    protected $fillable = [
        'google_id', 'name', 'token',
    ];

    protected $casts = [
        'token' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function calendars()
    {
        return $this->hasMany(Calendar::class);
    }

    public static function boot()
    {
        parent::boot();

        static::created(function ($googleAccount) {
            SynchronizeGoogleCalendars::dispatch($googleAccount);
        });
    }

}
