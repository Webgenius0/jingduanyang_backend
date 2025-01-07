<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PsychologistInformation extends Model
{
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

    protected function casts(): array {
        return [
            'id' => 'integer',
            'user_id' => 'integer',
        ];
    }

}
