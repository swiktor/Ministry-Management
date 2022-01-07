<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name', 'user_id'
    ];

    protected $casts = [
        'name' => 'string',
    ];

    public function coworkers()
    {
        return $this->belongsToMany(Coworker::class, 'coworkers_teams');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_teams');
    }

    use HasFactory;
}
