<?php

namespace App\Http\Controllers\Api\PayPal;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class SubcriptionBasePayPalController extends Controller
{
    protected $provider;

    public function __construct()
    {
        $this->provider = new PayPalClient;
        $this->provider->setApiCredentials(config('paypal'));
    }

    // Create a product
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

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
            Log::error('Product creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create product.', 'message' => $e->getMessage()], 500);
        }
    }

    // List all products
    public function listProducts()
    {
        try {
            $this->provider->getAccessToken();

            $products = $this->provider->listProducts();

            return response()->json(['products' => $products], 200);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve products', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to list products.', 'message' => $e->getMessage()], 500);
        }
    }

    // Create a plan
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
            Log::error('Plan creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create plan.', 'message' => $e->getMessage()], 500);
        }
    }



    // Create a subscription
    public function createSubscription(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|string',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

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
                ],
            ]);

         
            return response()->json(['subscription' => $subscription], 201);
        } catch (\Exception $e) {
            Log::error('Subscription creation failed', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create subscription.', 'message' => $e->getMessage()], 500);
        }
    }

    public function checkSubscriptionPaymentCompletedOrNot(Request $request)
    {

        Log::info('Webhook received', ['request' => $request->all()]);

        $subscriber = $request->input('resource.subscriber');

       

        if ($subscriber && isset($subscriber['email_address'])) {
            $email = $subscriber['email_address'];
            Log::info('Subscriber Email:', ['email' => $email]);
        } else {
            Log::warning('No email found in webhook payload.');
        }
    
        
    }
    
 
}
