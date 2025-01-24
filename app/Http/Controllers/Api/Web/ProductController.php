<?php
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponse;

    public function getProducts(Request $request)
    {
        $limit = $request->limit;
        if (! $limit) {
            $limit = 20;
        }
        $data = Product::with(['images'])->where('status', 'active')->paginate($limit);

        if (! $data) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Product data fetched successfully', 200);
    }

    public function productDetail($id)
    {
        $product = Product::with(['images', 'benefits'])->find($id);

        if (empty($product)) {
            return $this->success([], 'Product Not Found', 200);
        }

        return $this->success($product, 'Product data fetched successfully', 200);
    }

    public function reviewProduct($id)
    {
        $data = Review::with('images', 'user:id,first_name,last_name,avatar')
            ->where('product_id', $id)
            ->select('id', 'product_id', 'user_id', 'rating', 'comment', 'created_at')
            ->orderBy('created_at', 'desc')
            
            ->paginate(10);
        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Review data fetched successfully', 200);
    }

}
