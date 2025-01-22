<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\Courses;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CourseController extends Controller
{
    use ApiResponse;

    public function PremiumCourses()
    {
        $data = Courses::where('type','premium')->where('status','active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Course data fetched successfully', 200);
    }

    public function freeCourses()
    {
        $data = Courses::where('type','free')->where('status','active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 200);
        }

        return $this->success($data,'Course data fetched successfully', 200);
    }
}
