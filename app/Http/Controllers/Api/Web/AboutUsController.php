<?php

namespace App\Http\Controllers\Api\Web;

use App\Enum\Page;
use App\Models\CMS;
use App\Enum\Section;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AboutUsController extends Controller
{
    use ApiResponse;
    
    public function getAboutUs()
    {
        $query = CMS::where('page_name',  Page::ABOUT_US)->where('status', 'active');
        
        foreach (Section::getAboutUs() as $key => $section) {

            $cms[$key] = (clone $query)->where('section_name', $key)->latest()->take($section['item'])->{$section['type']}();

        }

        if ($cms == null) {

            return $this->error([], 'Why Choose Us Content not found', 200);

        }

        return $this->success($cms, 'Why Choose Us Content fetch Successful!', 200);
    }
}
