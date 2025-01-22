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

    public function checkOrderPayment(Request $request) {
       Log::info('Check Order Payment', ['request' => $request->all()]);
    }

}