<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderNotification;
use App\Models\Settings;
use App\Models\Shopping;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use NumberToWords\NumberToWords;

class BillinController extends Controller
{
    public static function billgernate(Request $request)
    {
        
        $size = Helper::showForm();
        $settings = Settings::selectExcept(['description', 'short_des'])->get()->first();
        // return $settings;
        $order = Order::getAllOrderDetail($request->id);
        // return $order;
        $totals = Cart::where('order_id', $order->id)->selectRaw('SUM(tax) as total_tax, SUM(cgst) as total_cgst, SUM(sgst) as total_sgst, SUM(amount) as total_payble,SUM(orignalAmount) as total_amount')->get()->first();
        // return $totals;
        $shipping = Shopping::where('id', $order->shipping_id)->get()->first();
        // return $shipping;
        $billing = Shopping::where('id', $order->billing_id)->get()->first();
        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');
        $number_toword = $numberTransformer->toWords($totals->total_payble);

        // Notification
        $notification = OrderNotification::where('order_id', $order->id)->first();

        if ($notification) {
            if (is_null($notification->read_at)) {
                $notification->update(['read_at' => Carbon::now('Asia/Kolkata')]);
            }
        } else {
            OrderNotification::create([
                'order_id' => $order->id, 
                'read_at' => Carbon::now('Asia/Kolkata'),
            ]);
        }
        
        return view('frontend.pages.userbill', compact('order', 'settings', 'size', 'totals', 'number_toword', 'shipping', 'billing'));
    }
    public static function billgernate2(Request $request)
    {
        return view('frontend.pages.location2');
    }

}
