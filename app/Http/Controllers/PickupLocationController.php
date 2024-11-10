<?php

namespace App\Http\Controllers;

use App\Models\PickupLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PickupLocationController extends Controller
{
    //
    public function pickup_address()
    {
        $pickup = PickupLocation::all();
        return view('backend.shipping.pickup_address.index',compact('pickup'));
    }
    public function create_address()
    {
        return view('backend.shipping.pickup_address.create');
    }
    public function store_address(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'nickname' => 'nullable|required|string',
            'shiperName' => 'required|string',
            'email' => 'required|email|unique:pickup_locations,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'address2' => 'nullable',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'pincode' => 'required|string',
            // 'lat' => 'nullable|numeric',
            // 'long' => 'nullable|numeric',
            // 'address_type' => 'nullable|string',
            // 'vendor_name' => 'nullable|string',
            // 'gstin' => 'nullable|string',
        ]);

        
        $token = session('shiprocket_token')?: $this->getToken();

        if (!$token) {
            return response()->json(['error' => 'Unable to fetch token'], 401);
        }
        
        PickupLocation::create([
            'pickup_location_nickname' => $validated['nickname'],
            'shiper_name' => $validated['shiperName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'address_2' => $validated['address2'] ?? "   ",
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'pin_code' => $validated['pincode'],
        ]);
        
        $data = [
            'pickup_location' => $validated['nickname'],
            'name' => $validated['shiperName'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'address_2' => $validated['address2'] ?? "   ",
            'city' => $validated['city'],
            'state' => $validated['state'],
            'country' => $validated['country'],
            'pin_code' => $validated['pincode'],
        ];
        // return $data;

        
        $response =  Http::withOptions(['verify' => false])
        ->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Content-Type' => 'application/json',
        ])->post('https://apiv2.shiprocket.in/v1/external/settings/company/addpickup', $data);
        
        // return $response;
        // Log the response for debugging
        Log::info('Add Pickup Response: ' . $response->body());

        // Check the response status
        // if ($response->successful()) {
        //     return response()->json(['message' => 'Pickup address added successfully!', 'data' => $response->json()]);
        // } else {
        //     Log::error('Failed to add pickup address: ' . $response->body());
        //     return response()->json(['error' => 'Failed to add pickup address', 'details' => $response->body()], 400);
        // }
        if($response->successful()){
            return redirect()->back()->with('success','Pickup address Created Successfully.');
        }
        else{
            return redirect()->back()->with('error','Pickup address not Created.');
        }

    }

    // public function edit_address($id)
    // {
    //     $data = PickupLocation::find($id);
    //     return view('backend.shipping.pickup_address.update',compact('data'));
    // }

    // public function update_address(Request $request)
    // {
    //     // Validate the incoming request
    //     $validated = $request->validate([
    //         'nickname' => 'nullable|required|string',
    //         'shiperName' => 'required|string',
    //         'email' => 'required|email|unique:pickup_locations,email',
    //         'phone' => 'required|string',
    //         'address' => 'required|string',
    //         'address2' => 'nullable',
    //         'city' => 'required|string',
    //         'state' => 'required|string',
    //         'country' => 'required|string',
    //         'pincode' => 'required|string',
    //         // 'lat' => 'nullable|numeric',
    //         // 'long' => 'nullable|numeric',
    //         // 'address_type' => 'nullable|string',
    //         // 'vendor_name' => 'nullable|string',
    //         // 'gstin' => 'nullable|string',
    //     ]);


    //     $token = session('shiprocket_token');

    //     if (!$token) {
    //         return response()->json(['error' => 'Unable to fetch token'], 401);
    //     }

    //     PickupLocation::create([
    //         'pickup_location_nickname' => $validated['nickname'],
    //         'shiper_name' => $validated['shiperName'],
    //         'email' => $validated['email'],
    //         'phone' => $validated['phone'],
    //         'address' => $validated['address'],
    //         'address_2' => $validated['address2'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         'country' => $validated['country'],
    //         'pin_code' => $validated['pincode'],
    //     ]);

    //     $data = [
    //         'pickup_location' => $validated['nickname'],
    //         'name' => $validated['shiperName'],
    //         'email' => $validated['email'],
    //         'phone' => $validated['phone'],
    //         'address' => $validated['address'],
    //         'address_2' => $validated['address2'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         'country' => $validated['country'],
    //         'pin_code' => $validated['pincode'],
    //     ];

    //     return $data;


    //     $response =  Http::withOptions(['verify' => false])
    //     ->withHeaders([
    //         'Authorization' => 'Bearer ' . $token,
    //         'Content-Type' => 'application/json',
    //     ])->post('https://apiv2.shiprocket.in/v1/external/settings/company/addpickup', $data);

    //     // Log the response for debugging
    //     Log::info('Add Pickup Response: ' . $response->body());

    //     // Check the response status
    //     // if ($response->successful()) {
    //     //     return response()->json(['message' => 'Pickup address added successfully!', 'data' => $response->json()]);
    //     // } else {
    //     //     Log::error('Failed to add pickup address: ' . $response->body());
    //     //     return response()->json(['error' => 'Failed to add pickup address', 'details' => $response->body()], 400);
    //     // }
    //     if($response->successful()){
    //         return redirect()->back()->with('success','Pickup address Created Successfully.');
    //     }
    //     else{
    //         return redirect()->back()->with('error','Pickup address not Created.');
    //     }
    // }

    // new code cgt
    // public function update_address(Request $request, $id)
    // {
    //     // Validate the incoming request
    //     $validated = $request->validate([
    //         'nickname' => 'nullable|required|string|max:255',
    //         'shiperName' => 'required|string|max:255',
    //         'email' => 'required|email|unique:pickup_locations,email,' . $id,
    //         'phone' => 'required|string|max:20',
    //         'address' => 'required|string',
    //         'address2' => 'nullable|string',
    //         'city' => 'required|string|max:100',
    //         'state' => 'required|string|max:100',
    //         'country' => 'required|string|max:100',
    //         'pincode' => 'required|string|max:10',
    //     ]);

    //     $token = session('shiprocket_token');

    //     if (!$token) {
    //         return response()->json(['error' => 'Unable to fetch token'], 401);
    //     }

    //     $pickupLocation = PickupLocation::find($id);

    //     $pickupLocation->update([
    //         'pickup_location_nickname' => $validated['nickname'],
    //         'shiper_name' => $validated['shiperName'],
    //         'email' => $validated['email'],
    //         'phone' => $validated['phone'],
    //         'address' => $validated['address'],
    //         'address_2' => $validated['address2'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         'country' => $validated['country'],
    //         'pin_code' => $validated['pincode'],
    //     ]);

    //     $data = [
    //         'pickup_location' => $validated['nickname'],
    //         'name' => $validated['shiperName'],
    //         'email' => $validated['email'],
    //         'phone' => $validated['phone'],
    //         'address' => $validated['address'],
    //         'address_2' => $validated['address2'],
    //         'city' => $validated['city'],
    //         'state' => $validated['state'],
    //         'country' => $validated['country'],
    //         'pin_code' => $validated['pincode'],
    //     ];

    //     // Send the updated data to Shiprocket API
    //     $response = Http::withOptions(['verify' => false])
    //         ->withHeaders([
    //             'Authorization' => 'Bearer ' . $token,
    //             'Content-Type' => 'application/json',
    //         ])->post('https://apiv2.shiprocket.in/v1/external/orders/address/pickup', $data);

    //     // Log the response for debugging
    //     Log::info('Update Pickup Response: ' . $response->body());

    //     // Check the response status
    //     if ($response->successful()) {
    //         return redirect()->back()->with('success', 'Pickup address updated successfully.');
    //     } else {
    //         Log::error('Failed to update pickup address: ' . $response->body());
    //         return redirect()->back()->with('error', 'Pickup address could not be updated.');
    //     }
    // }


}
