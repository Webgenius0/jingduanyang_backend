<?php
namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Mail\DoctorAccountActive;
use App\Models\PsychologistInformation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'doctor')->latest()->get();
            if (! empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('first_name', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    if (! empty($data->avatar)) {
                        $url = asset($data->avatar);
                    } else {
                        $url = asset('backend/images/placeholder/profile.jpeg');
                    }
                    $image = "<img src='$url' width='50' height='50'>";
                    return $image;
                })
                ->editColumn('name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })
                ->addColumn('qualification', function ($data) {
                    if(empty($data->psychologistInformation->qualification)){
                        return 'N/A';
                    }
                    return $data->psychologistInformation->qualification;
                })
                ->addColumn('ahpra_registration_number', function ($data) {
                    if(empty($data->psychologistInformation->ahpra_registration_number)){
                        return 'N/A';
                    }
                    return $data->psychologistInformation->ahpra_registration_number;
                })
                ->addColumn('experience', function ($data) {
                    if(empty($data->psychologistInformation->experience)){
                        return 'N/A';
                    }
                    return $data->psychologistInformation->experience;
                })
                ->addColumn('session_length', function ($data) {
                    if(empty($data->psychologistInformation->session_length)){
                        return 'N/A';
                    }
                    return $data->psychologistInformation->session_length;
                })
                ->addColumn('cust_per_session', function ($data) {
                    if(empty($data->psychologistInformation->cust_per_session)){
                        return 'N/A';
                    }
                    return '$' . $data->psychologistInformation->cust_per_session;
                })
                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->psychologistInformation->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->psychologistInformation->id . '" getAreaid="' . $data->psychologistInformation->id . '" name="status"';
                    if ($data->psychologistInformation->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })

                ->rawColumns(['status', 'image', 'name', 'qualification', 'experience', 'session_length', 'cust_per_session', 'ahpra_registration_number'])
                ->make();
        }

        return view('backend.layouts.doctor.index');
    }

    public function status($id)
    {
        $data = PsychologistInformation::with('user')->find($id);

        // dd($data->user->email);

        if (empty($data)) {
            return response()->json(['message' => 'Psychologist not found'], 404);
        }

        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            Mail::to($data->user->email)->send(new DoctorAccountActive($data));

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

}
