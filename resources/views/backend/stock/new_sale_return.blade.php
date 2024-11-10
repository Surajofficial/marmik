@extends('backend.layouts.master')
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS (including Popper.js for modals) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<style>
    .card-body {
        padding: 20px;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-bottom: 10px;
    }

    .form-row input,
    .form-row select {
        flex: 1;
        min-width: 200px;
    }

    .form-row button {
        flex-shrink: 0;
    }
</style>
@section('main-content')

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Invoice information</h6>
    </div>
    <div class="card-body">
        <form id="productForm">
            <!-- Invoice Details -->
            <div class="row mb-4">
                <div class="col-3">
                    <label for="invoice_id" class="form-label">Invoice Id</label>
                    <input type="text" class="form-control" name="invoice_id" id="invoice_id"
                        placeholder="Enter Invoice Id" required autocomplete="off">
                </div>
                <div class="col-3">
                    <label for="invoice_type" class="form-label">Invoice Type</label>
                    <select class="form-control" id="invoice_type" name="invoice_type" required>
                        <option value="Non_GST">Non GST</option>
                        <option value="GST">GST</option>
                        <option value="Bill_of_Supply">Bill of Supply</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="returnReason" class="form-label">Return Reason</label>
                    <select class="form-control" id="returnReason" name="returnReason" required>
                        <option value="Sale_Return">Sale Return</option>
                        <option value="Quality_Issue">Quality Issue</option>
                        <option value="Invoice_Correction">Invoice Correction</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="col-3">
                    <label for="return_date" class="form-label">Return Date</label>
                    <input type="date" class="form-control" name="return_date" id="return_date" required>
                </div>
            </div>

            <!-- Customer Details -->
            <div class="row mb-4">
                <div class="col-3">
                    <label for="customer_phone" class="form-label">Contact No.</label>
                    <input type="text" class="form-control" name="customer_phone" id="customer_phone" required>
                </div>
                <div class="col-3">
                    <label for="customer_name" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" name="customer_name" id="customer_name" required>
                </div>
                <div class="col-3">
                    <label for="customer_address" class="form-label">Address</label>
                    <textarea class="form-control" name="customer_address" id="customer_address"></textarea>
                </div>
                <div class="col-3">
                    <label for="place_of_supply" class="form-label">Place of Supply</label>
                    <select class="form-control" id="place_of_supply" name="place_of_supply" required>
                        <option value="delhi">Delhi</option>
                        <option value="up">Uttar Pradesh</option>
                        <option value="bihar">Bihar</option>
                        <option value="punjab">Punjab</option>
                        <option value="rajasthan">Rajasthan</option>
                        <option value="gujarat">Gujarat</option>
                    </select>
                </div>
            </div>

            <!-- Product Selection (Dynamically Populated) -->
            <div id="show-return-product">
            </div>

            <!-- Form Submission -->
            <button type="button" class="btn btn-dark mb-2" id="returnnow">Save</button>
            <div id="totalPrice" class="mt-3">
                <strong>Total Price(INR): <span id="totalAmount">0.00</span></strong>
            </div>
        </form>
    </div>

</div>


