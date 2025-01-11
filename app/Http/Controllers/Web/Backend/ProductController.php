<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Models\ProductBenefit;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    // $url = asset($data->images->first()->images);
                    if (empty($data->images->first()->images)) {
                        $url = asset('backend/images/placeholder/Untitled.jpg');
                        
                    }else{
                        $url = asset($data->images->first()->images);
                    }
                    $image       = "<img src='$url' width='50' height='50'>";
                    return $image;
                })
                ->addColumn('category_name', function ($data) {
                    return '<p>' . $data->product_category->name . ' </p>';
                })
                ->editColumn('stock', function ($data) {
                    if ($data->quantity > 0) {
                        return '<span class="badge bg-success text-white">Stock</span>';
                    } else {
                        return '<span class="badge bg-danger text-white">Stock Out</span>';
                    }
                })
                ->editColumn('price', function ($data) {
                    return '$' . $data->price;
                })
                ->editColumn('discount_price', function ($data) {
                    if($data->discount_price > 0){
                        return '$' . $data->discount_price;
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
                    return '<a href="' . route('admin.products.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image', 'action', 'category_name','stock','discount_price','price'])
                ->make();
        }
        return view('backend.layouts.product.index');
    }

    public function create()
    {
        $categories = ProductCategory::all();
        return view('backend.layouts.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|string|max:255',
            'price'=> 'required|numeric',
            'discount_price'=> 'required|numeric',
            'quantity' =>'required|numeric',
            'gallery_images.*' => 'nullable|image|mimes:png,jpg,jpeg|max:4048',
            'product_benefits.*' => 'nullable|string',
            'description' => 'required|string',
            'about' => 'nullable|string|max:40000',
        ],[
            'gallery_images.*.required' => 'Each image is required.',
            'gallery_images.*.image' => 'Each file must be an image.',
            'gallery_images.*.mimes' => 'Only jpeg, png, jpg, and gif files are allowed.',
            'gallery_images.*.max' => 'Image size must not exceed 2MB.',
        ]);

        try
        {
            DB::beginTransaction();
            // create product
            $product = Product::create([
                'title'=> $request->title,
                'slug'=> generateUniqueSlug($request->input('title'), 'products'),
                'price'=> $request->price,
                'discount_price'=> $request->discount_price,
                'quantity' => $request->quantity,
                'description' => $request->description,
                'about'=> $request->about,
                'product_category_id' => $request->product_category_id,
            ]);

            if ($request->hasFile('image')) {
                $image        = $request->file('image');
                $imageName    = uploadImage($image, 'Service');
            }

             // gallery images
             if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imageName    = uploadImage($image, 'product/images');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'images' => $imageName,
                    ]);
                }
            }
            // product benefits
            if ($request->product_benefits) {
                foreach ($request->product_benefits as $benefit) {
                    ProductBenefit::create([
                        'product_id' => $product->id,
                        'title' => $benefit,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('t-success', 'Product created successfully');
        }catch(\Exception $e)
        {
            DB::rollBack();
            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $product = Product::with(['images','benefits'])->findOrFail($id);
        $categories = ProductCategory::all();
        return view('backend.layouts.product.edit',  compact('product','categories'));
    }


    public function status($id)
    {
        $data = Product::find($id);
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

    public function ImageDelete($id)
    {
        $data = ProductImage::findOrFail($id);

        if (empty($data)) {

            return response()->json([
                'success' => false,
                "message" => "Item not found."
            ], 404);

        }

        // Delete the image file from storage
        if (file_exists(public_path($data->images))) {

            unlink(public_path($data->images));

        }

        // Delete the record from the database
        $data->delete();

        return response()->json([
            "success" => true,
            "message" => "Image deleted successfully."
        ], 200);
    }

    public function destroy($id)
    {
        $data = Product::findOrFail($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found.',
            ], 404);
        }
        if (file_exists(public_path($data->images))) {
            unlink(public_path($data->images));
        }

        $data->forceDelete();

        $benefits = ProductBenefit::where('product_id', $id)->get();
        foreach ($benefits as $benefit) {
            $benefit->delete();
        }
        
        $data->delete();

        return response()->json([
            'success' => true,
            'message'   => 'Deleted successfully.',
        ]);
    }
}
