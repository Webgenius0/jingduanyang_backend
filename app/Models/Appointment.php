<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'id'      => 'integer',
        'user_id' => 'integer',
        'team_id' => 'integer',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function psychologistInformation()
    {
        return $this->belongsTo(PsychologistInformation::class);
    }

    /**
     * Get the prescription associated with the appointment.
     */
    public function prescription()
    {
        return $this->hasOne(Prescription::class);
    }

}