@endsection
@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#product-dataTable').DataTable({
            "scrollX": false "columnDefs": [{
                "orderable": false,
                "targets": [10, 11, 12]
            }]
        });
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function (e) {
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
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            
            const today = new Date().toISOString().split('T')[0];
            $('#return_date').val(today);

            $('#returnnow').prop('disabled', true);



            function validateForm() {
                let isFormValid = true;

                const requiredFields = ['#invoice_id', '#returnReason', '#customer_phone', '#customer_name', '#place_of_supply', '#invoice_type', '#return_date'];

                requiredFields.forEach((field) => {
                    if (!$(field).val()) {
                        isFormValid = false;
                        $(field).addClass('is-invalid');
                    } else {
                        $(field).removeClass('is-invalid');
                    }
                });

                const phone = $('#customer_phone').val();
                if (phone && (phone.length !== 10 || isNaN(phone))) {
                    isFormValid = false;
                    $('#customer_phone').addClass('is-invalid');
                } else {
                    $('#customer_phone').removeClass('is-invalid');
                }


                let hasProduct = false;
                $('.product-row').each(function () {
                    let productId = $(this).find('[name="product_id[]"]').val();
                    let batchNo = $(this).find('[name="batch_no[]"]').val();
                    let quantity = $(this).find('[name="quantity[]"]').val();
                    if (productId && batchNo && quantity) {
                        hasProduct = true;
                    }
                });
                if (!hasProduct) {
                    isFormValid = false;
                }

                $('#returnnow').prop('disabled', !isFormValid);
            }

            function populateProducts(products) {
                $('#show-return-product').empty();

                $.each(products, function (index, product) {
                    var productRow = `
                            <div class="row mb-3 product-row">
                                <div class="col-md-4">
                                    <input type="hidden" class="form-control" name="product_id[]" value="${product.product_id}" readonly>
                                    <input type="text" class="form-control" name="product_name[]" value="${product.name}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="batch_no[]" value="${product.batch_no}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control product-quantity" name="quantity[]" value="${product.quantity}" min="1" data-original-quantity="${product.quantity}" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control product-price" name="price[]" value="${product.price_after_discount}" readonly>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger remove-row">Remove</button>
                                </div>
                            </div>
                        `;
                    $('#show-return-product').append(productRow);
                });

                calculateTotalPrice();
                validateForm();
            }

            function calculateTotalPrice() {
                var total = 0;
                $('.product-row').each(function () {
                    var price = parseFloat($(this).find('.product-price').val()) || 0;
                    var quantity = parseFloat($(this).find('.product-quantity').val()) || 0;
                    total += price * quantity;
                });
                $('#totalAmount').text(total.toFixed(2));
            }

            $('#invoice_id').autocomplete({
                source: function (request, response) {
                    $.ajax({
                        url: '{{route("stocks.search-invoice-id")}}',
                        type: 'GET',
                        data: { term: request.term },
                        success: function (data) {
                            response($.map(data, function (item) {
                                return { label: item.invoice_no, value: item.invoice_no };
                            }));
                        }
                    });
                },
                minLength: 2,
                select: function (event, ui) {
                    $('#invoice_id').val(ui.item.value).trigger('change');
                }
            });

            $('#invoice_id').on('change', function () {
                var invoiceId = $(this).val();
                if (invoiceId) {
                    $.ajax({
                        url: '{{route("stocks.get-invoice-details")}}',
                        type: 'GET',
                        data: { invoice_id: invoiceId },
                        success: function (response) {
                            if (response.customer) {
                                $('#invoice_type').val(response.customer.invoice_type);
                                $('#customer_phone').val(response.customer.customer_phone);
                                $('#customer_name').val(response.customer.customer_name);
                                $('#customer_address').val(response.customer.customer_address);
                            }
                            if (response.products) {
                                populateProducts(response.products);
                            } else {
                                alert("No products found for this invoice.");
                            }
                        },
                        error: function () {
                            alert("Error fetching invoice details. Please try again.");
                        }
                    });
                }
            });

            $(document).on('input', '.product-quantity', function () {
                var enteredQuantity = parseFloat($(this).val()) || 0;
                var originalQuantity = parseFloat($(this).data('original-quantity')) || 0;

                if (enteredQuantity > originalQuantity) {
                    alert("The return quantity cannot exceed the purchased quantity of " + originalQuantity);
                    $(this).val(originalQuantity);
                }

                calculateTotalPrice();
                validateForm();
            });

            $(document).on('click', '.remove-row', function () {
                $(this).closest('.product-row').remove();
                calculateTotalPrice();
                validateForm();
            });

            $('#returnnow').on('click', function (e) {
                e.preventDefault();
                if ($('#returnnow').prop('disabled')) return;

                var formData = $('#productForm').serialize();
                $.ajax({
                    url: '{{route("stocks.return-stock-product")}}',
                    type: 'POST',
                    data: formData,
                    success: function (response) {
                        if (response.success) {
                            $('#productForm')[0].reset();
                            $('#show-return-product').empty();
                            $('#totalAmount').text('0.00');
                            $('#returnnow').prop('disabled', true);

                            window.location.href = response.returnInvoiceGenerateUrl;
                        } else {
                            alert("Error processing return. Please try again.");
                        }
                    },
                    error: function () {
                        alert("Error submitting return request.");
                    }
                });
            });

            $('#productForm').on('input change', 'input, select', validateForm);
        });

    </script>

@endpush