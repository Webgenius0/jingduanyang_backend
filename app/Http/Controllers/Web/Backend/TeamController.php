<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Team::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('name', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('image', function ($data) {
                    $url = asset($data->image_url);
                    $image       = "<img src='$url' width='50' height='50'>";
                    return $image;
                })

                ->addColumn('total_fees', function ($data) {
                    return '$'. $data->total_fees;
                })

                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('admin.teams.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image', 'action'])
                ->make();
        }

        return view('backend.layouts.teams.index');
    }

    public function create()
    {
        return view('backend.layouts.teams.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'specialty'    => 'required',
            'experience'   => 'required',
            'consult_duration'   => 'required',
            'total_fees'   => 'required|numeric|integer',
            'phone_one'   => 'required',
            'phone_two'   => 'nullable',
            'location'   => 'nullable',
            'about'   => 'nullable',
            'specializes' => 'nullable|max:1500',
            'image_url'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // dd($request->all());

        try{
            if ($request->hasFile('image_url')) {
                $image                        = $request->file('image_url');
                $imageName                    = uploadImage($image, 'team');
            }

            Team::create([
                'name'         => $request->name,
                'specialty'    => $request->specialty,
                'experience'   => $request->experience,
                'consult_duration'   => $request->consult_duration,
                'total_fees'   => $request->total_fees,
                'phone_one'   => $request->phone_one,
                'phone_two'   => $request->phone_two,
                'location'   => $request->location,
                'about'   => $request->about,
                'specializes' => $request->specializes,
                'image_url'         => $imageName,
            ]);

            return redirect()->route('admin.teams.index')->with('success', 'Team created successfully.');
        }catch (\Exception $e) {
            return redirect()->route('admin.teams.index')->with('t-error',  'Something went wrong');
        }
    }

    public function edit($id)
    {
        $team = Team::find($id);
        if (empty($team)) {
            return redirect()->route('admin.teams.index')->with('error', 'Team not found.');
        }

        return view('backend.layouts.teams.edit', compact('team'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required',
            'specialty'    => 'required',
            'experience'   => 'required',
            'consult_duration'   => 'required',
            'total_fees'   => 'required|numeric|integer',
            'phone_one'   => 'required',
            'phone_two'   => 'nullable',
            'location'   => 'nullable',
            'about'   => 'nullable',
            'specializes' => 'nullable|max:1500',
            'image_url'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $team = Team::find($id);
        if (empty($team)) {
            return redirect()->route('admin.teams.index')->with('error', 'Team not found.');
        }
        if ($request->hasFile('image_url')) {

            if ($team->image_url) {
                $previousImagePath = public_path($team->image_url);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image                        = $request->file('image_url');
            $imageName                    = uploadImage($image, 'team');
        }else {
            $imageName = $team->image_url;
        }

        try{
            $team->update([
                'name'         => $request->name,
               'specialty'    => $request->specialty,
                'experience'   => $request->experience,
                'consult_duration'   => $request->consult_duration,
                'total_fees'   => $request->total_fees,
                'phone_one'   => $request->phone_one,
                'phone_two'   => $request->phone_two,
                'location'   => $request->location,
                'about'   => $request->about,
               'specializes' => $request->specializes,
                'image_url'         => $imageName,
            ]);

            return redirect()->route('admin.teams.index')->with('t-success', 'Team updated successfully.');
        }catch (\Exception $e) {
            return redirect()->route('admin.teams.index')->with('t-error',  'Something went wrong');
        }
    }

    public function destroy($id)
    {
        $data = Team::find($id);

        if($data->image) {

            $previousImagePath = public_path($data->image);

            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        if (!empty($data)) {

            $data->delete();

            return response()->json([
                't-success' => true,
                'message'   => 'Deleted successfully.',
            ]);

        } else {

            return response()->json(['message' => 'Team not found'], 404);

        }
    }

    public function status($id)
    {
        $data = Team::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Team not found'], 404);
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

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }
}
