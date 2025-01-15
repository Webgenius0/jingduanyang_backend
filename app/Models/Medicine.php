<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'prescription_id' => 'integer',
    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }
}
