<?php
namespace App\Http\Controllers\Api\Web;

use App\Models\Review;
use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use ApiResponse;

    public function getProducts(Request $request)
    {
        $limit = $request->limit;
        if (!$limit) {
            $limit = 20;
        }
    
        $data = Product::with(['images'])
            ->select('products.*', 
                DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id) as average_rating')
            )
            ->where('status', 'active')
            ->paginate($limit);
    
        if (!$data) {
            return $this->success([], 'Data Not Found', 200);
        }
    
        return $this->success($data, 'Product data fetched successfully', 200);
    }

    public function productDetail($id)
    {
        $product = Product::with(['images', 'benefits'])
                    ->select('products.*', 
                        DB::raw('(SELECT AVG(rating) FROM reviews WHERE reviews.product_id = products.id) as average_rating')
                    )
                    ->find($id);

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
            ->get();

        $data = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'user_id' => $item->user_id,
                'rating' => $item->rating,
                'comment' => $item->comment,
                'created_at' => $item->created_at->format('d-m-Y'),
                'images' => $item->images,
                'user' => [
                    'first_name' => $item->user->first_name,
                    'last_name' => $item->user->last_name,
                    'avatar' => $item->user->avatar,
                ],
            ];
        });

            // dd($data);

        if ($data->isEmpty()) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Review data fetched successfully', 200);
    }
}
