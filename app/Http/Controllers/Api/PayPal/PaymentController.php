<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    public function createPayPalOrder(Request $request)  {
      

        try{
            $this->provider->getAccessToken();
            $order = $this->provider->createOrder($request->all());

        return response()->json(['order' => $order], 201);
        } catch (\Exception $e) {
            Log::error('Order creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create order.', 'message' => $e->getMessage()], 500);
        }
    }



   
    public function checkOrderPayment(Request $request) {

    $email = $request->input('resource.purchase_units.0.custom_id');
    $type = $request->input('resource.purchase_units.0.invoice_id');
    $address = $request->input('resource.purchase_units.0.shipping.address');
    
    Log::info($address['address_line_1']);
    $user = User::where('email', $email)->first();
    if (!$user) {
        Log::error('User not found', ['email' => $email]);
        return response()->json(['error' => 'User not found'], 404);
    }
    

    $order = Order::create([
        'user_id' => $user->id,
        'order_id' => $request->input('resource.id'),
        'amount' => $request->input('resource.purchase_units.0.amount.value'),
        'currency' => $request->input('resource.purchase_units.0.amount.currency_code'),
        'payment_method' => 'PayPal', 
        'address' => $address['address_line_1'] ?? null,
        'status' => 'pending',  
        'type' => $type,
    ]);


    Log::info('Order created successfully', ['order_id' => $order->id]);
    
    foreach ($request->input('resource.purchase_units.0.items', []) as $item) {
        OrderProduct::create([
            'order_id' => $order->id,  
            'product_id' => $item['sku'], 
            'image_url' => $item['image_url'],
            'name' => $item['name'],  
            'quantity' => $item['quantity'],  
            'price' => $item['unit_amount']['value'],  
            'currency' => $item['unit_amount']['currency_code'], 
            'description' => $item['description'],  
      
        ]);
        
  
    }

    return response()->json(['message' => 'Order processed successfully'], 201);
}


public function  createOrderForAppointment(Request $request)  {
    try{
        $this->provider->getAccessToken();
        $order = $this->provider->createOrder($request->all());

    return response()->json(['order' => $order], 201);
    } catch (\Exception $e) {
        Log::error('Order creation failed', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to create order.', 'message' => $e->getMessage()], 500);
    }
}


}