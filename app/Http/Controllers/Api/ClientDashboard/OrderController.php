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

        $orders = Order::with(['orderProduct.product.images'])->where('user_id', $user->id)->paginate(10);

       if($orders->isEmpty()){
        return $this->success([], 'No orders found', 200);
       }
        return $this->success($orders, 'Orders fetched successfully', 200);
    }

    public function singelInvoice($id){
        $user = auth()->user();

        if (!$user) {
            return $this->error([], 'Unauthorized access', 404);
        }

        $invoice = Order::with(['user'])->where('user_id', $user->id)->where('id', $id)->first();

        if (!$invoice) {
            return $this->error([], 'Invoice not found', 200);
        }

        return $this->success($invoice, 'Invoice fetched successfully', 200);
    }
}
