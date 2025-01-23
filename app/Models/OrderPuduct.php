<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPuduct extends Model
{
    protected $guarded = [];


    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
