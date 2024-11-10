<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipping;
use App\Models\Shopping;
use App\Models\Couponnew;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ShippingController extends Controller
{

    public function index()
    {
        $shipping = Shipping::orderBy('id', 'DESC')->paginate(10);
        return view('backend.shipping.index')->with('shippings', $shipping);
    }

    public function create()
    {
        return view('backend.shipping.create');
    }


    public function store(Request $request)
    {
        $this->validate($request, [
            'type' => 'string|required',
            'price' => 'nullable|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();
        // return $data;
        $status = Shipping::create($data);
        if ($status) {
            session()->flash('success', 'Shipping successfully created');
        } else {
            session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    // this is old show function

    // public function show($id = null)
    // {
    //     $shipping = Shopping::where("user_id", Auth::guard('web')->user()->id)->count();
    //     return view('frontend.pages.cart', compact('shipping'));
    // }
    // this is new function
    public function show($id = null)
    {
        $userId = Auth::guard('web')->user()->id;

        // Count the number of shipping records for the user
        $shipping = Shopping::where('user_id', $userId)->count();
        // return  $shipping; 
        // Fetch all coupons that are either assigned to the authenticated user or available to all users
        $coupons = Couponnew::whereDoesntHave('users', function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereNotNull('used_at');
        })->orWhereDoesntHave('users')->get();


        // Pass both 'shipping' and 'coupons' to the view
        return view('frontend.pages.cart', compact('shipping', 'coupons'));

    }


    public function edit($id)
    {
        $shipping = Shipping::find($id);
        if (!$shipping) {
            session()->flash('error', 'Shipping not found');
        }
        return view('backend.shipping.edit')->with('shipping', $shipping);
    }

    public function update(Request $request, $id)
    {
        $shipping = Shipping::find($id);
        $this->validate($request, [
            'type' => 'string|required',
            'price' => 'nullable|numeric',
            'status' => 'required|in:active,inactive'
        ]);
        $data = $request->all();
        $status = $shipping->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Shipping successfully updated');
        } else {
            session()->flash('error', 'Error, Please try again');
        }
        return redirect()->route('shipping.index');
    }

    public function destroy($id)
    {
        $shipping = Shipping::find($id);
        if ($shipping) {
            $status = $shipping->delete();
            if ($status) {
                session()->flash('success', 'Shipping successfully deleted');
            } else {
                session()->flash('error', 'Error, Please try again');
            }
            return redirect()->route('shipping.index');
        } else {
            session()->flash('error', 'Shipping not found');
            return redirect()->back();
        }
    }
    public function shipping()
    {
        $shipping = Shopping::where("user_id", Auth::guard('web')->user()->id)->get();
        $user = User::where('id', Auth::user()->id)->get()->first();
        return view('frontend.pages.shipping-address', compact('user'))->with('shipping', json_encode($shipping));
    }
    public function shippingSubmit(Request $request)
    {

        $data = $request->all();
        // return $data;
        $this->validate($request, [
            'first_name' => 'string|required|min:2',
            // 'email' => 'string|required|email',  // Ensure email is unique
            'email' => 'string|required|email|unique:shoppings,email',  // Ensure email is unique
            'phone' => 'string|required',
            'country' => 'string|required',
            'address1' => 'string',
            'post_code' => 'string',
            'atype' => 'string|required',
        ]);

        $check = $this->createShipping($data);
        // return $check;
        if ($check) {
            session()->flash('success', 'Successfully added');
            return redirect()->route('shipping');
        } else {
            session()->flash('error', 'Email already in use!');
            return back();
        }
    }
    public function createShipping(array $data)
    {
        // Get the authenticated user
        $user = Auth::guard('web')->user();
        // Ensure user ID is retrieved properly
        $userId = $user->id;

        // Update user's email and mobile if not already set
        if ($user->email === null) {
            // Check if the new email already exists in the database
            $check_user = User::where('email', $data['email'])->count();

            if ($check_user <= 0) {
                // If no user has the same email, update the user's email
                $user->update(['email' => $data['email']]);
            } else {
                // If the email already exists, return false
                return false;
            }
        }

        if ($user->mobile === null) {
            $user->update(['mobile' => $data['phone']]);
        }

        // Check if the address number is 0, indicating a new address
        if ($data['add_num'] == 0) {
            // Create a new shipping address
            return Shopping::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'country' => $data['country'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'post_code' => $data['post_code'],
                'atype' => $data['atype'],
                'user_id' => $userId,
                'alter_nate_phone' => $data['alter_nate_phone'],
                'state' => $data['state'],
                'city' => $data['city']
            ]);
        } else {
            // Update the existing shipping address
            return Shopping::where('id', $data['add_num'])->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'country' => $data['country'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'post_code' => $data['post_code'],
                'atype' => $data['atype'],
                'user_id' => $userId,
                'alter_nate_phone' => $data['alter_nate_phone'],
                'state' => $data['state'],
                'city' => $data['city']
            ]);
        }
    }
    public function getAddressDetails($pincode)
    {
        $response = Http::get("https://api.postalpincode.in/pincode/{$pincode}");

        if (!preg_match('/^\d{6}$/', $pincode)) {
            return response()->json(['error' => 'Invalid pincode format.'], 422);
        }

        if ($response->successful() && $response->json()) {
            $data = $response->json();
            // Check if response is valid and has data
            if (!empty($data) && $data[0]['Status'] === 'Success') {
                // Extract city, state, and country from the response
                $places = $data[0]['PostOffice'];
                $city = $places[0]['District'] ?? null;
                $state = $places[0]['State'] ?? null;
                $country = 'IN';
                // Return the location details
                return response()->json([
                    'city' => $city,
                    'state' => $state,
                    'country' => $country,
                    'data' => $data,
                ]);
            }
        }

        // If no valid data found or request unsuccessful, return an error response
        return response()->json(['error' => 'Invalid pincode or no data available for this pincode.'], 422);
    }
}
