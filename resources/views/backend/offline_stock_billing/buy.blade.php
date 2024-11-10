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
            <h6 class="m-0 font-weight-bold text-primary float-left">Buy Stocks</h6>
        </div>
        <div class="card-body">
            <form id="customerForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="invoiceType" class="form-label">Invoice Type <span class="text-danger">*</span></label>
                            <select class="form-control invoiceType" id="invoiceType" name="invoiceType" required>
                                <option value="Non_GST">Non GST</option>
                                <option value="GST">GST</option>
                                {{-- <option value="Bill_of_Supply">Bill of Supply</option> --}}
                            </select>
                        </div>
                    </div>
                    {{-- <div class="col-md-3">
                        <div class="mb-3">
                            <label for="invoice_no" class="form-label">Invoice No. <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="invoice_no" name="invoice_no" required>
                        </div>
                    </div> --}}
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="customerName" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customerName" name="customerName" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="customerEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="customerEmail" name="customerEmail">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="customerPhone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customerPhone" name="customerPhone" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                            {{-- <textarea class="form-control" name="customerAddress" id="customerAddress"></textarea> --}}
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                    </div>
                    {{-- Optional --}}
                        {{-- <div class="col-md-3">
                            <div class="mb-3">
                                <label for="date" class="form-label">Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="date" name="date" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" class="form-control" id="due_date" name="due_date">
                            </div>
                        </div> --}}
                        {{-- <div class="col-md-3">
                            <div class="mb-3">
                                <label for="cgst_no" class="form-label">Bill To</label>
                            </div>
                        </div> --}}
                    {{-- Optional --}}
                    <div class="col-md-3 gstField" style="display:none;">
                        <div class="mb-3">
                            <label for="cgst_no" class="form-label">Customer GST IN <span class="text-danger">*</span></label>
                            <input type="cgst_no" class="form-control cgst_no" id="cgst_no" name="cgst_no">
                        </div>
                    </div>

                </div>

            </form>
            <form id="productForm">
                <div id="productRows">
                </div>
                <button type="button" class="btn btn-dark mb-2" id="buynow">
                    Buy Now
                </button>
                <div id="totalPrice" class="mt-3">
                    <strong>Total Price(INR): <span id="totalAmount">0.00</span></strong>
                </div>
            </form>
        </div>
    </div>

    <!-- Customer Details Modal -->
    {{-- <div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerModalLabel">Add Customer Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="submitCustomerDetails">Submit & Generate
                        Invoice</button>
                </div>
            </div>
        </div>
    </div> --}}
