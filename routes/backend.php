<?php

use App\Http\Controllers\Web\Backend\BlogCategoryController;
use App\Http\Controllers\Web\Backend\BlogController;
use App\Http\Controllers\Web\Backend\Cms\AboutUsController;
use App\Http\Controllers\Web\Backend\Cms\ConsultationController;
use App\Http\Controllers\Web\Backend\Cms\EducationController;
use App\Http\Controllers\Web\Backend\Cms\HelpController;
use App\Http\Controllers\Web\Backend\Cms\HomeController;
use App\Http\Controllers\Web\Backend\Cms\WhyChooseUsController;
use App\Http\Controllers\Web\Backend\CourseController;
use App\Http\Controllers\Web\Backend\DashboardController;
use App\Http\Controllers\Web\Backend\FaqController;
use App\Http\Controllers\Web\Backend\ProductCategoryController;
use App\Http\Controllers\Web\Backend\ProductController;
use App\Http\Controllers\Web\Backend\ServiceController;
use App\Http\Controllers\Web\Backend\TeamController;
use Illuminate\Support\Facades\Route;





Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');


Route::controller(ProductCategoryController::class)->group(function () {
    Route::get('/product-categories', 'index')->name('admin.product_categories.index');
    Route::get('/product-categories/create', 'create')->name('admin.product_categories.create');
    Route::post('/product-categories', 'store')->name('admin.product_categories.store');
    Route::get('/product-categories/edit/{id}', 'edit')->name('admin.product_categories.edit');
    Route::post('/product-categories/update/{id}', 'update')->name('admin.product_categories.update');
    Route::delete('/product-categories/delete/{id}', 'destroy')->name('admin.product_categories.destroy');
});

Route::controller(ProductController::class)->group(function () {
    Route::get('/products', 'index')->name('admin.products.index');
    Route::get('/products/create', 'create')->name('admin.products.create');
    Route::post('/products/store', 'store')->name('admin.products.store');
    Route::get('/products/edit/{id}', 'edit')->name('admin.products.edit');
    Route::post('/products/update/{id}', 'update')->name('admin.products.update');
    Route::delete('/products/delete/{id}', 'destroy')->name('admin.products.destroy');
});

Route::controller(CourseController::class)->group(function () {
    Route::get('/courses', 'index')->name('admin.courses.index');
    Route::get('/courses/create', 'create')->name('admin.courses.create');
    Route::post('/courses', 'store')->name('admin.courses.store');
    Route::get('/courses/edit/{id}', 'edit')->name('admin.courses.edit');
    Route::post('/courses/update/{id}', 'update')->name('admin.courses.update');
    Route::delete('/courses/delete/{id}', 'destroy')->name('admin.courses.destroy');
});

//Team Route
Route::controller(TeamController::class)->group(function () {
    Route::get('/teams', 'index')->name('admin.teams.index');
    Route::get('/teams/create', 'create')->name('admin.teams.create');
    Route::post('/teams/store', 'store')->name('admin.teams.store');
    Route::get('/teams/edit/{id}', 'edit')->name('admin.teams.edit');
    Route::post('/teams/update/{id}', 'update')->name('admin.teams.update');
    Route::delete('/teams/delete/{id}', 'destroy')->name('admin.teams.destroy');
    Route::post('/teams/status/{id}','status')->name('admin.teams.status');
});

//blog category route
Route::controller(BlogCategoryController::class)->group(function () {
    Route::get('/blog-categories', 'index')->name('admin.blog_categories.index');
    Route::post('/blog-categories/store', 'store')->name('admin.blog_categories.store');
    Route::get('/blog-categories/edit/{id}', 'edit')->name('admin.blog_categories.edit');
    Route::post('/blog-categories/update/{id}', 'update')->name('admin.blog_categories.update');
    Route::delete('/blog-categories/delete/{id}', 'destroy')->name('admin.blog_categories.destroy');
    Route::post('/blog-categories/status/{id}','status')->name('admin.blog_categories.status');
});

