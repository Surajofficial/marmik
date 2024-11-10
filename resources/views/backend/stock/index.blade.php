@extends('backend.layouts.master')

@section('main-content')
    <!-- Modal -->
    <div class="modal fade" id="batchModal" tabindex="-1" role="dialog" aria-labelledby="batchModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="batchModalLabel">Manage Stock</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="batchForm">
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="mt-2" for="city">City</label>
                            <select name="search-city" id="search-city" class="form-control">
                                <option value="">Select City Here...</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                                @endforeach
                            </select>
                            <label class="mt-2" for="batch_no">Batch Number</label>
                            <input type="text" class="form-control" name="search-batch" id="search-batch"
                                placeholder="Enter Batch Number">
                            <button type="submit" name="batch-submit" id="batch-submit"
                                class="btn btn-primary mt-2 text-right">Search</button>

                        </div>

                        {{-- Batch data show --}}
                        <div id="stockDetails" style="display: none;">
                            <hr>
                            <h4>Product Details</h4>
                            <p><strong>Title:</strong> <span id="product-title"></span></p>
                            <p><strong>Center Name:</strong> <span id="center-name"></span></p>
                            <p><strong>Batch Number:</strong> <span id="batch-number"></span></p>
                            <p><strong>Current Stock:</strong> <span id="current-stock"></span></p>
                            <p><strong>Expiry Date:</strong> <span id="expiry-date"></span></p>
                            <div id="stockAction" style="margin-top: 10px;">
                                <button type="button" class="btn btn-success" id="add-stock-confirm">Add Stock</button>
                                <button type="button" class="btn btn-danger" id="remove-stock">Remove Stock</button>
                            </div>
                            <input type="number" id="add-stock-quantity" placeholder="Enter stock to add or remove"
                                class="form-control mt-2">

                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                        <div id="error" class="text-danger"></div>
                        <div id="success" class="text-success"></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary float-left">Stocks Lists</h6>
            <div class="row">
                <div class="col-lg-5 p-0">
                    <a href="{{ route('stocks.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                        data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Stocks</a>
                </div>
                <div class="col-lg-7">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#batchModal">
                        Manage Stock
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="filter-date">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="start_date">Start Date:</label>
                            <input type="date" id="start_date" class="form-control mb-2" />
                        </div>
                        <div class="col-md-3">
                            <label for="end_date">End Date:</label>
                            <input type="date" id="end_date" class="form-control mb-2" />
                        </div>

                        <div class="col-md-3">
                            <label for="select_center">Center:</label>
                            <select name="" id="select_center" class="form-control mb-2">
                                <option value="">Select Center</option>
                                @foreach ($centers as $center)
                                    <option value="{{ $center->id }}">{{ $center->center_name }}</option>
                                @endforeach
                            </select>


                        </div>
                    </div>
                </div>


                @if (count(@$stocks) > 0)
                    <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S.N.</th>
                                <th>Product Name</th>
                                <th>Center Name</th>
                                <th>Batch Number</th>
                                <th>Stock</th>
                                <th>Expiry Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr data-center-id="{{ @$stock->center->id }}">
                                    <td>{{ $stock->id }}</td>
                                    <td>{{ @$stock->product->title }} {{ @$stock->strep->title }}</td>
                                    <td>{{ @$stock->center->center_name }}</td>
                                    <td>{{ $stock->batch_no }}</td>
                                    <td>{{ $stock->stock }}</td>
                                    <td>{{ $stock->expiry }}</td>
                                    <td>
                                        <a href="{{ route('stocks.edit', $stock->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('stocks.destroy', [$stock->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $stock->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No Products found!!! Please create Product</h6>
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

            // Combined date and center filtering logic
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    var startDate = $('#start_date').val();
                    var endDate = $('#end_date').val();
                    var expiryDate = data[5]; // Assuming expiry date is in the 6th column (0-indexed)
                    var selectedCenter = $('#select_center').val();
                    var rowCenterId = $(table.row(dataIndex).node()).data('center-id');

                    // Date filtering
                    var dateMatch = (startDate === "" && endDate === "") ||
                        (startDate === "" && expiryDate <= endDate) ||
                        (startDate <= expiryDate && endDate === "") ||
                        (startDate <= expiryDate && expiryDate <= endDate);

                    // Center filtering
                    var centerMatch = selectedCenter === "" || rowCenterId == selectedCenter;

                    return dateMatch && centerMatch;
                }
            );

            // Event listeners for date inputs and center select input
            $('#start_date, #end_date, #select_center').change(function() {
                table.draw();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#batchForm').on('submit', function(e) {
                e.preventDefault();
                var cityId = parseInt($('#search-city').val());
                var batchNumber = $('#search-batch').val();
                // console.log(cityId);
                if (batchNumber != "" && cityId) {
                    $.ajax({
                        url: '{{ route('stock.getByBatch') }}',
                        type: 'POST',
                        data: {
                            cityId: cityId,
                            batch_number: batchNumber,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.length > 0) {

                                var stock = response[0];
                                // console.log(stock);

                                $('#product-title').text(stock.product && stock.product.title ?
                                    stock.product.title : 'null');
                                $('#center-name').text(stock.center && stock.center
                                    .center_name ? stock.center.center_name : 'null');
                                $('#batch-number').text(stock.batch_no ? stock.batch_no :
                                    'null');
                                $('#current-stock').text(stock.stock ? stock.stock : 'null');
                                $('#expiry-date').text(stock.expiry ? stock.expiry : 'null');

                                $('#stockDetails').show();

                            } else {
                                // No stock found
                                $('#stockDetails').hide();
                                $('#error').text('No stocks found for this batch number!')
                                    .show();
                                errorHide();
                            }

                            $('#batchModal').modal('show');

                            $('#batchModal').on('hidden.bs.modal', function() {
                                window.location.reload();
                                $('#search-batch').val('');
                                $('#stockDetails').hide();

                                $('#product-title').text('null');
                                $('#center-name').text('null');
                                $('#batch-number').text('null');
                                $('#current-stock').text('null');
                                $('#expiry-date').text('null');

                            });
                            // $('#batch-submit').prop('disabled', false);

                        },
                        error: function(xhr) {
                            console.error('Error:', xhr);
                        }
                    });
                } else {
                    $('#error').html("Please first fill the field.");
                    errorHide();
                }

            });

            // Add Stock Logic
            $('#add-stock-confirm').on('click', function() {
                var addQuantity = parseInt($('#add-stock-quantity').val());
                var currentStock = parseInt($('#current-stock').text()) || 0;
                var cityId = parseInt($('#search-city').val());
                $('#add-stock-confirm').attr('disabled', 'disabled');
                if (isNaN(addQuantity) || addQuantity < 0) {
                    $('#add-stock-confirm').removeAttr('disabled');
                    $('#error').text('Please enter a valid quantity to add.');
                    errorHide();
                    return;
                } else {
                    $('#error').text('');
                }

                if (addQuantity) {
                    $.ajax({
                        url: '{{ route('stock.add') }}',
                        type: 'POST',
                        data: {
                            batch_number: $('#batch-number').text(),
                            quantity: addQuantity,
                            cityId: cityId,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                var newStock = parseInt($('#current-stock').text()) +
                                    addQuantity;
                                $('#current-stock').text(newStock);
                                $('#success').text('Successfully Added Stock' + addQuantity +
                                    ' | Current stock: ' + newStock);

                                $('#add-stock-quantity').val('');
                            }
                            $('#add-stock-confirm').removeAttr('disabled');
                        },
                        error: function(xhr) {
                            alert('Error adding stock', xhr);
                            $('#add-stock-confirm').removeAttr('disabled');
                        }
                    });
                }
            });

            // Remove Stock Logic
            $('#remove-stock').on('click', function() {
                $('#remove-stock').attr('disabled', 'disabled');
                var removeQuantity = parseInt($('#add-stock-quantity').val());
                var currentStock = parseInt($('#current-stock').text()) || 0;
                var cityId = parseInt($('#search-city').val());
                if (isNaN(removeQuantity) || removeQuantity <= 0) {
                    $('#error').text('Please enter a valid quantity to remove.');
                    $('#remove-stock').removeAttr('disabled');
                    errorHide();
                    return;
                } else {
                    $('#error').text('');
                }

                if (removeQuantity > currentStock) {
                    $('#error').text('Cannot remove more stock than available. Current stock: ' +
                        currentStock);
                    $('#remove-stock').removeAttr('disabled');
                    errorHide();
                    return;
                }

                $.ajax({
                    url: '{{ route('stock.remove') }}',
                    type: 'POST',
                    data: {
                        batch_number: $('#batch-number').text(),
                        cityId: cityId,
                        quantity: removeQuantity,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            var newStock = currentStock - removeQuantity;
                            $('#current-stock').text(newStock);

                            $('#success').text('Successfully Removed Stock' + removeQuantity +
                                ' | Current stock: ' + newStock);
                            $('#add-stock-quantity').val('');

                        }
                        $('#remove-stock').removeAttr('disabled');
                    },
                    error: function(xhr) {
                        alert('Error removing stock', xhr);
                        $('#remove-stock').removeAttr('disabled');
                    }
                });
            });

            function errorHide() {
                setTimeout(() => {
                    $('#error').text('');
                }, 2000);
            }
        });
    </script>
@endpush
