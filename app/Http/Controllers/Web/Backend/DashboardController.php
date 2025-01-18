<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index() {
        $totalClient = User::where('role', 'client')->count();
        $totalDoctor = User::where('role', 'doctor')->count();
        $totalBlog  = Blog::where('status', 'active')->count();
        $totalService = Service::where('status', 'active')->count();
        $totalProduct = Product::where('status', 'active')->count();
        return view('backend.layouts.index', compact('totalClient','totalDoctor','totalBlog','totalService','totalProduct'));
    }
}
