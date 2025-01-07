<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    use ApiResponse;

    public function blogs()
    {

        $data = Blog::where('status','active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Blog data fetched successfully', 200);
    }

    public function blogDetail($id)
    {
        $blog = Blog::find($id);

        if (empty($blog)) {
            return $this->error([], 'Blog Not Found', 404);
        }

        return $this->success($blog, 'Blog data fetched successfully', 200);
    }

    public function relatedBlog($id)
    {
        $data = Blog::where('blog_category_id', $id)
                    ->where('status', 'active')
                    ->inRandomOrder()
                    ->take(3)
                    ->get();

        if(!$data)
        {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Related Blog data fetched successfully', 200);
    }
}
