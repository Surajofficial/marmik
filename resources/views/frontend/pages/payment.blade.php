@extends('frontend.layouts.master')

@section('title', 'Marmik || Order Track Page')

@section('main-content')
    <section class="page-wrapper bg-primary1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Payment</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Payment</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <section class="section pb-4">
        <div class="container">

            <div class="row product-list">
                <div class="col-xl-12">
                    <h5 class="mb-0 flex-grow-1">Payment Selection</h5>

                    <ul class="nav nav-pills arrow-navtabs nav-success bg-light mb-3 mt-4 nav-justified custom-nav"
                        role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active py-3" data-bs-toggle="tab" href="#paypal" role="tab">
                                <span class="d-block d-sm-none"><i class="ri-paypal-fill align-bottom"></i></span>
                                <span class="d-none d-sm-block"><i class="ri-paypal-fill align-bottom pe-2"></i>
                                    Online</span>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link py-3" data-bs-toggle="tab" href="#cash" role="tab">
                                <span class="d-block d-sm-none"><i class="ri-money-dollar-box-fill align-bottom"></i></span>
                                <span class="d-none d-sm-block"> <i class="ri-money-dollar-box-fill align-bottom pe-2"></i>
                                    Cash on Delivery</span>
                            </a>
                        </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content text-muted">
                        <div class="tab-pane active" id="paypal" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center py-3">
                                        <div class="avatar-md mx-auto mb-4">
                                            <div
                                                class="avatar-title bg-primary-subtle text-primary rounded-circle display-6">
                                                <i class="bi bi-cash"></i>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-3">Online Pay</h5>
                                        <p class="text-muted mt-3 mb-0 w-75 mx-auto">Integer vulputate metus eget purus
                                            maximus porttitor. Maecenas ut porta justo.
                                            Donec finibus nec nibh ut urna viverra semper.</p>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end pt-3">
                                        <form class="form" method="POST" action="{{ route('cart.order') }}">
                                            @csrf

                                            <input type="hidden" name="shipping_id"
                                                value="{{ $data['shippingAddress'] }}" />
                                            <input type="hidden" name="billing_id" value="{{ $data['billingAddress'] }}" />
                                            <input type="hidden" name="tprice" value="{{ $price / 100 }}" />
                                            <input type="hidden" name="reward" value="{{ $reward }}" />
                                            @if (isset($data['presc']))
                                                <input type="hidden" name="priscription" value="{{ $data['presc'] }}" />
                                            @endif

                                            <input type="hidden" name="payment_method" value="online" />
                                            <script src="https://checkout.razorpay.com/v1/checkout.js" data-key="{{ env('ROZERPAY_ID') }}"
                                                data-amount="{{ $price }}" data-currency="INR" data-buttontext="Pay Amount {{ $price / 100 }}"
                                                data-buttontheme="brand-color" data-buttonclass="btn btn-primary" data-name="Dr Awish" data-description="Payment"
                                                data-prefill.name="{{ auth()->user()->name }}" data-prefill.email="{{ auth()->user()->email }}"
                                                data-prefill.contact="{{ auth()->user()->mobile }}" data-theme.color="#e1cb78"></script>
                                            <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane" id="cash" role="tabpanel">

                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center py-3">
                                        <div class="avatar-md mx-auto mb-4">
                                            <div
                                                class="avatar-title bg-primary-subtle text-primary rounded-circle display-6">
                                                <i class="bi bi-cash"></i>
                                            </div>
                                        </div>
                                        <h5 class="fs-16 mb-3">Cash on Delivery</h5>
                                        <p class="text-muted mt-3 mb-0 w-75 mx-auto">Integer vulputate metus eget purus
                                            maximus porttitor. Maecenas ut porta justo.
                                            Donec finibus nec nibh ut urna viverra semper.</p>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end pt-3">
                                        <form class="form" method="POST" action="{{ route('cart.order') }}">
                                            @csrf
                                            <input type="hidden" name="shipping_id"
                                                value="{{ $data['shippingAddress'] }}" />
                                            <input type="hidden" name="billing_id"
                                                value="{{ $data['billingAddress'] }}" />
                                            <input type="hidden" name="tprice" value="{{ $price / 100 }}" />
                                            <input type="hidden" name="reward" value="{{ $reward }}" />
                                            @if (isset($data['presc']))
                                                <input type="hidden" name="priscription"
                                                    value="{{ $data['presc'] }}" />
                                            @endif
                                            <input type="hidden" name="payment_method" value="cod" />

                                            <button type="submit" class="btn btn-hover w-md btn-primary">Continue<i
                                                    class="ri-logout-box-r-line align-bottom ms-2"></i></button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!--end col-->

            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <style>
        .razorpay-payment-button {
            background-color: rgb(31, 204, 31)
        }
    </style>

    @include('frontend.layouts.newsletter')

@endsection
