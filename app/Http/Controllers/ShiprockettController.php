<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PickupLocation;
use App\Models\ShipRocketUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShiprockettController extends Controller
{
    // Function to get the Shiprocket API token
    // public function getToken()
    // {
    //     // Send POST request to Shiprocket login endpoint
    //     $response = Http::withOptions(['verify' => false])->post('https://apiv2.shiprocket.in/v1/external/auth/login', [
    //         // 'email' => 'awishworkspace@gmail.com',
    //         // 'password' => 'Shiprocket.12!@#$'
    //         'email' => env('SHIPROCKET_EMAIL'),
    //         'password' => env('SHIPROCKET_PASSWORD'),
    //     ]);

    //     // Log the full response for debugging
    //     Log::info('Token Fetch Response: ' . $response->body());

    //     // Check if the request was successful
    //     if ($response->successful()) {
    //         // Extract token from the response
    //         $token = $response->json()['token'];
    //         session(['shiprocket_token' => $token]);  // Store the token in the session

    //         return $token;
    //     } else {
    //         // Log error details and return the error
    //         Log::error('Failed to fetch token. Response: ' . $response->body());
    //         return response()->json(['error' => 'Failed to fetch token', 'details' => $response->body()], 400);
    //     }
    // }
    public function addUser()
    {
        $index = ShipRocketUser::all();
        return view('backend.shipping.shipment_work.add_user', compact('index'));
    }

    public function shipUserCreate(Request $req)
    {
        $req->validate([
            'email' => 'required|email|unique:ship_rocket_users,email',
            'password' => 'required'
        ]);

        $email = $req->input('email');
        $pass = $req->input('password');

        $token = $this->getToken($email, $pass);

        if ($token instanceof \Illuminate\Http\JsonResponse) {
            // If there was an error while fetching the token, return the response directly
            return $token;
        }

        $shipUser = new ShipRocketUser();
        $shipUser->email = $email;
        $shipUser->password = $pass;
        $shipUser->token = $token;
        $shipUser->token_at = now();

        // if($shipUser->save())
        // {
        //     return redirect()->back()->with('success','User Created Successfully.');
        // }
        // else
        // {
        //     return redirect()->back()->with('error','User not Created.');
        // }
        if ($shipUser->save()) {
            return response()->json([
                'success' => true,
                'message' => 'User created successfully.',
                'data' => $shipUser 
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'User could not be created.'
            ]);
        }

    }

    public function getToken($email, $pass)
    {
        // Send POST request to Shiprocket login endpoint
        $response = Http::withOptions(['verify' => false])->post('https://apiv2.shiprocket.in/v1/external/auth/login', [
            'email' => $email,
            'password' => $pass,
        ]);

        // Log the full response for debugging
        Log::info('Token Fetch Response Status: ' . $response->status());
        Log::info('Token Fetch Response Body: ' . $response->body());   

        // Check if the request was successful
        if ($response->successful()) {
            // Extract token from the response
            $token = $response->json()['token'] ?? null;

            if ($token) {
                session(['shiprocket_token' => $token]);  // Store the token in the session
                return $token;
            } else {
                Log::error('Token not found in response.');
                return response()->json(['error' => 'Token not found in response'], 400);
            }
        } else {

            $responseData = $response->json();
        
            // Check if the error message is related to incorrect credentials
            if (isset($responseData['message']) && strpos($responseData['message'], 'invalid') !== false) {
                return response()->json(['error' => 'Email/Password does not match'], 401);
            }

            // Log error details and return the error
            Log::error('Failed to fetch token. Response: ' . $response->body());
            return response()->json(['error' => 'Failed to fetch token', 'details' => $response->json()], 400);
        }
    }

    public function generateToken(Request $request)
    {
        $userId =  $request->input('user_id');
        $user = ShipRocketUser::find($userId);

        $email = $user->email;
        $pass = $user->password;

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $token = $this->getToken($email, $pass);

        $user->token = $token;
        
        if ($user->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Token generated successfully.',
                'token' => $token
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Token not generated.',
            ]);
        }

        
    }


    // Function to track an order by AWB number
    public function trackOrder($awb)
    {
        // Fetch the token from the session
        $token = session('shiprocket_token');

        // Log the token being used
        Log::info('Using Token for Tracking: ' . $token);

        // If token is not available or empty, fetch a new one
        if (!$token) {
            $token = $this->getToken();
        }

        // If token is still not available after trying to fetch, return an error
        if (!$token) {
            return response()->json(['error' => 'Unable to fetch token'], 400);
        }

        // Send a GET request to track the order
        $trackResponse = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,  // Use Bearer token
                'Content-Type'  => 'application/json'
            ])
            ->get("https://apiv2.shiprocket.in/v1/external/courier/track/awb/$awb");

        // Log response for debugging
        Log::info('Track Order Response: ' . $trackResponse->body());

        // Check if the tracking request was successful
        if ($trackResponse->successful()) {
            // Return the successful response in JSON format
            return response()->json($trackResponse->json());
        } else {
            // Log the error and return a response
            Log::error('Failed to track order: ' . $trackResponse->body());
            return response()->json(['error' => 'Failed to track order'], 400);
        }
    }

    // public function createShipping(Request $request)
    // {
    //     // return $token = $this->getToken();
    //     $validated = $request->validate([
    //         'order_id' => 'required',
    //         'user_id' => 'required',
    //         'order_number' => 'required',
    //         'length' => 'required|numeric',
    //         'breadth' => 'required|numeric',
    //         'height' => 'required|numeric',
    //         'weight' => 'required|numeric',
    //         'city' => 'required|string',
    //         'state' => 'required|string',
    //         'pickup_address' => 'required|string'
    //     ]);

    //     // $ord = Order::where('id', $request->order_id)->get();
    //     $ord = Order::getAllOrderDetail($request->order_id);;
    //     // $ord_cart = Cart::where('order_id',$request->order_id)->get();
    //     // return $ord;
    //     $pickup_address = PickupLocation::find($validated['pickup_address']);
        
    //     $token = session('shiprocket_token');

    //     if (!$token) {
    //         $token = $this->getToken();
    //     }
    //     if(!$token)
    //     {
    //         return response()->json(['error' => 'Unable to fetch token'], 400);
    //     }

    //     $order_items = []; // Initialize an empty array to hold order items
    //     $new_sub_total = 0; // Initialize new subtotal
    //     $total_discount = 0; // Initialize total discount
    //     foreach ($ord->cart_info as $item) {

    //          // Original selling price
    //         $original_price = $item->product->price;

    //         // Calculate discount amount
    //         $discount_amount = ($item->product->discount / 100) * $original_price;

    //         // Final price after discount
    //         $final_price = $original_price - $discount_amount;
    //         // dd($item->product->product->hsn_no);
    //         $order_items[] = [
    //             'name' => $item->product->product->title, 
    //             'sku' => $item->product->sku, 
    //             'units' => $item->quantity, // Use the actual quantity from the cart
    //             'selling_price' => $item->product->price, // Selling price per unit
    //             'discount' => $item->product->discount, // Discount per unit
    //             'tax' => $item->product->product->tax, // Tax per unit
    //             'hsn' => $item->product->product->hsn_no // HSN code if applicable
    //         ];


    //         // Update new subtotal
    //         $new_sub_total += $final_price * $item->quantity;

    //         // Calculate total discount for this item
    //         $total_discount += $discount_amount * $item->quantity; // Total discount for this item
    //     }
    //     // dd($ord->address1);
    //     $billing_address = $ord->address1.' '.$ord->address2;

    //     // Prepare the shipping data
    //     $shippingData = [
    //         'order_id' => $validated['order_id'],
    //         'order_date' => $ord->created_at,
    //         'channel_id' => "5613365",
    //         'billing_customer_name' => $ord->first_name,
    //         'billing_last_name' => $ord->last_name,
    //         'billing_address' => "$billing_address",
    //         'billing_city' => $validated['city'],
    //         'billing_state' => $validated['state'],
    //         'billing_pincode' => $ord->post_code,
    //         'billing_country' => $ord->country,
    //         'billing_email' => $ord->email,
    //         'billing_phone' => $ord->phone,
    //         // 'shipping_is_billing' => 1,

    //         "shipping_is_billing" => true,
    //         "shipping_customer_name" => "",
    //         "shipping_last_name" => "",
    //         "shipping_address" => "",
    //         "shipping_address_2" => "",
    //         "shipping_city" => "",
    //         "shipping_pincode" => "",
    //         "shipping_country" => "",
    //         "shipping_state" => "",
    //         "shipping_email" => "",
    //         "shipping_phone" => "",


    //         'order_items' => $order_items,
    //         'payment_method' => $ord->payment_status,
    //         'shipping_charges' => "",
    //         'giftwrap_charges' => "",
    //         'transaction_charges' => "",
    //         'total_discount' => round($total_discount, 2),
    //         'sub_total' => round($new_sub_total, 2),
            

    //         'length' => $validated['length'],
    //         'breadth' => $validated['breadth'],
    //         'height' => $validated['height'],
    //         'weight' => $validated['weight'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         // 'pickup_location' => $validated['pickup_address'],
    //         'pickup_location' => $pickup_address['pickup_location'],
                
    //     ];

    //     // return $shippingData;


    //     // // Send a POST request to create the shipping order
    //     $response = Http::withOptions(['verify' => false])
    //         ->withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Content-Type' => 'application/json',
    //         ])
    //         ->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $shippingData);

    //     // Log the response for debugging
    //     Log::info('Create Shipping Response: ' . $response->body());

    //     // // Check if the request was successful
    //     // return response()->json(['message' => 'Shipping order created successfully!']);
    //     if ($response->successful()) {
    //         return response()->json(['message' => 'Shipping order created successfully!', 'data' => $response->json()]);
    //     } else {
    //         // Log the error and return a response
    //         Log::error('Failed to create shipping order: ' . $response->body());
    //         return response()->json(['error' => 'Failed to create shipping order', 'details' => $response->body()], 400);
    //     }
    // }

    // public function fetchPickupLocations()
    // {
    //     // Retrieve the Shiprocket token from session or environment
    //     $token = session('shiprocket_token') ?: $this->getToken(); 

    //     if (!$token) {
    //         return response()->json(['error' => 'Unable to fetch token'], 400);
    //     }

    //     // Send a GET request to fetch pickup locations
    //     $response = Http::withOptions(['verify' => false])
    //         ->withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Content-Type' => 'application/json',
    //         ])
    //         ->get('https://apiv2.shiprocket.in/v1/external/pickup/locations');

    //     // Log the response for debugging
    //     Log::info('Fetch Pickup Locations Response: ' . $response->body());

    //     if ($response->successful()) {
    //         return response()->json(['message' => 'Pickup locations fetched successfully!', 'data' => $response->json()]);
    //     } else {
    //         Log::error('Failed to fetch pickup locations: ' . $response->body());
    //         return response()->json(['error' => 'Failed to fetch pickup locations', 'details' => $response->json()], 400);
    //     }
    // }

    public function createShipping(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required',
            'user_id' => 'required',
            'order_number' => 'required',
            'length' => 'required|numeric',
            'breadth' => 'required|numeric',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'pickup_address' => 'required|string'
        ]);

        $ord = Order::getAllOrderDetail($validated['order_id']);
        $pickup_address = PickupLocation::find($validated['pickup_address']);

        // Validate if the pickup address exists
        if (!$pickup_address) {
            return response()->json(['error' => 'Wrong Pickup location entered. Please choose one location from the data given.'], 400);
        }

        $token = session('shiprocket_token') ?: $this->getToken();

        if (!$token) {
            return response()->json(['error' => 'Unable to fetch token'], 400);
        }

        $order_items = [];
        $new_sub_total = 0;
        $total_discount = 0;

        foreach ($ord->cart_info as $item) {
            $original_price = $item->product->price;
            $discount_amount = ($item->product->discount / 100) * $original_price;
            $final_price = $original_price - $discount_amount;

            $order_items[] = [
                'name' => $item->product->product->title,
                'sku' => $item->product->sku,
                'units' => $item->quantity,
                'selling_price' => $item->product->price,
                'discount' => $item->product->discount,
                'tax' => $item->product->product->tax,
                'hsn' => $item->product->product->hsn_no
            ];

            $new_sub_total += $final_price * $item->quantity;
            $total_discount += $discount_amount * $item->quantity;
        }

        // $billing_address = trim($ord->address1 . ' ' . $ord->address2);

        // Prepare the shipping data
        $shippingData = [
            'order_id' => $validated['order_id'],
            'order_date' => $ord->created_at,
            'channel_id' => "5613365",
            'billing_customer_name' => $ord->first_name,
            'billing_last_name' => $ord->last_name,
            'billing_address' => $ord->address1,
            'billing_address_2' => $ord->address2??"   ",
            'billing_city' => $ord->city,
            'billing_state' => $ord->state,
            'billing_pincode' => $ord->post_code,
            'billing_country' => $ord->country,
            'billing_email' => $ord->email,
            'billing_phone' => $ord->phone,
            'shipping_is_billing' => true,

            'order_items' => $order_items,
            'payment_method' => $ord->payment_status,
            'shipping_charges' => "",
            'giftwrap_charges' => "",
            'transaction_charges' => "",
            'total_discount' => round($total_discount, 2),
            'sub_total' => round($new_sub_total, 2),

            'length' => $validated['length'],
            'breadth' => $validated['breadth'],
            'height' => $validated['height'],
            'weight' => $validated['weight'],
            'pickup_location' => $pickup_address->pickup_location_nickname, 
        ];
        // return $shippingData;

        // create shipping proper


        // Send a POST request to create the shipping order
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Authorization' => 'Bearer ' . $token,
                'Content-Type' => 'application/json',
            ])
            ->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $shippingData);

        // Log the response for debugging
        Log::info('Create Shipping Response: ' . $response->body());

        if ($response->successful()) {
            return response()->json(['message' => 'Shipping order created successfully!', 'data' => $response->json()]);
        } else {
            Log::error('Failed to create shipping order: ' . $response->body());
            return response()->json(['error' => 'Failed to create shipping order', 'details' => $response->json()], 400);
        }
    }

}
