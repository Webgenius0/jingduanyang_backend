<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\Web\FaqController;
use App\Http\Controllers\Api\Web\BlogController;
use App\Http\Controllers\Api\Web\TeamController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\SocialAuthController;
use App\Http\Controllers\Api\Web\CourseController;
use App\Http\Controllers\Api\Web\QuizzeController;
use App\Http\Controllers\Api\Web\AboutUsController;
use App\Http\Controllers\Api\Web\ProductController;
use App\Http\Controllers\Api\Web\ServiceController;
use App\Http\Controllers\Api\Web\HomePageController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Web\DynamicPageController;
use App\Http\Controllers\Api\Web\SystemSettingController;
use App\Http\Controllers\Web\Backend\DashboardController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Http\Controllers\Api\ClientDashboard\DashboradController;
use App\Http\Controllers\Api\DoctorDashboard\AppointmentController;
use App\Http\Controllers\Api\ClientDashboard\ClientAppointmentController;
use App\Http\Controllers\Api\PayPal\PayPalController;

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

Route::group(['middleware' => ['jwt.verify']], function () {

    Route::controller(UserController::class)->prefix('users')->group(function () {
        Route::get('/data', 'userData');
        Route::post('/data/update', 'userUpdate');
        Route::post('/logout', 'logoutUser');
        Route::delete('/delete', 'deleteUser');

        Route::post('psychologist/information', 'psychologistInformation');
    });

    Route::controller(TeamController::class)->group(function () {
        Route::post('/appointments', 'appotment');
    });
    //Quzzes Route
    Route::controller(QuizzeController::class)->group(function () {
        Route::get('/quizzes/{id}', 'getQuizzes');
        Route::get('/anxiety-test', 'anxietyTest');
        Route::get('start-quiz', 'startQuiz');
        Route::get('anxiety-test-result', 'anxietyTestResult');
    });

    //Client Dashboard
    Route::group(['middleware' => ['client']], function () {

        Route::controller(UserController::class)->prefix('users')->group(function () {
            Route::post('/logout', 'logoutUser');
        });

        Route::controller(ClientAppointmentController::class)->group(function () {
            Route::get('/client-appointments', 'getAppointments');
            // Route::get('/appointment-detail/{id}', 'appointmentDetail');
            Route::get('/client-appointment-meeting', 'appointmentMeeting');

            Route::get('/doctor', 'getDoctor');
            Route::get('/client-prescription/{id}', 'getClientPrescription');
        });

        Route::controller(DashboradController::class)->group(function () {
            Route::get('/doctor-list', 'doctorList');
            Route::get('/previous-appointments ', 'previousAppointments');
            Route::get('/active-appointments', 'activeAppointments');
        });

    });

    //Doctor Dashboard
    Route::group(['middleware' => ['doctor']], function () {

        Route::controller(UserController::class)->prefix('users')->group(function () {
            Route::post('/logout', 'logoutUser');
        });

        Route::controller(AppointmentController::class)->group(function () {
            Route::get('/appointments', 'getAppointments');
            Route::get('/appointment-detail/{id}', 'appointmentDetail');
            Route::post('/appointment-schedule/update/{id}', 'appointmentScheduleUpdate');
            Route::get('/appointment-meeting', 'appointmentMeeting');
            Route::post('/appointment-status/{id}', 'appointmentStatus');
            Route::get('/appointment-schedule', 'appointmentSchedule');
            Route::post('/prescription/create', 'createPrescription');

            Route::get('/upcoming-appointments', 'upcomingAppointments');

            Route::get('/total-appointments', 'totalAppointments');
        });

    });

});

//System Setting route
Route::controller(SystemSettingController::class)->group(function () {
    Route::get('/system-setting', 'SystemSetting');
    Route::get('/social-media', 'socialMedia');
});

//Blog route
Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'blogs');
    Route::get('/blog-detail/{id}', 'blogDetail');
    Route::get('/related-blogs/{id}', 'relatedBlog');
});

//Dynamic page routes
Route::controller(DynamicPageController::class)->group(function () {
    Route::get('/dynamic-page', 'getDynamicPage');
    Route::get('/singel-page/{id}', 'singelPage');
});

//Team routes
Route::controller(TeamController::class)->group(function () {
    Route::get('/team', 'getTeam');
    Route::get('/team-detail/{id}', 'teamDetail');
});

//Service routes
Route::controller(ServiceController::class)->group(function () {
    Route::get('/services', 'getServices');
    Route::get('/service-detail/{id}', 'serviceDetail');

    Route::get('/why-choose-us', 'getWhyChooseUs');
});

//Faq routes
Route::controller(FaqController::class)->group(function () {
    Route::get('/faqs', 'getFaqs');
});

//About Us routes
Route::controller(AboutUsController::class)->group(function () {
    Route::get('/about-us', 'getAboutUs');
});

//Help Section route
Route::controller(HomePageController::class)->group(function () {
    Route::get('/home-page', 'getHomePage');
});

//Course route
Route::controller(CourseController::class)->group(function () {
    Route::get('/premium/courses', 'PremiumCourses');
    Route::get('/free/courses', 'freeCourses');
});

//Product Route
Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'getProducts');
    Route::get('/product-detail/{id}', 'productDetail');
});

//Quzzes Route
Route::controller(QuizzeController::class)->group(function () {
    Route::get('/quizzes-category', 'getQuizzesCategory');
});

Route::prefix('paypal')->group(function () {
    Route::post('/create-plan', [PayPalController::class, 'createPlan']);
    Route::post('/activate-plan', [PayPalController::class, 'activatePlan']);
    Route::post('/create-subscription', [PayPalController::class, 'createSubscription']);
    Route::get('/execute-subscription/{subscription_id}', [PayPalController::class, 'executeSubscription']);
});
