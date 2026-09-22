<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpendingItem extends Model
{
    protected $fillable = [
        'name',
        'price',
        'category',
        'is_correct',
        'order_num',
        'is_active',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
        'is_active' => 'boolean',
        'price' => 'integer',
        'order_num' => 'integer',
    ];
}
