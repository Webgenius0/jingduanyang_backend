<?php

namespace App\Http\Controllers\Web\Backend;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = FAQ::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('question', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('question', function ($data) {
                    $question       = $data->question;
                    $short_question = strlen($question) > 100 ? substr($question, 0, 100) . '...' : $question;
                    return '<p>' . $short_question . '</p>';
                })
                ->addColumn('answer', function ($data) {
                    $answer       = $data->answer;
                    $short_answer = strlen($answer) > 100 ? substr($answer, 0, 100) . '...' : $answer;
                    return '<p>' . $short_answer . '</p>';
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
                    return ' <a href="' . route('admin.faq.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                              <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                              <i class="bi bi-trash"></i>
                              </a>';
                })
                ->rawColumns(['answer', 'status', 'action', 'question'])
                ->make();
        }
        return view('backend.layouts.faq.index');
    }

    public function create()
    {
        return view('backend.layouts.faq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question'         => 'required',
            'answer'  => 'required',
        ]);
        try {
            FAQ::create(
                [
                    'question' => $request->question,
                    'answer'   => $request->answer,
                ]
            );
            return redirect()->route('admin.faq.index')->with('t-success', 'FAQ created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.faq.index')->with('t-error', 'Failed to create FAQ.');
        }
    }

    public function edit($id)
    {
        $faq = FAQ::find($id);
        if (empty($faq)) {
            return redirect()->route('admin.faq.index')->with('t-error', 'FAQ not found.');
        }
        return view('backend.layouts.faq.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question'         => 'required',
            'answer'  => 'required',
        ]);

        try {
            $faq = FAQ::find($id);
            if (empty($faq)) {
                return redirect()->route('admin.faq.index')->with('t-error', 'FAQ not found.');
            }
            $faq->question = $request->question;
            $faq->answer   = $request->answer;
            $faq->save();

            return redirect()->route('admin.faq.index')->with('t-success', 'FAQ updated successfully.');
        } catch (\Exception $e) {

            return redirect()->route('admin.faq.index')->with('t-error', 'Failed to update FAQ.');
        }
    }

    public function destroy($id)
    {
        $faq = FAQ::find($id);
        if (empty($faq)) {
            return response()->json([
                'status'  => false,
               'message' => 'FAQ not found.'
            ]);
        }
        $faq->delete();
        return response()->json([
            'status'  => true,
           'message' => 'FAQ deleted successfully.'

        ]);
    }

    public function status($id)
    {
        $data = FAQ::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Faq not found'], 404);
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

