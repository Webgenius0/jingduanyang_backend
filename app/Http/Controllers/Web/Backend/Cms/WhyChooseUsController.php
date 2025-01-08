<?php

namespace App\Http\Controllers\Web\Backend\Cms;

use App\Enum\Page;
use App\Enum\Section;
use App\Http\Controllers\Controller;
use App\Models\CMS;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = CMS::where('page_name', Page::SERVICES->value)->where('section_name', Section::WHY_CHOOSE_US_SECTION->value)->latest()->get();

            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('title', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('description', function ($data) {
                    $description       = $data->description;
                    $short_description = strlen($description) > 100 ? substr($description, 0, 100) . '...' : $description;
                    return '<p>' . $short_description . '</p>';
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
                    return '<a href="' . route('cms.why_choose_us.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>

                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'action','description'])
                ->make();
        }
        return view('backend.layouts.cms.why_choose.index');
    }

    public function create()
    {
        return view('backend.layouts.cms.why_choose.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'         => ['required','max:255'],
            'description'    => ['required','max:2000'],
        ]);

        CMS::create([
            'page_name'          => Page::SERVICES->value,
            'section_name'       => Section::WHY_CHOOSE_US_SECTION->value,
            'title'             => $request->title,
            'description'       => $request->description,
        ]);

        return redirect()->route('cms.why_choose_us.index')->with('success', 'Why Choose Us created successfully.');
    }

    public function edit($id)
    {
        $cms = CMS::find($id);
        if (empty($cms)) {
            return redirect()->route('cms.why_choose_us.index')->with('error', 'Why Choose Us not found.');
        }
        return view('backend.layouts.cms.why_choose.edit', compact('cms'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'         => ['required','max:255'],
            'description'    => ['required','max:2000'],
        ]);

        $cms = CMS::find($id);
        if (empty($cms)) {
            return redirect()->route('cms.why_choose_us.index')->with('error', 'Why Choose Us not found.');
        }

        $cms->update([
            'title'             => $request->title,
            'description'       => $request->description,
        ]);

        return redirect()->route('cms.why_choose_us.index')->with('success', 'Why Choose Us updated successfully.');
    }

    public function destroy($id)
    {
        $data = CMS::find($id);

        if (empty($data)) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found.',
            ], 404);
        }

        $data->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted successfully.',
            'data' => $data,
        ]);
    }

    public function status(int $id)
    {
        $data = CMS::findOrFail($id);
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
