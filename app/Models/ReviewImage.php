<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewImage extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'review_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
