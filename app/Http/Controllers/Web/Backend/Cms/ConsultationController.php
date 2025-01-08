<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultation = CMS::where('page_name', Page::HOME->value)->where('section_name', Section::CONSULTATION_SECTION->value)->first();
        return view('backend.layouts.cms.consultation.index', compact('consultation'));
    }

    public function ConsultationStore(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $consultation = CMS::where('page_name', Page::HOME->value)->where('section_name', Section::CONSULTATION_SECTION->value)->first();
        if($request->hasFile('image_url')) {
            if($consultation->image_url) {
                $image_path = public_path($consultation->image_url);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                $consultation->image_url = uploadImage($request->file('image_url'), 'cms/consultation');
            }else{
                $consultation->image_url = $consultation->image_url;
            }
        }

        CMS::updateOrCreate(
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::CONSULTATION_SECTION->value, 
            ],
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::CONSULTATION_SECTION->value,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $consultation->image_url,
            ]
        );

        return redirect()->route('cms.home.consultation.index')->with('t-success', 'Consultation content updated successfully.');
    }
}
