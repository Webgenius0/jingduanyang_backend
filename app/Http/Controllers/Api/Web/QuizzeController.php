<?php

namespace App\Http\Controllers\Api\Web;

use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\PatientAnxietyTest;
use App\Models\QuizzeCategory;
use App\Models\QuizzeQuestion;

class QuizzeController extends Controller
{
    use ApiResponse;
    public function getQuizzesCategory(Request $request)
    {
        $limit = $request->limit;
        if(!$limit)
        {
            $limit = 9;
        }
        $data = QuizzeCategory::where('status','active')->paginate($limit);

        if (!$data) {
            return $this->error([], 'Data Not Found', 404);
        }

        return $this->success($data, 'Quizzes Category data fetched successfully', 200);
    }

    public function getQuizzes($id)
    {
        $data = QuizzeQuestion::where('quizze_category_id', $id)
            ->where('status', 'active')
            ->get();
    
        if ($data->isEmpty()) {
            return $this->error([], 'Data Not Found', 404);
        }
    
        // Shuffle options for each question
        $shuffledData = $data->map(function ($question) {
            $op1 = $question->option1;
            $op2 = $question->option2;
            $op3 = $question->option3;
            $op4 = $question->answer;
            $options = [
                $op1,
                $op2,
                $op3,
                $op4
            ];
    
            // Shuffle the options
            shuffle($options);
    
            // Map the shuffled options back to the question
            return [
                'id' => $question->id,
                'quizze_category_id' => $question->quizze_category_id,
                'question' => $question->question,
                'option1' => $options[0],
                'option2' => $options[1],
                'option3' => $options[2],
                'option4' => $options[3],
            ];
        });
    
        return $this->success($shuffledData, 'Quizzes data fetched successfully', 200);
    }


    public function startQuiz()
    {
        $user_id = auth()->user()->id;

        $patientTest = PatientAnxietyTest::create(['user_id' => $user_id]);
        return $this->success($patientTest, 'Quiz started successfully', 200);
    }


    public function anxietyTest(Request $request) {
        $question_id = $request->question_id;
        $given_answer = $request->given_answer;
        $user_id = auth()->user()->id;
    
        $quizQuestion = QuizzeQuestion::find($question_id);
    
        if (!$quizQuestion) {
            return response()->json(['message' => 'Question not found'], 404);
        }
    
        $rightAnswer = $quizQuestion->answer;
    
        if ($rightAnswer == $given_answer) {
            $patientTest = PatientAnxietyTest::where('user_id', $user_id)->latest()->first();
            if (!$patientTest) {
                return $this->error($patientTest, 'No active quiz found for the user. Please start the quiz first.', 404);
            }
            $patientTest->score += 1;
            $patientTest->save();
           return $this->success($patientTest->score,'The Answer is Right',200);
        }
    
        return $this->error('The Answer is Wrong',404);
    }



    public function  anxietyTestResult(Request $request)  {
        $totalQuestion = QuizzeQuestion::where('status', 'active')->where('quizze_category_id',$request->category_id)->latest()->count();
        $user_id = auth()->user()->id;
        $totalScore = PatientAnxietyTest::where('user_id', $user_id)->latest()->first()->score??0 ;

        return $this->success([
            'total_question' => $totalQuestion,
            'total_score' => $totalScore
        ], 'Score fetched successfully', 200);
    }
    
    
}
