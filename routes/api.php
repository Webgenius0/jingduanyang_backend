<?php

use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Web\BlogController;
use App\Http\Controllers\Api\Web\DynamicPageController;
use App\Http\Controllers\Api\Web\FaqController;
use App\Http\Controllers\Api\Web\ServiceController;
use App\Http\Controllers\Api\Web\SystemSettingController;
use App\Http\Controllers\Api\Web\TeamController;
use Database\Seeders\FAQSeeder;
use Illuminate\Support\Facades\Route;







/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Social Login
Route::post('/social-login', [SocialAuthController::class, 'socialLogin']);

//Register API
Route::controller(RegisterController::class)->prefix('users/register')->group(function () {
    // User Register
    Route::post('/', 'userRegister');

    // Verify OTP
    Route::post('/otp-verify', 'otpVerify');

    // Resend OTP
    Route::post('/otp-resend', 'otpResend');
});

//Login API
Route::controller(LoginController::class)->prefix('users/login')->group(function () {

    // User Login
    Route::post('/', 'userLogin');

    // Verify Email
    Route::post('/email-verify', 'emailVerify');

    // Resend OTP
    Route::post('/otp-resend', 'otpResend');

    // Verify OTP
    Route::post('/otp-verify', 'otpVerify');

    //Reset Password
    Route::post('/reset-password', 'resetPassword');
});

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/data', 'userData');
        Route::post('/data/update', 'userUpdate');
        Route::post('/logout', 'logoutUser');
        Route::delete('/delete', 'deleteUser');
    });

});

//System Setting route
Route::controller(SystemSettingController::class)->group(function(){
    Route::get('/system-setting','SystemSetting');
    Route::get('/social-media','socialMedia');
});

//Blog route
Route::controller(BlogController::class)->group(function(){
    Route::get('/blogs','blogs');
    Route::get('/blog-detail/{id}','blogDetail');
    Route::get('/related-blogs/{id}','relatedBlog');
});

//Dynamic page routes
Route::controller(DynamicPageController::class)->group(function () {
    Route::get('/dynamic-page', 'getDynamicPage');
    Route::get('/singel-page/{id}','singelPage');
});

//Team routes
Route::controller(TeamController::class)->group(function(){
    Route::get('/team','getTeam');
    Route::get('/team-detail/{id}','teamDetail');
});

//Service routes
Route::controller(ServiceController::class)->group(function () {
    Route::get('/services','getServices');
    Route::get('/service-detail/{id}','serviceDetail');
});

//Faq routes
Route::controller(FaqController::class)->group(function () {
    Route::get('/faqs','getFaqs');
});

