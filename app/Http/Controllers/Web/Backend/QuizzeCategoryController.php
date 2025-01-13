<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\QuizzeCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuizzeCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = QuizzeCategory::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sub_description', function ($data) {
                    $sub_description = $data->sub_description;
                    $short_sub_description = strlen($sub_description) > 100 ? substr($sub_description, 0, 100) . '...' : $sub_description;
                    return '<p>' . $short_sub_description . '</p>';
                })
                ->addColumn('image', function ($data) {
                    $url = asset($data->icon);
                    $image = "<img src='$url' width='50' height='50'>";
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
                    return '<a href="' . route('admin.quizze_categories.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image', 'action', 'blog_category_id', 'sub_description'])
                ->make();
        }
        return view('backend.layouts.quizze_categories.index');
    }

    public function create()
    {
        return view('backend.layouts.quizze_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_description' => 'required|string|max:1000',
            'icon' => 'required|mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

        if($request->hasFile('icon')) {
            $image = $request->file('icon');
            $imageName = uploadImage($image, 'quizze_categories');
        }

        try{
            QuizzeCategory::create([
                'title' => $request->title,
                'slug' => generateUniqueSlug($request->input('title'), 'quizze_categories'),
                'sub_description' => $request->sub_description,
                'icon' => $imageName,
            ]);
            return redirect()->route('admin.quizze_categories.index')->with('success', 'Category created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Category creation failed');
        }
    }

    public function edit($id)
    {
        $data = QuizzeCategory::findOrFail($id);

        if(empty($data)){
            return redirect()->route('admin.quizze_categories.index')->with('t-error', 'Category not found.');
        }

        return view('backend.layouts.quizze_categories.edit', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sub_description' => 'required|string|max:1000',
            'icon' => 'mimes:jpeg,png,jpg,svg,webp|max:2048',
        ]);

       $data = QuizzeCategory::findOrFail($id);

        if(empty($data)){
            return redirect()->route('admin.quizze_categories.index')->with('t-error', 'Category not found.');
        }
        
        if ($request->hasFile('icon')) {
            if ($data->icon) {
                $previousImagePath = public_path($data->icon);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $icon                        = $request->file('icon');
            $iconName                    = uploadImage($icon, 'quizze_categories');
        }else {
            $iconName = $data->image;
        }

        try{
            $data->update([
                'title' => $request->title,
                'slug' => generateUniqueSlug($request->input('title'), 'quizze_categories'),
                'sub_description' => $request->sub_description,
                'icon' => $iconName,
            ]);
            return redirect()->route('admin.quizze_categories.index')->with('success', 'Category updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Category update failed');
        }
    }

    public function destroy($id)
    {
        $data = QuizzeCategory::find($id);

        if($data->icon) {

            $previousImagePath = public_path($data->icon);

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

            return response()->json(['message' => 'Quizze Category not found'], 404);

        }
    }

    public function status($id)
    {
        $data = QuizzeCategory::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Quizze Category not found'], 404);
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
