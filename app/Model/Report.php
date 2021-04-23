<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'ministry_id ', 'hours', 'placements', 'videos', 'returns', 'studies'
    ];

    public function ministries()
    {
        return $this->hasMany(Ministry::class, 'type_id', 'id');
    }

    use HasFactory;
}
