<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AboutUsController extends Controller
{
    public function index(Request $request)
    {

        $about_us = CMS::where('page_name',Page::ABOUT_US->value)->where('section_name',Section::ABOUT_US_SECTION->value)->first();

        return view('backend.layouts.cms.about_us.index', compact('about_us'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $about_us = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::ABOUT_US_SECTION->value)->first();
        if($request->hasFile('image_url')) {
            if($about_us->image_url) {
                $image_path = public_path($about_us->image_url);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                $about_us->image_url = uploadImage($request->file('image_url'), 'cms/about-us');
            }else{
                $about_us->image_url = $about_us->image_url;
            }
        }

        CMS::updateOrCreate(
            [
                'page_name' => Page::ABOUT_US->value,
                'section_name' => Section::ABOUT_US_SECTION->value, 
            ],
            [
                'page_name' => Page::ABOUT_US->value,
                'section_name' => Section::ABOUT_US_SECTION->value,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $about_us->image_url,
            ]
        );

        return redirect()->route('cms.about_us.index')->with('t-success', 'About Us content updated successfully.');
    }
}
