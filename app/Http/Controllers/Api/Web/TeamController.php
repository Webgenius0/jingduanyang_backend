<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Team;
use App\Models\Appointment;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{

    use ApiResponse;

    public function getTeam(Request $request)
    {
        $limit = $request->limit;
        if(!$limit)
        {
            $limit = 12;
        }

        $data = Team::where('status','active')->paginate($limit);

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Team fetched successfully', 200);
    }

    public function teamDetail($id)
    {
        $date = Team::find($id);

        if (empty($date)) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($date, 'Team fetched successfully', 200);
    }

    public function appotment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'age' => 'required|numeric|max:100',
            'consultant_type' => 'required|string',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            'message' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return $this->error([], $validator->errors()->first(), 400);
        }

        $user = auth()->user();

        // dd($user);

        if (!$user) {
            return $this->error([], 'User Not Found', 404);
        }

        $data = Appointment::create([
            'user_id' => $user->id,
            'team_id' => $request->team_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'age' => $request->age,
            'consultant_type' => $request->consultant_type,
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'message' => $request->message,
        ]);

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment created successfully', 200);
    }

}
