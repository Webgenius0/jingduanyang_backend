<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientVisit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
