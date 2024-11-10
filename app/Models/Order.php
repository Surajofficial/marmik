<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'priscription', 'modeof', 'order_number', 'sub_total', 'quantity', 'delivery_charge', 'status', 'total_amount', 'first_name', 'last_name', 'country', 'post_code', 'address1', 'address2', 'phone', 'state','city', 'email', 'payment_method', 'payment_status', 'shipping_id', 'coupon', 'invoice', 'razorpay_payment_id', 'shipping_charge', 'tracking_id', 'billing_id'];
    public function cart_info()
    {
        return $this->hasMany('App\Models\Cart', 'order_id', 'id');
    }
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
    public static function getAllOrder($id)
    {
        return Order::with('cart_info')->find($id);
    }
    public static function getAllOrderDetail($id)
    {
        return Order::with(['cart_info', 'cart_info.product', 'cart_info.product.product'])->find($id);
    }
    public static function countActiveOrder()
    {
        $data = Order::count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public static function countPendingOrder()
    {
        $data = Order::where('status', 'new')->count();

        if ($data) {
            return $data;
        }
        return 0;
    }

    public static function countDeliveredOrder()
    {
        $data = Order::where('status', 'delivered')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public static function countCancelOrder()
    {
        $data = Order::where('status', 'cancel')->count();
        if ($data) {
            return $data;
        }
        return 0;
    }
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function shipping()
    {
        return $this->belongsTo(Shipping::class, 'shipping_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    // protected $shiprocketService;

    // public function __construct(ShiprocketService $shiprocketService)
    // {
    //     $this->shiprocketService = $shiprocketService;
    // }

    // public function createOrder(Request $request)
    // {

        

    //     // Prepare your order data based on the incoming request
    //     $orderData = [
    //         'order_id' => '12345',
    //         'order_date' => now()->toIso8601String(),
    //         'pickup_location' => 'Your Pickup Location',
    //         'shipping_address' => [
    //             'name' => 'Customer Name',
    //             'address' => 'Customer Address',
    //             'city' => 'City',
    //             'state' => 'State',
    //             'country' => 'Country',
    //             'pincode' => 'Pincode',
    //             'phone' => 'Phone Number',
    //         ],
    //         'items' => [
    //             [
    //                 'name' => 'Product Name',
    //                 'sku' => 'Product SKU',
    //                 'units' => 1,
    //                 'selling_price' => 100,
    //                 // Add any other necessary fields
    //             ],
    //         ],
    //     ];

    //     // Call the createOrder method
    //     $response = $this->shiprocketService->createOrder($orderData);

    //     // Handle the response as needed
    //     return response()->json($response);
    // }

    // public function trackOrder($awb)
    // {
    //     $response = $this->shiprocketService->trackOrder($awb);

    //     // Handle the tracking response as needed
    //     return response()->json($response);
    // }



}
