<?php

namespace App\Http\Controllers\Api\ClientDashboard;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    use ApiResponse;
    public function addReview(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), [
            'rating' => 'required|numeric',
            'comment' => 'required',
            'images.*' => 'required|image|mimes:png,jpg,jpeg|max:4048',
        ]);

       

        if ($validator->fails()) {
            return $this->error([], $validator->errors(), 200);
        }

        $user = auth()->user();

        if(!$user) {
            return $this->error([], 'Unauthorized access', 200);
        }
        try {
            DB::beginTransaction();
            $data = Review::create([
                'user_id' => $user->id,
                'product_id' => $id,
                'rating' => $request->rating,
                'comment' => $request->comment
            ]);

             // gallery images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $imageName    = uploadImage($image, 'reviews/images');
                   $reviewImage = ReviewImage::create([
                        'review_id' => $data->id,
                        'image_url' => $imageName,
                    ]);
                }
            }

            DB::commit();
            return $this->success($data, 'Review created successfully', 200);
        }catch (\Exception $e) {
            DB::rollBack();
            return $this->error([],'Failed to create review', 200);
        }
       
    }
}
