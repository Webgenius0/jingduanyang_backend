<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function HeroSection() {
        $hero_section = CMS::where('page_name', Page::HOME->value)->where('section_name',Section::HERO_SECTION->value)->first();
        return view('backend.layouts.cms.home.hero_section', compact('hero_section'));
    }

    public function HeroSectionStore(Request $request)
    {
        $request->validate([
            'title'          => ['required','max:255'],
            'sub_title'      => ['required','max:255'],
            'description'    => ['required'],
        ]);

        CMS::updateOrCreate(
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::HERO_SECTION->value,
            ],
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::HERO_SECTION->value,
                'title' => $request->title,
                'sub_title' => $request->sub_title,
                'description' => $request->description,
            ]
        );

        return redirect()->route('cms.home.hero_section')->with('t-success', 'Hero Section updated successfully.');
    }
}
