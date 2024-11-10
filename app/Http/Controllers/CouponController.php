<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\User;
use App\Models\Couponnew;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //  this is old index function to show all coupon code
    // public function index()
    // {
    //     $coupon=Coupon::orderBy('id','DESC')->paginate('10');
    //     return view('backend.coupon.index')->with('coupons',$coupon);
    // }

    public function index()
    {
        // Fetch all coupons from the database, ordered by creation date (latest first)
        $coupons = Couponnew::orderBy('id', 'desc')->get();

    
        // Pass the coupons to the view
        return view('backend.coupon.indexcoupon', compact('coupons'));
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('backend.coupon.create');
        $users = User::all();
        $products = Product::all(); 
        return view('backend.coupon.createcoupon', compact('users', 'products'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //  old store function for creating coupons
    // public function store(Request $request)
    // {
    //     // $this->validate($request,[
    //     //     'code'=>'string|required',
    //     //     'type'=>'required|in:fixed,percent',
    //     //     'value'=>'required|numeric',
    //     //     'Coupen_Allowed'=>'required',
    //     //     'status'=>'required|in:active,inactive'
    //     // ]);
    //     $data=$request->all();
    //   //  dd($data);
    //     $status=Coupon::create($data);
    //     if($status){
    //         request()->session()->flash('success','Coupon Successfully added');
    //     }
    //     else{
    //         request()->session()->flash('error','Please try again!!');
    //     }
    //     return redirect()->route('coupon.index');
    // }


    private function generateUniqueCouponCode()
    {
        do {
            // Generate a coupon code with 3 random letters and 3 random digits
            $couponCode = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3)) .
                          substr(str_shuffle('0123456789'), 0, 3);
        } while (Couponnew::where('code', $couponCode)->exists());
    
        return $couponCode;
    }

    // here is new store code for creating coupon

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'assign_to' => 'required|in:all,selected',
            'users' => 'nullable|array', // Only validate if 'selected'
            'users.*' => 'exists:users,id', // Validate each user ID
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            // Redirect back with validation errors and input data
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Check if the 'code' field is empty, generate a unique coupon code
        $couponCode = $request->code ?: $this->generateUniqueCouponCode();
      
        // Create the coupon
        $coupon = Couponnew::create([
            'code' => $couponCode,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order' => $request->min_order,
            'max_discount' => $request->max_discount,
            'expires_at' => $request->expires_at,
            'product_id' => $request->product_id,
        ]);


        // Assign the coupon to users if selected
        if ($request->assign_to === 'selected' && $request->has('users')) {
            $coupon->users()->attach($request->users);
        }

        return redirect()->route('coupon.create')->with('success', 'Coupon created successfully!');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  this is old edit function for coupon table

    // public function edit($id)
    // {
    //     $coupon=Coupon::find($id);
    //     if($coupon){
    //         return view('backend.coupon.edit')->with('coupon',$coupon);
    //     }
    //     else{
    //         return view('backend.coupon.index')->with('error','Coupon not found');
    //     }
    // }

    // this is new coupon code for creating 

 
    public function edit($id)
    {
        // Retrieve the coupon with associated users
        $coupon = Couponnew::with('users')->findOrFail($id);

        // Check if coupon exists
        if (!$coupon) {
            return redirect()->route('coupons.index')->with('error', 'Coupon not found.');
        }

        // Retrieve all users for the selection
        $users = User::all(); // Adjust this to get your users as needed
        $products = Product::all();
        return view('backend.coupon.editcoupon', compact('coupon', 'users', 'products'));
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    //  this is old updation code for coupon
    // public function update(Request $request, $id)
    // {
    //     $coupon=Coupon::find($id);
    //     // $this->validate($request,[
    //     //     'code'=>'string|required',
    //     //     'type'=>'required|in:fixed,percent',
    //     //     'value'=>'required|numeric',
    //     //     'Coupen_Allowed'=>'required',
    //     //     'status'=>'required|in:active,inactive'
    //     // ]);
    //     $data=$request->all();
        
    //     $status=$coupon->fill($data)->save();
    //     if($status){
    //         request()->session()->flash('success','Coupon Successfully updated');
    //     }
    //     else{
    //         request()->session()->flash('error','Please try again!!');
    //     }
    //     return redirect()->route('coupon.index');
        
    // }

    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:50|unique:coupons_new,code,' . $id,
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0',
            'min_order' => 'required|numeric|min:0',
            'max_discount' => 'required|numeric|min:0',
            'expires_at' => 'nullable|date',
            'assign_to' => 'required|in:all,selected',
            'users' => 'nullable|array', // Only validate if 'selected'
            'users.*' => 'exists:users,id', // Validate each user ID
        ]);

        // If validation fails, return JSON response with errors
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // Find the coupon by ID
        $coupon = Couponnew::find($id);

        // Check if coupon exists
        if (!$coupon) {
            return response()->json([
                'status' => 'error',
                'message' => 'Coupon not found.',
            ], 404);
        }

        // Update the coupon with new data
        $coupon->update([
            'code' => $request->code,
            'description' => $request->description,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'min_order' => $request->min_order,
            'max_discount' => $request->max_discount,
            'expires_at' => $request->expires_at,
            'product_id' => $request->product_id,
        ]);

        // If 'assign_to' is 'selected', update the user relationships
        if ($request->assign_to === 'selected' && $request->has('users')) {
            $coupon->users()->sync($request->users);
        } else {
            // Remove all users if 'assign_to' is not 'selected'
            $coupon->users()->detach();
        }
        // Redirect to the edit page with a success message
        return redirect()->route('coupon.edit', $coupon->id)
        ->with('success', 'Coupon updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // this is old code for delete coupon
    // public function destroy($id)
    // {
    //     $coupon=Coupon::find($id);
    //     if($coupon){
    //         $status=$coupon->delete();
    //         if($status){
    //             request()->session()->flash('success','Coupon successfully deleted');
    //         }
    //         else{
    //             request()->session()->flash('error','Error, Please try again');
    //         }
    //         return redirect()->route('coupon.index');
    //     }
    //     else{
    //         request()->session()->flash('error','Coupon not found');
    //         return redirect()->back();
    //     }
    // }

    // this new code for delete coupon
    public function destroy($id)
    {
        // Find the coupon by ID
        $coupon = Couponnew::find($id);
    
        // Check if coupon exists
        if (!$coupon) {
            return redirect()->route('coupon.index')->with('error', 'Coupon not found.');
        }
    
        // Manually delete associated records in coupon_user
        $coupon->users()->detach(); // This will remove all entries related to this coupon in coupon_user
    
        // Delete the coupon
        $coupon->delete();
    
        // Redirect back to the coupon list with a success message
        return redirect()->route('coupon.index')->with('success', 'Coupon deleted successfully!');
    }
    


    public function couponStore(Request $request){
        // return $request->all();
        $coupon=Coupon::where('code',$request->code)->first();
        // dd($coupon);
        if(!$coupon){
            session()->forget('coupon');
            request()->session()->flash('error','Invalid coupon code, Please try again');
            return back();
        }
        if($coupon){
            $total_price=Cart::where('user_id',auth()->user()->id)->where('order_id',null)->sum('price');
            // dd($total_price);
            session()->put('coupon',[
                'id'=>$coupon->id,
                'code'=>$coupon->code,
                'value'=>$coupon->discount($total_price)
            ]);

            request()->session()->flash('success','Coupon successfully applied');
            return redirect()->back();
        }
    }
}
