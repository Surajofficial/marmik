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
            <h6>Total : <span id="total_amount"></span></h6>
            <div class="row">
                <div class="col-lg-12 p-0">
                    <a href="{{ route('stocks.buy') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Create Invoice</a>


                </div>

            </div>

        </div>
        <div class="col-12">
            <div class="row">
                <div class="col-3">
                    <label for="from_date">From Date:</label>
                    <input class="form-control w-100 " type="date" id="from_date">
                </div>
                <div class="col-3">
                    <label for="to_date">To Date:</label>
                    <input class="form-control w-100" type="date" id="to_date">
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
                                <th>Amount</th>
                                <th>Create At</th>
                                <th>Invoice Number</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

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

            function formatDate(date) {
                const day = String(date.getDate()).padStart(2, '0'); // Get day and pad with leading zero
                const month = String(date.getMonth() + 1).padStart(2, '0'); // Get month (0-11) and pad
                const year = String(date.getFullYear()).slice(-2); // Get last two digits of the year
                const hours = String(date.getHours()).padStart(2, '0'); // Get hours and pad
                const minutes = String(date.getMinutes()).padStart(2, '0'); // Get minutes and pad
                const seconds = String(date.getSeconds()).padStart(2, '0'); // Get seconds and pad

                return `${day}/${month}/${year} ${hours}:${minutes}:${seconds}`;
            }
            var daily_invoice_data = $('#product-dataTable').DataTable({
                "columnDefs": [{
                    "orderable": true,
                    "targets": [1]
                }],
                "processing": true,
                searching: false,
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.offline.invoice.show') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                            'content') // Ensure you have the CSRF token set in your HTML
                    },
                    "type": "POST", // Change to POST
                    "deferLoading": 0,
                    data: function(d) {
                        d.from_date = $('#from_date').val();
                        d.to_date = $('#to_date').val();
                    },
                    "dataSrc": function(json) {
                        // Set the total in your UI
                        $('#total_amount').text(json.total); // Display the total

                        return json.data; // Return the original data for DataTable
                    }
                },
                "columns": [{
                    data: 'id'
                }, {
                    data: 'customer_name'
                }, {
                    data: 'customer_phone'
                }, {
                    data: 'customer_email'
                }, {
                    data: 'total_amount'
                }, {
                    data: function(data) {
                        const date = new Date(data.created_at);

                        return formatDate(date);
                    }
                }, {
                    data: 'invoice_no'
                }, {
                    data: function(data) {
                        url = "{{ route('stocks.generateInvoiceShow', '::id::') }}".replace(
                            '::id::', data.invoice_no)
                        return `<a href="${url}" class="btn btn-success">View</a>`;
                    },
                }]
            });
            $('#from_date, #to_date').on('change', function() {
                daily_invoice_data.ajax.reload();
            });
        })
    </script>
@endpush
