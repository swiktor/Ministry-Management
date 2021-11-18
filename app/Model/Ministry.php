<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $fillable = [
        'id', 'type_id', 'when', 'user_id', 'event_id'
    ];

    protected $dates = ['when'];

    public function types()
    {
        return $this->belongsTo(Type::class, 'type_id', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function coworkers()
    {
        return $this->belongsToMany(Coworker::class, 'coworkers_ministries');
    }

    public function reports()
    {
        return $this->belongsTo(Report::class, 'id', 'ministry_id');
    }

    use HasFactory;
}
