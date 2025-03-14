<?php

namespace App\Http\Controllers\Api\ClientDashboard;

use App\Models\Appointment;
use App\Traits\ApiResponse;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\PsychologistInformation;
use Illuminate\Support\Facades\Validator;

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
            $query->whereHas('psychologistInformation.user', function ($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->input('first_name') . '%');
            });
        }
    
        // Get the paginated data
        $data = $query->paginate(10);
    
        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }
    
        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function clientAppointmentSchedule(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $query = Appointment::where('status', 'pending')->where('user_id', $user->id);

        // Add filter for psychologist_information_id if provided
        if (request()->has('user_id')) {
            $query->whereHas('psychologistInformation.user', function ($q) use ($request) {
                $q->where('id', $request->input('user_id'));
            });
        }


        $data = $query->get();

        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }

        // Group appointments by date and count
        $groupedData = $data->groupBy('appointment_date')
        ->map(function ($appointments, $date) {
            // Convert date to Carbon instance to ensure we can use format()
            $formattedDate = Carbon::parse($date)->format('Y-m-d');
            
            return [
                'appointmentCount' => (string) $appointments->count(), // Ensure appointment count is a string
                'date' => $formattedDate, // Format date to 'YYYY-MM-DD'
            ];
        });

        return $this->success($groupedData->values(), 'Appointment data fetched successfully', 200);
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
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function getDoctor()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Prescription::with('user.psychologistInformation','appointment:id,appointment_date,appointment_time,consultant_type')->select('prescriptions.user_id','prescriptions.appointment_id')->where('appointment_id', $user->id)->get();

        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Prescription data fetched successfully', 200);
    }

    public function getClientPrescription($id)
    {
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 401);
        }
        
        $data = Prescription::with('appointment.user:id,first_name,last_name,email,role','medicines','tests','user:id,first_name,last_name,email,role','user.psychologistInformation:id,user_id,qualification')->where('user_id', $id)->first();

        if (!$data) {
            return $this->success([], 'Data Not Found', 200);
        }    

        return $this->success($data, 'Prescription data fetched successfully', 200);
    }

    public function makeAppointments(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email',
            'phone'            => 'required|numeric',
            'age'              => 'required|numeric|max:100',
            'gender'           => 'required|string',
            'appointment_date' => 'required|date',
            'consultant_type'  => 'required|string',
            'appointment_time' => 'required',
        ]);

        $psychologist_information = PsychologistInformation::where('user_id', $id)->first();
        // dd($psychologist_information->id);

        if ($validator->fails()) {
            return $this->error([], $validator->errors(), 422);
        }

        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Appointment::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'gender' => $request->gender,
            'appointment_date' => $request->appointment_date,
            'consultant_type' => $request->consultant_type,
            'appointment_time' => $request->appointment_time,
            'user_id' => $user->id,
            'psychologist_information_id' => $psychologist_information->id,
        ]);

        if (!$data) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Prescription data fetched successfully', 200);
    }

    public function appointmentCancel(Request $request, $id)
    {
        $data = Appointment::find($id);

        $data->status = $request->status;

        $data->save();

        return $this->success($data, 'Appointment cancelled successfully', 200);
    }
}
