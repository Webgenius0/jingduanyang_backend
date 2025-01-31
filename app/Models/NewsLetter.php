<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsLetter extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'is_subscribed' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
