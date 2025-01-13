<?php

namespace App\Http\Controllers\Web\Backend;

use Illuminate\Http\Request;
use App\Models\QuizzeCategory;
use App\Models\QuizzeQuestion;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class QuizzeQuestionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = QuizzeQuestion::latest()->get();
            if (!empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('questions', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('quizze_category_id', function ($data) {
                    return $data->quizze_category->title;
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
                    return '<a href="' . route('admin.quizze_questions.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary text-white btn-sm" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </a>
                    <a href="javascript:void(0)" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white btn-sm" title="Delete">
                        <i class="bi bi-trash"></i>
                    </a>';
                })
                ->rawColumns(['status', 'action','quizze_category_id'])
                ->make();
        }
        return view('backend.layouts.quizze_questions.index');
    }

    public function create()
    {
        $categories =QuizzeCategory::all();
        return view('backend.layouts.quizze_questions.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'quizze_category_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'option1' => 'required|string|max:255',
            'option2' => 'required|string|max:255',
            'option3' => 'required|string|max:255',
        ]);

        try{
            QuizzeQuestion::create([
                'quizze_category_id' => $request->quizze_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
                'option1' => $request->option1,
                'option2' => $request->option2,
                'option3' => $request->option3,
            ]);
            return redirect()->route('admin.quizze_questions.index')->with('t-success', 'Question created successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $question = QuizzeQuestion::find($id);
        $categories =QuizzeCategory::all();
        return view('backend.layouts.quizze_questions.edit',compact('question','categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quizze_category_id' => 'required',
            'question' => 'required|string|max:255',
            'answer' => 'required|string|max:255',
            'option1' => 'required|string|max:255',
            'option2' => 'required|string|max:255',
            'option3' => 'required|string|max:255',
        ]);

        try{
            QuizzeQuestion::find($id)->update([
                'quizze_category_id' => $request->quizze_category_id,
                'question' => $request->question,
                'answer' => $request->answer,
                'option1' => $request->option1,
                'option2' => $request->option2,
                'option3' => $request->option3,
            ]);
            return redirect()->route('admin.quizze_questions.index')->with('t-success', 'Question updated successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('t-error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            QuizzeQuestion::destroy($id);
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], 500);
        }
    }

    public function status($id)
    {
        $data = QuizzeQuestion::find($id);
        if (empty($data)) {
            return response()->json(['message' => 'Question not found'], 404);
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
