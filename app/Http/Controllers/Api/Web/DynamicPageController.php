<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\DynamicPage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class DynamicPageController extends Controller
{

    use ApiResponse;

    
    public function getDynamicPage()
    {
        $data = DynamicPage::where('status', 'active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Page fetched successfully', 200);
    }

    public function singelPage($id)
    {
        $data = DynamicPage::find($id);

        if (empty($data)) {
            return $this->error([], 'Page Not Found', 404);
        }

        return $this->success($data, 'Page fetched successfully', 200);
    }
}
