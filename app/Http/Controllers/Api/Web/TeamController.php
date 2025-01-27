<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{

    use ApiResponse;

    public function getTeam(Request $request)
    {
        $limit = $request->limit ?? 12;

        $data = User::where('role', 'doctor')
            ->whereHas('psychologistInformation', function ($query) {
                $query->where('status', 'active');
            })
            ->with('psychologistInformation')
            ->paginate($limit);

        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Doctor fetched successfully', 200);
    }

    public function teamDetail($id, Request $request)
    {
        $user = User::with('psychologistInformation')->find($id);

        if (empty($user)) {
            return $this->success([], 'Data Not Found', 200);
        }

        // Log the client visit
        $ipAddress = $request->ip();
        $date      = now()->toDateString();

        // Check if the entry already exists
        $existingVisit = DB::table('client_visits')
            ->where('user_id', $id)
            ->where('ip', ip2long($ipAddress))
            ->first();

        if (!$existingVisit) {
            // Insert into client_visits table
            DB::table('client_visits')->insert([
                'user_id'    => $id,
                'ip'         => ip2long($ipAddress),
                'date'       => $date,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $this->success($user, 'Doctor fetched successfully', 200);
    }

    public function appotment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'       => 'required|string|max:255',
            'last_name'        => 'required|string|max:255',
            'email'            => 'required|email',
            'phone'            => 'required|numeric',
            'age'              => 'required|numeric|max:100',
            'gender'           => 'required|string',
            'consultant_type'  => 'required|string',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'message'          => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors()->first(), 400);
        }

        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'User Not Found', 404);
        }

        // Check if the user already has an existing appointment
        $existingAppointment = Appointment::where('user_id', $user->id)
            ->where('appointment_date', $request->appointment_date)
            ->where('appointment_time', $request->appointment_time)
            ->first();

        if ($existingAppointment) {
            return $this->error([], 'You already have an appointment scheduled at this date and time.', 400);
        }

        $data = Appointment::create([
            'user_id'                     => $user->id,
            'psychologist_information_id' => $request->psychologist_information_id,
            'first_name'                  => $request->first_name,
            'last_name'                   => $request->last_name,
            'email'                       => $request->email,
            'phone'                       => $request->phone,
            'age'                         => $request->age,
            'gender'                      => $request->gender,
            'consultant_type'             => $request->consultant_type,
            'appointment_date'            => $request->appointment_date,
            'appointment_time'            => $request->appointment_time,
            'message'                     => $request->message,
        ]);

        if (! $data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment created successfully', 200);
    }

}
