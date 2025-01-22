<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\SocialMedia;
use App\Models\SystemSetting;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    use ApiResponse;

    public function SystemSetting() {

        $data = SystemSetting::all();

        if (!$data) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'System Setting data fetched successfully', 200);
    }

    public function socialMedia() {

        $data = SocialMedia::all();

        if (!$data) {
            return $this->success([], 'Data Not Found', 200);
        }

        return $this->success($data, 'Social Media data fetched successfully', 200);
    }
}
