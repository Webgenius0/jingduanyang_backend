<?php

namespace App\Http\Controllers\Api\Web;

use App\Models\NewsLetter;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class NewsLetterController extends Controller
{
    use ApiResponse;

    public function newsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:news_letters,email',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            $newsLetter = new NewsLetter();
            $newsLetter->email = $request->email;
            $newsLetter->is_subscribed = true;
            $newsLetter->save();
            return $this->success($newsLetter, 'NewsLetter has been sent successfully.', 200);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }
}
