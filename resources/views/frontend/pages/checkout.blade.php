@extends('frontend.layouts.master')

@section('title', 'Marmik || Checkout Page')

@section('main-content')
    @php
        $shouldRedirect = false;
        if (count($shipping) > 0) {
            $address = request()->get('shippingAddress') ?? $shipping[0]['id'];
        } else {
            $shouldRedirect = true;
        }
    @endphp
    @if ($shouldRedirect)
        <script type="text/javascript">
            window.location.href = '{{ url('/shipping') }}';
        </script>
    @endif
    <section class="section mt-4">
        <h2 class="text-center my-4">Checkout</h2>
        <div class="container">
            <div class="row mb-0 pb-0">
                <div class="col-12 col-sm-4 pb-0 mb-0 mt-3">
                    <form action="{{ route('coupon-store') }}" class="pb-0 mb-0" method="POST">
                        @csrf
                        <input class="form-control rounded-pill" name="code" type="text" placeholder="Enter gst number"
                            aria-label="Add Gst Number here...">
                    </form>
                </div>
                <div class="col-12 col-sm-8 pb-0 mb-0 mt-3">
                    <form action="{{ route('coupon-store') }}" class="pb-0 mb-0" method="POST">
                        @csrf
                        <div class="hstack gap-3 px-3 pb-0 mb-0">
                            <input class="form-control rounded-pill" name="code" type="text"
                                placeholder="Enter coupon code" aria-label="Add Promo Code here...">
                            <button type="submit" class="btn btn-dark rounded-pill">Apply</button>
                        </div>
                        <br />
                        @if (Session::has('success'))
                            <p class="alert alert-success"> {{ Session::get('success') }}</p>
                        @endif
                        @if (Session::has('error'))
                            <p class="alert alert-success"> {{ Session::get('error') }}</p>
                        @endif
                    </form>

                </div>
            </div>
            <hr />
            <form class="form" id="order" method="POST" action="{{ route('cart.order') }}"
                enctype="multipart/form-data">
                @csrf
                @if ($presc == 1)
                    <div class="row">
                        <div class="col-12 row mb-2">
                            <div class="hstack col-sm-6">
                                <input class="form-control" name="presc" id="presc" type="file"
                                    placeholder="Enter gst number" aria-label="upload prescription pdf" required>
                            </div>
                            <div class="col-sm-6 mt-2 mt-sm-0">
                                <a href='tel:917408216946' class="btn btn-success text-white ">
                                    Get Free Consultation call On 7408216946
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="flex-shrink-0">
                    <a href="{{ route('shipping') }}?reward={{ $reward }}&tprice={{ $price }}"
                        class="btn btn-dark rounded-pill text-white ">
                        Add Address
                    </a>
                </div>
                <div class="col-12 row">
                    <div class="col-md-6 col-sm-6">
                        <div class="pt-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0">Shipping Address</h5>
                                </div>
                            </div>
                            <div class="row gy-3">

                                @foreach ($shipping as $key => $value)
                                    <div class="col-12">
                                        <div class="form-check card-radio">
                                            <input id="shippingAddress0{{ $value['id'] }}" value="{{ $value['id'] }}"
                                                name="shipping_id" type="radio" class="form-check-input"
                                                {{ old('shippingAddress', $address) == $value['id'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="shippingAddress0{{ $value['id'] }}">
                                                <span class="mb-3 text-uppercase fw-semibold d-block">{{ $value['atype'] }}
                                                    Address</span>
                                                <span
                                                    class="fs-14 mb-2 d-block fw-semibold">{{ $value['first_name'] }}</span>
                                                <span
                                                    class="text-muted fw-normal text-wrap mb-1 d-block">{{ $value['address1'] }}1</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['phone'] }}</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['email'] }}</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['country'] }}</span>
                                            </label>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="pt-2">
                            <div class="d-flex align-items-center mb-4">
                                <div class="flex-grow-1">
                                    <h5 class="mb-0">Billing Address</h5>
                                </div>
                            </div>
                            <div class="row gy-3">
                                @foreach ($shipping as $key => $value)
                                    <div class="col-12">
                                        <div class="form-check card-radio">
                                            <input id="billingAddress0{{ $value['id'] }}" value="{{ $value['id'] }}"
                                                name="billing_id" type="radio" class="form-check-input"
                                                {{ old('shippingAddress', $address) == $value['id'] ? 'checked' : '' }}>
                                            <label class="form-check-label" for="billingAddress0{{ $value['id'] }}">
                                                <span class="mb-3 text-uppercase fw-semibold d-block">{{ $value['atype'] }}
                                                    Address</span>
                                                <span
                                                    class="fs-14 mb-2 d-block fw-semibold">{{ $value['first_name'] }}</span>
                                                <span
                                                    class="text-muted fw-normal text-wrap mb-1 d-block">{{ $value['address1'] }}1</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['phone'] }}</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['email'] }}</span>
                                                <span class="text-muted fw-normal d-block">{{ $value['country'] }}</span>
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tprice" value="{{ $price / 100 }}" />
                <input type="hidden" name="tprice" value="{{ $price / 100 }}" />
                <input type="hidden" name="couponcode" value="{{ $couponcode }}" />
                <input type="hidden" name="rozorpay_id" id="rozerpay_id" value="{{ $reward }}" />

                @if (isset($data['presc']))
                    <input type="hidden" name="priscription" value="{{ $data['presc'] }}" />
                @endif
                <input type="hidden" name="payment_method" value="online" />
                <button type="submit" class="razorpay-payment-button btn btn-success rounded-pill">Pay Amount ₹
                    {{ number_format($price / 100, 2) }}</button>
            </form>
        </div><!--end container-->
    </section>
    <style>
        .razorpay-payment-button {
            margin-top: 20px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    @php
        $settings = DB::table('settings')->get();
    @endphp
    @foreach ($settings as $data)
        @php
            $logo = $data->logo;
        @endphp
    @endforeach
    <script>
        function payNow() {

            fetch('/create-order', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Laravel CSRF Token
                    },
                    body: JSON.stringify({
                        price: {{ $price }},
                    })
                })
                .then(response => response.json())
                .then(data => {

                    var options = {
                        "key": "{{ env('ROZERPAY_ID') }}", // Your Razorpay Key ID
                        "amount": data.amount, // Amount in paise
                        "currency": data.currency,
                        "name": "Dr Awish",
                        "description": "Payment",
                        "image": "{{ $logo }}",
                        "order_id": data.order_id, // The Razorpay Order ID
                        "handler": function(response) {
                            fetch('/verify-payment', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // For Laravel
                                    },
                                    body: JSON.stringify({
                                        razorpay_order_id: response.razorpay_order_id,
                                        razorpay_payment_id: response.razorpay_payment_id,
                                        razorpay_signature: response.razorpay_signature
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        $('#rozerpay_id').val(response.razorpay_payment_id);
                                        $('#order').off('submit').submit();

                                    } else {
                                        // Payment failed
                                        alert("Payment verification failed!");
                                    }
                                });
                        },
                        "prefill": {
                            "name": "{{ auth()->user()->name }}",
                            "email": "{{ auth()->user()->email }}",
                            "contact": "{{ auth()->user()->mobile }}"
                        },
                        "theme": {
                            "color": "#F37254"
                        }
                    };

                    // Open the Razorpay payment gateway
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
                });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#order').submit(function(e) {
                e.preventDefault();
                payNow()
            });
        });
    </script>
    @include('frontend.layouts.newsletter')
@endsection
