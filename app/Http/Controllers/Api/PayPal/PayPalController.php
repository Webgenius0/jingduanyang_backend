<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }


    public function createProduct(Request $request)
    {
        try {
            $this->provider->getAccessToken();

            $product = $this->provider->createProduct([
                'name' => $request->name,
                'description' => $request->description,
                'type' => 'SERVICE', // SERVICE or PHYSICAL
                'category' => 'SOFTWARE',
            ]);

            return response()->json(['product' => $product], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function listProducts()
    {
        try {
            $this->provider->getAccessToken();

            $products = $this->provider->listProducts();

            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }



    public function createPlan(Request $request)
    {
        try {
            $this->provider->getAccessToken();

            $plan = $this->provider->createPlan([
                'product_id' => $request->product_id,
                'name' => $request->name,
                'description' => $request->description,
                'billing_cycles' => [
                    [
                        'frequency' => [
                            'interval_unit' => 'MONTH',
                            'interval_count' => 1,
                        ],
                        'tenure_type' => 'REGULAR',
                        'sequence' => 1,
                        'total_cycles' => 0,
                        'pricing_scheme' => [
                            'fixed_price' => [
                                'value' => $request->price,
                                'currency_code' => 'USD',
                            ],
                        ],
                    ],
                ],
                'payment_preferences' => [
                    'auto_bill_outstanding' => true,
                    'setup_fee' => [
                        'value' => '0',
                        'currency_code' => 'USD',
                    ],
                    'setup_fee_failure_action' => 'CONTINUE',
                    'payment_failure_threshold' => 3,
                ],
            ]);

            return response()->json(['plan' => $plan], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

     // Activate a plan
     public function activatePlan(Request $request)
     {
         try {
             $this->provider->getAccessToken();
             $this->provider->activatePlan($request->plan_id);
 
             return response()->json(['message' => 'Plan activated successfully.'], 200);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
 
     // Create a subscription
     public function createSubscription(Request $request)
     {
         try {
             $this->provider->getAccessToken();
 
             $subscription = $this->provider->createSubscription([
                 'plan_id' => $request->plan_id,
                 'subscriber' => [
                     'name' => [
                         'given_name' => $request->first_name,
                         'surname' => $request->last_name,
                     ],
                     'email_address' => $request->email,
                 ],
                 'application_context' => [
                     'brand_name' => 'Your Brand Name',
                     'locale' => 'en-US',
                     'user_action' => 'SUBSCRIBE_NOW',
                     'payment_method' => [
                         'payer_selected' => 'PAYPAL',
                         'payee_preferred' => 'IMMEDIATE_PAYMENT_REQUIRED',
                     ],
                 ],
             ]);
 
             return response()->json(['subscription' => $subscription], 201);
         } catch (\Exception $e) {
             return response()->json(['error' => $e->getMessage()], 500);
         }
     }
 
     // Execute a subscription
     public function executeSubscription($subscription_id)
     {
         try {
             $this->provider->getAccessToken();
     
             $subscription = $this->provider->showSubscriptionDetails($subscription_id); 
     
             return response()->json(['message' => 'Subscription details retrieved successfully.', 'subscription' => $subscription], 200);
         } catch (\Exception $e) {
             return response()->json(['error' => 'Failed to retrieve subscription details.', 'message' => $e->getMessage()], 500);
         }
     }
     
     
     

}
