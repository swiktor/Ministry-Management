<?php

namespace App\Model;

use App\Model\Event;
use App\Model\Calendar;
use App\Model\GoogleAccount;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'goal_id', 'congregation_id', 'calendar_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ministries()
    {
        return $this->hasMany(Ministry::class, 'user_id', 'id');
    }

    public function goals()
    {
        return $this->hasOne(Goal::class, 'id', 'goal_id');
    }

    public function congregations()
    {
        return $this->hasOne(Congregation::class, 'id', 'congregation_id');
    }

    public function googleAccounts()
    {
        return $this->hasMany(GoogleAccount::class);
    }

    public function calendars()
    {
        return Calendar::whereHas('googleAccount', function ($accountQuery) {
                $accountQuery->whereHas('user', function ($userQuery) {
                    $userQuery->where('id', $this->id);
                });
            });
    }

}
