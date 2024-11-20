<!DOCTYPE html>
<html>

<head>
    <style>
        #header_tables .table>:not(caption)>*>* {
            padding: .2rem .1rem !important;
        }

        .header p {
            margin: 0 10px;
        }

        * {
            box-sizing: content-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f8f8;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        @media print {
            .table {
                page-break-inside: avoid;
            }

            .table tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .table td,
            .table th {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }

        .table {
            margin-bottom: 0 !important;
        }

        #header_tables td {
            font-size: 10px;
            border: 1px solid #000;
        }

        #header_tables th {
            font-size: 10px;
            border: 1px solid #000;
        }

        #table_product td {
            font-size: 10px;
            border: 1px solid #000;
            max-width: 15px;
            padding: 0;
            hyphens: auto;
        }

        #table_product th {
            font-size: 10px;
            border: 1px solid #000;
        }

        #tax_total td {
            font-size: 10px;
            padding: 0.5 rem !important;
        }

        #tax_total th {
            font-size: 12px;
            padding: 0.5 rem !important;
        }

        @media only screen and (max-width: 800px) {
            body {
                padding: 0;
            }

            .invoice-container {
                position: fixed;
                width: 100% !important;
            }

            #header_tables {
                width: auto;
                overflow: hidden;
            }
        }
    </style>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Invoice No {{ 927 }}</title> --}}
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
</head>

