<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ministry extends Model
{
    protected $fillable = [
        'type_id', 'when', 'user_id'
    ];

    use HasFactory;
}
