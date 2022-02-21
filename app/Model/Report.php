<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'ministry_id ', 'hours', 'placements', 'videos', 'returns', 'studies'
    ];

    protected $dates = ['hours'];

    protected $casts = [
        'placements' => 'integer',
        'videos' => 'integer',
        'returns' => 'integer',
        'studies' => 'integer',
    ];



    public function ministries()
    {
        // return $this->hasOne(Ministry::class, 'ministry_id', 'id');
        return $this->hasOne(Ministry::class, 'id', 'ministry_id');
    }

    use HasFactory;
}
