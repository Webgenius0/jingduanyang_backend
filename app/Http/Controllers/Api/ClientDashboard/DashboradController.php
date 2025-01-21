<?php
namespace App\Http\Controllers\Api\ClientDashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

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
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($doctors, 'Doctor data fetched successfully', 200);
    }

    /**
     * Fetches all the previous appointments of the current user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function previousAppointments(Request $request)
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $query = Appointment::with(['psychologistInformation.user:id,first_name,last_name,avatar'])
            ->select('appointments.user_id', 'appointments.psychologist_information_id', 'appointments.appointment_date')
            ->where('user_id', $user->id)
            ->where('appointment_date', '<', now());

        // Filter by year
        if ($request->has('year')) {
            $query->whereYear('appointment_date', $request->year);
        }

        // Filter by month
        if ($request->has('month')) {
            $query->whereMonth('appointment_date', $request->month);
        }

        // Filter by week
        if ($request->has('day')) {
            $query->whereDate('appointment_date', $request->day);
        }
        

        $data = $query->get();

        if ($data->isEmpty()) {
            return $this->success([], 'previous appointments is empty', 200);
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
            ->where('appointment_date', '>=', now())
            ->limit(2)
            ->get();

        if ($data->isEmpty()) {
            return $this->success([], 'No active appointments found', 200);
        }

        return $this->success($data, 'Active appointments fetched successfully', 200);
    }

    public function upcomingChackup()
    {
        $user = auth()->user();

        if (! $user) {
            return $this->error([], 'Unauthorized access', 401);
        }

        $data = Appointment::where('user_id', $user->id)->select(['appointment_date', 'status'])
            ->where('status', 'accept')
            ->where('appointment_date', '>', now())
            ->get();

        if ($data->isEmpty()) {
            return $this->success([], 'No upcoming checkups found', 200);
        }

        return $this->success($data, 'Upcoming checkups fetched successfully', 200);
    }

    public function userData()
    {
        $user = Auth::user();

        if (! $user) {
            return $this->error([], "User Not Found", 404);
        }

        return $this->success($user, 'User data fetched successfully', 200);
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'email'      => 'required|string',
            'gender'     => 'required|string',
            'birthdate'  => 'required|string',
            'languages'  => 'required|string',
            'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            // Get authenticated user
            $user = Auth::user();

            if (! $user) {
                return $this->error([], "User Not Found", 404);
            }

            if ($request->hasFile('avatar')) {

                if ($user->avatar) {
                    $previousImagePath = public_path($user->avatar);
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }

                $image     = $request->file('avatar');
                $imageName = uploadImage($image, 'User/Avatar');
            } else {
                $imageName = $user->avatar;
            }

            // Update user details
            $user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'gender'     => $request->gender,
                'birthdate'  => $request->birthdate,
                'languages'  => $request->languages,
                'avatar'     => $imageName,
            ]);

            return $this->success($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            return $this->error([], [
                'error' => $e->getMessage(),
            ]);
        }
    }

}
