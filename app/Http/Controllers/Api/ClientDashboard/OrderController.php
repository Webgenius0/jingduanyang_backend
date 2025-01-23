<?php

namespace App\Http\Controllers\Api\ClientDashboard;

use App\Models\Order;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    use ApiResponse;
    
    public function getOrders(){
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 404);
        }

        $orders = Order::with('orderPuduct')->where('user_id', $user->id)->get();

       if($orders->isEmpty()){
        return $this->success([], 'No orders found', 200);
       }
        return $this->success($orders, 'Orders fetched successfully', 200);
    }
}
