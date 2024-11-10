<?php

namespace App\Http\Controllers;

use App\Models\Rozerpay;
use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RozerpayController extends Controller
{


    public function createOrder(Request $request)
    {
        $amount = $request->input("price");
        $api = new Api(env('ROZERPAY_ID'), env('ROZERPAY_KEY'));
        $rozerpay = Rozerpay::create(['amount' => $amount]);
        $orderData = [
            'receipt' => "rcptid_$rozerpay->id",
            'amount' => $amount,
            'currency' => 'INR',
            'payment_capture' => 1,
        ];
        $razorpayOrder = $api->order->create($orderData);
        $rozerpay->update(['rozorpay_id' => $razorpayOrder['id']]);

        $razorpayOrder = $api->order->create($orderData);
        return response()->json([
            'order_id' => $razorpayOrder['id'],
            'amount' => $amount,
            'currency' => 'INR'
        ]);
    }
    public function verifyPayment(Request $request)
    {
    
        $api = new Api(env('ROZERPAY_ID'), env('ROZERPAY_KEY'));

        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature
        ];

        try {
            $api->utility->verifyPaymentSignature($attributes);
            return response()->json(['success' => true, 'status' => $api]);
        } catch (\Exception $e) {
            // Payment verification failed
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
