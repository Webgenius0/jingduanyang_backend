<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::latest()->get();
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
                ->addColumn('image', function ($data) {
                    $url = asset($data->image);
                    $image       = "<img src='$url' width='100' height='100'>";
                    return $image;
                })
                ->addColumn('blog_category_id', function ($data) {
                    return '<p>' . $data->category->name . ' </p>';
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
                    return '<a href="' . route('admin.blogs.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image', 'action', 'blog_category_id', 'sub_description'])
                ->make();
        }
        return view('backend.layouts.blog.index');
    }

    public function create()
    {
        $blog_categories = BlogCategory::all();
        return view('backend.layouts.blog.create', compact('blog_categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'sub_description' => 'nullable|max:1000',
            'description'  => 'required',
            'image'         => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'blog_category_id' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $image                        = $request->file('image');
            $imageName                    = uploadImage($image, 'Blog');
        }

        Blog::create([
            'title'         => $request->title,
            'slug'          => generateUniqueSlug($request->input('title'), 'blogs'),
            'sub_description' => $request->sub_description,
            'description'  => $request->description,
            'image'         => $imageName,
            'blog_category_id' => $request->blog_category_id,
        ]);

        return redirect()->route('admin.blogs.index')->with('t-success', 'Blog created successfully.');
    }

    public function edit($id)
    {
        $blog_categories = BlogCategory::all();
        $blog            = Blog::find($id);
        if (empty($blog)) {
            return redirect()->route('admin.blogs.index')->with('t-error', 'Blog not found.');
        }
        return view('backend.layouts.blog.edit', compact('blog', 'blog_categories'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title'         => 'required',
           'sub_description' => 'nullable|max:1000',
            'description'  => 'required',
            'blog_category_id' => 'required',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $blog = Blog::findOrFail($id);

        if (empty($blog)) {
            return redirect()->route('admin.blogs.index')->with('t-error', 'Blog not found.');
        }
        if ($request->hasFile('image')) {

            if ($blog->image) {
                $previousImagePath = public_path($blog->image);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }
            $image                        = $request->file('image');
            $imageName                    = uploadImage($image, 'Blog');
        }else {
            $imageName = $blog->image;
        }

        try{
            Blog::where('id',$id)->update([
                'title'         => $request->title,
                'slug'          => generateUniqueSlug($request->input('title'), 'blogs'),
                'sub_description' => $request->sub_description,
                'description'  => $request->description,
                'image'         => $imageName,
                'blog_category_id' => $request->blog_category_id,
            ]);
            return redirect()->route('admin.blogs.index')->with('t-success', 'Blog updated successfully.');
        }catch (\Exception $e) {
            return redirect()->route('admin.blogs.index')->with('t-error',  'Something went wrong');
        }
    }

    public function destroy($id)
    {
        $data = Blog::find($id);

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

            return response()->json(['message' => 'Blog not found'], 404);

        }
    }

    public function status($id)
    {
        $data = Blog::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Blog not found'], 404);
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
