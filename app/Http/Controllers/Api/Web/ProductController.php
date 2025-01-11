<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Product;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    use ApiResponse;
    
    public function getProducts()
    {
        $data = Product::with(['images'])->where('status','active')->paginate(20);

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Product data fetched successfully', 200);
    }

    public function productDetail($id)
    {
        $product = Product::with(['images','benefits'])->find($id);

        if (empty($product)) {
            return $this->error([], 'Product Not Found', 404);
        }

        return $this->success($product, 'Product data fetched successfully', 200);
    }
}
