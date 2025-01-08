<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HelpController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CMS::Where('page_name',Page::HOME->value)->where('section_name',Section::HELP_SECTION_ITEMS)->latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image_url', function ($data) {
                    $url = asset($data->image_url);
                    $image_url       = "<img src='$url' width='50' height='50'>";
                    return $image_url;
                })
                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })
                ->addColumn('action', function ($data) {
                    return '<a href="' . route('item.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'image_url', 'action', 'blog_category_id', 'sub_description'])
                ->make();
        }
        $help_section = CMS::where('page_name',Page::HOME->value)->where('section_name',Section::HELP_SECTION)->first();
        return view('backend.layouts.cms.help.index', compact('help_section'));
    }

    public function HelpSectionStore(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'description'   => 'required',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $help_section = CMS::where('page_name', Page::HOME->value)->where('section_name', Section::HELP_SECTION->value)->first();
        if($request->hasFile('image_url')) {
            if($help_section->image_url) {
                $image_path = public_path($help_section->image_url);
                if(file_exists($image_path)) {
                    unlink($image_path);
                }
                $help_section->image_url = uploadImage($request->file('image_url'), 'cms/help-section');
            }else{
                $help_section->image_url = $help_section->image_url;
            }
        }

        CMS::updateOrCreate(
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::HELP_SECTION->value, 
            ],
            [
                'page_name' => Page::HOME->value,
                'section_name' => Section::HELP_SECTION->value,
                'title' => $request->title,
                'description' => $request->description,
                'image_url' => $help_section->image_url,
            ]
        );

        return redirect()->route('cms.home.help_section.index')->with('t-success', 'About Us content updated successfully.');
    }

    public function Create()
    {
        return view('backend.layouts.cms.help.create');
    }

    public function Store(Request $request)
    {
        $request->validate([
            'title'         => 'required',
            'image_url'     => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $image                        = $request->file('image_url');
            $imageName                    = uploadImage($image, 'cms/help');
        }

        CMS::create([
            'page_name'          => Page::HOME->value,
            'section_name'       => Section::HELP_SECTION_ITEMS->value,
            'title'             => $request->title,
            'image_url'       => $imageName,
        ]);

        return redirect()->route('cms.home.help_section.index')->with('t-success', 'Help Section item created successfully.');
    }

    public function Edit($id)
    {
        $cms = CMS::find($id);
        if (empty($cms)) {
            return redirect()->route('cms.home.help_section.index')->with('error', 'Help Section item not found.');
        }
        return view('backend.layouts.cms.help.edit', compact('cms'));
    }

    public function Update(Request $request, $id)
    {
        $request->validate([
            'title'         => 'required',
            'image_url'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $cms = CMS::find($id);
        if (empty($cms)) {
            return redirect()->route('cms.home.help_section.index')->with('error', 'Help Section item not found.');
        }
        if ($request->hasFile('image_url')) {
            if ($cms->image_url) {
                $image_path = public_path($cms->image_url);
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                $cms->image_url = uploadImage($request->file('image_url'), 'cms/help');
            }else{
                $cms->image_url = $cms->image_url;
            }
        }
    
        $cms->update(
            [
                'page_name'          => Page::HOME->value,
                'section_name'       => Section::HELP_SECTION_ITEMS->value,
                'title'             => $request->title,
                'image_url'       => $cms->image_url,
            ]
        );
        return redirect()->route('cms.home.help_section.index')->with('t-success', 'Help Section item updated successfully.');
    }

    public function Destroy($id)
    {
        $data = CMS::find($id);

        if($data->image_url) {

            $previousImagePath = public_path($data->image_url);

            if (file_exists($previousImagePath)) {
                unlink($previousImagePath);
            }
        }

        if (!empty($data)) {

            $data->delete();

            return response()->json([
                't-success' => true,
                'message'   => 'Deleted successfully.',
            ]);

        } else {

            return response()->json(['message' => 'Item not found'], 404);

        }
    }

    public function Status($id)
    {
        $data = CMS::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
        }
    }

}
