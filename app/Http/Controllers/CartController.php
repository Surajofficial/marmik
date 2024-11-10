<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Cart;
use App\Models\Settings;
use App\Models\Shipping;
use App\Models\Shopping;
use App\Models\User;
use App\Models\Variant;
use Helper;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    protected $product = null;
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function buy(Request $request)
    {
        $product = Product::where('slug', $request->slug)->first();
        $already_cart = Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        if ($already_cart) {
            return ['status' => false, 'msg' => 'already exist'];
        } else {
            return $this->addToCart($request);
        }
    }
    public function addToCart(Request $request)
    {

        // return $request->all();
        if (empty($request->variant)) {
            return response()->json(['status' => 'false', 'message' => 'Invalid Products'], 400);
        }
        $product = Variant::with('product')->where('id', $request->variant)->get()->first();
        // return $product;
        if (empty($product)) {
            return response()->json(['status' => 'false', 'message' => 'Invalid Products'], 400);
        }
        $user_id = Auth::guard('web')->user()->id;
        $discount = $product->discount / 100;
        $discount_price = (float) str_replace(',', '', number_format($product->price - ($product->price * $discount), 2));
        $tax = (float) str_replace(',', '', number_format($discount_price * ($product->product->tax / 100), 2));
        $cgst = (float) str_replace(',', '', number_format($discount_price * ($product->product->cgst / 100), 2));
        $sgst = (float) str_replace(',', '', number_format($discount_price * ($product->product->sgst / 100), 2));
        $tax_1st = $tax;
        $cgst_1st = $cgst;
        $sgst_1st = $sgst;
        $already_cart = Cart::where('user_id', $user_id)->where('order_id', null)->where('product_id', $product->id)->first();
        $product->display_price = FrontendController::getprice($product);
        if ($product->display_price != $product->price) {
            $tax_1st = (float) str_replace(',', '', number_format($product->display_price * ($product->product->tax / 100), 2));
            $cgst_1st = (float) str_replace(',', '', number_format($product->display_price * ($product->product->cgst / 100), 2));
            $sgst_1st = (float) str_replace(',', '', number_format($product->display_price * ($product->product->sgst / 100), 2));
        } else {
            $product->display_price = $discount_price;
        }
        if ($already_cart) {
            $new_quantity = $already_cart->quantity + $request->q;
            if (isset($request->q) && $request->q == '-1' && $already_cart->quantity != 1) {
                $new_quantity = $already_cart->quantity - 1;
            }
            if ($already_cart->quantity <= 1 && $request->q == '-1') {
                Cart::where('user_id', $user_id)->where('order_id', null)->where('product_id', $product->id)->delete();
                return redirect()->back();
            }
            $new_quantity = $already_cart->quantity + $request->q;
            if ($new_quantity <= 0) {
                return response()->json(['status' => 'false', 'message' => "Can't add negative quantity"], 400);
            }
            if ($product->stock < $new_quantity) {
                return response()->json(['status' => 'false', 'message' => 'Stock not sufficient!'], 200);
            }
            $already_cart->quantity = $new_quantity;
            if ($new_quantity == 1) {
                $already_cart->amount = $product->display_price;
                $already_cart->tax = $tax_1st * $new_quantity;
                $already_cart->cgst = $cgst_1st * $new_quantity;
                $already_cart->sgst = $sgst_1st * $new_quantity;
            } else {
                $already_cart->amount = $product->display_price;
                $already_cart->amount += $discount_price * ($new_quantity - 1);
                $already_cart->tax = $tax_1st;
                $already_cart->cgst = $cgst_1st;
                $already_cart->sgst = $sgst_1st;
                $already_cart->tax += $tax * ($new_quantity - 1);
                $already_cart->cgst += $cgst * ($new_quantity - 1);
                $already_cart->sgst += $sgst * ($new_quantity - 1);
            }
            $already_cart->orignalAmount = $product->price * $new_quantity;
            $already_cart->discount = $discount_price * $new_quantity;
            $already_cart->save();
            // return $already_cart;
        } else {

            // return $product->display_price;
            if ($product->stock < $request->q || $product->stock <= 0) {
                return response()->json(['status' => 'false', 'message' => 'Stock not sufficient!'], 400);
            }
            $user = User::find($user_id);
            // return $product;
            $cart = new Cart();
            $cart->user_id = $user->id;
            $cart->product_id = $product->id;
            $cart->quantity = $request->q;
            if ($request->q == 1) {
                $cart->amount = $product->display_price;
                $cart->tax = $tax_1st * $request->q;
                $cart->cgst = $cgst_1st * $request->q;
                $cart->sgst = $sgst_1st * $request->q;
            } else {
                $cart->amount = $product->display_price;
                $cart->amount += $discount_price * ($request->q - 1);
                $cart->tax = $tax_1st * $request->q;
                $cart->cgst = $cgst_1st * $request->q;
                $cart->sgst = $sgst_1st * $request->q;
                $cart->tax += $tax * ($request->q - 1);
                $cart->cgst += $cgst * ($request->q - 1);
                $cart->sgst += $sgst * ($request->q - 1);
            }
            $cart->orignalAmount = $product->price * $request->q;
            $cart->price = $product->price;
            $cart->discount = $discount_price * $request->q;
            $cart->save();

            // Wishlist::where('user_id', $user_id)->where('cart_id', null)->update(['cart_id' => $cart->id]);
        }
        if (isset($request->type)) {
            return redirect()->back();
        }

        $total_quantity = Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        return response()->json(['status' => 'true', 'cart' => $total_quantity]);
    }

    public function singleAddToCart(Request $request)
    {
        $request->validate([
            'slug' => 'required',
            'quant' => 'required',
        ]);
        $product = Product::where('slug', $request->slug)->first();
        // return $product;
        if ($product->stock < $request->quant[1]) {
            return back()->with('error', 'Out of stock, You can add other products.');
        }
        if (($request->quant[1] < 1) || empty($product)) {
            session()->flash('error', 'Invalid Products');
            return back();
        }

        $already_cart = Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->where('product_id', $product->id)->first();
        if ($already_cart) {
            $already_cart->quantity += $request->quant[1];
            $already_cart->amount = $product->price * $request->quant[1] + $already_cart->amount;

            if ($already_cart->product->stock < $already_cart->quantity || $already_cart->product->stock <= 0)
                return back()->with('error', 'Stock not sufficient!.');

            $already_cart->save();
        } else {

            $cart = new Cart;
            $cart->user_id = Auth::guard('web')->user()->id;
            $cart->product_id = $product->id;
            $cart->price = $product->price - ($product->price * $product->discount) / 100;
            $cart->quantity = $request->quant[1];
            $cart->amount = $product->price * $request->quant[1];
            if ($cart->product->stock < $cart->quantity || $cart->product->stock <= 0)
                return back()->with('error', 'Stock not sufficient!.');
            // return $cart;
            $cart->save();
        }
        session()->flash('success', 'Product successfully added to cart.');
        return back();
    }

    public function cartDelete(Request $request)
    {
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            session()->flash('success', 'Cart successfully removed');
            return back()->with('success', 'Data saved successfully!');
        }
        session()->flash('error', 'Error please try again');
        return back()->with('key', 'value');
    }

    public function cartRemove(Request $request)
    {
        $cartItem = Cart::find($request->id);
        if ($cartItem) {
            $cartItem->delete();
            $user_id = Auth::guard('web')->user()->id;
            $total_quantity = Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
            return response()->json(['status' => 'true', 'message' => 'Cart item successfully removed!', 'cart' => $total_quantity]);
        }

        return response()->json(['status' => 'false', 'message' => 'Error, please try again.']);
    }

    public function cartUpdate(Request $request)
    {
        // dd($request->all());
        if ($request->quant) {
            $error = [];
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k => $quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if ($quant > 0 && $cart) {
                    // return $quant;

                    if ($cart->product->stock < $quant) {
                        session()->flash('error', 'Out of stock');
                        return back();
                    }
                    $cart->quantity = ($cart->product->stock > $quant) ? $quant : $cart->product->stock;
                    if ($cart->product->stock <= 0)
                        continue;
                    $after_price = $cart->product->price - ($cart->product->price * $cart->product->discount) / 100;
                    $cart->amount = $after_price * $quant;
                    $cart->save();
                    $success = 'Cart successfully updated!';
                } else {
                    $error[] = 'Cart Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        } else {
            return back()->with('Cart Invalid!');
        }
    }

    public function dummy(Request $request)
    {
        dd($request);
    }

    public function checkout(Request $request)
    {


        $shipping = Shopping::where('user_id', Auth::guard('web')->user()->id)->count();
        if ($shipping == 0) {
            return redirect()->route('shipping');
        }
        $couponcode = $request->input('couponcode'); // or $request->tprice;
        $product_cart = Cart::where('user_id', Auth::guard('web')->user()->id)->where('order_id', null)->get();
        $already_cart = Cart::where('user_id', Auth::guard('web')->user()->id)->get()->toArray();
        $product = Product::where('id', $product_cart[0]->product_id)->get();
        $shipping = Shopping::where("user_id", Auth::guard('web')->user()->id)->get()->toArray();
        $charge = Shipping::where("status", 'active')->orderby("id", 'DESC')->limit(1)->get()->toArray();
        $data = $request->all();
        // return $data;
        if (isset($data['presc'])) {
            $presc = $data['presc'];
            $input = time() . "." . $presc->getClientOriginalExtension();
            $destinationPath = 'assets/prescription/';
            $presc->move($destinationPath, $input);
            $data['presc'] = $input;
        }

        $delevery = (float) Settings::pluck('delevery_fee_after')->first();
        $price = $data['tprice'];
        if (isset($data['tprice']) && is_numeric($data['tprice'])) {
            $price = round(floatval($price) * 100);
        } else {
            return redirect()->back()->withErrors(['tprice' => 'Invalid total price']);
        }

        // return $product[0]->presc;
        return view('frontend.pages.checkout')->with('shipping', $shipping)->with('cart', $already_cart)->with('charge', $charge)->with('presc', @$product[0]->presc)->with('data', $data)->with('price', $price)->with('reward', $data['reward'])->with('couponcode', $couponcode);
    }
    public function getCartData()
    {
        $cartItems = Helper::getAllProductFromCart();
        $total = number_format(Helper::totalCartPrice()['payable_amount'], 2);
        return ['cart' => $cartItems, 'total' => $total];
    }
}
