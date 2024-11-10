@extends('backend.layouts.master')


{{-- color : #8da5ff --}}
@push('styles')
    <link href="../backend/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="../backend/css/app.min.css" rel="stylesheet" type="text/css">
@endpush
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-center">
                        <h6 class="mb-sm-0" style="font-weight: 600">TAX INVOICE</h6>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            @php
                $settings = DB::table('settings')->get();
            @endphp
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp
                    <div class="card" id="demo">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-header p-4" style="background: #fff !important;border:1px solid #ccc">
                                    <div class="d-sm-flex">
                                        <div class="flex-grow-1">
                                            <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach"
                                                class="card-logo card-logo-dark" alt="logo" height="80" />
                                            {{-- <img src="{{ asset('images/DrAwish.png')}}" class="card-logo card-logo-dark" alt="logo" width="200px" height="150"> --}}
                                        </div>
                                        <div class="flex-shrink-0 mt-sm-0 mt-3 text-right">
                                            <h4 class="font-weight-bold">Awish Clinic</h4>
                                            <h6 id="billing-name" class="text-color m-0">
                                                @foreach ($settings as $data)
                                                    {{ $data->address }}
                                                @endforeach
                                            </h6>
                                            <p class="mb-1 text-color"><span>Phone: </span><span id="billing-phone-no">
                                                    @foreach ($settings as $data)
                                                        {{ $data->phone }}
                                                    @endforeach
                                                </span><br />
                                                <span class="text-color">Timing : 10:00am - 8:00pm</span> <br>
                                                {{-- @foreach ($settings as $data) {{$data->email}} @endforeach</span><br/> --}}
                                            </p><br>


                                            GSTIN : @foreach ($settings as $data)
                                                {{ $data->gst }}
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <!--end card-header-->
                            </div><!--end col-->
                            <div class="col-lg-12">
                                <div class="card-body" style="padding:0; !important">
                                    <div class="row g-3" style="width: 100%; margin-left: 0px;">
                                        <div class="col-lg-8 " style="padding: 0;border:1px solid #ccc">
                                            <p class="text-white text-uppercase fw-medium fs-12 back-color"
                                                style="padding: .5rem; margin-bottom:0px;"><b>Bill To:</b></p>
                                            <div class="cust_detail">
                                                <h6 class="fs-14 mb-0">Name: {{ $invoiceData['customer_name'] ?? '' }}</h6>
                                                @if (!empty($invoiceData['customer_email']))
                                                    <h6 class="fs-14 mb-0">Email: {{ $invoiceData['customer_email'] ?? '' }}
                                                    </h6>
                                                @endif
                                                <h6 class="fs-14 mb-0">Phone: {{ $invoiceData['customer_phone'] ?? '' }}
                                                </h6>
                                                <h6 class="fs-14 mb-0">Address: {{ $invoiceData['customer_address'] ?? '' }}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="col-lg-4" style="padding: .5rem 1rem; border:1px solid #ccc">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <h6 class="fs-14 ">Invoice No. </h6>
                                                    </td>
                                                    <td>
                                                        <h6 style="padding-left: 15px">:
                                                            &nbsp;{{ $invoiceData['invoice_no'] }}</h6>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6 class="fs-14 ">Date </h6>
                                                    </td>
                                                    <td>
                                                        <h6 style="padding-left: 15px">:
                                                            &nbsp;{{ date('d-m-Y', strtotime($invoiceData['invoice_date'])) }}
                                                        </h6>
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>

                                        <!--end col-->
                                    </div>
                                    <!--end row-->
                                </div>
                                <!--end card-body-->
                            </div><!--end col-->

                            <div class="col-lg-12">
                                <div class="card-body m-0">
                                    <div class="table-responsive" style="border:1px solid #ccc; height:500px;">
                                        <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                            <thead>
                                                <tr class="back-color">
                                                    <th scope="col">S.No.</th>
                                                    <th scope="col">PARTICULARS</th>
                                                    <!-- <th scope="col">Batch No.</th> -->
                                                    <th>HSN/SAC</th>
                                                    <th scope="col">QUANTITY</th>
                                                    {{-- <th scope="col">UNIT PRICE and discount</th> --}}
                                                    <th scope="col">UNIT PRICE</th>
                                                    <th scope="col">DISCOUNT PRICE </th>
                                                    <!-- <th scope="col">CGST (%)</th>
                                                                                <th scope="col">SGST (%)</th> -->
                                                    <th>GST</th>
                                                    <!-- <th scope="col">CGST Amount (INR)</th>
                                                                                <th scope="col">SGST Amount (INR)</th> -->
                                                    <th>AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody id="products-list">
                                                @foreach ($invoiceData['products'] as $productId => $product)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td style="text-align: left">{{ $product['name'] }}</td>
                                                        <!-- <td>{{ $product['batch_no'] ?? 'N/A' }}</td> -->
                                                        <td></td>
                                                        <td>{{ $product['quantity'] }}</td>
                                                        {{-- <td>&#8377;{{ number_format($product['original_price'], 2) }} <br>
                                                            -Disc: {{ $product['discount_percentage'] }} %
                                                        </td> --}}
                                                        <td><strong>&#8377;{{ number_format($product['original_price'], 2) }} <br></strong></td>
                                                        <td>
                                                            @php
                                                                $discountAmount = ($product['original_price'] * $product['discount_percentage']) / 100;
                                                            @endphp
                                                            <strong> &#8377;{{ number_format($discountAmount, 2) }}</strong>
                                                        </td>
                                                        <!-- <td>{{ number_format($product['cgst_rate'], 2) }}%</td>
                                                            <td>{{ number_format($product['sgst_rate'], 2) }}%</td>
                                                            <td>{{ number_format($product['cgst_amount'], 2) }}</td>
                                                            <td>{{ number_format($product['sgst_amount'], 2) }}</td> -->
                                                        <td>{{ number_format($product['cgst_rate'], 2) }}%</td>
                                                        <td class="text-end">&#8377; {{ number_format($product['sub_total'], 2) }}
                                                        </td>
                                                        <!-- <td class="text-end">{{ number_format($product['total_price'], 2) }}</td> -->

                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="row border-top" style="margin: 0 !important; margin-bottom:0px; ">
                                        <div class="col-lg-7" style="border:1px solid #ccc">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <p class="mt-2 p-2 mb-5 text-color"><b>Delevery Terms:</b></p>
                                                </div>
                                                <div class="col-lg-6">
                                                    <p class="mt-2 p-2 text-right">Total Qty :
                                                        {{ $invoiceData['total_quantity'] }}</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12 p-0">
                                                    <p class="back-color p-2 text-white">Amount in Words :</p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h6 class="text-color">
                                                        <span>{{ Helper::inwords( floor($invoiceData['sub_total']) ) }}</span>
                                                        Rupees Only
                                                    </h6>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-lg-12 p-0">
                                                    <p class="back-color p-2 text-white">Terms / Declaration :</p>
                                                </div>
                                                <div class="col-lg-12">
                                                    <h6><span>Terms and conditions here...</span> </h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 pt-3" style="border:1px solid #ccc">
                                            <div class="row">
                                                <div class="col-lg-6 text-color font-weight-bold">Sub Total :</div>
                                                <div class="col-lg-6 text-right text-color font-weight-bold">₹
                                                    {{ number_format($invoiceData['sub_total'], 2) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 ft">Add CGST :</div>
                                                <div class="col-lg-6 ft text-right">₹
                                                    {{ number_format($invoiceData['total_cgst'], 2) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 ft">Add SGST :</div>
                                                <div class="col-lg-6 ft text-right">₹
                                                    {{ number_format($invoiceData['total_sgst'], 2) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 ft">Round Off(-) :</div>
                                                <div class="col-lg-6 ft text-right">₹
                                                    {{ number_format($invoiceData['sub_total'] - floor($invoiceData['sub_total']), 2) }}
                                                </div>
                                            </div>
                                            <div class="row back-color mt-5">
                                                <div class="col-lg-6 p-2 text-white">Total (INR) :</div>
                                                <div class="col-lg-6 text-right p-2 text-white">₹
                                                    {{ floor($invoiceData['sub_total']) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6 p-2">Amount Paid :</div>
                                                <div class="col-lg-6 text-right p-2">₹
                                                    {{ floor($invoiceData['sub_total']) }}</div>
                                            </div>


                                            <!-- <tr class="table">
                                                    <th>Balance :</th>
                                                    <td class="text-end">
                                                        <span class="fw-semibold cart-total">₹ 0.00</span>
                                                    </td>
                                                </tr> -->

                                            <p class="mt-5 pt-5 text-right" style="margin-bottom: 0px !important;"><b>For,
                                                    Dr Awish</b></p>
                                        </div>
                                    </div>


                                    <div class="hstack gap-2 justify-content-end ">
                                        <button id="print" onclick="invoice()" class="btn btn-primary"><i
                                                class="ri-download-2-line align-bottom me-1"></i> Print</button>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

    <style>
        .cust_detail {
            padding: .8em;
        }

        .cust_detail h6 {
            padding: .5rem;
        }

        .text-color {
            color: #555555;
            font-weight: 600;
        }

        .back-color {
            background: #212120;
        }

        .back-color th {
            color: #fff;
            border: 1px solid #ccc !important;
        }

        .card-body {
            padding: 0 !important;
        }

        tbody .box-list {
            min-height: 20rem;
        }

        .ft {
            font-size: 12px;
        }

        /* Main layout styling */
        .page-title-box {
            background-color: #f7f7f7;
            border-bottom: 2px solid #e0e0e0;
            padding: 15px;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .table-active {
            background-color: #e9ecef;
            font-weight: bold;
        }

        /* Styling for borders and text alignment */
        .table-borderless th,
        .table-borderless td {
            padding: 10px;
            border: none;
        }

        .table-borderless td.text-end {
            text-align: right;
        }

        /* Print Styles */
        @media print {
            body {
                font-family: Arial, sans-serif;
                -webkit-print-color-adjust: exact;
                /* Ensure colors are preserved */
                color-adjust: exact;
            }

            .col-lg-8 {
                width: 66.67%;
                float: left;
            }

            .col-lg-4 {
                width: 33.33%;
                float: left;
            }

            .col-lg-7 {
                width: 58.33%;
                float: left;
            }

            .col-lg-5 {
                width: 41.67%;
                float: left;
            }

            .col-lg-6 {
                width: 50%;
                float: left;
            }

            td h6 {
                font-size: 12px !important;
            }

            /* Ensure colors are printed */
            .page-title-box,
            .card-header,
            .table-active {
                background-color: #f7f7f7 !important;
                color: #000 !important;
            }

            .table-active {
                background-color: #e9ecef !important;
            }

            .card {
                border: 1px solid #dee2e6;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                border: 1px solid #ddd;
                border: none;
            }

            th,
            td {
                padding: 12px;
                border: 1px solid #ddd;
                border: none !important;
            }

            /* Ensuring color and background color are kept */
            .table thead th {
                background-color: inherit !important;
                color: #fff;
                border: none;
            }

            /* Ensure no element hides during print */
            #accordionSidebar,
            .navbar,
            .footer,
            .breadcrumb,
            .page-title-right {
                display: none;
            }

            /* Force table borders to be consistent */
            .table-borderless th,
            .table-borderless td {
                border: 1px solid #ddd;
            }

            p,
            span,
            td,
            th {
                font-size: 12px;
                color: #000;
            }

            .text-end {
                text-align: right !important;
            }

            button,
            a {
                display: none !important;
            }
        }
    </style>
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        function invoice() {
            $("#accordionSidebar, .navbar, #print, .footer, .breadcrumb, .page-title-right").hide();
            window.print();
            setTimeout(function() {
                $("#accordionSidebar, .navbar, #print, .footer, .breadcrumb, .page-title-right").show();
            }, 1000);
        }
    </script>
@endpush