<body class="invoice-container">
    <div class="border border-dark">
        <h6 class="text-center border-bottom  border-dark " style="background-color:#C0C0C0;">PROFORMA INVOICE</h6>
        <div class="col-12 header text-center">
            <h4 class="text-center" style="text-align:center;"><b>NIDUS PHARMA PVT LTD</b></h4>
            <b style="text-align:center;">GROUND FLOOR, 1/51 KANAKPURA, RIICO INDUSTRIAL AREA, SIRSI ROAD
                JAIPUR.-302034</b><br />
            <b style="text-align:center;">Phone No.: 9529479308 Mobile No.: 9529479308 Email : niduspharma@gmail.com</b>
        </div>
        <div class="col-12 ms-2">
            <b class="">GSTIN: 08AABCN9364Q1ZM, Registered State: Rajasthan, 08</b>
        </div>
        <div class="border-top border-dark " id="header_tables" style="font-size: 0.7rem;">
            <div class="row">
                <div class="col me-0 pe-0 border-end border-dark">
                    <p>
                        <small>
                            To, <br>
                            <b class="ms-1">DR AWISH</b>
                            <p class="ms-1">AWISH SKIN & HAIR CLINIC, J-232, SARITA VIHAR <br />NEW DELHI-110076,
                                Delhi, 07</p>
                            <b class="ms-1">Phone No.:</b> 9711948720<b class="ms-3">Mobile:</b> 9365749188,
                            7084746942<br />
                        </small>
                    <div class="border-top border-dark mt-1">
                        <small>
                            <b class="ms-1">State </b> : Delhi, 07<br />
                            <b class="ms-1">GSTIN </b> : 07CJQPR9719A1ZR, Registered<br />
                            <b class="ms-1">D.L.No.</b> : R.NO.DMC/R/14917, IADVL REG NO.ND/10063<br />
                        </small>
                    </div>
                    </p>
                </div>
                <div class="col me-0 ms-auto ps-0">
                    <small>
                        <div class="row border-bottom border-dark  m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">Proforma Invoice</b>
                            <p class="col">: JPP28409</p> <b class="col">Date</b>
                            <p class="col">: 27-03-2024</p>
                        </div>
                        <div class="row border-bottom border-dark p-0 m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">Transport Name</b>
                            <p class="col">: TRACKON PAID </p>
                        </div>
                        <div class="row border-bottom border-dark p-0 m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">Total Cases</b>
                            <p class="col">: </p> <b class="col">Weight</b>
                            <p class="col">: </p>
                        </div>
                        <div class="row border-bottom border-dark p-0 m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">L.R. No.</b>
                            <p class="col">: </p> <b class="col">L.R. Date</b>
                            <p class="col">: </p>
                        </div>
                        <div class="row border-bottom border-dark p-0 m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">Dispatch To</b>
                            <p class="col">: </p>
                        </div>
                        <div class="row border-bottom border-dark p-0 m-0 " style="height: 1rem">
                            <b class="col-4 ms-1">Terms</b>
                            <p class="col">: </p> <b class="col">Due Date</b>
                            <p class="col">: </p>
                        </div>
                        <br>
                        <b class="text-danger ms-2">Bank Name : Axis Bank A/C No : 92302003 1844567</b><br /><b
                            class="text-danger ms-2"> Branch : 13 LNP SRIGANGANAGAR NEFT IFSC CODE : UTIB0005131</b>
                </div>
            </div>
        </div>
        <table class="table" id="table_product" style="overflow-x:auto;">
            <thead style="background-color:#C0C0C0;" class="text-white">
                <tr>
                    <td scope="col">Sr</td>
                    <td scope="col">Desc. of Goods</td>
                    <td scope="col">Pack</td>
                    <td scope="col">HSN</td>
                    <td scope="col">Batch No.</td>
                    <td scope="col">Exp. Dt</td>
                    <td scope="col">Qty</td>
                    <td scope="col">Q. Dis</td>
                    <td scope="col">M.R.P.</td>
                    <td scope="col">P.T.S.</td>
                    <td scope="col">CD%</td>
                    <td scope="col">Rate</td>
                    <td scope="col">Disc. %</td>
                    <td scope="col">Disc. Amt</td>
                    <td scope="col">GST%</td>
                    <td scope="col">Basic Amt</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->carts as $item)
                    <tr>
                        <td scope="row">{{ $loop->index + 1 }}</td>
                        <td class="quantity">{{ $item->quantity }}</td>
                        @php
                            $product = $item->product;
                        @endphp
                        <!-- <td class="size">
                        1X{{ $product->size != null ? $size["$product->size"] : 'Not Given' }}
                        {{-- {{ $product->size }} --}}
                    </td> -->
                        <td class="title">{{ $product->title }}</td>
                        <td class="hsn_no">{{ $product->hsn_no != null ? $product->hsn_no : 'Not Given' }}</td>
                        <td class="batch_no">{{ $product->batch_no != null ? $product->batch_no : 'Not Given' }}</td>
                        <td class="expiry">{{ $product->expiry != null ? $product->expiry : 'Not Given' }}</td>
                        <td class="quantity">{{ $product->quantity != null ? $product->quantity : 'Not Given' }}</td>
                        <td class="quantity_discount">
                            {{ $product->quantity_discount != null ? $product->quantity_discount : 'Not Given' }}</td>
                        <td class="price">{{ $product->price != null ? $product->price : 'Not Given' }}</td>
                        <td class="pts">{{ $product->pts != null ? $product->pts : 'Not Given' }}</td>
                        <td class="cd">{{ $product->cd != null ? $product->cd : 'Not Given' }}</td>
                        <td class="rate">{{ $product->rate != null ? $product->rate : 'Not Given' }}</td>
                        <td class="discount">
                            {{ $product->orignalAmount != 0 ? 100 - ($product->amount * 100) / $product->orignalAmount : 0 }}
                        </td>
                        <td class="amount">{{ $product->orignalAmount ?? 'not given' }}</td>
                        <td class="gst">{{ $product->gst != null ? $product->gst : 'Not Given' }}</td>
                        <td class="basic_amount">
                            {{ $product->basic_amount != null ? $product->basic_amount : 'Not Given' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class=" mt-0 border-bottom border-dark" id="">
            <div class="row">
                <div class="col-4 ms-2 me-0 pe-0">
                    <small>D.L. No. : 20B/44740, 21B/44741<br />
                        <b class="mt-2">Message :</b><br />
                        <b class="mt-2">Terms :</b> <br />
                        <small>
                            Interest @ 24% p.a. will be charged after 30 days.<br />
                            Goods onces sold will not be taken back or exchanged.<br />
                            Our responsibility ceases as goods leave our place.<br />
                            ₹ : One Thousand One Hundred Seventy-Six Only <br />
                        </small>
                    </small>
                </div>
                <div class="col-3 me-0 mt-2">
                    <small>
                        <table class="">
                            <tr class="border-top border-bottom border-dark">
                                <th>Tax Type</th>
                                <th>Taxable Value</th>
                                <th>IGST %</th>
                                <th>Value</th>
                            </tr>
                            <tr class="border-top border-dark">
                                <td>GST {{ $totals->total_cgst }}</td>
                                <td>{{ $totals->total_tax }}</td>
                                <td>{{ $totals->total_sgst }}</td>
                                <td>{{ $totals->total_tax + $totals->total_cgst + $totals->total_sgst }}</td>
                            </tr>
                            <tr class="border-top border-bottom border-dark">
                                <th>Total</th>
                                <th>{{ $totals->total_tax }}</th>
                                <th>{{ $totals->total_sgst }}</th>
                                <th>{{ $totals->total_tax + $totals->total_cgst + $totals->total_sgst }}</th>
                            </tr>
                        </table>
                    </small>
                </div>
                <div class="col-3 ms-auto border-start border-dark me-0">
                    <div class="row border-bottom border-dark me-0 pe-0">
                        <div class="col border-end border-dark ps-1 pe-0 me-0 ">
                            <b>Gross Amt.</b><br />
                            FREIGHT
                        </div>
                        <div class="col text-end ps-0 pe-0 me-0 ms-0 ">
                            <b>10000</b><br />
                            0.00<br />
                            0.00
                        </div>
                    </div>
                    <div class="row border-bottom border-dark me-0 pe-0">
                        <div class="col border-end border-dark ps-1 pe-0 me-0 pb-2 ">
                            <b>Taxable Amount</b><br />
                            IGST Value
                        </div>
                        <div class="col text-end ps-0 pe-0 me-0 ms-0 ">
                            10000<br />
                            0.00
                        </div>
                    </div>
                    <div class="row border-bottom border-dark me-0 pe-0">
                        <div class="col border-end border-dark ps-1 pe-0 me-0 ">
                            <b>Total</b>
                        </div>
                        <div class="col text-end ps-0 pe-0 me-0 ms-0 ">
                            10000
                        </div>
                    </div>
                    <div class="row me-0 pe-0">
                        <div class="col border-end border-dark text-bottom ps-1 pe-0 me-0 ">
                            <b>Rounding</b>
                        </div>
                        <div class="col text-end ps-0 pe-0 me-0 ms-0 ">
                            0.00<br />
                            0.00
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row border-bottom border-dark m-0 me-0 pe-0">
            <div class="col-4 ms-2 me-0 pe-0">AMount in words</div>
            <div class="col-3 me-0"></div>
            <div class="col-3 ms-auto pe-0 me-0">
                <div class="row me-0 pe-0">
                    <div class="col text-bottom ps-2 pe-0 me-0 ">
                        <b>Net Amount</b>
                    </div>
                    <div class="col text-end ps-0 pe-0 me-0 ms-0 ">
                        10000
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="text-end"><b>For, NIDUS PHARMA PVT LTD</b></div>
            <small>
                <div class="row mt-5 align-items-end">
                    <div class="col pb-0 mb-0">
                        <b class="align-baseline">
                            Subject to JAIPUR. Jurisdiction only.<br />
                            Pending Outstanding : 81872.00
                        </b>
                    </div>
                    <div class="col">
                        <b>
                            <div class="row">
                                <div class="col">Net Amt.</div>
                                <div class="col"> : </div>
                                <div class="col text-end"> 1000</div>
                            </div>
                            <div class="row">
                                <div class="col">Previous Oustanding</div>
                                <div class="col"> : </div>
                                <div class="col text-end">89889</div>
                            </div>
                            <div class="row">
                                <div class="col border-top border-dark">-</div>
                                <div class="col border-top border-dark"> : </div>
                                <div class="col border-top border-dark text-end">89889</div>
                            </div>
                        </b>
                    </div>
                    <div class="col text-end me-2" style="padding-bottom: 0"><b>Authorised Signatory</b></div>
                </div>
            </small>
        </div>
    </div>
</body>

</html>
