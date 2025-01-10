<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ProductCategory::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('name', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
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
                    return '<button type="button" data-id="' . $data->id . '" class="edit btn btn-primary text-white btn-sm" title="Edit"> <i class="bi bi-pencil"></i></button>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'action'])
                ->make();
        }
        return view('backend.layouts.product_category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:product_categories',
        ]);

        try {
            ProductCategory::create([
                'name' => $request->name,
                'slug' => generateUniqueSlug($request->name, 'product_categories'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully!',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success'=> false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        $data = ProductCategory::find($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category = ProductCategory::find($id);
        if ($category) {
            $category->update([
                'name' => $request->name,
                'slug'=> generateUniqueSlug($request->name,'product_categories'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Category not found!'
            ]);
        }
    }

     public function destroy($id)
    {
        try {
            ProductCategory::destroy($id);

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], 500);
        }
    }

    public function status(int $id)
    {
        $data = ProductCategory::findOrFail($id);
        
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
