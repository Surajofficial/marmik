<?php

use App\Http\Controllers\FrontendController;
use App\Models\Message;
use App\Models\Category;
use App\Models\Brand;
use App\Models\PostTag;
use App\Models\PostCategory;
use App\Models\Order;
use App\Models\Wishlist;
use App\Models\Shipping;
use App\Models\Cart;
use App\Models\ProductType;
use App\Models\Concern;
use App\Models\OrderNotification;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
// use Auth;
class Helper extends Model
{
    public static function groupArray(array $array, int $numberOfGroups)
    {
        $result = [];
        $groupSize = (int) ceil(count($array) / $numberOfGroups);

        for ($i = 0; $i < $numberOfGroups; $i++) {
            $result[] = array_slice($array, $i * $groupSize, $groupSize);
        }

        return $result;
    }

    public static function messageList()
    {
        return Message::whereNull('read_at')->orderBy('created_at', 'desc')->get();
    }
    public static function getAllCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        return $menu;
    }


    public static function getHeaderCategory()
    {
        $category = new Category();
        $menu = $category->getAllParentWithChild();
        $columns = 2; // Number of columns you want
        $count = ceil(count($menu) / $columns); // Calculate items per column
        $menu_nav = '';

        if ($menu) {
            for ($i = 0; $i < $columns; $i++) {
                $menu_nav .= '<div class="dropdowns-group11 col-lg-3 col-12">';

                for ($j = $i * $count; $j < ($i + 1) * $count && $j < count($menu); $j++) {
                    $cat_info = $menu[$j];
                    $menu_nav .= '<div class="dropdowns-block align-items-center">';
                    $menu_nav .= '<span class="dropdowns-icon "><i class="bx bx-bookmark"></i></span>';
                    // $menu_nav .= '<ul>';
                    $menu_nav .= '<a href="' . route('product-cat', $menu[$i * $count]->slug) . '" class="text-md-base font-medium">' . $menu[$i * $count]->title . '</a>';
                    // $menu_nav .= '<li class="dropdowns-item-li move-right-hover">';
                    // $menu_nav .= '<i class="bx bx-chevron-right"></i>';
                    // $menu_nav .= '<a href="' . route('product-cat', $cat_info->slug) . '">' . $cat_info->title . '</a>';
                    $menu_nav .= '</div>';
                    if ($cat_info->child_cat->count() > 0) {
                        $menu_nav .= '<ul class="">';
                        foreach ($cat_info->child_cat as $sub_menu) {
                            $menu_nav .= '<li class="dropdowns-item-li move-right-hover">';
                            $menu_nav .= '<i class="bx bx-chevron-right"></i>';
                            $menu_nav .= '<a href="' . route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) . '">' . $sub_menu->title . '</a>';
                            // $menu_nav .= '<a href="' . route('product-sub-cat', [$cat_info->slug, $sub_menu->slug]) . '" class="menus-link">' . $sub_menu->title . '</a>';
                            $menu_nav .= '</li>';
                        }
                        $menu_nav .= '</ul>';
                    }

                    // $menu_nav .= '</li>';
                    // $menu_nav .= '</ul>';
                    // $menu_nav .= '</div>';
                }

                $menu_nav .= '</div>';
            }
        }

        return $menu_nav;
    }




    public static function getHeaderConcern()
    {
        $concern = new Concern();
        $menu = $concern->getAllParentWithChild();
        $columns = 3; // Number of columns you want
        $count = ceil(count($menu) / $columns); // Calculate items per column
        $menu_nav = '';

        if ($menu) {
            for ($i = 0; $i < $columns; $i++) {
                $menu_nav .= '<div class="col-lg-3 col-12">';
                // $menu_nav .= '<div class="dropdowns-block">';
                // $menu_nav .= '<span class="dropdowns-icon"><i class="bx bx-bookmark"></i></span>';
                $menu_nav .= '<div class="dropdowns-inner">';

                if (isset($menu[$i * $count])) {
                    // $menu_nav .= '<a href="' . route('product-concern', $menu[$i * $count]->slug) . '" class="text-md-base font-medium ">' . $menu[$i * $count]->title . '</a>';
                    $menu_nav .= '<ul class="p-0 mt-2">';

                    for ($j = $i * $count; $j < ($i + 1) * $count && $j < count($menu); $j++) {
                        $cat_info = $menu[$j];

                        if ($cat_info->child_cat->count() > 0) {
                            foreach ($cat_info->child_cat as $sub_menu) {
                                $menu_nav .= '<li class="dropdowns-item-li move-right-hover">';
                                $menu_nav .= '<i class="bx bx-chevron-right"></i>';
                                $menu_nav .= '<a href="' . route('product-sub-concern', [$cat_info->slug, $sub_menu->slug]) . '">' . $sub_menu->title . '</a>';
                                $menu_nav .= '</li>';
                            }
                        } else {
                            $menu_nav .= '<li class="dropdowns-item-li move-right-hover">';
                            $menu_nav .= '<i class="bx bx-chevron-right"></i>';
                            $menu_nav .= '<a href="' . route('product-concern', $cat_info->slug) . '">' . $cat_info->title . '</a>';
                            $menu_nav .= '</li>';
                        }
                    }

                    $menu_nav .= '</ul>';
                }

                // $menu_nav .= '</div>';
                $menu_nav .= '</div>';
                $menu_nav .= '</div>';
            }
        }

        return $menu_nav;
    }

    public static function getHeaderConcern1()
    {

        $menu = Concern::orderBy('id', 'DESC')->get();
        //    $menu=$brand->getAll();
        if ($menu) {
            ?>


            <?php
            foreach ($menu as $cat_info) {

                if ($cat_info->child_cat->count() > 0) {
                    ?>
                    <li class="nav-item"><a href="<?php echo route('product-concern', $cat_info->slug); ?>" class="nav-link"
                            data-key="t-clothing"><?php echo $cat_info->title; ?></a> </li>

                    <?php
                } else {
                    ?>
                    <li class="nav-item"> <a href="<?php echo route('product-concern', $cat_info->slug); ?>" class="nav-link"
                            data-key="t-clothing"><?php echo $cat_info->title; ?></a> </li>
                    <?php
                }
            }
            ?>


            <?php
        }
    }
    public static function getHeaderBrand()
    {
        // $brand = new Brand();
        // print_r($brand);
        // exit();
        $menu = Brand::orderBy('id', 'ASC')->limit(5)->get();
        $menu1 = Brand::orderBy('id', 'ASC')->limit(5)->get();
        //    $menu=$brand->getAll();
        if ($menu) {
            ?>


            <?php
            foreach ($menu as $cat_info) {
                if ($cat_info->count() > 0) {
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo route('product-brand', $cat_info->slug); ?>" class="nav-link"
                            data-key="t-clothing"><?php echo $cat_info->title; ?></a>

                    </li>
                    <?php
                } else {
                    ?>
                    <li class="nav-item">
                        <a href="<?php echo route('product-cat', $cat_info->slug); ?>" class="nav-link"
                            data-key="t-clothing"><?php echo $cat_info->title; ?></a>
                    </li>
                    <?php
                }
            }
            ?>


            <?php
        }
    }




    public static function getHeaderProductType()
    {
        $menu = ProductType::orderBy('id', 'ASC')->get();
        $columns = 3; // Number of columns you want
        $count = ceil(count($menu) / $columns); // Calculate items per column
        $menu_nav = '';

        if ($menu) {
            for ($i = 0; $i < $columns; $i++) {
                $menu_nav .= '<div class="dropdowns-group1 col-lg-3 col-12">';
                $menu_nav .= '<ul>';
                for ($j = $i * $count; $j < ($i + 1) * $count && $j < count($menu); $j++) {
                    $cat_info = $menu[$j];
                    $menu_nav .= '<li class="dropdowns-item-li move-right-hover">';
                    $menu_nav .= '<i class="bx bx-chevron-right"></i>';
                    $menu_nav .= '<a href="' . route('product-type', $cat_info->slug) . '">' . $cat_info->title . '</a>';
                    $menu_nav .= '</li>';
                }
                $menu_nav .= '</ul>';
                $menu_nav .= '</div>';
            }
        }

        return $menu_nav;
    }

    public static function productCategoryList($option = 'all')
    {
        if ($option = 'all') {
            return Category::orderBy('id', 'DESC')->get();
        }
        return Category::has('products')->orderBy('id', 'DESC')->get();
    }

    public static function postTagList($option = 'all')
    {
        if ($option = 'all') {
            return PostTag::orderBy('id', 'desc')->get();
        }
        return PostTag::has('posts')->orderBy('id', 'desc')->get();
    }

    public static function postCategoryList($option = "all")
    {
        if ($option = 'all') {
            return PostCategory::orderBy('id', 'DESC')->get();
        }
        return PostCategory::has('posts')->orderBy('id', 'DESC')->get();
    }
    // Cart Count
    public static function cartCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            return Cart::where('user_id', $user_id)->where('order_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    // relationship cart with product
    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
    public static function getAllProductFromCart($user_id = '')
    {
        if (Auth::check()) {

            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            $cart = Cart::with(['product', 'product.product'])->where('user_id', $user_id)->where('order_id', null)->get();
            foreach ($cart as $item) {
                $item->product->display_price = FrontendController::getprice($item->product);
            }
            return $cart;
        } else {
            return 0;
        }
    }


    // Total amount cart
    public static function totalCartPrice($user_id = '')
    {
        if (Auth::check()) {
            if (empty($user_id)) {
                $user_id = Auth::guard('web')->user()->id;
            }

            $cartSums = Cart::where('user_id', $user_id)->where('order_id', null)
                ->selectRaw('SUM(orignalAmount) as original_amount, SUM(amount) as payable_amount, SUM(cgst) as total_cgst, SUM(sgst) as total_sgst, SUM(discount) as total_discount, SUM(tax) as total_tax')
                ->first();
            return [
                'payable_amount' => $cartSums->payable_amount,
                'original_amount' => $cartSums->original_amount,
                'total_cgst' => $cartSums->total_cgst,
                'total_sgst' => $cartSums->total_sgst,
                'total_discount' => $cartSums->total_discount,
                'total_tax' => $cartSums->total_tax,
            ];
        } else {
            return 0;
        }
    }


    public static function totalCgstPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            $cart = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
            return Product::where('id', @$cart[0]->product['id'])->sum('cgst');
        } else {
            return 0;
        }
    }
    public static function totalSgstPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            $cart = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
            return Product::where('id', @$cart[0]->product['id'])->sum('sgst');
        } else {
            return 0;
        }
    }
    public static function totalTaxPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            $cart = Cart::with('product')->where('user_id', $user_id)->where('order_id', null)->get();
            $sgst = Product::where('id', @$cart[0]->product['id'])->sum('sgst');
            $cgst = Product::where('id', @$cart[0]->product['id'])->sum('cgst');
            $tax = Product::where('id', @$cart[0]->product['id'])->sum('tax');
            return ['tax' => $tax, 'cgst' => $cgst, 'sgst' => $sgst];
        } else {
            return 0;
        }
    }
    // Wishlist Count
    public static function wishlistCount($user_id = '')
    {

        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('quantity');
        } else {
            return 0;
        }
    }
    // public static function getAllProductFromWishlist($user_id = '')
    // {
    //     if (Auth::check()) {
    //         if ($user_id == "")
    //             $user_id = Auth::guard('web')->user()->id;
    //         return Wishlist::with('product')->where('user_id', $user_id)->get();
    //     } else {
    //         return 0;
    //     }
    // }

    public static function getWishlistWithProducts($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "") {
                $user_id = Auth::guard('web')->user()->id;
            }

            // Fetch the wishlist with product details including image and stock
            return Wishlist::with([
                'product' => function ($query) {
                    $query->select('id', 'title', 'photo'); // Removed 'price' and 'stock'
                },
                'variant' => function ($query) {
                    $query->select('product_id', 'price', 'stock'); // Fetching price and stock from the variants table
                }
            ])
                ->where('user_id', $user_id)
                ->get();
        } else {
            return 0;
        }
    }
    public static function totalWishlistPrice($user_id = '')
    {
        if (Auth::check()) {
            if ($user_id == "")
                $user_id = Auth::guard('web')->user()->id;
            return Wishlist::where('user_id', $user_id)->where('cart_id', null)->sum('amount');
        } else {
            return 0;
        }
    }

    // Total price with shipping and coupon
    public static function grandPrice($id, $user_id)
    {
        $order = Order::find($id);
        //       dd($id);
        if ($order) {
            $shipping_price = (float) $order->shipping->price;
            $order_price = self::orderPric($id, $user_id);
            return number_format((float) ($order_price + $shipping_price), 2, '.', '');
        } else {
            return 0;
        }
    }


    // Admin home
    public static function earningPerMonth()
    {
        $month_data = Order::where('status', 'delivered')->get();
        // return $month_data;
        $price = 0;
        foreach ($month_data as $data) {
            $price = $data->cart_info->sum('price');
        }
        return number_format((float) ($price), 2, '.', '');
    }

    public static function shipping()
    {
        return Shipping::orderBy('id', 'DESC')->get();
    }


    public static function inwords($number, $true = true)
    {
        $no = floor($number);
        $point = number_format(number_format($number, 2, '.', '') - $no, 2, '', '');
        $digitpoint = strlen($point);
        $digit = strlen($no);
        //Ones, Tens, Hundreds
        $ones = array(0 => 'Zero', '1' => 'One', '2' => 'Two', '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six', '7' => 'Seven', '8' => 'Eight', '9' => 'Nine', '10' => 'Ten');
        $tens = array('11' => 'Eleven', '12' => 'Twelve', '13' => 'Thirteen', '14' => 'Fourteen', '15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen', '18' => 'Eighteen', '19' => 'Nineteen', '20' => 'Twenty', '30' => 'Thirty', 40 => 'Forty', '50' => 'Fifty', '60' => 'Sixty', '70' => 'Seventy', '80' => 'Eighty', '90' => 'Ninety');
        $hundred = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
        $string_word = array();
        $numbers = array_reverse(str_split($no, 1));
        //print_r($numbers);
        $i = 0;
        while ($i < $digit) {
            if ($i == 0) {
                if (!isset($numbers[2]) && !isset($numbers[1])) {
                    $string_word[] = $ones[$numbers[0]];
                }
            }
            if ($i == 1) {
                $temp = intval($numbers[1] . "" . $numbers[0]);
                $ten = intval($numbers[1] . "0");
                if ($ten == 0 && $temp == 0) {
                } else if ($temp <= 10) {
                    $string_word[] = $ones[$temp];
                } else if ($temp > 11 && $temp <= 20) {
                    $string_word[] = $tens[$temp];
                } else if (isset($tens[$temp])) {
                    $string_word[] = $tens[$temp];
                } else {
                    $string_word[] = $tens[$ten] . " " . $ones[$numbers[0]];
                }
            }
            if ($i == 2) {
                if (!isset($numbers[3]) && $numbers[2] != 0) {
                    $string_word[] = $ones[$numbers[2]] . " " . $hundred[1];
                }
                if (isset($numbers[3]) && $numbers[2] != 0) {
                    $string_word[] = $ones[$numbers[2]] . " " . $hundred[1];
                }
            }
            if ($i == 3 || $i == 4) {
                if (isset($numbers[4])) {
                    $temp = intval($numbers[4] . "" . $numbers[3]);
                    $ten = intval($numbers[4] . "0");
                    echo $temp . "--" . $ten;
                    if ($temp == 0 && $ten == 0) {
                    } else if ($temp == 10) {
                        $string_word[] = $ones[$temp] . " " . $hundred[2];
                    } elseif ($temp > 10 && $temp <= 20) {
                        $string_word[] = $tens[$temp] . " " . $hundred[2];
                    } else {
                        $num = ($numbers[3] == 0) ? '' : $ones[$numbers[3]];
                        $string_word[] = $tens[$ten] . " " . $num . " " . $hundred[2];
                    }
                } else {
                    $string_word[] = $ones[$numbers[3]] . " " . $hundred[2];
                }
                $i++;
            }
            if ($i == 5 || $i == 6) {
                if (isset($numbers[6])) {
                    $temp = intval($numbers[6] . "" . $numbers[5]);
                    $ten = intval($numbers[6] . "0");
                    if ($numbers[5] == 0 && $numbers[6] == 0) {
                    } elseif ($temp == 10) {
                        $string_word[] = $ones[$temp] . " " . $hundred[5];
                    } elseif ($temp > 10 && $temp <= 20) {
                        $string_word[] = $tens[$temp] . " " . $hundred[5];
                    } else {
                        $num = ($numbers[5] == 0) ? '' : $ones[$numbers[5]];
                        $tens_1 = (!isset($tens[$ten])) ? '' : $tens[$ten];
                        $string_word[] = $tens_1 . " " . $num . " " . $hundred[3];
                    }
                } else {
                    $string_word[] = $ones[$numbers[5]] . " " . $hundred[3];
                }
                $i++;
            }
            if ($i == 7 || $i == 8) {
                if (isset($numbers[8])) {
                    $temp = intval($numbers[8] . "" . $numbers[7]);
                    $ten = intval($numbers[8] . "0");
                    if ($numbers[7] == 0 && $numbers[8] == 0) {
                        continue;
                    } else if ($temp == 10) {
                        $string_word[] = $ones[$temp] . " " . $hundred[4];
                    } elseif ($temp > 10 && $temp <= 20) {
                        $string_word[] = $tens[$temp] . " " . $hundred[4];
                    } else {
                        $num = ($numbers[7] == 0) ? '' : $ones[$numbers[7]];
                        $string_word[] = $tens[$ten] . " " . $num . " " . $hundred[4];
                    }
                } else {
                    $string_word[] = $ones[$numbers[7]] . " " . $hundred[4];
                }
                $i++;
            }
            if ($i == 9) {
                $string_word[] = $ones[$numbers[9]] . " " . $hundred[1];
            }
            $i++;
            //$string_word[] = $i;
        }
        $str = array_reverse($string_word);
        return implode(' ', $str);
    }

    public static function showForm()
    {
        return [
            "5" => "30 ml",
            "6" => "100ml/3.38oz",
            "7" => "200ml/ 6.76 fl oz",
            "8" => "100ml/ 3.38 fl oz",
            "9" => "200ml",
            "10" => "60ml (2.02 fl oz)",
            "11" => "60g/ 2.02 fl. oz",
            "12" => "80g/2.82 fl 0z",
            "13" => "150 ml",
            "14" => "10 tablets",
            "15" => "20 gm",
            "16" => "30gm",
            "17" => "15 gm",
            "18" => "50 ml",
            "19" => "15 ml",
            "20" => "10 gm",
            "21" => "75 gm",
            "22" => "15 TABLETS",
            "23" => "1 Tablet",
            "24" => "OINTMENT",
            "25" => "OINTMENT",
            "26" => "OINTMENT",
            "27" => "OINTMENT",
            "28" => "4 CAPSULE"
        ];
    }

    public static function getOrderNotifications()
    {
        $orderNotificationsCount = OrderNotification::whereNull('read_at')->count();
        $order_read = OrderNotification::whereNull('read_at')->orderBy('created_at', 'desc')->take(5)->get();
        $order_notify = OrderNotification::orderBy('created_at', 'desc')->get();

        return [
            'count' => $orderNotificationsCount,
            'notifications' => $order_notify,
            'ord-N-Read' => $order_read
        ];
    }
}

?>