<?php

namespace App\Http\Controllers\Api\ClientDashboard;

use App\Models\Appointment;
use App\Traits\ApiResponse;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;

class ClientAppointmentController extends Controller
{
    use ApiResponse;
    
    public function getAppointments(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $query = Appointment::with(['psychologistInformation.user'])->where('user_id', $user->id);
    
        // Filter by appointment_date (exact match)
        if ($request->input('appointment_date')) {
            $query->whereDate('appointment_date', Carbon::parse($request->input('appointment_date'))->format('Y-m-d'));
        }
    
        if ($request->input('first_name')) {
            $query->where('first_name', 'like', '%' . $request->input('first_name') . '%');
        }
    
        // Get the paginated data
        $data = $query->paginate(10);
    
        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }
    
        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function appointmentMeeting()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }
        
        $data = Appointment::with(['psychologistInformation.user'])
            ->where('user_id', $user->id)
            ->where('status', 'pending')
            ->whereNotNull('meting_link')
            ->paginate(10);

        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function getDoctor()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Prescription::with('user.psychologistInformation')->select('prescriptions.user_id','prescriptions.appointment_id')->where('appointment_id', $user->id)->get();

        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Prescription data fetched successfully', 200);
    }

    public function getClientPrescription($id)
    {
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 401);
        }
        
        $data = Prescription::with('medicines','tests','user')->where('user_id', $id)->first();

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }    

        return $this->success($data, 'Prescription data fetched successfully', 200);
    }
}
