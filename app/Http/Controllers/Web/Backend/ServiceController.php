<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Service::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sub_description', function ($data) {
                    $sub_description       = $data->sub_description;
                    $short_sub_description = strlen($sub_description) > 100 ? substr($sub_description, 0, 100) . '...' : $sub_description;
                    return '<p>' . $short_sub_description . '</p>';
                })
                ->addColumn('icon', function ($data) {
                    $url = asset($data->icon);
                    $icon       = "<img src='$url' width='50' height='50'>";
                    return $icon;
                })
                ->addColumn('image', function ($data) {
                    $url = asset($data->image);
                    $image       = "<img src='$url' width='50' height='50'>";
                    return $image;
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
                    return '<a href="' . route('admin.services.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image', 'action', 'sub_description', 'icon'])
                ->make();
        }
        return view('backend.layouts.service.index');
    }

    public function create()
    {
        return view('backend.layouts.service.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'sub_description' => 'nullable|max:1000',
            'description'    => 'required',
            'icon'          => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {

            $image_icon = uploadImage($request->file('icon'), 'services');
            $image_image = uploadImage($request->file('image'), 'services');

            Service::create([
                'title'         => $request->title,
                'slug'          => generateUniqueSlug($request->input('title'), 'services'),
                'sub_description' => $request->sub_description,
                'description'    => $request->description,
                'icon'          => $image_icon,
                'image'         => $image_image,
            ]);

            return redirect()->route('admin.services.index')->with('t-success', 'Service created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('t-error',  'Something went wrong');
        }
    }

    public function edit($id)
    {
        $service = Service::find($id);
        if (empty($service)) {
            return redirect()->route('admin.services.index')->with('t-error', 'Service not found.');
        }
        return view('backend.layouts.service.edit', compact('service'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required',
            'sub_description' => 'nullable|max:1000',
            'description'    => 'required',
            'icon'          => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = Service::find($id);

        if (empty($data)) {
            return redirect()->route('admin.services.index')->with('t-error', 'Service not found.');
        }

        if ($request->hasFile('image')) {

            if ($data->image) {
                $previousImagePath = public_path($data->image);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image                        = $request->file('image');
            $imageName                    = uploadImage($image, 'services');
        } else {
            $imageName = $data->image;
        }

        if ($request->hasFile('icon')) {

            if ($data->icon) {
                $previousImagePath = public_path($data->icon);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $icon                        = $request->file('icon');
            $iconName                    = uploadImage($icon, 'services');
        } else {
            $iconName = $data->icon;
        }
        try {
            $data->title         = $request->title;
            $data->slug          = generateUniqueSlug($request->input('title'), 'services');
            $data->sub_description = $request->sub_description;
            $data->description    = $request->description;
            $data->icon          = $iconName;
            $data->image         = $imageName;
            $data->save();
            return redirect()->route('admin.services.index')->with('t-success', 'Service updated successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.services.index')->with('t-error', 'Something went wrong');
        }
    }

    public function destroy($id)
    {
        $data = Service::find($id);

        if (empty($data)) {
            return response()->json([
                'error' => true,
                'message' => 'Service not found.'
            ]);
        }

        if ($data->image) {
            $previousImagePath = public_path($data->image);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        if ($data->icon) {
            $previousImagePath = public_path($data->icon);
            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Service Deleted Successfully.'
        ]);
    }

    public function status($id)
    {
        $data = Service::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Service not found'], 404);
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
