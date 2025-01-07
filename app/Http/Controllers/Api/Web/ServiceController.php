<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{

    use ApiResponse;


    public function getServices() {

        $data = Service::where('status','active')->get();

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Services fetched successfully', 200);
    }

    public function serviceDetail($id) {

        $service = Service::find($id);

        if (empty($service)) {
            
            return $this->error([], 'Service Not Found', 404);
        }

        return $this->success($service, 'Service fetched successfully', 200);
    }
}
