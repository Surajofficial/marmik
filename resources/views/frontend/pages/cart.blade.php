@extends('frontend.layouts.master')
@section('title', 'Cart Page')
@section('main-content')
    <section class="page-wrapper bg-color-light">
        <div class="container pt-3">
            <div class="row">
                <div class="col-lg-12 mt-5 pt-5">
                    <div class="text-center d-flex align-items-center justify-content-between hero">
                        <h4 class=" mb-0">Shopping Cart</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item" aria-current="page">Shopping Cart</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section><!--end page-wrapper-->
    <style>
        .table_price>:not(caption)>*>* {
            padding: 0 !important;
            text-align: left
        }
    </style>

    <style>
        #appliedcoupons {
            max-width: 300px;
            /* Adjust as needed */
            border-radius: 5px;

            margin-top: 10px;
            font-size: 14px;
            color: #495057;
        }

        .applied-coupon {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 5px 0;
            border-bottom: 1px solid #dee2e6;
        }

        .applied-coupon:last-child {
            border-bottom: none;
            /* Remove bottom border for the last coupon */
        }

        .applied-coupon span {
            font-weight: 500;
        }

        .remove-coupon {
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            color: #dc3545;
            /* You can change this color */
            display: flex;
            align-items: center;
        }

        .remove-coupon i {
            font-size: 18px;
            /* Adjust the size as needed */
        }

        .remove-coupon:hover {
            color: #c82333;
            /* Darker shade for hover effect */
        }

        @media(max-width:450px) {
            .cart-box {
                margin: 0 !important;
            }

            .cart-box .hstack {
                display: flex;
                flex-direction: column;
                /* width: 100%; */
                margin: 0px !important;
                padding: 15px 10px;
            }

            .cart-box .hstack a,
            .cart-box .hstack button {
                width: 80%;
            }

            .hero {
                display: flex;
                flex-direction: column;
            }
        }
    </style>


    <div class="modal" id="applycoupon" tabindex="-1" aria-labelledby="applycouponLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="applycouponLabel">Apply Coupons</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">

                    <div id="notification" style="display: none; padding: 10px; margin-bottom: 10px; border-radius: 5px;">
                    </div>

                    <div class="row">
                        @php
                            $cart_product = Helper::getAllProductFromCart();
                        @endphp

                        @foreach ($coupons as $coupon)
                            @php
                                $hasCoupons = false; // Flag to check if the coupon applies to any product in the cart
                            @endphp

                            @foreach ($cart_product as $key => $cart)
                                @php
                                    $variant = $cart['product'];
                                    $product = $variant['product'];
                                    $productid = $product['id'];
                                @endphp

                                @if ($coupon->product_id == $productid || $coupon->product_id == 0)
                                    <div class="col-md-6 mb-3">
                                        <div class="card border shadow-sm">
                                            <div class="card-body">
                                                <h5 class="card-title">{{ $coupon->code }}</h5>
                                                <p class="card-text mb-0">
                                                    @if ($coupon->discount_type == 'percentage')
                                                        Discount: <span
                                                            class="badge bg-success">{{ $coupon->discount_value }}%
                                                            off</span>
                                                    @else
                                                        Discount: <span
                                                            class="badge bg-success">₹{{ $coupon->discount_value }}
                                                            off</span>
                                                    @endif
                                                </p>
                                                <span class="badge bg-danger">Min Order: ₹{{ $coupon->min_order }}</span>
                                                <span class="badge bg-info">Up to: ₹{{ $coupon->max_discount }}</span>
                                                <div>
                                                    <button class="btn btn-primary btn-sm apply-coupon"
                                                        data-code="{{ $coupon->code }}"
                                                        data-min-order="{{ $coupon->min_order }}"
                                                        data-discount-value="{{ $coupon->discount_value }}"
                                                        data-max-discount="{{ $coupon->max_discount }}"
                                                        data-discount-type="{{ $coupon->discount_type }}">
                                                        Apply
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        $hasCoupons = true; // Set the flag to true if a matching product is found
                                        break; // Exit the loop after finding a matching product for this coupon
                                    @endphp
                                @endif
                            @endforeach
                            @if (!$hasCoupons)
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="container">

            <div class="row product-list justify-content-center">

                <div class="col-lg-12">
                    <form action="{{ route('checkout') }}" method="post">
                        @csrf
                        <div class="d-flex align-items-center mb-4">
                            <h5 class="mb-0 flex-grow-1 fw-medium">There are <span
                                    class="fw-bold product-count">{{ Helper::cartCount() }}</span> products in your cart
                            </h5>
                            <div class="flex-shrink-0">
                            </div>
                        </div>
                        @php
                            $cart_product = Helper::getAllProductFromCart();
                        @endphp
                        @if ($cart_product)
                            <div class="card product bg-color-light">
                                @foreach ($cart_product as $key => $cart)
                                    @php
                                        $variant = $cart['product'];
                                        $product = $variant['product'];
                                        $cgst_per = $product['cgst'];
                                        $tax_per = $product['tax'];
                                        $sgst_per = $product['sgst'];
                                        $discount_per = $variant['discount'];
                                        $total = $variant['price'];
                                        if ($variant->display_price != $total) {
                                        }
                                        $discount = number_format($total * ($discount_per / 100), 2);
                                        $discount_price_single = $total - $discount;
                                        $cgst = number_format($discount_price_single * ($cgst_per / 100), 2);
                                        $tax = number_format($discount_price_single * ($tax_per / 100), 2);
                                        $sgst = number_format($discount_price_single * ($sgst_per / 100), 2);
                                        $discount_price = number_format($cart->quantity * ($total - $discount), 2);
                                        $orignal_price = number_format($cart->quantity * $total, 2);
                                        $data[$loop->index]['cgst'] = $cgst;
                                        $data[$loop->index]['sgst'] = $sgst;
                                        $data[$loop->index]['tax'] = $tax;
                                        $data[$loop->index]['discount'] = $discount;
                                        $data[$loop->index]['orignal_price'] = $total;
                                        $data[$loop->index]['discount_price'] = $total - $discount;
                                        $cgst *= $cart->quantity;
                                        $tax *= $cart->quantity;
                                        $sgst *= $cart->quantity;
                                        $discount *= $cart->quantity;
                                    @endphp
                                    <div class="card-body p-4">
                                        <div class="row gy-3">
                                            <div class="col-sm-auto">
                                                <div class="avatar-lg h-100">
                                                    <div class="avatar-title bg-danger-subtle rounded py-3">
                                                        @php
                                                            $photo = explode(',', $product['photo']);
                                                        @endphp
                                                        <img src="{{ $photo[0] ?? '' }}" alt="{{ $photo[0] ?? '' }}"
                                                            class="avatar-md img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <a href="#!">
                                                    <h5 class="fs-16 lh-base mb-1">{{ $product['title'] }}</h5>
                                                </a>
                                                <div class="input-step">
                                                    <button type="button" class="minus_crt" data-id="{{ $loop->index }}"
                                                        data-slug="{{ $product['slug'] }}"
                                                        data-variant="{{ $variant['id'] }}" data-q="{{ $cart->quantity }}"
                                                        data-price="{{ number_format($cart['price'], 2) }}">-</button>
                                                    <input type="number" class="product-quantity"
                                                        value="{{ $cart->quantity }}" id="quantity_input" min="0"
                                                        max="100" readonly>
                                                    <button type="button" class="plus_crt" data-id="{{ $loop->index }}"
                                                        data-price="{{ number_format($cart['price'], 2) }}"
                                                        data-variant="{{ $variant['id'] }}"
                                                        data-slug="{{ $cart->product['slug'] }}">+</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-auto">
                                                <div class="text-lg-end">
                                                    <table class="table table_price table-borderless mb-0 fs-15">
                                                        <tbody>
                                                            <tr>
                                                                <td>CGST({{ $cgst_per }}) :</td>
                                                                <td class="text-end cart-subtotal"
                                                                    id="cgst{{ $loop->index }}">
                                                                    {{ $cgst }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>SGST({{ $sgst_per }}) :</td>
                                                                <td class="text-end cart-subtotal"
                                                                    id="sgst{{ $loop->index }}">
                                                                    {{ $sgst }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Other({{ $tax_per }}) :</td>
                                                                <td class="text-end cart-subtotal"
                                                                    id="tax{{ $loop->index }}">
                                                                    {{ $tax }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Discount({{ $discount_per }}) :</td>
                                                                <td class="text-end cart-subtotal"
                                                                    id="discount{{ $loop->index }}">
                                                                    {{ $discount }}
                                                                </td>
                                                            </tr>
                                                            <tr style="font-weight: bolder">
                                                                <td>Price :</td>
                                                                <td class="text-end cart-subtotal">
                                                                    <del
                                                                        id="orignal_price{{ $loop->index }}">{{ $orignal_price }}</del>
                                                                    /
                                                                    <span
                                                                        id="discount_price{{ $loop->index }}">{{ $discount_price }}</span>

                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @if (!empty($cart))
                                        <div class="card-footer">
                                            <div class="row align-items-center gy-3">
                                                <!-- Left side: Remove button -->
                                                <div class="col-sm d-flex justify-content-start">
                                                    <div>
                                                        <a href="{{ route('cart-delete', $cart->id) }}"
                                                            class="d-block text-body p-1 px-2">
                                                            <i class="ri-delete-bin-fill text-muted align-bottom me-1"></i>
                                                            Remove
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @if (!empty($cart))
                                    {{-- <div class="col-md-12 text-end mt-2">
                                        <button type="button" class="btn btn-dark mb-2" data-bs-toggle="modal"
                                            data-bs-target="#applycoupon">
                                            Apply Coupons
                                        </button>
                                    </div> --}}

                                    <div class="col-lg-4 ms-auto cart-box">
                                        <div class="sticky-side-div">
                                            <div class="card overflow-hidden">
                                                <div class="card-header border-bottom-dashed">
                                                    <h5 class="card-title mb-0 fs-15">Order Summary</h5>
                                                </div>
                                                <div class="card-body pt-4">
                                                    <div class="table-responsive table-card">
                                                        <table class="table table-borderless mb-0 fs-15">
                                                            <tbody>
                                                                <tr>
                                                                    @php
                                                                        // Calculate total cart price
                                                                        $total_amount = Helper::totalCartPrice();
                                                                        // print_r($total_amount);
                                                                        // exit();
                                                                        $total = $total_amount['original_amount'];
                                                                        $payable = $total_amount['payable_amount'];
                                                                        $gst = $total_amount;
                                                                        $sgst = $gst['total_sgst'];
                                                                        $cgst = $gst['total_cgst'];
                                                                        $tax = $gst['total_tax'];

                                                                        // Get active shipping details
                                                                        $shipping = DB::table('shippings')
                                                                            ->where('status', 'active')
                                                                            ->limit(1)
                                                                            ->get();

                                                                        // Get settings
                                                                        $setting = DB::table('settings')->first();

                                                                        // Determine delivery fee
                                                                        // Determine delivery fee

                                                                        if ($payable > $setting->delevery_fee_after) {
                                                                            $amount = 0; // Delivery is free
                                                                            $delevery = 0; // No delivery fee
                                                                        } else {
                                                                            $amount = 80; // Delivery fee
                                                                            $delevery = 80; // Standard delivery fee applies
                                                                        }

                                                                        // Calculate total tax
                                                                        $total_tax =
                                                                            (int) $cgst + (int) $sgst + (int) $tax;

                                                                        // Total amount calculations
                                                                        $total_amount = $payable + $amount;
                                                                        $total_amount1 = ((int) $total * 8) / 100;

                                                                        // Calculate rewards points
                                                                        $rpoint = !empty($rewards['items'])
                                                                            ? 0
                                                                            : (int) @$rewards[0]->point;

                                                                        // Final total calculations
                                                                        $tax = ($total * $total_tax) / 100;
                                                                        $total_amount1 = $tax - $rpoint;
                                                                    @endphp
                                                                    <td>Sub Total :</td>
                                                                    <td class="text-end cart-subtotal" id="total">
                                                                        {{ number_format($total, 2) }}
                                                                    </td>
                                                                </tr>

                                                                @if ($payable != $total)
                                                                    <tr>
                                                                        <td>Payable :</td>
                                                                        <td class="text-end cart-subtotal" id="payable">
                                                                            {{ number_format($payable, 2) }}
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr>
                                                                    <td>Discount Applied:</td>
                                                                    <td class="text-end cart-discount" id="discount">
                                                                        {{ $total - $payable }}
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Shipping Charge :</td>
                                                                    <td class="text-end cart-shipping">
                                                                        @if ($delevery > 0)
                                                                            <span>{{ $amount }} Rs</span>
                                                                        @else
                                                                            <del>{{ $delevery }} Rs</del>
                                                                            <span class="text-success">Free</span>
                                                                        @endif

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Rewards(you have {{ $rpoint }} point) : </td>
                                                                    <td class="text-end cart-tax">{{ $rpoint }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Estimated Tax : </td>
                                                                    <td class="text-end cart-tax" id="tax">
                                                                        {{ $total_tax }}
                                                                    </td>
                                                                </tr>

                                                                {{-- <tr>
                                                                    <td>Coupon Discount</td>
                                                                    <td class="text-end coupon-discount"
                                                                        id="coupondiscount">

                                                                    </td>
                                                                </tr> --}}
                                                                <tr class="table-active">
                                                                    <th>Total (INR) :</th>
                                                                    <td class="text-end" id="total_inr">
                                                                        <span
                                                                            class="fw-semibold cart-total">{{ number_format($total_amount, 2) }}</span>
                                                                    </td>

                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="accordion1 " id="genques-accordion">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <!-- end table-responsive -->
                                                </div>
                                            </div>
                                            <div class="hstack gap-2 justify-content-between justify-content-end m-3 mb-4">
                                                <a href="{{ route('home') }}"
                                                    class="btn btn-outline-dark rounded-pill">Continue
                                                    Shopping</a>
                                                <input type="hidden" name="reward" id="totalInr"
                                                    value="{{ $rpoint }}" />
                                                <input type="hidden" name="couponcode" id="couponcode"
                                                    value="" />
                                                <input type="hidden" class="" id="finalShoppingPrice"
                                                    name="tprice" value="{{ number_format($payable, 2, '.', '') }}" />
                                                <button class="btn btn-dark rounded-pill" type="submit">Continue
                                                    Payment</button>
                                            </div>

                                        </div>
                                        <!-- end sticky -->
                                    </div><!--end col-->
                                @endif
                                <!-- end card footer -->
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    @include('frontend.layouts.newsletter')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('.shipping select[name=shipping]').change(function() {
                let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
                let subtotal = parseFloat($('.order_subtotal').data('price'));
                let coupon = parseFloat($('.coupon_price').data('price')) || 0;
                // alert(coupon);
                $('#order_total_price span').text('$' + (subtotal + cost - coupon).toFixed(2));
            });

        });
        @isset($data)
            localStorage.setItem('data', JSON.stringify(@json($data)));
        @endisset

        function setdata(newQuantity, index, ad_or) {
            var data = JSON.parse(localStorage.getItem('data'));
            // Convert values to float
            var cgst = parseFloat(data[index].cgst.replace(/,/g, ''));
            var sgst = parseFloat(data[index]['sgst'].replace(/,/g, ''));
            var tax = parseFloat(data[index]['tax'].replace(/,/g, ''));
            var discount = parseFloat(data[index]['discount'].replace(/,/g, ''));
            var originalPrice = parseFloat(data[index]['orignal_price']);
            var discountPrice = parseFloat(data[index]['discount_price']);

            var total = parseFloat($('#total').text().replace(/,/g, ''));
            var tax_apply = parseFloat($('#tax').text().replace(/,/g, ''));
            var payable = parseFloat($('#payable').text().replace(/,/g, ''));
            var discount_apply = parseFloat($('#discount').text().replace(/,/g, ''));
            if (ad_or == 'add') {
                $('#total').text((total + originalPrice).toFixed(2))
                // console.log(total)
                $('#tax').text((tax_apply + cgst + sgst + tax).toFixed(2))
                $('#payable').text((payable + discountPrice).toFixed(2))
                $('#discount').text((discount + discount_apply).toFixed(2))
                if (payable) {
                    $('#total_inr').text((payable + discountPrice).toFixed(2))
                } else {
                    $('#total_inr').text((total + originalPrice).toFixed(2))
                }
            } else {
                $('#total').text((total - originalPrice).toFixed(2))
                // console.log(total)
                $('#tax').text((tax_apply - (cgst + sgst + tax)).toFixed(2))
                $('#payable').text((payable - discountPrice).toFixed(2))
                $('#discount').text((discount - discount_apply).toFixed(2))
                if (payable) {
                    $('#total_inr').text((payable - discountPrice).toFixed(2))
                } else {
                    $('#total_inr').text((total - originalPrice).toFixed(2))
                }
            }
            var newQuantity = parseInt(newQuantity);
            var newCgst = cgst * newQuantity;
            var newSgst = sgst * newQuantity;
            var newTax = tax * newQuantity;
            var newDiscount = discount * newQuantity;
            var newOriginalPrice = originalPrice * newQuantity;
            var newDiscountPrice = discountPrice * newQuantity;
            // Update the values in the table
            $('#cgst' + index).text(newCgst.toFixed(2));
            $('#sgst' + index).text(newSgst.toFixed(2));
            $('#tax' + index).text(newTax.toFixed(2));
            $('#discount' + index).text(newDiscount.toFixed(2));
            $('#orignal_price' + index).text(newOriginalPrice.toFixed(2));
            $('#discount_price' + index).text(newDiscountPrice.toFixed(2));
        }
        // console.log(data);
        $(document).on('click', '.plus_crt', function(e) {
            e.preventDefault();
            var button = $(this);
            slug = button.data('slug')
            variant = button.data('variant')
            var price = button.data('price').toString()
            price = price.replace(/,/g, ''); // Remove commas
            currentTotal = $('#total').text().toString();
            currentTotal = currentTotal.replace(/,/g, ''); // Remove commas
            currentTotal = parseFloat(currentTotal);
            price = parseFloat(price);
            quantity = 1
            q = $('#quantity_input').val();
            var index = $(this).data('id');
            $.ajax({
                url: `{{ route('add.to.cart') }}`,
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}', // Add CSRF token for security
                    'slug': slug,
                    'q': quantity,
                    'variant': variant
                },
                success: function(response) {
                    // Handle the response here
                    if (response.status == 'true') {
                        // Find the sibling input field
                        var input = button.siblings('.product-quantity');
                        // Get the current value
                        var currentValue = parseInt(input.val());
                        var newValue = currentValue + 1;
                        currentTotal = currentTotal + price;
                        currentTotal = currentTotal.toFixed(2)
                        // console.log(currentTotal)
                        // setdata(parseInt(response.cart), index, 'add');
                        // $('#total').text(currentTotal);

                        input.val(newValue);
                        window.location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle the error here
                    // alert('An error occurred: ' + error);
                }
            });
        })
        $(document).on('click', '.minus_crt', function(e) {
            e.preventDefault();

            var button = $(this);
            // Find the sibling input field
            var input = button.siblings('.product-quantity');
            // Get the current value
            var currentValue = parseInt(input.val());

            if (currentValue != 1) {
                q = $('#quantity_input').val();

                slug = button.data('slug')
                variant = button.data('variant')
                var price = button.data('price').toString()
                price = price.replace(/,/g, ''); // Remove commas
                currentTotal = $('#total').text().toString();
                currentTotal = currentTotal.replace(/,/g, ''); // Remove commas
                currentTotal = parseFloat(currentTotal);
                price = parseFloat(price);
                var index = $(this).data('id');
                quantity = -1
                $.ajax({
                    url: `{{ route('add.to.cart') }}`,
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}', // Add CSRF token for security
                        'slug': slug,
                        'q': quantity,
                        'variant': variant
                    },
                    success: function(response) {
                        // Handle the response here
                        if (response.status == 'true') {
                            // setdata(parseInt(response.cart), index, 'minus');
                            var newValue = currentValue - 1;
                            currentTotal = currentTotal - price;
                            currentTotal = currentTotal.toFixed(2)
                            $('#total').text(currentTotal);
                            input.val(newValue);
                            window.location.reload();
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle the error here
                        // alert('An error occurred: ' + error);
                    }
                });
            }
        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let appliedCoupons = {}; // Store applied coupons
            let currentDiscount = 0; // Store current applied discount
            let originalAmount = parseFloat(document.querySelector('.cart-total').textContent.replace(/,/g, '')
                .trim()) || 0;
            // console.log(originalAmount);
            document.getElementById("finalShoppingPrice").value = originalAmount;
            let currentButton = null; // Track the currently disabled button
            document.querySelectorAll('.apply-coupon').forEach(button => {
                button.addEventListener('click', function() {
                    const couponCode = this.getAttribute('data-code');
                    const minOrder = parseFloat(this.getAttribute('data-min-order')) || 0;
                    const discountValue = parseFloat(this.getAttribute('data-discount-value')) || 0;
                    const discountType = this.getAttribute('data-discount-type');
                    const maxDiscount = parseFloat(this.getAttribute('data-max-discount')) || 0;
                    const notification = document.getElementById('notification');
                    const appliedCouponsContainer = document.getElementById('appliedcoupons');
                    const coupondiscount = document.getElementById('coupondiscount');
                    const couponcode = document.getElementById('couponcode');

                    // Restore the original amount before applying any discounts
                    let totalAmount = originalAmount;

                    // Check if the coupon has already been applied
                    if (appliedCoupons[couponCode]) {
                        notification.style.display = 'block';
                        notification.textContent = `Coupon "${couponCode}" is already applied.`;
                        notification.style.backgroundColor = '#f8d7da';
                        notification.style.color = '#721c24';
                        notification.style.borderColor = '#f5c6cb';
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 5000);
                        return;
                    }

                    // Check for minimum order
                    if (totalAmount < minOrder) {
                        notification.style.display = 'block';
                        notification.textContent = `Minimum order required: ₹${minOrder}`;
                        notification.style.backgroundColor = '#f8d7da';
                        notification.style.color = '#721c24';
                        notification.style.borderColor = '#f5c6cb';
                        setTimeout(() => {
                            notification.style.display = 'none';
                        }, 5000);
                        return;
                    }

                    // Calculate new discount
                    let discountApplied = discountValue;
                    if (discountType === 'percentage') {
                        discountApplied = totalAmount * (discountValue / 100);
                    }

                    // Apply max discount limit
                    if (discountApplied > maxDiscount) {
                        discountApplied = maxDiscount;
                    }

                    // Calculate the new total amount after applying discount
                    totalAmount -= discountApplied;
                    totalAmount = totalAmount < 0 ? 0 : totalAmount;

                    // Update the display with the new total amount
                    document.querySelector('.cart-total').textContent = totalAmount.toFixed(2)
                        .replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                    // Update the hidden input field with the new total amount
                    document.getElementById("finalShoppingPrice").value = totalAmount.toFixed(2);
                    document.getElementById("couponcode").value = couponCode;

                    // Update the current discount and applied coupons
                    currentDiscount = discountApplied;
                    appliedCoupons = {}; // Reset applied coupons to allow only one at a time
                    appliedCoupons[couponCode] = true; // Mark this coupon as applied

                    // Show success message
                    notification.style.display = 'block';
                    notification.textContent =
                        `Coupon applied successfully: ${couponCode} - ₹${discountApplied.toFixed(2)} applied`;
                    notification.style.backgroundColor = '#d4edda';
                    notification.style.color = '#155724';
                    notification.style.borderColor = '#c3e6cb';

                    setTimeout(() => {
                        notification.style.display = 'none';
                    }, 5000);

                    // Display the applied coupon details
                    appliedCouponsContainer.innerHTML = `<div class="applied-coupon">
                    <span><strong>${couponCode}</strong> - Discount: ₹${discountApplied.toFixed(2)}</span>
                    <button class="remove-coupon" data-code="${couponCode}">
                        <i class="ph-x-circle fs-24"></i>
                    </button>
                </div>`;

                    coupondiscount.innerHTML = `-₹${discountApplied.toFixed(2)}`;


                    // Disable the current button and enable the previous one, if any
                    if (currentButton) {
                        currentButton.disabled = false;
                    }
                    this.disabled = true;
                    currentButton = this; // Set the current button as the one clicked

                    // Add event listener for the remove coupon button
                    document.querySelector('.remove-coupon').addEventListener('click', function() {
                        document.getElementById("couponcode").value = '';
                        // Reset total amount to the original amount before applying discount
                        totalAmount = originalAmount;
                        document.querySelector('.cart-total').textContent = originalAmount
                            .toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ',');
                        document.getElementById("finalShoppingPrice").value = originalAmount
                            .toFixed(2);

                        // Clear applied coupon details
                        appliedCouponsContainer.innerHTML = '';
                        coupondiscount.innerHTML = '';
                        appliedCoupons = {}; // Reset applied coupons
                        currentDiscount = 0; // Reset current discount

                        // Enable the apply button
                        currentButton.disabled = false;
                        currentButton = null;
                    });
                });
            });
        });
    </script>

    <style>
        #brandecommercecard {
            display: none
        }
    </style>
@endsection
