@extends('frontend.layouts.master')

@section('title', 'Dr Awish || Order Track Page')

@section('main-content')
    <section class="page-wrapper bg-primary1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Track Order</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Track Order</li>
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
    <!-- end page title -->

    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-4 pb-2">
                        <h5 class="mb-0 text-decoration-underline">Order ID <b>{{ $order->order_number }}</b></h5>
                    </div>
                </div>
            </div><!--end row-->
            <div class="track-orders">
                <div class="row justify-content-between gy-4 gy-md-0">

                    <div class="col-md-2 order-tracking text-start text-md-center ps-4 ps-md-0 completed" id="new">
                        <span class="is-complete"></span>
                        <h6 class="fs-15 mt-3 mt-md-4">Order Process</h6>
                        <!-- <p class="text-muted fs-14 mb-0">Mon, 23 Nov</p> -->
                    </div><!--end col-->
                    <div class="col-md-2 order-tracking text-start text-md-center ps-4 ps-md-0" id="new1">
                        <span class="is-complete"></span>
                        <h6 class="fs-15 mt-3 mt-md-4">Order Shipped</h6>
                        <!-- <p class="text-muted fs-14 mb-0">Mon, 23 Nov</p> -->
                    </div><!--end col-->
                    <div class="col-md-2 order-tracking text-start text-md-center ps-4 ps-md-0" id="new2">
                        <span class="is-complete"></span>
                        <h6 class="fs-15 mt-3 mt-md-4">Out Of Delivery</h6>
                        <!-- <p class="text-muted fs-14 mb-0">Mon, 23 Nov</p> -->
                    </div><!--end col-->
                    <div class="col-md-2 order-tracking text-start text-md-center ps-4 ps-md-0" id="new3">
                        <span class="is-complete"></span>
                        <h6 class="fs-15 mt-3 mt-md-4">Delivered</h6>
                        <!-- <p class="text-muted fs-14 mb-0">Mon, 23 Nov</p> -->
                    </div><!--end col-->

                </div><!--end row-->
            </div>
        </div><!--end container-->
    </section>

    <section class="section pt-0">
        <div class="container">
            <div class="card border-dashed">
                <div class="card-body border-bottom border-bottom-dashed p-4">
                    <div class="row g-3">
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Invoice ID</p>
                            <h5 class="fs-14 mb-0"><span id="invoice-no">{{ $order->id }}</span></h5>
                        </div>
                        <!--end col-->
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Date</p>
                            <h5 class="fs-14 mb-0"><span id="invoice-date">{{ $order->updated_at }}</span> <small
                                    class="text-muted" id="invoice-time">02:36PM</small></h5>
                        </div>
                        <!--end col-->
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Payment Status</p>
                            <span class="badge bg-success-subtle text-success  fs-11"
                                id="payment-status">{{ $order->payment_status }}</span>
                        </div>
                        <!--end col-->
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Total Amount</p>
                            <h5 class="fs-14 mb-0">₹ <span id="total-amount">{{ $order->total_amount }}</span></h5>
                        </div>
                        <!--end col-->
                    </div><!--end row-->
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <h6 class="text-muted text-uppercase fs-12 mb-3">Billing Address</h6>
                            <h6 id="billing-name">{{ $order->first_name }}</h6>
                            <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->address1 }}</p>
                            <p class="text-muted mb-1">
                                <span>Phone: +91{{ $order->phone }}</span>
                            </p>
                            <p class="text-muted mb-0"><span>Postal Code: </span><span
                                    id="billing-tax-no">{{ $order->postal_code }}</span> </p>
                        </div>
                        <!--end col-->
                        <div class="col-6">
                            <h6 class="text-muted text-uppercase fs-12 mb-3">Shipping Address</h6>
                            <h6 id="billing-name">{{ $order->first_name }}</h6>
                            <p class="text-muted mb-1" id="billing-address-line-1">{{ $order->address1 }}</p>
                            <p class="text-muted mb-1">
                                <span>Phone: +91{{ $order->phone }}</span>
                            </p>
                            <p class="text-muted mb-0"><span>Postal Code: </span><span
                                    id="billing-tax-no">{{ $order->postal_code }}</span> </p>
                        </div>
                        <!--end col-->
                    </div><!--end row-->
                </div>

            </div>
            <div class="card-body p-4">
                <div class="d-flex mb-3">
                    <h5 class="card-title flex-grow-1 mb-0"><i
                            class="mdi mdi-truck-fast-outline align-middle me-1 text-muted"></i>payment Details</h5>
                    <div class="flex-shrink-0">
                        <a href="javascript:void(0);" class="badge bg-primary-subtle text-primary  fs-11">Track Order</a>
                    </div>
                </div>
                <div>
                    <div class="row align-items-center gy-3 gy-md-0">

                        <div class="col-md-4">
                            <div class="text-end text-md-start">
                                <p class="text-muted mb-0 fs-14">Online</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-end">
                                <a href="{{ route('faq') }}" class="btn btn-soft-info"><i
                                        class="ri-customer-service-2-line align-bottom me-1"></i> Help Center</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="text-end mt-4">
                    <a href="{{ route('product-grids') }}" class="btn btn-danger btn-hover">Continue Shopping <i
                            class="ri-arrow-right-line align-bottom ms-1"></i></a>
                </div>
            </div>
        </div>
        </div><!--end container-->
    </section>

    <section class="section bg-light bg-opacity-25"
        style="background-image: url('../assets/images/ecommerce/bg-effect.png');background-position: center; background-size: cover;">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    <div>
                        <p class="fs-15 text-uppercase fw-medium"><span class="fw-semibold text-danger">25% Up to</span>
                            off all Products</p>
                        <h1 class="lh-base text-capitalize mb-3">Stay home & get your daily needs from our shop</h1>
                        <p class="fs-15 mb-4 pb-2">Start You'r Daily Shopping with <a href="#!"
                                class="link-info fw-medium">Toner</a></p>
                        <form action="#!">
                            <div class="position-relative ecommerce-subscript">
                                <input type="email" class="form-control rounded-pill" placeholder="Enter your email">
                                <button type="submit" class="btn btn-info btn-hover rounded-pill">Subscript Now</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-4">
                    <div class="mt-5 mt-lg-0">
                        <img src="../assets/images/ecommerce/subscribe.png" alt="" class="img-fluid">
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    <section class="section py-5">
        <div class="container">
            <div class="row gy-4 gy-lg-0">
                <div class="col-lg-3 col-sm-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="../assets/images/ecommerce/fast-delivery.png" alt="" class="avatar-sm">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">Fast & Secure Delivery</h5>
                            <p class="text-muted mb-0">Tell about your service.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="../assets/images/ecommerce/returns.png" alt="" class="avatar-sm">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">2 Days Return Policy</h5>
                            <p class="text-muted mb-0">No question ask.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="../assets/images/ecommerce/guarantee-certificate.png" alt=""
                                class="avatar-sm">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">Money Back Guarantee</h5>
                            <p class="text-muted mb-0">Within 5 business days</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="../assets/images/ecommerce/24-hours-support.png" alt="" class="avatar-sm">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">24 X 7 Service</h5>
                            <p class="text-muted mb-0">Online service for customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var status = "<?php print_r($order->status); ?>";
        if (status == "new") {
            document.getElementById("new").classList.add("completed");
        } else if (status == "process") {
            document.getElementById("new").classList.add("completed");
            document.getElementById("new1").classList.add("completed");
        } else if (status == "delivered") {
            document.getElementById("new").classList.add("completed");
            document.getElementById("new1").classList.add("completed");
            document.getElementById("new2").classList.add("completed");
            document.getElementById("new3").classList.add("completed");
        } else if (status == "cancel") {
            //    document.getElementById("new3").classList.add("completed"); 
        }
    </script>

@endsection
