<?php

namespace App\Http\Controllers\Api\Web;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use App\Traits\ApiResponse;

class HomePageController extends Controller
{
    use ApiResponse;
    public function getHomePage()
    {

        $query = CMS::where('page_name', Page::HOME)->where('status', 'active');
        foreach (Section::getHome() as $key => $section) {
            $cms[$key] = (clone $query)->where('section_name', $key)->latest()->take($section['item'])->{$section['type']}();
        }
        if ($cms == null) {
            return $this->error([], 'Home Page Content not found', 200);
        }
        return $this->success($cms, 'Home Page Content fetch Successful!', 200);
    }

}
