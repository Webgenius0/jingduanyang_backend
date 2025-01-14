<?php

namespace App\Http\Controllers\Api\DoctorDashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use ApiResponse;

    public function getAppointments(Request $request)
    {
        $query = Appointment::with(['user:id,first_name,avatar,gender', 'team:id,total_fees'])
            ->where('status', 'pending');

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

}
