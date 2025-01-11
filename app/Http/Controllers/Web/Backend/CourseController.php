<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Courses;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Courses::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn(name: 'image_url', content: function ($data) {
                    $url = asset($data->image_url);
                    $image_url = "<img src='$url' width='50' height='50'>";
                    return $image_url;
                })
                ->editColumn('price', function ($data) {
                    if ($data->price > 0) {
                        return '$' . $data->price;
                    } else {
                        return '<span class="badge bg-danger text-white">Free</span>';
                    }
                })
                ->editColumn('type', function ($data) {
                    if ($data->type == 'free') {
                        return '<span class="badge bg-success text-white">Free</span>';
                    } else {
                        return '<span class="badge bg-danger text-white">Premium</span>';
                    }
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
                    return '<a href="' . route('admin.courses.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image_url', 'action', 'price', 'type'])
                ->make();
        }
        return view('backend.layouts.courses.index');
    }

    public function create()
    {
        return view('backend.layouts.courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'type' => 'required|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'image_url' => 'required|image|mimes:jpeg,png,jpg',

        ]);

        try {
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
                $imageName = uploadImage($image, 'courses');
            } else {
                $imageName = null;
            }

            Courses::create([
                'title' => $request->title,
                'slug' => generateUniqueSlug($request->input('title'), 'courses'),
                'price' => $request->price,
                'type' => $request->type,
                'video_url' => $request->video_url,
                'image_url' => $imageName,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $course = Courses::findOrFail($id);

        if(empty($course)){

            return redirect()->route('admin.courses.index')->with('t-error', 'Course not found.');
        }

        return view('backend.layouts.courses.edit', data: compact('course'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'nullable|numeric',
            'type' => 'required|string|max:255',
            'video_url' => 'nullable|string|max:255',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg',

        ]);

        $course = Courses::findOrFail($id);

        if(empty($course)){
            return redirect()->route('admin.courses.index')->with('t-error', 'Course not found.');
        }

        if ($request->hasFile( 'image_url')) {

            if ($course->image_url) {
                $previousImagePath = public_path($course->image_url);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image                        = $request->file('image_url');
            $imageName                    = uploadImage($image, 'courses');
        }else {
            $imageName = $course->image_url;
        }

        try {
            $course->update([
                'title' => $request->title,
                'slug' => generateUniqueSlug($request->input('title'), 'courses'),
                'price' => $request->price,
                'type' => $request->type,
                'video_url' => $request->video_url,
                'image_url' => $imageName,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    public function status($id)
    {
        $data = Courses::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Courses not found'], 404);
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

    public function destroy($id)
    {
        $data = Courses::find($id);

        if($data->image_url) {

            $previousImagePath = public_path($data->image_url);

            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        if (!empty($data)) {

            $data->delete();

            return response()->json([
                'success' => true,
                'message'   => 'Deleted successfully.',
            ]);

        } else {

            return response()->json([
                'success' => false,
                'message' => 'Courses not found'
            ], 404);

        }
    }
}
