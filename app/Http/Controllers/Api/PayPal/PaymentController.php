<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
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
}
