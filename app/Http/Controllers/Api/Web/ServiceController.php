<?php

namespace App\Http\Controllers\Api\Web;

use App\Enum\Page;
use App\Models\CMS;
use App\Enum\Section;
use App\Models\Service;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

    public function getWhyChooseUs()
    {
        $query = CMS::where('page_name',  Page::SERVICES)->where('status', 'active');
        foreach (Section::getWhyChooseUs() as $key => $section) {
            $cms[$key] = (clone $query)->where('section_name', $key)->latest()->take($section['item'])->{$section['type']}();
        }
        if ($cms == null) {
            return $this->error([], 'Why Choose Us Content not found', 200);
        }
        return $this->success($cms, 'Why Choose Us Content fetch Successful!', 200);
    }
}
