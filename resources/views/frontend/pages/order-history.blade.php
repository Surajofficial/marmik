@extends('frontend.layouts.master')

@section('title', 'Marmik || Order Track Page')

@section('main-content')
    <section class="page-wrapper bg-primary1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Order History</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Order History</li>
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
                    @if (count($orders) > 0)
                        <div>
                            <div class="table-responsive">
                                <table class="table fs-15 align-middle table-nowrap">
                                    <thead>
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Total Amount</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">TBT15454841</a>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-light rounded">
                                                            <img src="../assets/images/products/img-19.png" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="product-details.html">
                                                            <h6 class="fs-15 mb-1">World's Most Expensive T Shirt</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-13">Women's Clothes</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><span class="text-muted">01 Jul, 2022</span></td>
                                            <td class="fw-medium">$287.53</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success ">Delivered</span>
                                            </td>
                                            <td>
                                                <a href="#invoiceModal" data-bs-toggle="modal"
                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">TBT15425012</a>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-danger-subtle rounded">
                                                            <img src="../assets/images/products/img-12.png" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="product-details.html">
                                                            <h6 class="fs-15 mb-1">Onyx SmartGRID Chair Red</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-13">Furniture & Decor</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">01 Feb, 2023</span>
                                            </td>
                                            <td class="fw-medium">$39.99</td>
                                            <td>
                                                <span class="badge bg-secondary-subtle text-secondary ">Shipping</span>
                                            </td>
                                            <td>
                                                <a href="#invoiceModal" data-bs-toggle="modal"
                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">TBT1524563</a>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-success-subtle rounded">
                                                            <img src="../assets/images/products/img-4.png" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="product-details.html">
                                                            <h6 class="fs-15 mb-1">Slippers Open Toe</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-13">Footwear</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">09 Dec, 2022</span>
                                            </td>
                                            <td class="fw-medium">$874.00</td>
                                            <td><span class="badge bg-danger-subtle text-danger ">Out Of Delivery</span>
                                            </td>
                                            <td>
                                                <a href="#invoiceModal" data-bs-toggle="modal"
                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">TBT1524530</a>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-secondary-subtle rounded">
                                                            <img src="../assets/images/products/img-1.png" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="product-details.html">
                                                            <h6 class="fs-15 mb-1">Hp Trendsetter Backpack</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-13">Handbags & Clutches</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">02 Jan, 2023</span>
                                            </td>
                                            <td class="fw-medium">$32.00</td>
                                            <td>
                                                <span class="badge bg-success-subtle text-success ">Delivered</span>
                                            </td>
                                            <td>
                                                <a href="#invoiceModal" data-bs-toggle="modal"
                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="text-body">TBT13642870</a>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-3">
                                                    <div class="avatar-sm flex-shrink-0">
                                                        <div class="avatar-title bg-info-subtle rounded">
                                                            <img src="../assets/images/products/img-7.png" alt=""
                                                                class="avatar-xs">
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="product-details.html">
                                                            <h6 class="fs-15 mb-1">Innovative education book</h6>
                                                        </a>
                                                        <p class="mb-0 text-muted fs-13">Books</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="text-muted">08 Jan, 2023</span>
                                            </td>
                                            <td class="fw-medium">$18.32</td>
                                            <td>
                                                <span class="badge bg-warning-subtle text-warning ">Pending</span>
                                            </td>
                                            <td>
                                                <a href="#invoiceModal" data-bs-toggle="modal"
                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <button class="btn btn-hover btn-primary">Continue Shopping <i
                                        class="ri-arrow-right-line align-middle ms-1"></i></button>
                            </div>
                        </div>
                    @else
                        <h6 class="text-center">No orders found!!! Please order some products</h6>
                    @endif

                </div><!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end conatiner-->
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
                                class="link-primary text-decoration-underline fw-medium">Toner</a></p>
                        <form action="#!">
                            <div class="position-relative ecommerce-subscript">
                                <input type="email" class="form-control rounded-pill" placeholder="Enter your email">
                                <button type="submit" class="btn btn-primary btn-hover rounded-pill">Subscript
                                    Now</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->
                <div class="col-lg-4">
                    <div class="mt-4 mt-lg-0">
                        <img src="../assets/images/ecommerce/subscribe.png" alt="" class="img-fluid">
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end conatiner-->
    </section>

    <section class="position-relative py-5">
        <div class="container">
            <div class="row gy-4 gy-lg-0">
                <div class="col-lg-3 col-sm-6">
                    <div class="d-flex align-items-center gap-3">
                        <div class="flex-shrink-0">
                            <img src="../assets/images/ecommerce/fast-delivery.png" alt="" class="avatar-sm">
                        </div>
                        <div class="flex-grow-1">
                            <h5 class="fs-15">Fast &amp; Secure Delivery</h5>
                            <p class="text-muted mb-0">Tell about your service.</p>
                        </div>
                    </div>
                </div><!--end col-->
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
                </div><!--end col-->
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
                </div><!--end col-->
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
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!--end container-->
    </section>
    <!-- Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-custom-size">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="invoiceModalLabel">Invoice #TTB30280001</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="card mb-0" id="demo">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header border-bottom-dashed p-4">
                                    <div class="d-sm-flex">
                                        <div class="flex-grow-1">
                                            <img src="../assets/images/logo-dark.png" class="card-logo card-logo-dark"
                                                alt="logo dark" height="26">
                                            <img src="../assets/images/logo-light.png" class="card-logo card-logo-light"
                                                alt="logo light" height="26">
                                            <div class="mt-sm-5 mt-4">
                                                <h6 class="text-muted text-uppercase fw-semibold fs-14">Address</h6>
                                                <p class="text-muted mb-1" id="address-details">Phoenix, USA</p>
                                                <p class="text-muted mb-0" id="zip-code"><span>Zip-code:</span> 90201</p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0 mt-sm-0 mt-3">
                                            <h6><span class="text-muted fw-normal">Legal Registration No:</span> <span
                                                    id="legal-register-no">987654</span></h6>
                                            <h6><span class="text-muted fw-normal">Email:</span> <span
                                                    id="email">toner@themesbrand.com</span></h6>
                                            <h6><span class="text-muted fw-normal">Website:</span> <a
                                                    href="https://themesbrand.com/" class="link-primary" target="_blank"
                                                    id="website">www.themesbrand.com</a></h6>
                                            <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span
                                                    id="contact-no"> +(314) 234 6789</span></h6>
                                        </div>
                                    </div>
                                </div>
                                <!--end card-header-->
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body p-4">
                                    <div class="row g-3">
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Invoice No</p>
                                            <h5 class="fs-15 mb-0">#TTB<span id="invoice-no">30280001</span></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Date</p>
                                            <h5 class="fs-15 mb-0"><span id="invoice-date">14 Jan, 2023</span> <small
                                                    class="text-muted" id="invoice-time">12:22PM</small></h5>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Payment Status</p>
                                            <span class="badge bg-success-subtle text-success "
                                                id="payment-status">Paid</span>
                                        </div>
                                        <!--end col-->
                                        <div class="col-lg-3 col-6">
                                            <p class="text-muted mb-2 text-uppercase fw-semibold fs-14">Total Amount</p>
                                            <h5 class="fs-15 mb-0">$<span id="total-amount">1406.92</span></h5>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body p-4 border-top border-top-dashed">
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">Billing Address
                                            </h6>
                                            <p class="fw-medium mb-2 fs-16" id="billing-name">Raquel Murillo</p>
                                            <p class="text-muted mb-1" id="billing-address-line-1">4430 Holt Street,
                                                Miami, Florida-33169</p>
                                            <p class="text-muted mb-1"><span>Phone: +</span><span
                                                    id="billing-phone-no">(123) 561-238-1000</span></p>
                                            <p class="text-muted mb-0"><span>Tax: </span><span
                                                    id="billing-tax-no">65-498700</span> </p>
                                        </div>
                                        <!--end col-->
                                        <div class="col-6">
                                            <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">Shipping Address
                                            </h6>
                                            <p class="fw-medium mb-2 fs-16" id="shipping-name">Raquel Murillo</p>
                                            <p class="text-muted mb-1" id="shipping-address-line-1">4430 Holt Street,
                                                Miami, Florida-33169</p>
                                            <p class="text-muted mb-1"><span>Phone: +</span><span
                                                    id="shipping-phone-no">(123) 561-238-1000</span></p>
                                        </div>
                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body p-4">
                                    <div class="table-responsive">
                                        <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="table-active">
                                                    <th scope="col" style="width: 50px;">#</th>
                                                    <th scope="col">Product Details</th>
                                                    <th scope="col">Rate</th>
                                                    <th scope="col">Quantity</th>
                                                    <th scope="col" class="text-end">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                <tr>
                                                    <th scope="row">01</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">World's most expensive t shirt</span>
                                                        <p class="text-muted mb-0">Graphic Print Men & Women Sweatshirt</p>
                                                    </td>
                                                    <td>$266.24</td>
                                                    <td>03</td>
                                                    <td class="text-end">$798.72</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">02</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">Ninja Pro Max Smartwatch</span>
                                                        <p class="text-muted mb-0">large display of 40mm (1.6″ inch), 27
                                                            sports mode, SpO2 monitor</p>
                                                    </td>
                                                    <td>$247.27</td>
                                                    <td>01</td>
                                                    <td class="text-end">$247.27</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">03</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">Girls Mint Green & Off-White Open Toe
                                                            Flats</span>
                                                        <p class="text-muted mb-0">Fabric:Synthetic · Color:Green · Shoe
                                                            Type:Sandals</p>
                                                    </td>
                                                    <td>$24.07</td>
                                                    <td>05</td>
                                                    <td class="text-end">$120.35</td>
                                                </tr>
                                                <tr>
                                                    <th scope="row">04</th>
                                                    <td class="text-start">
                                                        <span class="fw-medium">Carven Lounge Chair Red</span>
                                                        <p class="text-muted mb-0">Carven Fabric Lounge Chair in Red Color
                                                        </p>
                                                    </td>
                                                    <td>$209.99</td>
                                                    <td>01</td>
                                                    <td class="text-end">$209.99</td>
                                                </tr>
                                            </tbody>
                                        </table><!--end table-->
                                    </div>
                                    <div class="border-top border-top-dashed mt-2">
                                        <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto"
                                            style="width:250px">
                                            <tbody>
                                                <tr>
                                                    <td>Sub Total</td>
                                                    <td class="text-end">$1376.33</td>
                                                </tr>
                                                <tr>
                                                    <td>Estimated Tax (12.5%)</td>
                                                    <td class="text-end">$172.04</td>
                                                </tr>
                                                <tr>
                                                    <td>Discount <small class="text-muted">(TONER50)</small></td>
                                                    <td class="text-end">- $206.45</td>
                                                </tr>
                                                <tr>
                                                    <td>Shipping Charge</td>
                                                    <td class="text-end">$65.00</td>
                                                </tr>
                                                <tr class="border-top border-top-dashed fs-15">
                                                    <th scope="row">Total Amount</th>
                                                    <th class="text-end">$1406.92</th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <!--end table-->
                                    </div>
                                    <div class="mt-3">
                                        <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                        <p class="text-muted mb-1">Payment Method: <span class="fw-medium"
                                                id="payment-method">Mastercard</span></p>
                                        <p class="text-muted mb-1">Card Holder: <span class="fw-medium"
                                                id="card-holder-name">Raquel Murillo</span></p>
                                        <p class="text-muted mb-1">Card Number: <span class="fw-medium"
                                                id="card-number">xxx xxxx xxxx 1234</span></p>
                                        <p class="text-muted">Total Amount: <span class="fw-medium">$ </span><span
                                                id="card-total-amount">1406.92</span></p>
                                    </div>
                                    <div class="mt-4">
                                        <div class="alert alert-info">
                                            <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                <span id="note">All accounts are to be paid within 7 days from receipt
                                                    of invoice. To be paid by cheque or
                                                    credit card or direct payment online. If account is not paid within 7
                                                    days the credits details supplied as confirmation of work undertaken
                                                    will be charged the agreed quoted fee noted above.
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                        <a href="javascript:window.print()" class="btn btn-success"><i
                                                class="ri-printer-line align-bottom me-1"></i> Print</a>
                                        <a href="javascript:void(0);" class="btn btn-primary"><i
                                                class="ri-download-2-line align-bottom me-1"></i> Download</a>
                                    </div>
                                </div>
                                <!--end card-body-->
                            </div><!--end col-->
                        </div><!--end row-->
                    </div>
                    <!--end card-->
                </div>
            </div>
        </div>
    </div>
@endsection
