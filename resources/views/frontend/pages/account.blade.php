@extends('frontend.layouts.master')

@section('title', 'E-SHOP || Order Track Page')

@section('main-content')
    <section class="position-relative">
        <div class="profile-basic position-relative"
            style="background-image: url('../assets/images/istockphoto-657304138-612x612.jpg');background-size: cover;background-position: center; height: 300px;">
            <div class="bg-overlay bg-primary" style="--bs-bg-opacity: 0.99;"></div>
        </div>
        @php
            $user = DB::table('users')
                ->where('status', 'active')
                ->where('id', auth()->user()->id)
                ->limit(1)
                ->get();
        @endphp
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pt-3">
                        <div class="mt-n5 d-flex gap-3 flex-wrap align-items-end">
                            <img src="{{ $user[0]->photo ? $user[0]->photo : asset('../assets/images/users/a.png') }}"
                                alt="" class="avatar-xl rounded p-1 bg-light mt-n3">

                            <div>

                                <h5 class="fs-18">{{ $user[0]->name }}</h5>
                                <div class="text-muted">
                                    @isset($shipping)
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $shipping->city ?? '' }},{{ $shipping->state ?? '' }}
                                    @endisset
                                </div>
                            </div>
                            <div class="ms-md-auto">
                                <a href="{{ route('home') }}" class="btn btn-success btn-hover">
                                    <i class="bi bi-cart4 me-1 align-middle"></i> Shopping Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end profile -->

    <!-- start tab-->
    <section class="py-5">
        <div class="container">

            <div class="modal" id="editaccountmodal" tabindex="-1" aria-labelledby="editaccountmodalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="editaccountmodalLabel">Edit Details</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="addressid-input" class="form-control" value="">
                            <p id="errormsg"></p>
                            <form action="{{ route('account.edit') }}" id="addressForm" method="post"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="name" placeholder="name"
                                            value="{{ $user[0]->name }}">
                                    </div>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="email" placeholder="email"
                                            value="{{ $user[0]->email }}">
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <input type="file" class="form-control" name="profile_image" accept="image/*">
                                    </div>

                                    <div class="col-md-2 mt-3">
                                        <button type="button" class="btn btn-success" id="updateBtn">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <div class="row">
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column gap-3" role="tablist">
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link fs-15 active" data-bs-toggle="tab" href="#custom-v-pills-profile"
                                        role="tab" aria-selected="true"><i
                                            class="bi bi-person-circle align-middle me-1"></i> Account Info</a>
                                </li>
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-list"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-bookmark-check align-middle me-1"></i> Wish list</a>
                                </li>
                                <li class="nav-item " role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#orders_table" role="tab"
                                        aria-selected="false" tabindex="-1"><i class="bi bi-bag align-middle me-1"></i>
                                        Order</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link fs-15" href="{{ route('user.logout') }}"><i
                                            class="bi bi-box-arrow-right align-middle me-1"></i> Logout</a>
                                </li>

                                <li class="nav-item " role="presentation">
                                    <a class="nav-link fs-15" data-bs-toggle="tab" href="#custom-v-pills-coupon"
                                        role="tab" aria-selected="false" tabindex="-1"><i
                                            class="bi bi-ticket align-middle me-1"></i>
                                        Coupon Used</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div><!--end col-->
                <div class="col-lg-9">
                    <div class="tab-content gi-muted">
                        <div class="tab-pane fade show active" id="custom-v-pills-profile" role="tabpanel">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div id="success-message">
                                                @if (session('success'))
                                                    <div class="alert alert-success">
                                                        {{ session('success') }}
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="d-flex mb-4">
                                                <h6 class="fs-16 text-decoration-underline flex-grow-1 mb-0">Personal Info
                                                </h6>
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#editaccountmodal">
                                                    Edit Profile
                                                </button>
                                            </div>



                                            <div class="table-responsive table-card px-1">
                                                <table class="table table-borderless table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                Customer Name
                                                            </td>
                                                            <!-- Table Cell for Name -->
                                                            <td class="fw-medium" id="user-name">
                                                                {{ $user[0]->name }}
                                                            </td>


                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Mobile / Phone Number
                                                            </td>
                                                            <td class="fw-medium">
                                                                {{ @$user[0]->mobile }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Email Address
                                                            </td>

                                                            <!-- Table Cell for Email -->
                                                            <td class="fw-medium" id="user-email">
                                                                {{ $user[0]->email }}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Location
                                                            </td>
                                                            <td class="fw-medium">
                                                                @isset($shipping)
                                                                    {{ $shipping->city ?? '' }},{{ $shipping->state ?? '' }}
                                                                @endisset
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                Since Member
                                                            </td>
                                                            <td class="fw-medium">
                                                                {{ $user[0]->created_at }}
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                            <div class="mt-4">
                                                <a class="fs-16 text-decoration-underline"
                                                    href="{{ route('shipping') }}">Billing & Shipping Address</a>
                                            </div>
                                            <div class="row mt-4" id="address-list">

                                            </div>
                                            <!-- end row -->
                                        </div>
                                    </div>
                                    <!--end card-->
                                </div>
                                <!--end col-->
                            </div>
                        </div>
                        <!--end tab-pane-->
                        <div class="tab-pane " id="custom-v-pills-list" role="tabpanel">
                            <div class=" overflow-hidden">
                                <div class="card" style="margin-bottom: 0;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <p><b> My Wishlist (<span
                                                            class="wishlist-count">{{ $wishlistCount }}</span>)</b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @if ($featured->count() > 0)
                                    @foreach ($featured as $product)
                                        <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                            <div class="card p-2 wishlist" style="margin-bottom: 0;">
                                                <div class="row p-3">
                                                    <div class="col-lg-3 col-md-3 col-sm-3">
                                                        @php
                                                            $photo = explode(',', $product->product->photo);
                                                        @endphp
                                                        <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                            height="100" width="100">
                                                    </div>
                                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                                        <h6 class="mt-1">
                                                            <span class="text-wrap">{{ $product->product->title }}</span>
                                                        </h6>

                                                        <div>
                                                            @php
                                                                $after_discount =
                                                                    $product->price -
                                                                    ($product->price * $product->discount) / 100;
                                                            @endphp

                                                            @if ($product->stock <= 0)
                                                                <h4 class="text-danger">Out of stock</h4>
                                                            @else
                                                                <h5>
                                                                    Rs.{{ number_format($after_discount, 2) }}
                                                                    @if ($product->discount > 0)
                                                                        <span
                                                                            class="text-danger text-decoration-line-through">
                                                                            Rs.{{ number_format($product->price, 2) }}
                                                                        </span>
                                                                    @endif
                                                                </h5>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3 col-sm-3 wh-btn">
                                                        <span class="remove-wishlist-btn"
                                                            data-product-id="{{ $product->product->id }}"
                                                            data-product_variants-id="{{ $product->id }}">
                                                            <i class="ph-trash fs-24 mt-4"
                                                                style="margin-left: 61%; color:#ccc"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @else
                                    <p>No featured products available.</p>
                                @endif


                            </div>
                        </div>
                        <div class="tab-pane fade" id="orders_table" role="tabpanel">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive table-card">
                                        @if (count($orders) > 0)
                                            <table class="table fs-15 align-middle table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Order ID</th>
                                                        <th scope="col">Order Number</th>
                                                        <th scope="col">Product</th>
                                                        <th scope="col">Date</th>
                                                        <th scope="col">Total Amount</th>
                                                        <th scope="col">Status</th>
                                                        <th scope="col">Tracking Id</th>
                                                        <th scope="col">Track Order</th>
                                                        <th scope="col">Invoice</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($orders as $order)
                                                        @php
                                                            $shipping_charge = DB::table('shippings')
                                                                ->where('id', $order->shipping_id)
                                                                ->pluck('price');
                                                            $porder = DB::table('carts')
                                                                ->where('order_id', $order->id)
                                                                ->get();
                                                            // dd($porder));
                                                            $product = DB::table('products')
                                                                ->where('id', @$porder[0]->product_id)
                                                                ->get();
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <a href="#"
                                                                    class="text-body">{{ $order->id }}</a>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="text-body">
                                                                    {{ $order->order_number }}</a>
                                                            </td>
                                                            <td>
                                                                <a href="#" class="text-body">
                                                                    {{ @$product[0]->title }}...</a>
                                                            </td>

                                                            <td><span class="text-muted">{{ $order->created_at }}</span>
                                                            </td>
                                                            <td class="fw-medium">
                                                                Rs.{{ number_format($order->total_amount, 2) }}</td>

                                                            <td>
                                                                @if ($order->status == 'new')
                                                                    <span
                                                                        class="badge  bg-primary-subtle text-primary">{{ $order->status }}</span>
                                                                @elseif($order->status == 'process')
                                                                    <span
                                                                        class="badge  bg-warning-subtle text-warning">{{ $order->status }}</span>
                                                                @elseif($order->status == 'delivered')
                                                                    <span
                                                                        class="badge  bg-success-subtle text-success">{{ $order->status }}</span>
                                                                @else
                                                                    <span
                                                                        class="badge  bg-danger-subtle badge-danger">{{ $order->status }}</span>
                                                                @endif
                                                            </td>

                                                            <td>
                                                                @if ($order->tracking_id == '')
                                                                    <a href="#"
                                                                        class="btn btn-danger btn-sm">Pending</a>
                                                                @else
                                                                    <span
                                                                        class="badge  bg-primary-subtle text-primary">{{ $order->tracking_id }}
                                                                    </span>
                                                                @endif

                                                            </td>
                                                            <td>

                                                                @if ($order->tracking_id == '')
                                                                    <a href="#"
                                                                        class="btn btn-danger btn-sm">Pending</a>
                                                                @else
                                                                    <a href="https://www.shiprocket.in/shipment-tracking/"
                                                                        target="_blank"
                                                                        class="btn btn-primary btn-sm">Track Order</a>
                                                                @endif

                                                            </td>

                                                            <td>
                                                                <a href="#invoiceModal_{{ $order->id }}"
                                                                    data-id="{{ $order->id }}" data-bs-toggle="modal"
                                                                    class="btn btn-secondary btn-sm">Invoice</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        @else
                                            <h6 class="text-center mt-5">No orders found!!! Please order some products</h6>
                                        @endif
                                    </div>
                                    <div class="text-end mt-4">
                                        <a href="{{ route('home') }}" class="btn btn-hover btn-primary">Continue
                                            Shopping <i class="ri-arrow-right-line align-middle ms-1"></i></a>
                                    </div>
                                </div>
                                <!-- end card-body -->
                            </div>
                            <!--end card-->
                        </div>
                    </div>

                </div>

            </div>

        </div>
        </div>

        <div class="tab-pane fade" id="custom-v-pills-coupan" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        @php

                            $cps = DB::table('coupons')->where('status', 'active')->get();

                        @endphp
                        @if ($cps)
                            @foreach ($cps as $cp)
                                <h6 class="text-center mt-3">
                                    <span>{{ $cp->id }}:-</span>{{ $cp->title }} - <a
                                        href="#">{{ $cp->code }}</a>
                                </h6>
                            @endforeach
                        @endif
                    </div>

                </div>

            </div>

        </div>

        <div class="tab-pane fade" id="custom-v-pills-reward" role="tabpanel">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive table-card">
                        @php

                            $rewards = DB::table('rewards')
                                ->where('user_id', auth()->user()->id)
                                ->orderBy('id', 'ASC')
                                ->get();

                        @endphp

                        @if (empty($rewards['items']) == true || empty($rewards) == false)
                            <h6 class="text-center mt-3">You Have {{ (int) @$rewards[0]->point }} Points
                            </h6>
                        @else
                            <h6 class="text-center mt-3">You Have 0 Points !! Please Order to get the
                                Rewards Points</h6>
                        @endif
                    </div>

                </div>

            </div>

        </div>


        <style>
            .coupon-ticket {
                position: relative;
                background: #f7f7f7;
                border: 2px dashed #ddd;
                border-radius: 10px;
                padding: 20px;
                margin: 15px 0;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                display: flex;
                justify-content: space-between;
                align-items: center;
                overflow: hidden;
                flex-wrap: wrap;
                /* To support long descriptions */
            }

            .coupon-ticket:before,
            .coupon-ticket:after {
                content: '';
                position: absolute;
                width: 20px;
                height: 20px;
                background: #f7f7f7;
                border-radius: 50%;
                box-shadow: 0 0 0 2px #ddd;
            }

            .coupon-ticket:before {
                top: -10px;
                left: 50%;
                transform: translateX(-50%);
            }

            .coupon-ticket:after {
                bottom: -10px;
                left: 50%;
                transform: translateX(-50%);
            }

            .coupon-details {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .coupon-code {
                font-size: 18px;
                font-weight: bold;
                color: #333;
                margin-bottom: 5px;
            }

            .coupon-discount {
                font-size: 24px;
                color: #27ae60;
                font-weight: bold;
                margin-bottom: 5px;
            }

            .coupon-expiry {
                font-size: 14px;
                color: #888;
            }

            .coupon-description {
                font-size: 14px;
                color: #555;
                margin-top: 10px;
            }

            @media(max-width: 575px) {
                .wishlist {
                    position: relative;
                }

                .wishlist h6 {
                    margin-top: 20px !important;
                }

                .wishlist .wh-btn {
                    position: absolute;
                    top: 0;
                    right: -25%;
                }


            }

            @media (max-width: 768px) {
                .coupon-ticket {
                    flex-direction: column;
                    padding: 15px;
                }

                .coupon-details {
                    margin-bottom: 15px;
                }
            }
        </style>

        <div class="tab-pane fade" id="custom-v-pills-coupon" role="tabpanel">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            @foreach ($usedCoupons as $coupon)
                                <!-- Coupon Ticket -->
                                <div class="coupon-ticket">
                                    <div class="coupon-details">
                                        <div class="coupon-code">
                                            <strong>Coupon Code:</strong> {{ $coupon->code }}
                                        </div>
                                        <div class="coupon-discount">
                                            <span>
                                                @if ($coupon->discount_type == 'percentage')
                                                    {{ $coupon->discount_value }}% Off
                                                @else
                                                    ₹{{ $coupon->discount_value }} Off
                                                @endif
                                            </span>
                                        </div>
                                        <div class="coupon-expiry">
                                            <span>Expires on:
                                                {{ \Carbon\Carbon::parse($coupon->expires_at)->format('d-M-Y') }}</span>
                                        </div>
                                        @if ($coupon->description)
                                            <div class="coupon-description">
                                                {{ $coupon->description }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- end coupon ticket -->
                            @endforeach
                        </div>
                    </div>
                    <!--end card-->
                </div>
                <!--end col-->
            </div>
        </div>

        </div>
        </div>
        </div> <!-- end row-->
        </div>
    </section>
    <!-- end tab-->

    <!-- start subscribe-->

    <!-- end subscribe-->


    @include('frontend.layouts.newsletter')

    <!-- Modal -->


    <script>
        var addressListData = @json($shipping);
        // console.log(addressListData);
        var editlist = false;

        loadAddressList(addressListData);

        function loadAddressList(datas) {
            document.getElementById("address-list").innerHTML = "";
            Array.from(datas).forEach(function(listdata) {
                var checkinput = listdata.checked ? "checked" : "";
                document.getElementById("address-list").innerHTML +=
                    '<div class="col-lg-6">\
                                                                        <div>\
                                                                            <div class="form-check card-radio">\
                                                                                <input id="shippingAddress' + listdata.id +
                    '" name="shippingAddress" type="radio" class="form-check-input" ' + checkinput +
                    '>\
                                                                                <label class="form-check-label" for="shippingAddress' +
                    listdata
                    .id +
                    '">\
                                                                                <span class="mb-4 fw-semibold fs-12 d-block text-muted text-uppercase">' +
                    listdata
                    .atype +
                    ' Address</span>\
                                                                                <span class="fs-14 mb-2 fw-semibold  d-block">' +
                    listdata
                    .first_name +
                    '</span>\
                                                                                <span class="text-muted fw-normal text-wrap mb-1 d-block">' +
                    listdata
                    .address1 +
                    '</span>\
                                                                                <span class="text-muted fw-normal d-block">Mo. ' +
                    listdata
                    .phone + '</span>\
                                                                                </label>\
                                                                            </div>\
                                                                        </div>\
                                                                    </div>';

                editAddressList();
                removeItem();
            });
        };


        // var createAddressForms = document.querySelectorAll('.createAddress-form')
        // Array.prototype.slice.call(createAddressForms).forEach(function (form) {
        //     form.addEventListener('submit', function (event) {
        //         if (!form.checkValidity()) {
        //             event.preventDefault();
        //             event.stopPropagation();
        //         } else {
        //             event.preventDefault();
        //             var inputName = document.getElementById('addaddress-Name').value;
        //             var addressValue = document.getElementById('addaddress-textarea').value;
        //             var phoneValue = document.getElementById('addaddress-phone').value;
        //             var stateValue = document.getElementById('state').value;

        //             if (inputName !== "" &&
        //                 addressValue !== "" &&
        //                 stateValue !== "" &&
        //                 phoneValue !== "" && !editlist) {
        //                 var newListId = findNextId();
        //                 var newList = {
        //                     'id': newListId,
        //                     "checked": false,
        //                     "addressType": stateValue,
        //                     "name": inputName,
        //                     "address": addressValue,
        //                     "phone": phoneValue
        //                 };

        //                 addressListData.push(newList);
        //             } else if (inputName !== "" &&
        //                 addressValue !== "" &&
        //                 stateValue !== "" &&
        //                 phoneValue !== "" && editlist) {
        //                 var getEditid = 0;
        //                 getEditid = document.getElementById("addressid-input").value;
        //                 addressListData = addressListData.map(function (item) {
        //                     if (item.id == getEditid) {
        //                         var editObj = {
        //                             'id': getEditid,
        //                             "checked": item.checked,
        //                             "addressType": stateValue,
        //                             "name": inputName,
        //                             "address": addressValue,
        //                             "phone": phoneValue
        //                         }
        //                         return editObj;
        //                     }
        //                     return item;
        //                 });
        //                 editlist = false;
        //                 console.log(addressListData)
        //             }

        //             loadAddressList(addressListData)
        //             document.getElementById("addAddress-close").click();
        //         }
        //         form.classList.add('was-validated');
        //     }, false)
        // });

        function fetchIdFromObj(list) {
            return parseInt(list.id);
        }

        function findNextId() {
            if (addressListData.length === 0) {
                return 0;
            }
            var lastElementId = fetchIdFromObj(addressListData[addressListData.length - 1]),
                firstElementId = fetchIdFromObj(addressListData[0]);
            return (firstElementId >= lastElementId) ? (firstElementId + 1) : (lastElementId + 1);
        }

        Array.from(document.querySelectorAll(".addAddress-modal")).forEach(function(elem) {
            elem.addEventListener('click', function(event) {
                document.getElementById("addAddressModalLabel").innerHTML = "Add New Address";
                document.getElementById("addNewAddress").innerHTML = "Add";
                document.getElementById("addaddress-Name").value = "";
                document.getElementById("addaddress-textarea").value = "";
                document.getElementById("addaddress-phone").value = "";
                document.getElementById("state").value = "Home";

                document.getElementById("createAddress-form").classList.remove('was-validated');
            });
        });


        function editAddressList() {
            var getEditid = 0;
            Array.from(document.querySelectorAll(".edit-list")).forEach(function(elem) {
                elem.addEventListener('click', function(event) {
                    getEditid = elem.getAttribute('data-edit-id');
                    addressListData = addressListData.map(function(item) {
                        if (item.id == getEditid) {
                            editlist = true;
                            document.getElementById("createAddress-form").classList.remove(
                                'was-validated');
                            document.getElementById("addAddressModalLabel").innerHTML =
                                "Edit Address";
                            document.getElementById("addNewAddress").innerHTML = "Save";

                            document.getElementById("addressid-input").value = item.id;
                            document.getElementById('addaddress-Name').value = item.name;
                            document.getElementById('addaddress-textarea').value = item.address;
                            document.getElementById('addaddress-phone').value = item.phone;
                            document.getElementById('state').value = item.addressType;

                        }
                        return item;
                    });
                });
            });
        };


        // removeItem
        function removeItem() {
            var getid = 0;
            Array.from(document.querySelectorAll(".remove-list")).forEach(function(item) {
                item.addEventListener('click', function(event) {
                    getid = item.getAttribute('data-remove-id');
                    document.getElementById("remove-address").addEventListener("click", function() {
                        function arrayRemove(arr, value) {
                            return arr.filter(function(ele) {
                                return ele.id != value;
                            });
                        }
                        var filtered = arrayRemove(addressListData, getid);

                        addressListData = filtered;

                        loadAddressList(addressListData);
                        document.getElementById("close-removeAddressModal").click();
                    });
                });
            });
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <script>
        $(document).ready(function() {
            $('#updateBtn').on('click', function() {
                // Create a FormData object to hold form data
                var formData = new FormData($('#addressForm')[0]); // Use the form element directly

                // AJAX request
                $.ajax({
                    url: '{{ route('account.edit') }}', // Your route for updating account
                    type: 'POST',
                    data: formData,
                    processData: false, // Prevent jQuery from automatically transforming the data into a query string
                    contentType: false, // Set the content type to false to allow file uploads
                    success: function(response) {
                        if (response.success) {
                            // Update the name and email in the table cells
                            $('#user-name').text($('input[name="name"]').val());
                            $('#user-email').text($('input[name="email"]').val());

                            // Display the success message
                            $('#success-message').html(
                                '<div class="alert alert-success">Profile Updated Successfully!</div>'
                            );

                            // Optional: Auto-hide the success message after a few seconds
                            setTimeout(function() {
                                $('#success-message .alert').fadeOut();
                            }, 3000);
                        } else {
                            // Handle error (this block may not be necessary if you don't expect specific errors)
                            alert('Error updating profile.');
                        }
                        // Close the modal using Bootstrap's API
                        $('#editaccountmodal').modal('hide');
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let errors = xhr.responseJSON.errors;
                            let errorMsg = '';
                            for (let key in errors) {
                                errorMsg += errors[key].join(', ') + '<br>';
                            }
                            $('#errormsg').html('<div class="alert alert-danger">' + errorMsg +
                                '</div>'); // Display the error messages
                        } else {
                            $('#errormsg').html(
                                '<div class="alert alert-danger">An error occurred. Please try again.</div>'
                            ); // Display a fallback error message
                        }
                    }
                });
            });
        });
    </script>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            // Event listener for remove wishlist button
            $('.remove-wishlist-btn').on('click', function(e) {
                e.preventDefault();



                // Get product and variant ID from the button data attributes
                var button = $(this);
                var productId = button.data('product-id');


                var productVariantsId = button.data('product_variants-id');





                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Do you want to remove this item from your wishlist?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, remove it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // AJAX request to remove item from the wishlist
                        $.ajax({
                            url: '{{ route('wishlist.remove') }}',
                            method: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                product_id: productId,
                                product_variants_id: productVariantsId
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Remove the product card from the DOM
                                    button.closest('.card').remove();

                                    // Update the wishlist count in the DOM
                                    $('.wishlist-count').text(response
                                        .wishlistCount
                                    ); // Assuming you have a span or element with class 'wishlist-count' for displaying the count

                                    // SweetAlert success message
                                    Swal.fire(
                                        'Removed!',
                                        'The item has been removed from your wishlist.',
                                        'success'
                                    );
                                } else {
                                    // SweetAlert error message
                                    Swal.fire(
                                        'Error!',
                                        'Failed to remove the item from your wishlist.',
                                        'error'
                                    );
                                }
                            },
                            error: function() {
                                // SweetAlert error message
                                Swal.fire(
                                    'Error!',
                                    'Something went wrong. Please try again.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@endpush
