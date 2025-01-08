<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index()
    {
        $education = CMS::where('page_name', Page::HOME->value)->where('section_name', Section::EDUCATION_SECTION->value)->first();
        return view('backend.layouts.cms.education.index', compact('education'));
    }

    public function EducationStore(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $education = CMS::where('page_name', Page::HOME->value)->where('section_name', Section::EDUCATION_SECTION->value)->first();
        if($request->hasFile('image_url')) {
            if($education->image_url) {
                $image_path = public_path($education->image_url);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                $education->image_url = uploadImage($request->file('image_url'), 'cms/education');
            }else{
                $education->image_url = $education->image_url;
            }
        }

        CMS::updateOrCreate(
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::EDUCATION_SECTION->value, 
            ],
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::EDUCATION_SECTION->value,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $education->image_url,
            ]
        );

        return redirect()->route('cms.home.education.index')->with('t-success', 'Education content updated successfully.');
    }
}
