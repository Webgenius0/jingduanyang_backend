<?php
namespace App\Http\Controllers\Api\DoctorDashboard;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\Test;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    use ApiResponse;

    public function getAppointments(Request $request)
    {
        $query = Appointment::with([
            'user:id,avatar,gender',
            'psychologistInformation.user'
        ]);
    
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

    public function appointmentDetail($id)
    {
        $data = Appointment::with(['user:id,avatar,gender', 'psychologistInformation.user'])
            ->where('id', $id)
            ->first();

        if (! $data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function appointmentScheduleUpdate(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required',
            'appointment_time' => 'required',
            'available_times'  => 'required',
            'available_day'    => 'required',
            'meting_link'      => 'required|url',
            'note'             => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $data = Appointment::where('id', $id)->first();

        if (! $data) {
            return $this->error([], 'Data Not Found', 404);
        }

        $data->appointment_date = $request->appointment_date;
        $data->appointment_time = $request->appointment_time;
        $data->available_times  = $request->available_times;
        $data->available_day    = $request->available_day;
        $data->meting_link      = $request->meting_link;
        $data->note             = $request->note;
        $data->save();

        return $this->success($data, 'Appointment data updated successfully', 200);
    }

    public function appointmentMeeting()
    {
        $currentDate = now(); // Get the current date

        $data = Appointment::with(['user:id,avatar,gender'])
            ->where('status', 'pending')
            ->whereNotNull('meting_link')
            ->whereDate('appointment_date', '=', $currentDate)
            ->get();

        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Appointment data fetched successfully', 200);
    }

    public function appointmentStatus(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,accept,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        $data = Appointment::where('id', $id)->first();

        if (! $data) {
            return $this->error([], 'Data Not Found', 404);
        }

        $data->status = $request->status;
        $data->save();

        return $this->success($data, 'Appointment status updated successfully', 200);
    }

    public function appointmentSchedule()
    {
        $data = Appointment::with(['user:id,avatar,gender'])
            ->where('status', 'pending')
            ->get();

        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        // Group appointments by date and count
        $groupedData = $data->groupBy('appointment_date')
            ->map(function ($appointments) {
                return $appointments->count();
            });

        return $this->success($groupedData, 'Appointment data fetched successfully', 200);
    }

    public function createPrescription(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|exists:appointments,id',
            'date'           => 'required|date',
            'age'            => 'required|numeric',
            'gender'         => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            DB::beginTransaction();

            $prescription = Prescription::create([
                'user_id'        => auth()->user()->id,
                'appointment_id' => $request->appointment_id,
                'date'           => $request->date,
                'age'            => $request->age,
                'gender'         => $request->gender,
                'test_notes'     => $request->test_notes,
                'medicine_notes' => $request->medicine_notes,
            ]);

            if ($request->medicine_name) {
                foreach ($request->medicine_name as $name) {
                    Medicine::create([
                        'prescription_id' => $prescription->id,
                        'medicine_name'   => $name,
                    ]);
                }
            }

            if ($request->test_name) {
                foreach ($request->test_name as $name) {
                    Test::create([
                        'prescription_id' => $prescription->id,
                        'test_name'       => $name,
                    ]);
                }
            }

            DB::commit();
            return $this->success($prescription, 'Prescription created successfully', 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage(), 500);
        }
    }

    public function upcomingAppointments()
    {
        $data = Appointment::with(['user:id,avatar,gender'])
            ->where('status', 'pending')
            ->whereDate('appointment_date', '>', now())
            ->get();

        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Upcoming Appointment data fetched successfully', 200);
    }

}
