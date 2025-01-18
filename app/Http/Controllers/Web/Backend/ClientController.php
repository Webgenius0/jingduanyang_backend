<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::where('role', 'client')->latest()->get();
            if (! empty($request->input('search.value'))) {
                $searchTerm = $request->input('search.value');
                $data->where('first_name', 'LIKE', "%$searchTerm%");
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($data) {
                    if (! empty($data->avatar)) {
                        $url = asset($data->avatar);
                    } else {
                        $url = asset('backend/images/placeholder/profile.jpeg');
                    }
                    $image = "<img src='$url' width='50' height='50'>";
                    return $image;
                })
                ->editColumn('name', function ($data) {
                    return $data->first_name . ' ' . $data->last_name;
                })
                ->rawColumns(['status', 'image', 'name'])
                ->make();
        }

        return view('backend.layouts.clients.index');
    }
}
