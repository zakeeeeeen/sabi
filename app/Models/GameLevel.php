<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameLevel extends Model
{
    protected $fillable = [
        'title',
        'description',
        'map_data',
        'is_active',
    ];

    protected $casts = [
        'map_data' => 'array',
        'is_active' => 'boolean',
    ];
}