//Blog Route
Route::controller(BlogController::class)->group(function () {
    Route::get('/blogs', 'index')->name('admin.blogs.index');
    Route::get('/blogs/create', 'create')->name('admin.blogs.create');
    Route::post('/blogs/store', 'store')->name('admin.blogs.store');
    Route::get('/blogs/edit/{id}', 'edit')->name('admin.blogs.edit');
    Route::post('/blogs/update/{id}', 'update')->name('admin.blogs.update');
    Route::delete('/blogs/delete/{id}', 'destroy')->name('admin.blogs.destroy');
    Route::post('/blogs/status/{id}','status')->name('admin.blogs.status');
});

//Services routes
Route::controller(ServiceController::class)->group(function () {
    Route::get('/services', 'index')->name('admin.services.index');
    Route::get('/services/create', 'create')->name('admin.services.create');
    Route::post('/services/store', 'store')->name('admin.services.store');
    Route::get('/services/edit/{id}', 'edit')->name('admin.services.edit');
    Route::post('/services/update/{id}', 'update')->name('admin.services.update');
    Route::delete('/services/delete/{id}', 'destroy')->name('admin.services.destroy');
    Route::post('/services/status/{id}', 'status')->name('admin.services.status');
});

//Faq route for admin
Route::controller(FaqController::class)->group(function () {
    Route::get('/faq','index')->name('admin.faq.index');
    Route::get('/faq/create','create')->name('admin.faq.create');
    Route::post('/faq/store','store')->name('admin.faq.store');
    Route::get('/faq/edit/{id}','edit')->name('admin.faq.edit');
    Route::post('/faq/update/{id}','update')->name('admin.faq.update');
    Route::delete('/faq/delete/{id}','destroy')->name('admin.faq.destroy');
    Route::post('/faq/status/{id}','status')->name('admin.faq.status');
});

//Cms  Home Hero section Route
Route::controller(HomeController::class)->group(function () {
    Route::get('/cms/home/hero-section','HeroSection')->name('cms.home.hero_section');
    Route::post('/cms/home/hero-section/store', 'HeroSectionStore')->name('cms.home.hero_section.store');
});

//Cms Home Education Route
Route::controller(EducationController::class)->group(function () {
    Route::get('/cms/home/education','index')->name('cms.home.education.index');
    Route::post('/cms/home/education/store', 'EducationStore')->name('cms.home.education.store');
});

//Cms Home Consultation Route
Route::controller(ConsultationController::class)->group(function () {
    Route::get('/cms/home/consultation','index')->name('cms.home.consultation.index');
    Route::post('/cms/home/consultation/store', 'ConsultationStore')->name('cms.home.consultation.store');
});


//Cms Home Help Section route
Route::controller(HelpController::class)->group(function () {
    Route::get('/cms/home/help-section','index')->name('cms.home.help_section.index');
    Route::post('/cms/home/help-section/store', 'HelpSectionStore')->name('cms.home.help_section.store');

    //Help Section Item route
    Route::get('/cms/home/help-section/item/create', 'Create')->name('item.create');
    Route::post('/cms/home/help-section/item/store', 'Store')->name('item.store');
    Route::get('/cms/home/help-section/item/edit/{id}', 'Edit')->name('item.edit');
    Route::post('/cms/home/help-section/item/update/{id}', 'Update')->name('item.update');
    Route::delete('/cms/home/help-section/item/delete/{id}', 'Destroy')->name('item.destroy');
    Route::post('/cms/home/help-section/item/status/{id}', 'Status')->name('item.status');

});

//Cms Testimonial route

//Cms About Us Page route
Route::controller(AboutUsController::class)->group(function () {
    Route::get('/cms/about-us','index')->name('cms.about_us.index');
    Route::post('/cms/about-us/store', 'store')->name('cms.about_us.store');
});

//Why Choose Us Route
Route::controller(WhyChooseUsController::class)->group(function () {
    Route::get('/why-choose-us','index')->name('cms.why_choose_us.index');
    Route::get('/why-choose-us/create','create')->name('cms.why_choose_us.create');
    Route::post('/why-choose-us/store', 'store')->name('cms.why_choose_us.store');
    Route::get('/why-choose-us/edit/{id}','edit')->name('cms.why_choose_us.edit');
    Route::post('/why-choose-us/update/{id}','update')->name('cms.why_choose_us.update');
    Route::delete('/why-choose-us/delete/{id}','destroy')->name('cms.why_choose_us.destroy');
    Route::post('/why-choose-us/status/{id}', 'status')->name('cms.why_choose_us.status');
});
