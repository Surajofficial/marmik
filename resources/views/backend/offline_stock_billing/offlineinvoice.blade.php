@extends('backend.layouts.master')

@section('main-content')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Invoice Lists</h6>
            <div class="row">
                <div class="col-lg-12 p-0">
                    <a href="{{ route('stocks.buy') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Create Invoice</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count(@$invoiceData) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Customer Name</th>
                                <th>Mobile</th>
                                <th>Email</th>
                                <th>Create At</th>
                                <th>Invoice Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($invoiceData as $invoice)
                                <tr data-center-id="{{ @$invoice->id }}">
                                    <td>{{ $invoice->id }}</td>
                                    <td>{{ @$invoice->customer_name }}</td>
                                    <td>{{ $invoice->customer_phone }}</td>
                                    <td>{{ $invoice->customer_email }}</td>
                                    <td>{{ $invoice->created_at }}</td>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>
                                        <a href="{{ route('stocks.generateInvoiceShow', $invoice->invoice_no) }}"
                                            class="btn btn-success">View</a>
                                        <a href="{{ route('stocks.generateInvoiceShow', $invoice->invoice_no) }}"
                                            class="btn btn-info">Edit</a>
                                        <a href="{{ route('stocks.trashInvoice', $invoice->id) }}"
                                            class="btn btn-danger" onclick="return confirm('Are you sure you want to trash this invoice?');">Trash</a>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No Invoice found!!! Please create Invoice</h6>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Reset date inputs
            $('#start_date').val('');
            $('#end_date').val('');

            var table = $('#product-dataTable').DataTable({
                "columnDefs": [{
                    "orderable": true,
                    "targets": [1]
                }]
            });
        })
    </script>
@endpush
