<?php

namespace App\Http\Controllers;

use App\Events\OrderPlaced;
use App\Jobs\GeneratePdfJob;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\DiscountedPurchase;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\PickupLocation;
use App\Models\Shopping;
use App\Models\Settings;
use App\Models\Stocks;
use App\Models\Variant;
use Helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'asc')->get();
        return view('backend.order.index')->with('orders', $orders);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $data = $request->all();
    //     if (empty(Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->first())) {
    //         session()->flash('error', 'Cart is Empty !');
    //         return redirect()->back();
    //     }

    //     if (isset($data['presc'])) {
    //         $presc = $data['presc'];
    //         $input = time() . "." . $presc->getClientOriginalExtension();
    //         $destinationPath = 'assets/prescription/';
    //         $presc->move($destinationPath, $input);
    //         $data['presc'] = $input;
    //     }
    //     $ord = Shopping::find($data['shipping_id']);
    //     $order = new Order();
    //     $order_data = $request->all();
    //     $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
    //     $order_data['first_name'] = $ord['first_name'];
    //     $order_data['last_name'] = $ord['last_name'];
    //     $order_data['address1'] = $ord['address1'];
    //     $order_data['address2'] = $ord['address2'];
    //     $order_data['phone'] = $ord['phone'];
    //     $order_data['post_code'] = $ord['post_code'];
    //     $order_data['email'] = $ord['email'];
    //     $order_data['country'] = $ord['country'];
    //     $order_data['user_id'] = $request->user()->id;
    //     $order_data['shipping_id'] = $request->shipping_id;
    //     $payable_amount = Helper::totalCartPrice()['payable_amount'];
    //     $order_data['sub_total'] = $payable_amount;
    //     $order_data['quantity'] = Helper::cartCount();
    //     $delevery_fee = Settings::pluck('delevery_fee_after')->first();
    //     if (session('coupon')) {
    //         $order_data['coupon'] = session('coupon')['value'];
    //     }
    //     $shipping = Shipping::where("status", 'active')->orderby("id", 'DESC')->limit(1)->pluck('price');
    //     if ($delevery_fee > $payable_amount) {
    //         $order_data['total_amount'] = $payable_amount + $shipping[0];
    //         $order_data['shipping_charge'] = $shipping[0];
    //     } else {
    //         $order_data['total_amount'] = $payable_amount;
    //         $order_data['shipping_charge'] = 0;
    //     }
    //     $order_data['status'] = "new";
    //     $order_data['payment_method'] = 'paypal';
    //     $order_data['payment_status'] = 'paid';
    //     $order->fill($order_data);
    //     // $order->save();
    //     session()->forget('cart');
    //     session()->forget('coupon');
    //     // $cart = Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
    //     $cart = Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->get();
    //     // return $cart;
    //     session()->flash('success', 'Your product successfully placed in order');
    //     return view('frontend.pages.order-confirmation')->with('order', $order_data['order_number']);
    // }

    public function submitTracking(Request $request): array
    {
        $order = Order::where('id', $request->order_id)->update(['tracking_id' => $request->tracking_number, 'status' => 'process']);
        return ['success' => true, 'order' => $order];
    }
    public function store(Request $request)
    {


        $data = $request->all();
        $userId = Auth::guard('web')->user()->id;
        $couponcode = $request->input('couponcode'); // or $request->tprice;


        // Check if the cart is empty
        if (empty(Cart::where('user_id', $userId)->where('order_id', null)->first())) {
            session()->flash('error', 'Cart is Empty!');
            return redirect()->back();
        }

        // Handle prescription file upload
        if (isset($data['presc'])) {
            $presc = $data['presc'];
            $input = time() . "." . $presc->getClientOriginalExtension();
            $destinationPath = 'assets/prescription/';
            $presc->move($destinationPath, $input);
            $data['presc'] = $input;
        }

        // Create the order
        $order = new Order();
        $ord = Shopping::find($data['shipping_id']);
        $order_data = [
            'order_number' => 'ORD-' . strtoupper(Str::random(10)),
            'first_name' => $ord->first_name,
            'last_name' => $ord->last_name,
            'address1' => $ord->address1,
            'address2' => $ord->address2,
            'phone' => $ord->phone,
            'city' => $ord->city,
            'state' => $ord->state,
            'post_code' => $ord->post_code,
            'email' => $ord->email,
            'country' => $ord->country,
            'billing_id' => $request->billing_id,
            'user_id' => $userId,
            'shipping_id' => $data['shipping_id'],
            'sub_total' => Helper::totalCartPrice()['payable_amount'],
            'quantity' => Helper::cartCount(),
            'status' => 'new',
            'payment_method' => 'paypal',
            'payment_status' => 'paid',
        ];

        // Calculate total amount
        $delevery_fee = Settings::pluck('delevery_fee_after')->first();
        $order_data['total_amount'] = ($delevery_fee > $order_data['sub_total']) ? $order_data['sub_total'] + 80 : $order_data['sub_total'];
        $order_data['shipping_charge'] = ($delevery_fee > $order_data['sub_total']) ? 80 : 0;
        $order->fill($order_data);
        $order->save();

        // event(new OrderPlaced($order));

        // Update cart items with order ID
        $cartItems = Cart::where('user_id', $userId)->where('order_id', null)->get();
        foreach ($cartItems as $item) {
            $product = Variant::where('id', $item->product_id)->first();
            if ($product->special_price != 0) {
                $discount = DiscountedPurchase::where('user_id', Auth::guard('web')->user()->id)->where('product_variants_id', $product->id)->first();
                if (!$discount) {
                    DiscountedPurchase::create(['product_variants_id' => $product->id, 'user_id' => Auth::guard('web')->user()->id]);
                }
            }
        }
        foreach ($cartItems as $cartItem) {
            $cartItem->update(['order_id' => $order->id]);

            // Get the variant
            $variant = Variant::find($cartItem->product_id);

            // Subtract stock from batches
            $quantity = $cartItem->quantity;
            $batches = Stocks::where('variant_id', $variant->id)
                ->where('stock', '>', 0)
                ->orderBy('expiry', 'ASC')
                ->get();

            foreach ($batches as $batch) {
                if ($quantity <= 0)
                    break;

                if ($batch->stock >= $quantity) {
                    $batch->stock -= $quantity;
                    $batch->save();
                    $quantity = 0;
                } else {
                    $quantity -= $batch->stock;
                    $batch->stock = 0;
                    $batch->save();
                }
            }

            // Update the total stock in the variant table
            $totalStock = Stocks::where('variant_id', $variant->id)->sum('stock');
            $variant->update(['stock' => $totalStock]);
        }

        session()->forget('cart');
        session()->forget('coupon');

        OrderNotification::create([
            'order_id' => $order->id,
            'message' => 'New Order Place: Order ID ' . $order->order_number,
        ]);



        session()->flash('success', 'Your order has been successfully placed.');
        // Assuming you have a Coupon table and want to get coupon ID
        $coupon = DB::table('coupons')->where('code', $couponcode)->first();

        if ($coupon) {
            // Update the coupon usage record
            DB::table('coupon_user')
                ->where('user_id', $userId)
                ->where('coupon_id', $coupon->id)
                ->update([
                    'used_at' => Carbon::now(), // Update the used_at timestamp
                    'updated_at' => Carbon::now() // Update the updated_at timestamp
                ]);

            // return response()->json(['success' => true, 'message' => 'Coupon usage updated successfully.']);
        }
        return view('frontend.pages.order-confirmation')->with('order', $order_data['order_number']);
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::getAllOrderDetail($id);
        $pickup_loc = PickupLocation::all();
        return view('backend.order.show',compact('pickup_loc'))->with('order', $order);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $order = Order::find($id);
        return view('backend.order.edit')->with('order', $order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);
        $this->validate($request, [
            'status' => 'required|in:new,process,delivered,cancel'
        ]);
        $data = $request->all();
        // return $request->status;
        if ($request->status == 'delivered') {
            foreach ($order->cart as $cart) {
                $product = $cart->product;
                // return $product;
                $product->stock -= $cart->quantity;
                $product->save();
            }
        }
        $status = $order->fill($data)->save();
        if ($status) {
            session()->flash('success', 'Successfully updated order');
        } else {
            session()->flash('error', 'Error while updating order');
        }
        return redirect()->route('order.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $order = Order::find($id);
        if ($order) {
            $status = $order->delete();
            if ($status) {
                session()->flash('success', 'Order Successfully deleted');
            } else {
                session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack($id)
    {
        //   dd($id);
        $order = Order::where('user_id', Auth::guard('web')->user()->id)->where('order_number', $id)->first();
        return view('frontend.pages.order-track')->with('order', $order);
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', Auth::guard('web')->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                session()->flash('success', 'Your order has been placed. please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "process") {
                session()->flash('success', 'Your order is under processing please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "delivered") {
                session()->flash('success', 'Your order is successfully delivered.');
                return redirect()->route('home');
            } else {
                session()->flash('error', 'Your order canceled. please try again');
                return redirect()->route('home');
            }
        } else {
            session()->flash('error', 'Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    // public function pdf(Request $request)
    // {
    //     $order = Order::getAllOrder($request->id);
    //     // return $order;
    //     $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
    //     // return $file_name;
    //     $pdf = Pdf::loadview('backend.order.pdf', compact('order'));
    //     return $pdf->download($file_name);
    // }
    public function pdf(Request $request)
    {

        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $file_path = "public/pdfs/$file_name";
        if (!Storage::exists($file_name)) {
            // Dispatch job to generate PDF if not exists
            GeneratePdfJob::dispatch($order->id);
            return response()->json(['message' => 'PDF generation is in progress. Pslease try again shortly.']);
        }
        return response()->download(storage_path("app/$file_path"));
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return Carbon::parse($d->created_at)->format('m');
            });
        // dd($items);
        $result = [];
        foreach ($items as $month => $item_collections) {
            foreach ($item_collections as $item) {
                $amount = $item->cart_info->sum('amount');
                // dd($amount);
                $m = intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount : $result[$m] = $amount;
            }
        }
        $data = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 1));
            $data[$monthName] = (!empty($result[$i])) ? number_format((float) ($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
