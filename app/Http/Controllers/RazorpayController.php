<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;

class RazorpayController extends Controller
{
    public function razorpay()
    {
        return view('index');
    }

    public function payment(Request $request)
    {
        $input = $request->all();
        $api = new Api(env('RAZOR_KEY'), env('RAZOR_SECRET'));

        if (isset($input['razorpay_payment_id']) && !empty($input['razorpay_payment_id'])) {
            try {
                $payment = $api->payment->fetch($input['razorpay_payment_id']);
                $response = $payment->capture(['amount' => $payment['amount']]);
                Session::put('success', 'Payment successful, your order will be dispatched in the next 48 hours.');
            } catch (Exception $e) {
                Session::put('error', $e->getMessage());
                return redirect()->back();
            }
        } else {
            Session::put('error', 'Payment ID is missing.');
            return redirect()->back();
        }

        return redirect()->back();
    }
    public function handleWebhook(Request $request)
    {
        $requestBody = json_decode($request->getContent(), true);
        $this->storeWebhookData($requestBody);
        // Verify the webhook signature
        // $api = new Api(env('ROZERPAY_KEY'), env('ROZERPAY_ID'));
        // $webhookSignature = $request->header('X-Razorpay-Signature');
        return 'test';
        // try {
        //     $api->utility->verifyWebhookSignature($requestBody, $webhookSignature, 'your_webhook_secret');
        // } catch (Exception $e) {
        //     // Handle webhook verification failure
        //     $requestBody = $e;
        //     // return response()->json(['error' => 'Webhook signature verification failed.'], 400);
        // }
        // $this->storeWebhookData($requestBody);

        // Process the webhook event
        // $event = $requestBody['event'];
        // $paymentId = $requestBody['payload']['payment']['entity']['id'];

        // Example: Update order status or send confirmation email
        // Your custom logic here...

        return response()->json(['success' => 'Webhook received successfully.']);
    }
    private function storeWebhookData(array $data)
    {
        $fileName = 'webhook-' . time() . '.json'; // Generate a unique filename
        $filePath = storage_path('app/webhooks/' . $fileName);

        // Ensure the directory exists
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        // Write JSON data to file
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
}
