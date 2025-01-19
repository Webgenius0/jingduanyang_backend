<?php
namespace App\Http\Controllers\Api\ClientDashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Traits\ApiResponse;

class DashboradController extends Controller
{
    use ApiResponse;
    public function doctorList()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }
        
        $doctors = User::with('PsychologistInformation')->where('role', 'doctor')->get();

        if ($doctors->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($doctors, 'Doctor data fetched successfully', 200);
    }

    /**
     * Fetches all the previous appointments of the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function previousAppointments()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }
        
        $data = Appointment::with(['psychologistInformation.user:id,first_name,last_name,avatar'])->select('appointments.user_id', 'appointments.psychologist_information_id', 'appointments.appointment_date')
            ->where('user_id', $user->id)
            ->where('appointment_date', '<', now()) // Assuming `appointment_date` exists
            ->get();

        if ($data->isEmpty()) {
            return $this->error([], 'No previous appointments found', 404);
        }

        return $this->success($data, 'Previous appointments fetched successfully', 200);
    }

    public function activeAppointments()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Appointment::with(['psychologistInformation.user:id,first_name,last_name,avatar'])
            ->where('user_id', $user->id)
            ->where('status', 'accept')
            // ->where('appointment_date', '>=', now())
            ->limit(2)
            ->get();

        if ($data->isEmpty()) {
            return $this->error([], 'No active appointments found', 404);
        }

        return $this->success($data, 'Active appointments fetched successfully', 200);
    }

}
