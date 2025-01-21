<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }


    public function createTransaction()
    {
        return response()->json(['message' => 'Transaction page (for API demo purposes).']);
    }

    public function processTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction'),
                "cancel_url" => route('cancelTransaction'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => "100.00"
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->json(['approval_url' => $link['href']]);
                }
            }
        }

        return response()->json(['error' => 'Unable to create PayPal transaction.'], 500);
    }

    public function successTransaction(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->query('token'));

        if ($response['status'] === 'COMPLETED') {
            return response()->json(['message' => 'Transaction completed successfully!'], 200);
        }

        return response()->json(['error' => 'Transaction failed.'], 400);
    }

    public function cancelTransaction()
    {
        return response()->json(['message' => 'Transaction canceled by user.'], 200);
    }
}
