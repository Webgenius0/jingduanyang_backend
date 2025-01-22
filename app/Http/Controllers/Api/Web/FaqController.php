<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\FAQ;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{

    use ApiResponse;

    public function getFaqs()
    {
        $data = FAQ::where('status','active') ->take(5)->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Faq data fetched successfully', 200);
    }
}
