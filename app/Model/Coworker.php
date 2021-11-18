<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coworker extends Model
{
    protected $fillable = [
        'name', 'surname', 'active'
    ];


    public function ministries()
    {
        return $this->belongsToMany(Coworker::class, 'coworkers_ministries');
    }





    use HasFactory;
}
