<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Porder;
use App\Models\Shipping;
use App\Models\Product;

use App\Models\Shopping;
use App\Models\Reward;


use App\Models\User;
use PDF;
use Notification;
use Helper;
use Illuminate\Support\Str;
use App\Notifications\StatusNotification;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        //dd($orders);
        return view('backend.invoice.index')->with('orders', $orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // dd("hello");
        $product = Product::orderBy('id', 'DESC')->paginate(10);
        $orders = Order::orderBy('id', 'DESC')->paginate(10);
        return view('backend.invoice.create')->with('orders', $orders)->with('product', $product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        dd($data);
        if (isset($data['shipping_id'])) {
            $ord = Shopping::find($data['shipping_id']);
        } else {
            $ord = [];
        }

        $story = Reward::where('user_id', auth()->user()->id)->get();
        if (isset($story[0]->id)) {
            $rewards = Reward::find($story[0]->id);
            $data['user_id'] = $story[0]->user_id;
            $data['point'] = (int)$story[0]->point - (int)$data['reward'];
            $rewards->fill($data)->update();
        }


        //dd($rewards);
        //   dd($ord);
        //  dd($ord['first_name']);

        // $this->validate($request,[
        //     'first_name'=>'string|required',
        //     'last_name'=>'string|required',
        //     'address1'=>'string|required',
        //     'address2'=>'string|nullable',
        //     'coupon'=>'nullable|numeric',
        //     'phone'=>'numeric|required',
        //     'post_code'=>'string|nullable',
        //     'email'=>'string|required'
        // ]);
        // return $request->all();

        if (empty(Cart::where('user_id', auth()->user()->id)->where('order_id', null)->first())) {
            request()->session()->flash('error', 'Cart is Empty !');
            return back();
        }
        // $cart=Cart::get();
        // // return $cart;
        // $cart_index='ORD-'.strtoupper(uniqid());
        // $sub_total=0;
        // foreach($cart as $cart_item){
        //     $sub_total+=$cart_item['amount'];
        //     $data=array(
        //         'cart_id'=>$cart_index,
        //         'user_id'=>$request->user()->id,
        //         'product_id'=>$cart_item['id'],
        //         'quantity'=>$cart_item['quantity'],
        //         'amount'=>$cart_item['amount'],
        //         'status'=>'new',
        //         'price'=>$cart_item['price'],
        //     );

        //     $cart=new Cart();
        //     $cart->fill($data);
        //     $cart->save();
        // }

        // $total_prod=0;
        // if(session('cart')){
        //         foreach(session('cart') as $cart_items){
        //             $total_prod+=$cart_items['quantity'];
        //         }
        // }

        $order = new Order();
        $order_data = $request->all();
        $order_data['order_number'] = 'ORD-' . strtoupper(Str::random(10));
        if ($ord == '') {
            $order_data['first_name'] = $ord['first_name'];
            $order_data['last_name'] = $ord['last_name'];
            $order_data['address1'] = $ord['address1'];
            $order_data['address2'] = $ord['address2'];
            $order_data['phone'] = $ord['phone'];
            $order_data['post_code'] = $ord['post_code'];
            $order_data['email'] = $ord['email'];

            $order_data['country'] = $ord['country'];
        }

        //     'first_name'=>'string|required',
        //     'last_name'=>'string|required',
        //     'address1'=>'string|required',
        //     'address2'=>'string|nullable',
        //     'coupon'=>'nullable|numeric',
        //     'phone'=>'numeric|required',
        //     'post_code'=>'string|nullable',
        //     'email'=>'string|required'
        $order_data['user_id'] = $request->user()->id;
        $order_data['shipping_id'] = $request->shipping_id;
        // $shipping=Shipping::where('id',$order_data['shipping_id'])->pluck('price');
        $shipping = Shipping::where("status", 'active')->orderby("id", 'DESC')->limit(1)->pluck('price');
        //  dd($shipping);
        // return session('coupon')['value'];
        $order_data['sub_total'] = Helper::totalCartPrice();
        $order_data['quantity'] = Helper::cartCount();
        if (session('coupon')) {
            $order_data['coupon'] = session('coupon')['value'];
        }
        if ($request->shipping) {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0] - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice() + $shipping[0];
            }
        } else {
            if (session('coupon')) {
                $order_data['total_amount'] = Helper::totalCartPrice() - session('coupon')['value'];
            } else {
                $order_data['total_amount'] = Helper::totalCartPrice();
            }
        }
        $order_data['total_amount'] = (int) $data['tprice'];
        // dd($order_data);
        // return $order_data['total_amount'];
        $order_data['status'] = "new";
        if (request('payment_method') == 'onine') {
            $order_data['payment_method'] = 'online';
            $order_data['payment_status'] = 'paid';
        } else {
            $order_data['payment_method'] = 'cod';
            $order_data['payment_status'] = 'Unpaid';
        }
        $order->fill($order_data);

        // dd($order);
        $status = $order->save();
        if ($order)
            // dd($order->id);
            $users = User::where('role', 'admin')->first();
        $details = [
            'title' => 'New order created',
            'actionURL' => route('order.show', $order->id),
            'fas' => 'fa-file-alt'
        ];
        Notification::send($users, new StatusNotification($details));

        session()->forget('cart');
        session()->forget('coupon');
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => $order->id]);
        // $porder=new Porder();

        // $porder['onumber']='ORD-'.strtoupper(Str::random(10));
        // $porder['first_name']=$ord['first_name'];
        // $porder['last_name']=$ord['last_name'];
        // $porder['address1']=$ord['address1'];
        // $status=Porder::create($pdata);


        // dd($users);      
        request()->session()->flash('success', 'Your product successfully placed in order');
        $msg = "<!doctype html>
        <html lang=\"en\" data-bs-theme=\"light\" data-footer=\"dark\">
        
            
        <!-- Mirrored from themesbrand.com/toner/html/frontend/email-order-success.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 07:41:31 GMT -->
        <head>
        
                <meta charset=\"utf-8\">
                <title>Order Success Email Template | Toner eCommerce + Admin HTML Template</title>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                <meta content=\"Toner - eCommerce + Admin HTML Template Build with HTML, React, Laravel, Nodejs\" name=\"description\">
                <meta content=\"Themesbrand\" name=\"author\">
                <!-- App favicon -->
                <link rel=\"shortcut icon\" href=\"https://themesbrand.com/toner/html/assets/images/favicon.ico\">
        
                <link href=\"https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap\" rel=\"stylesheet\">
        
            </head>
        
            <body>
        
                <section style=\"font-family: 'Inter', sans-serif; box-sizing: border-box; font-size: 15px; width: 100%; background-color: transparent; margin: 35px 0;color: #06283D;\">
                    <div style=\"max-width: 650px;margin:auto; box-shadow: rgba(135, 138, 153, 0.10) 0 5px 20px -6px;border-radius: 6px;border: 1px solid #eef1f5;overflow: hidden;background-color: #fff;\">
                        <div style=\"padding: 1.5rem;background-color: #fafafa;\">
                            <a href=\"index.html\"><img src=\"../assets/images/logo-dark.png\" alt=\"\" height=\"28\" style=\"display: block;margin: 0 auto;\"></a>
                        </div>
                        <div style=\"padding: 1.5rem;\">
                            <h5 style=\"font-size: 18px;font-family: 'Inter', sans-serif;font-weight: 600;margin-bottom: 18px;margin-top: 0px;line-height: 1.2;\">Your Order Confirmed!</h5>
        
                            <h6 style=\"font-size: 16px;font-weight: 500;margin-bottom: 12px;margin-top: 0px;line-height: 1.2;\">Hello, Edward</h6>
                            <p style=\"color: #878a99 !important; margin-bottom: 20px;margin-top: 0px;\">Your order has been Confirmed and will be shipping soon.</p>
                            <table style=\"width: 100%;\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td style=\"padding: 5px; vertical-align: top;\">
                                        <p style=\"color: #878a99 !important; margin-bottom: 12px; font-size: 13px; text-transform: uppercase;font-weight: 500;margin-top: 0px;\">Order Date</p>
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">01 Jan, 2023</h6>
                                    </td>
                                    <td style=\"padding: 5px; vertical-align: top;\">
                                        <p style=\"color: #878a99 !important; margin-bottom: 12px; font-size: 13px; text-transform: uppercase;font-weight: 500;margin-top: 0px;\">Order ID</p>
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">HY45120010</h6>
                                    </td>
                                    <td style=\"padding: 5px; vertical-align: top;\">
                                        <p style=\"color: #878a99 !important; margin-bottom: 12px; font-size: 13px; text-transform: uppercase;font-weight: 500;margin-top: 0px;\">Payment</p>
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">Cash On Delivery</h6>
                                    </td>
                                    <td style=\"padding: 5px; vertical-align: top;\">
                                        <p style=\"color: #878a99 !important; margin-bottom: 12px; font-size: 13px; text-transform: uppercase;font-weight: 500;margin-top: 0px;\">Address</p>
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">USA</h6>
                                    </td>
                                </tr>
                            </table>
        
                            <h6 style=\"font-family: 'Inter', sans-serif; font-size: 15px;font-weight: 600; text-decoration-line: underline;margin-bottom: 16px;margin-top: 20px;\">Her'e what you ordered:</h6>
                            <table style=\"width: 100%;border-collapse: collapse;\" cellspacing=\"0\" cellpadding=\"0\">
                                <tr>
                                    <td style=\"padding: 12px 5px; vertical-align: top;width: 65px;\">
                                        <div style=\"border: 1px solid #eaeef4;height: 64px;width: 64px;display: flex; align-items: center;justify-content: center;border-radius: 6px;\">
                                            <img src=\"../assets/images/products/img-5.png\" alt=\"\" height=\"38\">
                                        </div>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Inter', sans-serif;\">Noise NoiseFit Endure Smart Watch</h6>
                                        <p style=\"color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;\">Graphic Print Men & Women Sweatshirt</p>
                                        <p style=\"color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 0;\"><span>Color: Red</span> <span style=\"margin-left: 15px;\">Size: 8 (US)</span></p>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 400; font-family: 'Inter', sans-serif;\">Qty 5</h6>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;text-align: end;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$599.99</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 12px 5px; vertical-align: top;width: 65px;\">
                                        <div style=\"border: 1px solid #eaeef4;height: 64px;width: 64px;display: flex; align-items: center;justify-content: center;border-radius: 6px;\">
                                            <img src=\"../assets/images/products/img-6.png\" alt=\"\" height=\"38\">
                                        </div>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Inter', sans-serif;\">Striped High Neck Men Orange Sweater</h6>
                                        <p style=\"color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;\">Graphic Print Men & Women Sweatshirt</p>
                                        <p style=\"color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 0;\"><span>Color: Orange</span> <span style=\"margin-left: 15px;\">Size: M</span></p>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 400; font-family: 'Inter', sans-serif;\">Qty 1</h6>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;text-align: end;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$62.40</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 12px 5px; vertical-align: top;width: 65px;\">
                                        <div style=\"border: 1px solid #eaeef4;height: 64px;width: 64px;display: flex; align-items: center;justify-content: center;border-radius: 6px;\">
                                            <img src=\"../assets/images/products/img-4.png\" alt=\"\" height=\"38\">
                                        </div>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 500; font-family: 'Inter', sans-serif;\">Girls Mint Green Solid Open Flats</h6>
                                        <p style=\"color: #878a99 !important; margin-bottom: 10px; font-size: 13px;font-weight: 500;margin-top: 6px;\">Women Footwear</p>
                                        <p style=\"color: #878a99 !important; margin-bottom: 0px; font-size: 13px;font-weight: 500;margin-top: 0;\"><span>Color: Mint Green</span> <span style=\"margin-left: 15px;\">Size: 10 (US)</span></p>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 400; font-family: 'Inter', sans-serif;\">Qty 3</h6>
                                    </td>
                                    <td style=\"padding: 12px 5px; vertical-align: top;text-align: end;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$43.00</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=\"3\" style=\"padding: 12px 8px; font-size: 15px;border-top: 1px solid #e9ebec;\">
                                        Subtotal
                                    </td>
                                    <td style=\"padding: 12px 8px; font-size: 15px;text-align: end; border-top: 1px solid #e9ebec;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$334.97</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=\"3\" style=\"padding: 12px 8px; font-size: 15px;\">
                                        Shipping Charge
                                    </td>
                                    <td style=\"padding: 12px 8px; font-size: 15px;text-align: end; \">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$9.50</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=\"3\" style=\"padding: 12px 8px; font-size: 15px;\">
                                        Taxs (18.00%)
                                    </td>
                                    <td style=\"padding: 12px 8px; font-size: 15px;text-align: end; \">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$15.26</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=\"3\" style=\"padding: 12px 8px; font-size: 15px;\">
                                        Discount (Toner50)
                                    </td>
                                    <td style=\"padding: 12px 8px; font-size: 15px;text-align: end; \">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$50.00</h6>
                                    </th>
                                </tr>
                                <tr>
                                    <td colspan=\"3\" style=\"padding: 12px 8px; font-size: 15px;border-top: 1px solid #e9ebec;\">
                                        Total Amount
                                    </td>
                                    <td style=\"padding: 12px 8px; font-size: 15px;text-align: end; border-top: 1px solid #e9ebec;\">
                                        <h6 style=\"font-size: 15px; margin: 0px;font-weight: 600; font-family: 'Inter', sans-serif;\">$338.95</h6>
                                    </td>
                                </tr>
                            </table>
                            <p style=\"color: #878a99; margin-bottom: 20px;margin-top: 15px;\">We'll send you shipping Confirmation when your item(s) are on the way! We appreciate your business, and hope you enjoy your purchase.</p>
                            <div style=\"text-align: right;\">
                                <h6 style=\"font-size: 15px; margin: 0px;font-weight: 500;font-size: 17px; font-family: 'Inter', sans-serif;\">Thank you!</h6>
                                <p style=\"color: #878a99; margin-bottom: 0;margin-top: 8px;\">Themesbrand</p>
                            </div>
                        </div>
                        <div style=\"padding: 1.5rem;background-color: #fafafa;\">
                            <div style=\"display: flex;gap: 5px;justify-content: space-between;\">
                                <p style=\"color: #878a99; margin: 0;\">Questions? Contact Our <a href=\"#!\" style=\"text-decoration: none;\"> Customer Support</a></p>
                                <p style=\"color: #878a99; margin: 0;\"><script>document.write(new Date().getFullYear())</script> © Toner.</p>
                            </div>
                        </div>
                    </div>
                </section>
        
           
        
            </body>
        
        
        <!-- Mirrored from themesbrand.com/toner/html/frontend/email-order-success.html by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 04 Jan 2024 07:41:31 GMT -->
        </html>";
        //dd($msg);
        // use wordwrap() if lines are longer than 70 characters

        // send email
        $status = mail("kshitiztripathi231@gmail.com", "Order Successfully", $msg);

        $reward_amount = (int) $order_data['sub_total'] / 100;
        $ranout = $reward_amount * 3;
        // return $request->all();

        // dd($story);       
        if (empty($story['items']) == false) {

            Reward::create([
                'point' => $ranout,
                'user_id' => auth()->user()->id
            ]);
        } else {
            //  dd($story[0]->id);
            $rewards = Reward::find($story[0]->id);
            $data['user_id'] = $story[0]->user_id;
            $data['point'] = (int)$story[0]->point + $ranout;
            $rewards->fill($data)->update();
        }


        // $status=$story->fill($data)->save();

        //dd($status);

        //  return redirect()->route('home');

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
        $order = Order::find($id);
        // return $order;
        return view('backend.order.show')->with('order', $order);
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
            request()->session()->flash('success', 'Successfully updated order');
        } else {
            request()->session()->flash('error', 'Error while updating order');
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
                request()->session()->flash('success', 'Order Successfully deleted');
            } else {
                request()->session()->flash('error', 'Order can not deleted');
            }
            return redirect()->route('order.index');
        } else {
            request()->session()->flash('error', 'Order can not found');
            return redirect()->back();
        }
    }

    public function orderTrack($id)
    {
        //   dd($id);
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $id)->first();
        return view('frontend.pages.order-track')->with('order', $order);
    }

    public function productTrackOrder(Request $request)
    {
        // return $request->all();
        $order = Order::where('user_id', auth()->user()->id)->where('order_number', $request->order_number)->first();
        if ($order) {
            if ($order->status == "new") {
                request()->session()->flash('success', 'Your order has been placed. please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "process") {
                request()->session()->flash('success', 'Your order is under processing please wait.');
                return redirect()->route('home');
            } elseif ($order->status == "delivered") {
                request()->session()->flash('success', 'Your order is successfully delivered.');
                return redirect()->route('home');
            } else {
                request()->session()->flash('error', 'Your order canceled. please try again');
                return redirect()->route('home');
            }
        } else {
            request()->session()->flash('error', 'Invalid order numer please try again');
            return back();
        }
    }

    // PDF generate
    public function pdf(Request $request)
    {
        $order = Order::getAllOrder($request->id);
        // return $order;
        $file_name = $order->order_number . '-' . $order->first_name . '.pdf';
        // return $file_name;
        $pdf = PDF::loadview('backend.order.pdf', compact('order'));
        return $pdf->download($file_name);
    }
    // Income chart
    public function incomeChart(Request $request)
    {
        $year = \Carbon\Carbon::now()->year;
        // dd($year);
        $items = Order::with(['cart_info'])->whereYear('created_at', $year)->where('status', 'delivered')->get()
            ->groupBy(function ($d) {
                return \Carbon\Carbon::parse($d->created_at)->format('m');
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
            $data[$monthName] = (!empty($result[$i])) ? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
