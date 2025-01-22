<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderPuduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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

    public function captureOrder($orderId) {
        try {
            $this->provider->getAccessToken();
            $capture = $this->provider->capturePaymentOrder($orderId);

            return response()->json(['capture' => $capture], 200);
        } catch (\Exception $e) {
            Log::error('Order capture failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to capture order.', 'message' => $e->getMessage()], 500);
        }
    }

    public function checkOrderPayment(Request $request)
{
   
    $email = $request->input('resource.purchase_units.0.custom_id');
    
    $user = User::where('email', $email)->first();
    if (!$user) {
        Log::error('User not found', ['email' => $email]);
        return response()->json(['error' => 'User not found'], 404);
    }
    
    // log everything one by one
    Log::info('User found', ['user_id' => $user->id]);
    Log::info('Order ID', ['order_id' => $request->input('resource.id')]);
    Log::info('Amount', ['amount' => $request->input('resource.purchase_units.0.amount.value')]);
    Log::info('Currency', ['currency' => $request->input('resource.purchase_units.0.amount.currency_code')]);
    Log::info('Payment Method', ['payment_method' => 'PayPal']);
    Log::info('Status', ['status' => 'approved']);
    // now log all item
    foreach ($request->input('resource.purchase_units.0.items', []) as $item) {
        Log::info('Product', [
            'product_sku' => $item['sku'],
            'product_name' => $item['name'],
            'quantity' => $item['quantity'],
            'price' => $item['unit_amount']['value'],
            'currency' => $item['unit_amount']['    `'],
            'description' => $item['description'],
        ]);
    }

    $order = Order::create([
        'user_id' => $user->id,
        'order_id' => $request->input('resource.id'),
        'amount' => $request->input('resource.purchase_units.0.amount.value'),
        'currency' => $request->input('resource.purchase_units.0.amount.currency_code'),
        'payment_method' => 'PayPal', 
        'status' => 'approved',  
    ]);

    Log::info('Order created successfully', ['order_id' => $order->id]);

    foreach ($request->input('resource.purchase_units.0.items', []) as $item) {
        OrderPuduct::create([
            'order_id' => $order->id,  
            'product_id' => $item['sku'], 
            'name' => $item['name'],  
            'quantity' => $item['quantity'],  
            'price' => $item['unit_amount']['value'],  
            'currency' => $item['unit_amount']['currency_code'], 
            'description' => $item['description'],  
      
        ]);
        
        // Log product information for debugging
        Log::info('Product added', [
            'order_id' => $order->id,
            'product_sku' => $item['sku'],
            'product_name' => $item['name'],
            'quantity' => $item['quantity']
        ]);
    }

    // Shipping information logging for debugging
    $shippingInfo = $request->input('resource.purchase_units.0.shipping');
    Log::info('Shipping Info', ['shipping' => $shippingInfo]);

    // If you want to store shipping info as well, you can implement that here:
    // Example: Create a Shipping model entry (if needed)
    // Shipping::create([
    //     'order_id' => $order->id,
    //     'full_name' => $shippingInfo['name']['full_name'],
    //     'address' => json_encode($shippingInfo['address']),
    // ]);

    // Log successful order processing
    Log::info('Order and products created successfully', ['order_id' => $order->id]);

    // Return a success response
    return response()->json(['message' => 'Order processed successfully'], 201);
}


}