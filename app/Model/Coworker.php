<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coworker extends Model
{
    protected $fillable = [
        'name', 'surname', 'active'
    ];

    use HasFactory;
}
