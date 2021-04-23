<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    protected $fillable = [
        'name', 'duration'
    ];

    public function ministries()
    {
        return $this->hasMany(Ministry::class, 'type_id', 'id');
    }



    use HasFactory;
}
