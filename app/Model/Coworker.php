<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coworker extends Model
{
    protected $fillable = [
        'name', 'surname', 'active', 'congregation_id'
    ];

    public function ministries()
    {
        return $this->belongsToMany(Coworker::class, 'coworkers_ministries');
    }

    public function congregations()
    {
        return $this->belongsTo(Congregation::class, 'congregation_id', 'id');
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'coworkers_teams');
    }

    use HasFactory;
}
