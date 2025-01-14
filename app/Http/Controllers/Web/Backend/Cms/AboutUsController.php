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

    public function TrackRecord()
    {
        $empowered_client = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::EMPOWERED_CLIENTS->value)->first();
        $patient_satisfaction = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::PATIENT_SATISFACTION->value)->first();
        $experience = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::EXPERIENCE->value)->first();
        $certified_expert = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::CERTIFIED_EXPERT->value)->first();
        $total_employees = CMS::where('page_name', Page::ABOUT_US->value)->where('section_name', Section::EMPLOYEES->value)->first();
        return view('backend.layouts.cms.about_us.track_record.index',compact('empowered_client','patient_satisfaction','experience','certified_expert','total_employees'));
    }

    public function EmpoweredClients(Request $request)
    {
        $request->validate([
            'empowered_clients' => 'required|numeric|max:100',
        ]);

        CMS::updateOrCreate(
        [
        'page_name' => Page::ABOUT_US->value,
        'section_name' => Section::EMPOWERED_CLIENTS->value
        ],
        [
            'page_name' => Page::ABOUT_US->value,
            'section_name' => Section::EMPOWERED_CLIENTS->value,
            'title' => $request->empowered_clients
        ]);

        return redirect()->back()->with('t-success', 'Total Empowered Clients updated successfully.');
    }

    public function PatientsSatisfaction(Request $request)
    {
        $request->validate([
            'total_satisfaction' => 'required|numeric',
        ]);

        CMS::updateOrCreate(
        [
        'page_name' => Page::ABOUT_US->value,
        'section_name' => Section::PATIENT_SATISFACTION->value
        ],
        [
            'page_name' => Page::ABOUT_US->value,
            'section_name' => Section::PATIENT_SATISFACTION->value,
            'title' => $request->total_satisfaction
        ]);

        return redirect()->back()->with('t-success', 'Total Patient Satisfaction updated successfully.');
    }

    public function YearsOfExperience(Request $request)
    {
        $request->validate([
            'experience' => 'required|numeric',
        ]);

        CMS::updateOrCreate(
        [
        'page_name' => Page::ABOUT_US->value,
        'section_name' => Section::EXPERIENCE->value
        ],
        [
            'page_name' => Page::ABOUT_US->value,
            'section_name' => Section::EXPERIENCE->value,
            'title' => $request->experience
        ]);

        return redirect()->back()->with('t-success', 'Years of Experience updated successfully.');
    }

    public function CertifiedExpert(Request $request)
    {
        $request->validate([
            'certified_expert' => 'required|numeric',
        ]);

        CMS::updateOrCreate(
        [
        'page_name' => Page::ABOUT_US->value,
        'section_name' => Section::CERTIFIED_EXPERT->value
        ],
        [
            'page_name' => Page::ABOUT_US->value,
            'section_name' => Section::CERTIFIED_EXPERT->value,
            'title' => $request->certified_expert
        ]);

        return redirect()->back()->with('t-success', 'Certified Expert updated successfully.');
    }

    public function TotalEmployees(Request $request)
    {
        $request->validate([
            'employees' => 'required|numeric',
        ]);

        CMS::updateOrCreate(
        [
        'page_name' => Page::ABOUT_US->value,
        'section_name' => Section::EMPLOYEES->value
        ],
        [
            'page_name' => Page::ABOUT_US->value,
            'section_name' => Section::EMPLOYEES->value,
            'title' => $request->employees
        ]);

        return redirect()->back()->with('t-success', 'Total Employees updated successfully.');
    }
}
