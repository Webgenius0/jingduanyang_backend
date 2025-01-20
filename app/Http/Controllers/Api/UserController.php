<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PsychologistInformation;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use ApiResponse;

    /**
     * Fetch Login User Data
     *
     * @return \Illuminate\Http\JsonResponse  JSON response with success or error.
     */

    public function userData()
    {

        $user = auth()->user();

        if (! $user) {
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

    public function userUpdate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'avatar'         => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'required|string|max:255',
            'phone'          => 'required|numeric',
            'gender'         => 'required|string',
            'birthdate'      => 'required|string',
            'state'          => 'required|string',
            'city'           => 'nullable|string',
            'zip_code'       => 'nullable|string',
            'therapy_type'   => 'nullable|string',
            'languages'      => 'required|string',
            'agree_to_terms' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            // Find the user by ID
            $user = auth()->user();

            // If user is not found, return an error response
            if (! $user) {
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

            $user->first_name     = $request->first_name;
            $user->last_name      = $request->last_name;
            $user->email          = $request->email;
            $user->phone          = $request->phone;
            $user->gender         = $request->gender;
            $user->birthdate      = $request->birthdate;
            $user->state          = $request->state;
            $user->city           = $request->city;
            $user->zip_code       = $request->zip_code;
            $user->therapy_type   = $request->therapy_type;
            $user->languages      = $request->languages;
            $user->agree_to_terms = $request->agree_to_terms;
            $user->avatar         = $imageName;

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
    public function logoutUser()
    {

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
    public function deleteUser()
    {
        try {
            // Get the authenticated user
            $user = auth()->user()->with('psychologistInformation')->first();

            // If user is not found, return an error response
            if (! $user) {
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

    public function psychologistInformation(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'avatar'                    => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
            'first_name'                => 'required|string|max:255',
            'last_name'                 => 'required|string|max:255',
            'phone'                     => 'required|numeric',
            'gender'                    => 'required|string',
            'birthdate'                 => 'required|date',
            'languages'                 => 'required|string',
            'location'                  => 'required|string',
            'qualification'             => 'required|string',
            'ahpra_registration_number' => 'required|string',
            'therapy_mode'              => 'required|string',
            'client_age'                => 'nullable|string',
            'session_length'            => 'nullable|string',
            'cust_per_session'          => 'nullable|string',
            'medicare_rebate_amount'    => 'nullable|string',
            'experience'                => 'required|numeric',
            'aphra_certificate'         => 'required|mimes:jpg,jpeg,png,pdf,doc,docx|max:5120',
            'description'               => 'nullable|string',
            'agree_to_terms'            => 'required|boolean',
            'verified_registered'       => 'required|boolean',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            // Get authenticated user with psychologist information
            $user = Auth::user();

            if (! $user) {
                return $this->error([], "User Not Found", 404);
            }

            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                // Delete previous avatar if exists
                if ($user->avatar) {
                    $previousImagePath = public_path($user->avatar);
                    if (file_exists($previousImagePath)) {
                        unlink($previousImagePath);
                    }
                }
                $image      = $request->file('avatar');
                $avatarPath = uploadImage($image, 'User/Avatar');
            } else {
                $avatarPath = $user->avatar;
            }

            // Start transaction
            DB::beginTransaction();

            // Update user details
            $user->update([
                'first_name'          => $request->first_name,
                'last_name'           => $request->last_name,
                'phone'               => $request->phone,
                'gender'              => $request->gender,
                'birthdate'           => $request->birthdate,
                'languages'           => $request->languages,
                'agree_to_terms'      => $request->agree_to_terms,
                'verified_registered' => $request->verified_registered,
                'avatar'              => $avatarPath,
            ]);

            // Handle aphra_certificate upload
            if ($request->hasFile('aphra_certificate')) {
                $certificate     = $request->file('aphra_certificate');
                $certificatePath = uploadImage($certificate, 'User/Certificate');
            } else {
                $certificatePath = null;
            }

            // Check if PsychologistInformation already exists
            $psychologistInfo = PsychologistInformation::where('user_id', $user->id)->first();

            if ($psychologistInfo) {
                // Update existing psychologist information
                $psychologistInfo->update([
                    'qualification'             => $request->qualification,
                    'ahpra_registration_number' => $request->ahpra_registration_number,
                    'therapy_mode'              => $request->therapy_mode,
                    'client_age'                => $request->client_age,
                    'session_length'            => $request->session_length,
                    'cust_per_session'          => $request->cust_per_session,
                    'medicare_rebate_amount'    => $request->medicare_rebate_amount,
                    'experience'                => $request->experience,
                    'location'                  => $request->location,
                    'description'               => $request->description,
                    'aphra_certificate'         => $certificatePath ?? $psychologistInfo->aphra_certificate,
                ]);
            } else {
                // Create new psychologist information
                PsychologistInformation::create([
                    'user_id'                   => $user->id,
                    'qualification'             => $request->qualification,
                    'ahpra_registration_number' => $request->ahpra_registration_number,
                    'therapy_mode'              => $request->therapy_mode,
                    'client_age'                => $request->client_age,
                    'session_length'            => $request->session_length,
                    'cust_per_session'          => $request->cust_per_session,
                    'medicare_rebate_amount'    => $request->medicare_rebate_amount,
                    'experience'                => $request->experience,
                    'description'               => $request->description,
                    'aphra_certificate'         => $certificatePath,
                    'location'                  => $request->location,
                    'status'                    => 'active',
                ]);
            }

            // Commit transaction
            DB::commit();

            return $this->success($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();
            return $this->error([], $e->getMessage(), 500);
        }
    }

    public function user()
    {
        $user = Auth::user();

        if (! $user) {
            return $this->error([], "User Not Found", 404);
        }

        return $this->success($user, 'User data fetched successfully', 200);
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'first_name' => 'required|string',
            'last_name'  => 'required|string',
            'phone'      => 'required|string',
            'email'      => 'required|string',
            'gender'     => 'required|string',
            'birthdate'  => 'required|string',
            'languages'  => 'required|string',
            'avatar'     => 'nullable|image|mimes:jpeg,png,jpg,svg|max:5120',
        ]);

        // Return validation errors
        if ($validator->fails()) {
            return $this->error($validator->errors(), "Validation Error", 422);
        }

        try {
            // Get authenticated user
            $user = Auth::user();

            if (! $user) {
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

            // Update user details
            $user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
                'email'      => $request->email,
                'gender'     => $request->gender,
                'birthdate'  => $request->birthdate,
                'languages'  => $request->languages,
                'avatar'     => $imageName,
            ]);

            return $this->success($user, 'User updated successfully', 200);
        } catch (\Exception $e) {
            return $this->error([], [
                'error' => $e->getMessage(),
            ]);
        }
    }
}
