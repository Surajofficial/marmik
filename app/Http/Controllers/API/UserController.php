<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Shopping;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function loginSubmitApi(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only('email', 'password');

        // Attempt to log in
        if (Auth::guard('web')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 'active'])) {
            $user = Auth::guard('web')->user();
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Successfully logged in',
                'status' => true,
                'data' => [
                    'user' => $user,
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                ],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password, please try again!',
            ], 401);
        }
    }
    public function registerSubmitApi(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|min:2',
            'email' => 'string|required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'message' => 'Validation failed',
                'status' => false,
            ], 422); // Unprocessable Entity
        }

        // Gather all data from the request
        $data = $request->only('name', 'email', 'password');

        // Hash the password before saving it
        $data['password'] = Hash::make($data['password']);

        // Create a new user
        $user = User::create($data);

        // Return success response with user data
        return response()->json([
            'status' => true,
            'message' => 'Successfully registered',
            'user' => $user,
        ], 201); // Created
    }
    public function account(Request $request)
    {

        $userId = $request->user()->id;
        $orders = Order::where('user_id', $userId)->orderBy('id', 'DESC')->paginate(10);
        $wishlist = Wishlist::where('user_id', $userId)->orderBy('id', 'DESC')->paginate(10);
        $shipping = Shopping::where('user_id', $userId)->first();

        return response()->json([
            'status' => true,
            'message' => 'Successfully Fethched',
            'data' => [
                'shipping' => $shipping,
                'orders' => $orders,
                'wishlist' => $wishlist,
            ]
        ]);
    }

}
