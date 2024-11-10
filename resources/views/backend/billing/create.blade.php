@extends('backend.layouts.master')

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
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Create Bill</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Bill</a></li>
                                <li class="breadcrumb-item active">Create Bill</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            @php
                $settings = DB::table('settings')->get();

            @endphp
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="card">
                        <form class="needs-validation" action="{{ route('billing.store') }}" method="post">
                            {{ csrf_field() }}
                            <div class="card-body border-bottom border-bottom-dashed p-4">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="profile-user mx-auto  mb-3">
                                            <input id="profile-img-file-input" type="file"
                                                class="profile-img-file-input">
                                            <label for="profile-img-file-input" class="d-block" tabindex="0">
                                                <span
                                                    class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded"
                                                    style="height: 60px; width: 256px;">
                                                    <img src="{{ $settings[0]->logo }}"
                                                        class="card-logo card-logo-dark user-profile-image img-fluid"
                                                        alt="logo dark">
                                                    <img src="{{ $settings[0]->logo }}"
                                                        class="card-logo card-logo-light user-profile-image img-fluid"
                                                        alt="logo light">
                                                </span>
                                            </label>
                                        </div>
                                        <div>
                                            <div>
                                                <label for="companyAddress" class="form-label">Address</label>
                                            </div>
                                            <div class="mb-2">
                                                <textarea class="form-control" id="companyAddress" rows="3" placeholder="Company Address">{{ $settings[0]->address }}</textarea>
                                                <div class="invalid-feedback">
                                                    Please enter a address
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-4 ms-auto">
                                        <div class="mb-2">
                                            <input type="text" class="form-control" id="registrationNumber"
                                                maxlength="12" placeholder="Legal Registration No">
                                            <div class="invalid-feedback">
                                                Please enter a registration no, Ex., 012345678912
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <input type="email" value = "{{ $settings[0]->email }}" class="form-control"
                                                id="companyEmail" placeholder="Email Address">
                                            <div class="invalid-feedback">
                                                Please enter a valid email, Ex., example@gamil.com
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" value = "www.awish.com" class="form-control"
                                                id="companyWebsite" placeholder="Website">
                                            <div class="invalid-feedback">
                                                Please enter a website, Ex., www.example.com
                                            </div>
                                        </div>
                                        <div>
                                            <input type="text" value = "{{ $settings[0]->phone }}" class="form-control"
                                                data-plugin="cleave-phone" id="compnayContactno" placeholder="Contact No">
                                            <div class="invalid-feedback">
                                                Please enter a contact number
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end row-->
                            </div>
                            <div class="card-body p-4">
                                <div class="row g-3">
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="choices-payment-status" class="form-label">Gst Type</label>
                                        <select name="gtype" class="form-control" data-choices data-choices-search-false
                                            id="gst" style="padding:0px;padding-left:10px;">
                                            <option value="">Select Gst Type</option>
                                            <option value="Non Gst">Non Gst</option>
                                            <option value="Gst">Gst</option>
                                        </select>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <label for="date-field" class="form-label">Date</label>
                                            <input type="date" name="bdate" class="form-control" id="date-field"
                                                data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-sm-6">
                                        <label for="choices-payment-status" class="form-label">Payment Status</label>
                                        <select class="form-control" data-choices data-choices-search-false
                                            id="choices-payment-status" name="pstatus"
                                            style="padding:0px;padding-left:10px;">
                                            <option value="">Select Payment Status</option>
                                            <option value="Paid">Paid</option>
                                            <option value="Unpaid">Unpaid</option>
                                            <option value="Refund">Refund</option>
                                        </select>
                                    </div>
                                    <!--end col-->
                                    <div class="col-lg-3 col-sm-6">
                                        <div>
                                            <label for="totalamountInput" class="form-label">Total Amount</label>
                                            <input type="text" class="form-control" id="totalamountInput"
                                                placeholder="$0.00" readonly>
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <div class="card-body p-4 border-top border-top-dashed">
                                <div class="row">
                                    <div class="col-lg-4 col-sm-6">
                                        <div>
                                            <label for="billingName"
                                                class="text-muted text-uppercase fw-semibold form-label">Billing
                                                Address</label>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" id="billingName"
                                                name="billingName" placeholder="Full Name">
                                            <div class="invalid-feedback">
                                                Please enter a full name
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <textarea class="form-control" id="billingAddress" name="billingAddress" rows="3" placeholder="Address"></textarea>
                                            <div class="invalid-feedback">
                                                Please enter a address
                                            </div>
                                        </div>
                                        <div class="mb-2">
                                            <input type="text" class="form-control" data-plugin="cleave-phone"
                                                id="billingPhoneno" name="billingPhoneno" placeholder="(123)456-7890">
                                            <div class="invalid-feedback">
                                                Please enter a phone number
                                            </div>
                                        </div>
                                    </div>
                                    <!--end col-->
                                    <!--end col-->
                                </div>
                                <!--end row-->
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="invoice-table table table-borderless table-nowrap mb-0">
                                        <thead class="align-middle">
                                            <tr class="table-active">
                                                <th scope="col" style="width: 50px;">#</th>
                                                <th scope="col">
                                                    Product Details
                                                </th>
                                                <th scope="col" style="width: 120px;">
                                                    <div class="d-flex currency-select input-light align-items-center">
                                                        Rate

                                                    </div>
                                                </th>
                                                <th scope="col" style="width: 120px;">
                                                    <div class="d-flex currency-select input-light align-items-center">
                                                        Cgst(%)

                                                    </div>
                                                </th>
                                                <th scope="col" style="width: 120px;">
                                                    <div class="d-flex currency-select input-light align-items-center">
                                                        Sgst(%)

                                                    </div>
                                                </th>

                                                <th scope="col" style="width: 120px;">Quantity</th>
                                                <th scope="col" class="text-end" style="width: 180px;">Amount</th>
                                                <th scope="col" class="text-end" style="width: 105px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody id="newlink">

                                        </tbody>
                                        <tbody>
                                            <tr id="newForm" style="display: none;">
                                                <td class="d-none" colspan="5">
                                                    <p>Add New Product</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">
                                                    <button type="button" onclick="new_link(this)" data-count="0"
                                                        id="0" class="add btn btn-soft-secondary fw-medium"><i
                                                            class="ri-add-fill me-1 align-bottom"></i> Add Item</button>
                                                </td>
                                            </tr>
                                            <tr class="border-top border-top-dashed mt-2">
                                                <td colspan="3"></td>
                                                <td colspan="2" class="p-0">
                                                    <table
                                                        class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Sub Total</th>
                                                                <td style="width:150px;">
                                                                    <input type="text" class="form-control"
                                                                        id="cart-subtotal" name="ptotal" placeholder="0"
                                                                        readonly>
                                                                </td>
                                                            </tr>

                                                            <tr>
                                                                <th scope="row">Discount <small
                                                                        class="text-muted">(%)</small></th>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="cart-discount" name="discount"
                                                                        placeholder="0">
                                                                </td>
                                                            </tr>
                                                            <tr class="border-top border-top-dashed">
                                                                <th scope="row">Total Amount</th>
                                                                <td>
                                                                    <input type="text" class="form-control"
                                                                        id="cart-total" name="subtotal" placeholder="0"
                                                                        readonly>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <!--end table-->
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <!--end table-->
                                </div>
                                <div class="row mt-3">
                                    <div class="col-lg-4">
                                        <div class="mb-2">
                                            <label for="choices-payment-type"
                                                class="form-label text-muted text-uppercase fw-semibold">Payment
                                                Details</label>
                                            <select class="form-control" data-choices data-choices-search-false
                                                data-choices-removeItem id="choices-payment-type" name="pmethod"
                                                style="padding:0px;padding-left:10px;">
                                                <option value="">Payment Method</option>
                                                <option value="Mastercard">Mastercard</option>
                                                <option value="Credit Card">Credit Card</option>
                                                <option value="Visa">Visa</option>
                                                <option value="Paypal">Paypal</option>
                                            </select>
                                        </div>

                                    </div>
                                    <!--end col-->
                                </div>
                                <!--end row-->
                                <div class="mt-4">
                                    <label for="exampleFormControlTextarea1"
                                        class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                                    <textarea class="form-control alert alert-warning" id="exampleFormControlTextarea1" placeholder="Notes"
                                        rows="2">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</textarea>
                                </div>
                                <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                    <button type="submit" class="btn btn-success"><i
                                            class="ri-printer-line align-bottom me-1"></i> Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>


    <script>
        /*
    Template Name: Toner eCommerce + Admin HTML Template
    Author: Themesbrand
    Website: https://Themesbrand.com/
    Contact: Themesbrand@gmail.com
    File: Invoice create init Js File
    */


        let count = 1;

        function new_link(p) {
            const count = Number(p.id) + 1;
            p.id = count;
            var tr1 = document.createElement("tr");
            tr1.id = count;
            tr1.className = "product_" + count;

            var product = <?php print_r(json_encode($product)); ?>;
            var productData = product.data;
            var delLink = ` <th scope="row" class="product-id">1</th>
            <td class="text-start">
            <select data-count="${count}" id="product2" name="product[]"   class="form-control" style="padding:0px;padding-left:10px;"   >
       
       <option value="">--Select Products--</option>
@foreach ($product as $products)
<option value="{{ $products->id }}" data-price="{{ $products->price }}" data-stock="{{ $products->stock }}" data-cgst="{{ $products->cgst }}" data-sgst="{{ $products->sgst }}" data-tax="{{ $products->tax }}">{{ $products->title }}</option>
@endforeach
   </select>   
            </td>
            <td>
                <input type="number" class="form-control product-price_${count}" id="price_${count}" step="0.01" placeholder="0.00"  >
               <input type="hidden" id="tax_"${count}/>
             
                <div class="invalid-feedback">
                    Please enter a rate
                </div>
            </td>
            <td>
              
             
               <input type="number" id="cgst_${count}" name="cgst[]" class="form-control product-price" readonly/>
               
                <div class="invalid-feedback">
                    Please enter a cgst
                </div>
            </td>
            <td>
              
              
               <input type="number" class="form-control product-price" id="sgst_${count}" name="sgst[]" readonly/>
                <div class="invalid-feedback">
                    Please enter a sgst
                </div>
            </td>

            <td>
                <div class="input-step">
                
                    <input type="number" class="product-quantity" id="qty_${count}" name="qty[]" value="0" readonly>

                </div>
            </td>
            <td class="text-end">
                <div>
                    <input type="text" class="form-control product-line-price" id="productPrice_${count}" placeholder="0.00" readonly >
                                    <input type="hidden"  id="productdetail" placeholder="0.00" readonly >
                                    </div>
            </td>
            <td class="product-removal">
                <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
            </td>
       `;

            tr1.innerHTML = document.getElementById("newForm").innerHTML + delLink;
            document.getElementById("newlink").appendChild(tr1);
            var genericExamples = document.querySelectorAll("[data-trigger]");
            Array.from(genericExamples).forEach(function(genericExamp) {
                var element = genericExamp;
                new Choices(element, {
                    placeholderValue: "This is a placeholder set in the config",
                    searchPlaceholderValue: "This is a search placeholder",
                });
            });

            //isData();
            remove();

            resetRow()
        }

        remove();
        /* Set rates + misc */
        var taxRate = 0.125;
        var shippingRate = 65.0;
        var discountRate = 0.15;

        function remove() {
            Array.from(document.querySelectorAll(".product-removal a")).forEach(function(el) {
                el.addEventListener("click", function(e) {
                    removeItem(e);
                    var count = Number($(".add").attr("id"));
                    $(".add").attr("id", count - 1);
                    resetRow()
                });
            });
        }

        function resetRow() {

            Array.from(document.getElementById("newlink").querySelectorAll("tr")).forEach(function(subItem, index) {
                var incid = index + 1;
                subItem.querySelector('.product-id').innerHTML = incid;

            });
        }





        /* Remove item from cart */
        function removeItem(removeButton) {
            removeButton.target.closest("tr").remove();

        }




        // Invoice Data Load On Form
    </script>
    <script>
        //    $('select[name="product"]').on("change",function(){
        //         var element= $(this).find('option:selected'); 
        //        console.log($(".add").attr("id"));  
        //         var price = element.attr('data-price');
        //         var stock = element.attr('data-stock');
        //         var cgst = element.attr('data-cgst');
        //         var sgst = element.attr('data-sgst');
        //         var tax = element.attr('data-tax');
        //      if(stock > 0)
        //      {
        //         document.getElementById('price').value = price;
        //         document.getElementById('cgst').value=cgst;
        //         document.getElementById('sgst').value=sgst;
        //         document.getElementById('tax').value=tax;
        //         var alltax=cgst+sgst+tax;

        //         $('#qty').attr('readonly',false);

        //      }
        //      else
        //      {
        //         alert("No stock Availbale");
        //      }
        //     });
        $(document).on('change', '.text-start select', function() {
            var element = $(this).find('option:selected');

            var count = $(".add").attr("id");
            var currentCount = $(this).attr('data-count')
            var price = element.attr('data-price');
            var stock = element.attr('data-stock');
            var cgst = element.attr('data-cgst');
            var sgst = element.attr('data-sgst');
            var tax = element.attr('data-tax');
            if (stock > 0) {
                // document.getElementById().value = price;
                $("#price_" + count).val(price);
                $("#cgst_" + count).val(cgst);
                $("#sgst_" + count).val(sgst);
                $("#tax_" + count).val(tax);

                var alltax = cgst + sgst + tax;

                $('#qty_' + count).attr('readonly', false);

            } else {
                alert("No stock Availbale");
            }
        });
    </script>
    <script>
        $(document).on('input', '.product-quantity', function() {
            console.log($(this).attr('id'));
            var current = $(this).attr('id').split('_', 2)[1];

            var price = document.getElementById('price_' + current).value;

            var sub_total = Number(price) * $(this).val();
            var alltax = Number(document.getElementById('sgst_' + current).value) + Number(document.getElementById(
                'cgst_' + current).value);
            var taxprice = (sub_total + alltax) / 100;
            var vtax = sub_total + (sub_total * alltax) / 100;
            $("#productPrice_" + current).val(vtax);
            var count = $(".add").attr("id");
            var total1 = 0;
            for (var i = 1; i <= count; i++) {
                var p = Number($("#productPrice_" + count).val())
                total1 += total1 + p;
            }
            $("#cart-subtotal").val(total1);
            $("#cart-tax").val(alltax);
            $("#tp").val(alltax);
            var stax = (sub_total + alltax) / 100;

            var dis = (Number($("#cart-subtotal").val()) * Number($("#cart-discount").val())) / 100;
            $("#tp").val(alltax);
            var subtotal = Number($("#cart-subtotal").val()) - dis;
            $("#cart-total").val(subtotal);

            $("#totalamountInput").val(subtotal);
        });
    </script>
    <script>
        $('#cart-discount').on("input", function() {

            // var price=document.getElementById('price').value;
            // var sub_total= Number(price) * $(this).val();

            // var alltax = Number(document.getElementById('sgst').value)+Number(document.getElementById('cgst').value)+Number(document.getElementById('tax').value);
            // var taxprice =(sub_total + alltax)/100;
            var dis = (Number($("#cart-subtotal").val()) * Number($("#cart-discount").val())) / 100;
            var subtotal = Number($("#cart-subtotal").val()) - dis;
            $("#cart-total").val(subtotal);
            $("#totalamountInput").val(subtotal);

        });
    </script>
    <script>
        $("#gst").change(function() {
            if ($(this).val() == 'ngst') {
                // alert('ngst');
            }
        });
    </script>
    <script>
        $("#idForm").submit(function(e) {
            e.preventDefault(); // avoid to execute the actual submit of the form.

            var form = $(this);
            var actionUrl = form.attr('action');
            $.ajax({
                type: "POST",
                url: actionUrl + '/store',
                data: form.serialize(), // serializes the form's elements.
                success: function(data) {
                    console.log(data); // show response from the php script.
                }
            });

        });
    </script>
    <!-- <script>
        $(document).on('change', '.text-start select', function() {
            alert("Success");
        });
    </script> -->
@endpush
