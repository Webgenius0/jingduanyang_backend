<?php

namespace App\Http\Controllers\Api\ClientDashboard;

use App\Models\Appointment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RescheduleController extends Controller
{
    use ApiResponse;
    
    public function singelAppointments($id)
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Appointment::find($id);

        if (!$data) {
            return $this->error([], 'No appointments found', 200);
        }

        return $this->success($data, 'Appointments fetched successfully', 200);
    }

    public function rescheduleAppointments(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Appointment::find($id);

        if (!$data) {
            return $this->error([], 'No appointments found', 200);
        }

        $data->appointment_date = $request->appointment_date;
        $data->appointment_time = $request->appointment_time;
        $data->save();

        return $this->success($data, 'Appointments rescheduled successfully', 200);
    }
}
