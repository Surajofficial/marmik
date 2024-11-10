<!DOCTYPE html>
<html>

<head>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
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

        td {
            font-size: 10px;
            border: 1px solid #000;
        }

        th {
            font-size: 10px;
            border: 1px solid #000;
            background-color: #C0C0C0;
        }

        /* td {
            font-size: 10px;
            border: 1px solid #000;
            max-width: 15px;
            padding: 0;
            hyphens: auto;
        }

        #table_product th {
            font-size: 10px;
            border: 1px solid #000;
        } */
    </style>
</head>

<body>
    <div class="container">
        <div class="invoice">
            <div class="row m-4 pb-5">
                <div class="col-4">
                    <img class="col-6 " src="{{ asset('/storage/photos/black2.png') }}" alt="Awish Logo">
                </div>
                <div class="col-8  text-end">
                    <b>Tax Invoice/Bill of Supply/Cash Memo<br /></b>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="details">
                        <small>
                            <b>Sold By:</b>
                            <p>{{ $settings->name }}<br />
                                {{ $settings->address }}<br />
                            <div class="mt-auto">
                                <b>GST:</b> {{ $settings->gst }}<br />
                                <b>Order Number:</b> {{ $order->order_number }}<br />
                                <b>Order Date:</b> {{ $order->created_at->format('D d M, Y') }}</p>
                            </div>
                        </small>
                    </div>
                </div>

                <div class="col-6">
                    <div class="details text-end">
                        <small>
                            @if ($billing)
                                <b>Billing Address:</b>
                                {{ $billing->first_name }}{{ $billing->last_name }}<br />
                                {{ $billing->address1 }} {{ $billing->address2 }}<br />
                                {{ $billing->state }} {{ $billing->city }}
                                IN<br />
                            @endif
                            @if ($shipping)
                                <p><b>Shipping Address:</b>
                                    {{ $shipping->first_name }}{{ $shipping->last_name }}<br />
                                    {{ $shipping->address1 }} {{ $shipping->address2 }}<br />
                                    {{ $shipping->state }} {{ $shipping->city }}
                                    IN<br />
                                </p>
                            @endif

                        </small>
                    </div>
                </div>


            </div>
            <div class="table-container mt-3">
                <table style="width: 100%">
                    <thead>
                        <tr>
                            <th>SI. No</th>
                            <th>Product Name</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Qty</th>
                            <th>SGST</th>
                            <th>CGST</th>
                            <th>Other Tax</th>
                            <th>Total Tax Amount</th>
                            <th>Total Cost</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $total_amount = 0;
                        @endphp
                        @foreach ($order->cart_info as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->product->product->title }}</td>
                                <td>₹{{ $item->product->price }}</td>
                                <td>{{ $item->product->discount }}%</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ $item->product->product->sgst }}%</td>
                                <td>{{ $item->product->product->cgst }}%</td>
                                <td>{{ $item->product->product->tax }}%</td>
                                <td> ₹{{ $item->cgst + $item->sgst + $item->tax }}</td>
                                <td> ₹{{ $item->product->price * $item->quantity }}</td>
                                <td> ₹{{ ($item->product->price - ($item->product->price * $item->product->discount) / 100) * $item->quantity }}
                                </td>
                            </tr>
                            @php
                                $total +=
                                    ($item->product->price - ($item->product->price * $item->product->discount) / 100) *
                                    $item->quantity;
                                $total_amount += $item->product->price * $item->quantity;
                            @endphp
                        @endforeach

                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9" class="total">TOTAL:</td>
                            <th class="total">₹{{ $totals->total_amount }}</th>
                            <th class="total">₹{{ $totals->total_payble }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div>
                <div class="footer border border-dark">
                    <b>
                        Amount in Words:
                        <span class="text-capitalize">{{ $number_toword }}</span>
                    </b>
                </div>
                <div class="signature border border-dark text-end p-3">
                    <b>{{ $settings->name }}<br />
                        <br />
                        Authorized Signatory</b>
                </div>
            </div>

        </div>
    </div>
</body>

</html>
