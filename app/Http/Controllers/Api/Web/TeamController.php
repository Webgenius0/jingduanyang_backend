<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Doctor fetched successfully', 200);
    }

    public function teamDetail($id)
    {
        
        $user = User::with('psychologistInformation')->find($id);

    
        if (empty($user)) {
            return $this->error([], 'Data Not Found', 404);
        }

       
        if (! empty($user->psychologistInformation)) {
            $user->psychologistInformation->increment('views');
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
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            'message'          => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error([], $validator->errors()->first(), 400);
        }

        $user = auth()->user();

        // dd($user);

        if (! $user) {
            return $this->error([], 'User Not Found', 404);
        }

        $data = Appointment::create([
            'user_id'          => $user->id,
            'psychologist_information_id' => $request->psychologist_information_id,
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'phone'            => $request->phone,
            'age'              => $request->age,
            'gender'           => $request->gender,
            'consultant_type'  => $request->consultant_type,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message'          => $request->message,
        ]);

        if (! $data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment created successfully', 200);
    }

}
