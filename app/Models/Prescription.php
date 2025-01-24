<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Prescription extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
    ];

    /**
     * Get the user for the prescription.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the medicines for the prescription.
     */
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    /**
     * Get the tests for the prescription.
     */
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

     /**
     * Get the appointment associated with the prescription.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
