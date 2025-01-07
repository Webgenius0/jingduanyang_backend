<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller {
    use ApiResponse;

    /**
     * Fetch Login User Data
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function userData() {

        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'User Not Found', 404);
        }

        return $this->success($user, 'User data fetched successfully', 200);
    }

    /**
     * Update User Information
     *
     * @param  \Illuminate\Http\Request  $request  The HTTP request with the register query.
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function userUpdate(Request $request) {

        $validator = Validator::make($request->all(), [
            'avatar'  => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
            'first_name'    => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
            'birthdate' => 'nullable|string',
            'state' => 'nullable|string',
            'city' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'therapy_type' => 'nullable|string',
            'languages' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            // Find the user by ID
            $user = auth()->user();

            // If user is not found, return an error response
            if (!$user) {
                return $this->error([], "User Not Found", 404);
            }

            if ($request->hasFile('avatar')) {

                if ($user->avatar) {
                    $previousImagePath = public_path($user->avatar);
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }

                $image     = $request->file('avatar');
                $imageName = uploadImage($image, 'User/Avatar');
            } else {
                $imageName = $user->avatar;
            }

            $user->first_name    = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->gender = $request->gender;
            $user->birthdate = $request->birthdate;
            $user->state = $request->state;
            $user->city = $request->city;
            $user->zip_code = $request->zip_code;
            $user->therapy_type = $request->therapy_type;
            $user->languages = $request->languages;
            $user->agree_to_terms = $request->agree_to_terms;
            $user->avatar  = $imageName;

            $user->save();

            return $this->success($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }

    /**
     * Logout the authenticated user's account
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse JSON response with success or error.
     */
    public function logoutUser() {

        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->success([], 'Successfully logged out', 200);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }

    }

    /**
     * Delete the authenticated user's account
     *
     * @return \Illuminate\Http\JsonResponse JSON response with success or error.
     */
    public function deleteUser() {
        try {
            // Get the authenticated user
            $user = auth()->user();

            // If user is not found, return an error response
            if (!$user) {
                return $this->error([], "User Not Found", 404);
            }

            // Delete the user's avatar if it exists
            if ($user->avatar) {
                $previousImagePath = public_path($user->avatar);
                if (file_exists($previousImagePath)) {
                    unlink($previousImagePath);
                }
            }

            // Delete the user
            $user->delete();

            return $this->success([], 'User deleted successfully', 200);
        } catch (\Exception $e) {
            return $this->error([], $e->getMessage(), 500);
        }
    }
}
