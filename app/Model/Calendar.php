<?php

namespace App\Model;

use App\Jobs\SynchronizeGoogleEvents;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'google_id', 'name', 'color', 'timezone',
    ];

    public function googleAccount()
    {
        return $this->belongsTo(GoogleAccount::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    // public static function boot()
    // {
    //     parent::boot();

    //     static::created(function ($calendar) {
    //         SynchronizeGoogleEvents::dispatch($calendar);
    //     });
    // }

}