@endsection
@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
            display: block;
            width: 100%;
            padding: .375rem 2.25rem .375rem .75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-form-control-bg);
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
    </style>
    <script>
        $(document).ready(function() {
            function calculateTotal() {
                let total = 0;
                $('.form-row').each(function() {
                    let quantity = $(this).find('.product-quantity').val() || 1;
                    let unitPrice = $(this).find('.product-price').val() || 0;
                    total += parseFloat(quantity) * parseFloat(unitPrice);
                });
                $('#totalAmount').text(total.toFixed(2));
            }

            function addNewRow() {
                let newRow = `<div class="form-row mb-3">
                            <select class="form-control product-select mb-2" name="product[]" required>
                                <option value="">Select Product</option>
                                @foreach ($products as $item)
                                    <option value="{{ $item->id }}">{{ $item->product->title }}({{ $item->strep->title }})</option>
                                @endforeach
                            </select>
                            <select class="form-control batch-select mb-2" name="batch_no[]" disabled required>
                                <option value="" disabled selected>Select Batch no.</option>
                            </select>

                            <!-- Stock Info and Error Messages -->
                            <div class="stock-info mb-2">
                                <div class="out-of-stock-message text-danger small" style="display: none;">Out of stock</div>
                                <div class="available-stock text-muted small" style="display: none;"></div>
                            </div>

                            <input type="number" class="form-control product-quantity mb-2" name="quantity[]" min="1" value="1" placeholder="Enter Quantity" required disabled>
                            <input type="number" class="form-control product-price mb-2" name="price[]" placeholder="Enter Price" required readonly>

                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-success add-row" disabled>Add</button>
                                <button type="button" class="btn btn-danger remove-row" style="display: none;">Remove</button>
                            </div>
                        </div>`;
                $('#productRows').append(newRow);
                // Initialize Select2 on the newly added select element
                $('.product-select').last().select2();
                updateButtons();
            }


            function updateButtons() {
                let rows = $('.form-row');
                rows.each(function(index) {
                    $(this).find('.add-row').toggle(index === rows.length - 1);
                    $(this).find('.remove-row').toggle(rows.length > 1);
                });
            }
            addNewRow();
            $(document).on('click', '.remove-row', function() {
                $(this).closest('.form-row').remove();
                calculateTotal();
                updateButtons();
            });

            $(document).on('change', '.product-select', function() {
                let productId = $(this).val();
                let batchSelect = $(this).closest('.form-row').find('.batch-select');
                let priceInput = $(this).closest('.form-row').find('.product-price');
                batchSelect.empty().prop('disabled', true);
                priceInput.val(0);
                if (productId) {
                    $.ajax({
                        url: '/admin/offline-invoices/get-product-batches/' + productId,
                        method: 'GET',
                        success: function(response) {
                            if (response.batches && response.batches.length > 0) {
                                batchSelect.prop('disabled', false).append(
                                    '<option value="">Select Batch no.</option>');
                                response.batches.forEach(function(batch) {
                                    batchSelect.append(
                                        `<option value="${batch.batch_no}" data-id='${batch.id}' data-price="${batch.price}" data-stock="${batch.stock}">${batch.batch_no}(exp.${batch.expiry})</option>`
                                    );
                                });
                            } else {
                                batchSelect.append(
                                    '<option value="">No Batches Available</option>');
                            }
                        },
                        error: function() {
                            alert('Error fetching batches');
                        }
                    });
                } else {
                    batchSelect.append('<option value="">Select Batch no.</option>');
                }
            });

            $(document).on('change', '.batch-select', function() {
                let selectedOption = $(this).find('option:selected');
                let price = selectedOption.data('price') || 0;
                let id = selectedOption.data('id');
                let quantityInput = $(this).closest('.form-row').find('.product-quantity');
                let availableStockInfo = $(this).closest('.form-row').find('.available-stock');
                let selectedBatch = $(this).val();
                let addButton = $(this).closest('.form-row').find('.add-row');
                addButton.prop('disabled', !selectedBatch);
                // Update price and show available stock
                $(this).closest('.form-row').find('.product-price').val(price);
                quantityInput.prop('disabled', !selectedOption.val());
                if (id) {
                    $.ajax({
                        url: '/admin/offline-invoices/get-product-stock/' + id,
                        method: 'GET',
                        success: function(response) {
                            if (response.stock) {
                                availableStock = response.stock.stock
                                selectedOption.attr('data-stock', availableStock)
                                if (availableStock > 0) {
                                    quantityInput.attr('max', availableStock)
                                    availableStockInfo.text(
                                        `Available stock: ${availableStock}`).show();
                                } else {
                                    availableStockInfo.hide();
                                }
                            }
                        },
                        error: function() {
                            alert('Error fetching batches');
                        }
                    });
                }


                calculateTotal();
            });

            $(document).on('input', '.product-quantity', function() {
                let quantity = parseInt($(this).val()) || 1;
                let selectedBatch = $(this).closest('.form-row').find('.batch-select option:selected');
                let availableStock = parseInt(selectedBatch.data('stock')) || 0;
                let outOfStockMessage = $(this).closest('.form-row').find('.out-of-stock-message');

                if (quantity > availableStock) {
                    alert(`Insufficient stock. Only ${availableStock} items available.`);
                    $(this).val(availableStock);
                    outOfStockMessage.show();
                } else {
                    outOfStockMessage.hide();
                }

                calculateTotal();
            });


            $(document).on('click', '.add-row', function() {
                if ($(this).prop('disabled')) return;
                addNewRow();
                calculateTotal();
            });

            $('#buynow').click(function() {
                let lastRow = $('.form-row').last();
                let productSelected = lastRow.find('.product-select').val();
                let batchSelected = lastRow.find('.batch-select').val();
                let quantity = parseInt(lastRow.find('.product-quantity').val());
                let availableStock = parseInt(lastRow.find('.batch-select option:selected').data(
                    'stock')) || 0;
                if (productSelected && batchSelected) {
                    if (quantity > availableStock) {
                        alert(`Insufficient stock. Only ${availableStock} items available for this batch.`);
                    } else {
                        $('#customerModal').modal('show');
                    }
                } else {
                    alert('Please select both a product and batch in the last row before proceeding.');
                }

                if (validateForm()) {
                    let customerData = {
                        customer_name: $('#customerName').val(),
                        customer_email: $('#customerEmail').val(),
                        customer_phone: $('#customerPhone').val(),
                        customer_address: $('#city').val(),
                        invoice_type: $('#invoiceType').val(),
                        date:$('#date').val(),
                        // due_date:$('#due_date').val(),
                        products: [],
                        prices: [],
                        batch_nos: [],
                        quantities: []
                    };
                    $('.form-row').each(function() {
                        customerData.products.push($(this).find('.product-select').val());
                        customerData.batch_nos.push($(this).find('.batch-select').val());
                        customerData.prices.push($(this).find('.product-price').val());
                        customerData.quantities.push($(this).find('.product-quantity').val());
                    });

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/offline-invoices/generateInvoice',
                        method: 'POST',
                        data: customerData,
                        success: function(response) {
                            if (response.success) {
                                $('#customerModal').modal('hide');
                                window.location.href = response.invoiceUrl;
                            } else {
                                alert('Error generating invoice: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            alert('An error occurred: ' + xhr.responseText);
                        }
                    });
                }
            });

            // Regular expressions for validation
            const phoneRegex = /^[0-9]{10}$/; // Validates 10-digit phone numbers
            // const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Validates basic email format

            function validateForm() {
                let isValid = true;
                if (!$('#customerName').val()) {
                    isValid = false;
                    alert("Customer name is required.");
                }
                let phone = $('#customerPhone').val();
                if (!phoneRegex.test(phone)) {
                    isValid = false;
                    alert("Please enter a valid 10-digit phone number.");
                }
                // if (!$('#customerAddress').val()) {
                //     isValid = false;
                //     alert("Customer address is required.");
                // }

                $('.form-row').each(function() {
                    let productId = $(this).find('.product-select').val();
                    let batchNo = $(this).find('.batch-select').val();
                    let quantity = $(this).find('.product-quantity').val();
                    let price = $(this).find('.product-price').val();

                    if (!productId || !batchNo || !quantity || !price) {
                        isValid = false;
                        alert("Please complete all fields in the product rows.");
                    }
                });

                return isValid;
            }

            $('#customerPhone').on('input', function() {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            });

            // $('#submitCustomerDetails').click(function() {
            //     if (validateForm()) {
            //         let customerData = {
            //             customer_name: $('#customerName').val(),
            //             customer_email: $('#customerEmail').val(),
            //             customer_phone: $('#customerPhone').val(),
            //             customer_address: $('#customerAddress').val(),
            //             invoice_type: $('#invoiceType').val(),
            //             products: [],
            //             prices: [],
            //             batch_nos: [],
            //             quantities: []
            //         };
            //         $('.form-row').each(function() {
            //             customerData.products.push($(this).find('.product-select').val());
            //             customerData.batch_nos.push($(this).find('.batch-select').val());
            //             customerData.prices.push($(this).find('.product-price').val());
            //             customerData.quantities.push($(this).find('.product-quantity').val());
            //         });

            //         $.ajax({
            //             headers: {
            //                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //             },
            //             url: '/admin/stock/generateInvoice',
            //             method: 'POST',
            //             data: customerData,
            //             success: function(response) {
            //                 if (response.success) {
            //                     $('#customerModal').modal('hide');
            //                     window.location.href = response.invoiceUrl;
            //                 } else {
            //                     alert('Error generating invoice: ' + response.message);
            //                 }
            //             },
            //             error: function(xhr) {
            //                 alert('An error occurred: ' + xhr.responseText);
            //             }
            //         });
            //     }
            // });
        });
    </script>

    <script>
        $(document).ready(function(){
            $(document).on('change','.invoiceType', function() {
                var invoiceType = $(this).val();  
    
                if (invoiceType === 'GST') {
                    $('.cgst_no').attr('required', true);
                    // $('.cgst_no').closest('.col-md-3').find('label').append('<span class="text-danger">*</span>');
                    $('.gstField').show();  // Show the GST field
                } else {
                    $('.cgst_no').removeAttr('required');
                    $('.gstField').hide();  // Hide the GST field
                }
            });
        });
    </script>
@endpush
