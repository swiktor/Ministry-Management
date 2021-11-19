<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Congregation extends Model
{
    protected $fillable = [
        'name'
    ];

    // public function coworkers()
    // {
    //     return $this->hasMany(Coworker::class);
    // }

    use HasFactory;
}
