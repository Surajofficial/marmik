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
                                <h4 class="mb-sm-0">Create Purchase</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Purchase</a></li>
                                        <li class="breadcrumb-item active">Create Purchase</li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->

                    <div class="row justify-content-center">
                        <div class="col-xxl-12">
                            <div class="card">
                                <form class="needs-validation">
                                    <div class="card-body border-bottom border-bottom-dashed p-4" style="display:none">
                                        <div class="row">
                                            <div class="col-lg-4">
                                                <div class="profile-user mx-auto  mb-3">
                                                    <input id="profile-img-file-input" type="file" class="profile-img-file-input" >
                                                    <label for="profile-img-file-input" class="d-block" tabindex="0">
                                                        <span class="overflow-hidden border border-dashed d-flex align-items-center justify-content-center rounded" style="height: 60px; width: 256px;">
                                                            <img src="../assets/images/logo-dark.png" class="card-logo card-logo-dark user-profile-image img-fluid" alt="logo dark">
                                                            <img src="../assets/images/logo-light.png" class="card-logo card-logo-light user-profile-image img-fluid" alt="logo light">
                                                        </span>
                                                    </label>
                                                </div>
                                                <div>
                                                    <div>
                                                        <label for="companyAddress" class="form-label">Address</label>
                                                    </div>
                                                    <div class="mb-2">
                                                        <textarea class="form-control" id="companyAddress" rows="3" placeholder="Company Address" required></textarea>
                                                        <div class="invalid-feedback">
                                                            Please enter a address
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 mb-lg-0">
                                                        <input type="text" class="form-control" id="companyaddpostalcode" minlength="5" maxlength="6" placeholder="Enter Postal Code" required >
                                                        <div class="invalid-feedback">
                                                            The US zip code must contain 5 digits, Ex. 45678
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4 ms-auto">
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" id="registrationNumber" maxlength="12" placeholder="Legal Registration No" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a registration no, Ex., 012345678912
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="email" class="form-control" id="companyEmail" placeholder="Email Address" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a valid email, Ex., example@gamil.com
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" id="companyWebsite" placeholder="Website" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a website, Ex., www.example.com
                                                    </div>
                                                </div>
                                                <div>
                                                    <input type="text" class="form-control" data-plugin="cleave-phone" id="compnayContactno" placeholder="Contact No" required >
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
                                        <div class="col-lg-2 col-sm-6">
                                                <label for="ptype" class="form-label">Purchase Type</label>
                                                <select name="ptype" class="form-control" data-choices data-choices-search-false required>
                                                    <option value="">Select Payment Status</option>
                                                    <option value="gst">GST</option>
                                                    <option value="ngst">Non Gst</option>
                                                 
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Date</label>
                                                    <input name="date "type="date" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <label for="invoicenoInput" class="form-label">Supplier Name</label>
                                                <select name="supplier" id="supplier" class="form-control" data-choices data-choices-search-false id="choices-payment-status" required>
                                                   
                                                    <option value="">--Select Supplier--</option>
             @foreach($suppliers as $supplier)
              <option id="{{$supplier->price}}" value="{{$supplier->id}}">{{$supplier->name}}</option>
              @endforeach
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <label for="invoicenoInput" class="form-label">Payment Terms</label>
                                                <select name="pterms" class="form-control" data-choices data-choices-search-false id="choices-payment-status" required>
                                                    <option value="">Select Payment Status</option>
                                                    <option value="Paid">Card</option>
                                                    <option value="Unpaid">Cash</option>
                                                    <option value="Refund">Online</option>
                                                </select>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Due Date</label>
                                                    <input name="ddate" type="date" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Place of Supply</label>
                                                    <select name="psupply" class="form-control" >
                                                    <option value="">Select Place of Supply</option>
                                                    <option value="Paid">Delhi</option>
                                                    <option value="Unpaid">Noida</option>
                                                    <option value="Refund">Uttar Pradesh</option>
                                                </select>                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Purchase Bill No:- </label>
                                                    <input name="pbill" type="text" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Purchase Order No:- </label>
                                                    <input name="porderno"  type="text" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">Purchase Order Date:- </label>
                                                    <input name="porderdate" type="date" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-sm-6">
                                                <div>
                                                    <label for="date-field" class="form-label">E-Way Bill No:- </label>
                                                    <input name="ebill" type="text" class="form-control" id="date-field" data-provider="flatpickr" data-time="true" placeholder="Select Date-time">
                                                </div>
                                            </div>
                                            <!--end col-->
                                           
                                            <!--end col-->
                                            <div class="col-lg-3 col-sm-6">
                                                <label for="choices-payment-status" class="form-label">Payment Status</label>
                                                <select name="pstatus" class="form-control" data-choices data-choices-search-false id="choices-payment-status" required>
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
                                                    <input name="tamountx`" type="text" class="form-control" id="totalamountInput" placeholder="$0.00" readonly >
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <div class="card-body p-4 border-top border-top-dashed" style="display:none;">
                                        <div class="row">
                                            <div class="col-lg-4 col-sm-6">
                                                <div>
                                                    <label for="billingName" class="text-muted text-uppercase fw-semibold form-label">Billing Address</label>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" id="billingName" placeholder="Full Name" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a full name
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <textarea class="form-control" id="billingAddress" rows="3" placeholder="Address" required></textarea>
                                                    <div class="invalid-feedback">
                                                        Please enter a address
                                                    </div>
                                                </div>
                                                <div class="mb-2">
                                                    <input type="text" class="form-control" data-plugin="cleave-phone" id="billingPhoneno" placeholder="(123)456-7890" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a phone number
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" id="billingTaxno" placeholder="Tax Number" required >
                                                    <div class="invalid-feedback">
                                                        Please enter a tax number
                                                    </div>
                                                </div>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="same" name="same" onchange="billingFunction()" >
                                                    <label class="form-check-label" for="same">
                                                        Will your Billing and Shipping address same?
                                                    </label>
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-sm-6 ms-auto">
                                                <div class="row">
                                                    <div class="col-lg-8">
                                                        <div>
                                                            <label for="shippingName" class="form-label text-muted text-uppercase fw-semibold">Shipping Address</label>
                                                        </div>
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" id="shippingName" placeholder="Full Name" required >
                                                            <div class="invalid-feedback">
                                                                Please enter a full name
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <textarea class="form-control" id="shippingAddress" rows="3" placeholder="Address" required></textarea>
                                                            <div class="invalid-feedback">
                                                                Please enter a address
                                                            </div>
                                                        </div>
                                                        <div class="mb-2">
                                                            <input type="text" class="form-control" data-plugin="cleave-phone" id="shippingPhoneno" placeholder="(123)456-7890" required >
                                                            <div class="invalid-feedback">
                                                                Please enter a phone number
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <input type="text" class="form-control" id="shippingTaxno" placeholder="Tax Number" required >
                                                            <div class="invalid-feedback">
                                                                Please enter a tax number
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                        <th scope="col" style="width: 10  0px;">
                                                            Batch No. 
                                                        </th>
                                                        <th scope="col">
                                                            Product Details
                                                        </th>
                                                        <th scope="col">
                                                            Unit
                                                        </th>
                                                        <th scope="col" style="width: 120px;">Quantity</th>
                                                        <th scope="col" style="width: 120px;">
                                                            <div class="d-flex currency-select input-light align-items-center">
                                                                Purchase Price
                                                                <select class="form-selectborder-0 bg-light" data-choices data-choices-search-false id="choices-payment-currency" onchange="otherPayment()">
                                                                    <option value="$">($)</option>
                                                                    <option value="£">(£)</option>
                                                                    <option value="₹">(₹)</option>
                                                                    <option value="€">(€)</option>
                                                                </select>
                                                            </div>
                                                        </th>
                                                        <th scope="col" class="text-end" style="width: 180px;">Disc(%)</th>
                                                        <th scope="col" class="text-end" style="width: 180px;">Tax(%)</th>
                                                        <th scope="col" class="text-end" style="width: 180px;">Cess(%)</th>
                                                        <th scope="col" class="text-end" style="width: 180px;">Total Price</th>

                                                      
                                                        <th scope="col" class="text-end" style="width: 105px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="newlink">
                                                    <tr id="1" class="product">
                                                        <th scope="row" class="product-id">1</th>
                                                        <td>
                                                            <input type="number" class="form-control product-price" id="batchnumber" step="0.01" placeholder="### " required >
                                                            <div class="invalid-feedback">
                                                                Please enter a bnumber  
                                                            </div>
                                                        </td>
                                                        <td class="text-start">
                                                            <div class="mb-2">
                                                            <select data-style="dsf" id="product" name="product"   class="form-control"   required>
                                                   
                                                   <option value="">--Select Products--</option>
            @foreach($product as $products)
             <option value="{{$products->id}}" data-price="{{$products->price}}">{{$products->title}}</option>
             @endforeach
                                               </select>   
                                                                                                  <div class="invalid-feedback">
                                                                    Please enter a product name
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                        <input type="text" class="form-control"  placeholder="Product Name"  >
                                                            <div class="invalid-feedback">
                                                                Please enter a rate
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="input-step">
                                                                <button type="button" class='minus'>–</button>
                                                                <input type="number" class="product-quantity" id="product-qty-1" value="0" >
                                                                <button type="button" class='plus'>+</button>
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >
                                                            </div>
                                                        </td>
                                                        <td class="text-end">
                                                            <div>
                                                                <input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >
                                                            </div>
                                                        </td>
                                                        <td class="product-removal">
                                                            <a href="javascript:void(0)" class="btn btn-danger">Delete</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tbody>
                                                    <tr id="newForm" style="display: block;"><td class="d-none" colspan="5"><p>Add New Form</p></td></tr>
                                                    <tr>
                                                        <td colspan="5">
                                                            <a href="javascript:new_link()" id="add-item" class="btn btn-soft-secondary fw-medium"><i class="ri-add-fill me-1 align-bottom"></i> Add Item</a>
                                                        </td>
                                                    </tr>
                                                    <tr class="border-top border-top-dashed mt-2">
                                                        <td colspan="3"></td>
                                                        <td colspan="2" class="p-0">
                                                            <table class="table table-borderless table-sm table-nowrap align-middle mb-0">
                                                                <tbody>
                                                                    <tr>
                                                                        <th scope="row">Sub Total</th>
                                                                        <td style="width:150px;">
                                                                            <input type="text" class="form-control" id="cart-subtotal" placeholder="$0.00" readonly >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Estimated Tax (12.5%)</th>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="cart-tax" placeholder="$0.00" readonly >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Discount <small class="text-muted">(VELZON15)</small></th>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="cart-discount" placeholder="$0.00" readonly >
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <th scope="row">Shipping Charge</th>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="cart-shipping" placeholder="$0.00" readonly >
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="border-top border-top-dashed">
                                                                        <th scope="row">Total Amount</th>
                                                                        <td>
                                                                            <input type="text" class="form-control" id="cart-total" placeholder="$0.00" readonly >
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
                                                    <label for="choices-payment-type" class="form-label text-muted text-uppercase fw-semibold">Payment Details</label>
                                                    <select name= "pmethod" class="form-control" data-choices data-choices-search-false data-choices-removeItem id="choices-payment-type">
                                                        <option value="">Payment Method</option>
                                                        <option value="Mastercard">Mastercard</option>
                                                        <option value="Credit Card">Credit Card</option>
                                                        <option value="Visa">Visa</option>
                                                        <option value="Paypal">Paypal</option>
                                                    </select>
                                                </div>
                                                <div class="mb-2">
                                                    <input class="form-control" type="text" id="cardholderName" placeholder="Card Holder Name">
                                                </div>
                                                <div class="mb-2">
                                                    <input class="form-control" type="text" id="cardNumber" placeholder="xxxx xxxx xxxx xxxx">
                                                </div>
                                                <div>
                                                    <input class="form-control " type="text" id="amountTotalPay" placeholder="$0.00" readonly >
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                        <div class="mt-4">
                                            <label for="exampleFormControlTextarea1" class="form-label text-muted text-uppercase fw-semibold">NOTES</label>
                                            <textarea class="form-control alert alert-warning" id="exampleFormControlTextarea1" placeholder="Notes" rows="2" required>All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or credit card or direct payment online. If account is not paid within 7 days the credits details supplied as confirmation of work undertaken will be charged the agreed quoted fee noted above.</textarea>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                                            <button type="submit" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Save</button>
                                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download Invoice</a>
                                            <a href="javascript:void(0);" class="btn btn-danger"><i class="ri-send-plane-fill align-bottom me-1"></i> Send Invoice</a>
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
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>
<script>

    </script>
<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>


<script>
  /*
Template Name: Toner eCommerce + Admin HTML Template
Author: Themesbrand
Website: https://Themesbrand.com/
Contact: Themesbrand@gmail.com
File: Invoice create init Js File
*/

var paymentSign = "$";
Array.from(document.getElementsByClassName("product-line-price")).forEach(function (item) {
	item.value = paymentSign +"0.00"
});
function otherPayment() {
	var paymentType = document.getElementById("choices-payment-currency").value;
	paymentSign = paymentType;


	Array.from(document.getElementsByClassName("product-line-price")).forEach(function (item) {
			isUpdate = item.value.slice(1);
			item.value = paymentSign + isUpdate;
		});

	recalculateCart();
}

var isPaymentEl = document.getElementById("choices-payment-currency");
var choices = new Choices(isPaymentEl, {
	searchEnabled: false
});

// Profile Img
document
	.querySelector("#profile-img-file-input")
	.addEventListener("change", function () {
		var preview = document.querySelector(".user-profile-image");
		var file = document.querySelector(".profile-img-file-input").files[0];
		var reader = new FileReader();
		reader.addEventListener(
			"load",
			function () {
				preview.src = reader.result;
				//localStorage.setItem("invoiceLogo", reader.result);
			},
			false
		);
		if (file) {
			reader.readAsDataURL(file);
		}
	});

flatpickr("#date-field", {
	enableTime: true,
	dateFormat: "d M, Y, h:i K",
});

isData();

function isData() {
	var plus = document.getElementsByClassName("plus"),
		minus = document.getElementsByClassName("minus");

	if (plus) {
		Array.from(plus).forEach(function (e) {
			e.onclick = function (event) {
				if (parseInt(e.previousElementSibling.value) < 10) {
					event.target.previousElementSibling.value++;

					var itemAmount = e.parentElement.parentElement.previousElementSibling.querySelector(".product-price").value;

					var priceselection = e.parentElement.parentElement.nextElementSibling.querySelector(".product-line-price");

					var productQty = e.parentElement.querySelector(".product-quantity").value;

					updateQuantity(productQty, itemAmount, priceselection);
				}
			}
		});

	}

	if (minus) {
		Array.from(minus).forEach(function (e) {
			e.onclick = function (event) {
				if (parseInt(e.nextElementSibling.value) > 1) {
					event.target.nextElementSibling.value--;
					var itemAmount = e.parentElement.parentElement.previousElementSibling.querySelector(".product-price").value;
					var priceselection = e.parentElement.parentElement.nextElementSibling.querySelector(".product-line-price");
					// var productQty = 1;
					var productQty = e.parentElement.querySelector(".product-quantity").value;
					updateQuantity(productQty, itemAmount, priceselection);
				}
			};
		});
	}
}

var count = 1;

function new_link() {
	count++;
	var tr1 = document.createElement("tr");
	tr1.id = count;
	tr1.className = "product";

	var delLink =
		"<tr>" +
		'<th scope="row" class="product-id">' +
		count +
		"</th>" +
    '<td>'+
    '<input type="number" class="form-control product-price" id="batchnumber" step="0.01" placeholder="### " required >'+
    '<div class="invalid-feedback">'+  
    '</div>'+
'</td>'+
		'<td class="text-start">' +
		'<div class="mb-2">' +
		'<input class="form-control bg-light border-0" type="text" id="productName-' + count + '" placeholder="Product Name">' +
		'</div>' +
		"</div>" +
		"</td>" +
		"<td>" +
		'<input class="form-control bg-light border-0 product-price" type="number" id="productRate-' + count + '" step="0.01" placeholder="$0.00">' +
		"</td>" +
		"<td>" +
		'<div class="input-step">' +
		'<button type="button" class="minus">–</button>' +
		'<input type="number" class="product-quantity" id="product-qty-' + count + '" value="0" readonly>' +
		'<button type="button" class="plus">+</button>' +
		"</div>" +
		"</td>" +
		'<td class="text-end">' +
		"<div>" +
		'<input type="text" class="form-control bg-light border-0 product-line-price" id="productPrice-' + count + '" value="$0.00" placeholder="$0.00" />' +
		"</div>" +
		"</td>" +
		
    '<td class="text-end">'+
    "<div>"+
    '<input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  />'+
    '</div>'+
                                                        '</td>'+
                                                        '<td class="text-end">'+
                                                            '<div>'+
                                                                '<input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >'+
                                                            '</div>'+
                                                        '</td>'+
                                                        '<td class="text-end">'+
                                                            '<div>'+
                                                                '<input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >'+
                                                            '</div>'+
                                                        '</td>'+
                                                        '<td class="text-end">'+
                                                            '<div>'+
                                                                '<input type="text" class="form-control product-line-price" id="productPrice-1" placeholder="₹ 0.00"  >'+
                                                            '</div>'+
                                                        '</td>'+  
                                                        '<td class="product-removal">' +
		'<a class="btn btn-danger">Delete</a>' +
		"</td>" +
		"</tr>";

	tr1.innerHTML = document.getElementById("newForm").innerHTML + delLink;

	document.getElementById("newlink").appendChild(tr1);
	var genericExamples = document.querySelectorAll("[data-trigger]");
	Array.from(genericExamples).forEach(function (genericExamp) {
		var element = genericExamp;
		new Choices(element, {
			placeholderValue: "This is a placeholder set in the config",
			searchPlaceholderValue: "This is a search placeholder",
		});
	});

	isData();
	remove();
	amountKeyup();
	resetRow()
}

remove();
/* Set rates + misc */
var taxRate = 0.125;
var shippingRate = 65.0;
var discountRate = 0.15;

function remove() {
	Array.from(document.querySelectorAll(".product-removal a")).forEach(function (el) {
		el.addEventListener("click", function (e) {
			removeItem(e);
			resetRow()
		});
	});
}

function resetRow() {

	Array.from(document.getElementById("newlink").querySelectorAll("tr")).forEach(function (subItem, index) {
		var incid = index + 1;
		subItem.querySelector('.product-id').innerHTML = incid;

	});
}

/* Recalculate cart */
function recalculateCart() {
	var subtotal = 0;

	Array.from(document.getElementsByClassName("product")).forEach(function (item) {
		Array.from(item.getElementsByClassName("product-line-price")).forEach(function (e) {
			if (e.value) {
				subtotal += parseFloat(e.value.slice(1));
			}
		});
	});

	/* Calculate totals */
	var tax = subtotal * taxRate;
	var discount = subtotal * discountRate;

	var shipping = subtotal > 0 ? shippingRate : 0;
	var total = subtotal + tax + shipping - discount;

	document.getElementById("cart-subtotal").value =
		paymentSign + subtotal.toFixed(2);
	document.getElementById("cart-tax").value = paymentSign + tax.toFixed(2);
	document.getElementById("cart-shipping").value =
		paymentSign + shipping.toFixed(2);
	document.getElementById("cart-total").value = paymentSign + total.toFixed(2);
	document.getElementById("cart-discount").value =
		paymentSign + discount.toFixed(2);
	document.getElementById("totalamountInput").value =
		paymentSign + total.toFixed(2);
	document.getElementById("amountTotalPay").value =
		paymentSign + total.toFixed(2);
}

function amountKeyup() {

	// var listArray = [];

	// listArray.push(document.getElementsByClassName('product-price'));
	Array.from(document.getElementsByClassName('product-price')).forEach(function (item) {
		item.addEventListener('keyup', function (e) {

			var priceselection = item.parentElement.nextElementSibling.nextElementSibling.querySelector('.product-line-price');

			var amount = e.target.value;
			var itemQuntity = item.parentElement.nextElementSibling.querySelector('.product-quantity').value;

			updateQuantity(amount, itemQuntity, priceselection);

		});
	});
}

amountKeyup();
/* Update quantity */
function updateQuantity(amount, itemQuntity, priceselection) {
	var linePrice = amount * itemQuntity;
	/* Update line price display and recalc cart totals */
	linePrice = linePrice.toFixed(2);
	priceselection.value = paymentSign + linePrice;

	recalculateCart();

}

 

/* Remove item from cart */
function removeItem(removeButton) {
	removeButton.target.closest("tr").remove();
	recalculateCart();
}

//Choise Js
var genericExamples = document.querySelectorAll("[data-trigger]");
Array.from(genericExamples).forEach(function (genericExamp) {
	var element = genericExamp;
	new Choices(element, {
		placeholderValue: "This is a placeholder set in the config",
		searchPlaceholderValue: "This is a search placeholder",
	});
});

//Address
function billingFunction() {
	if (document.getElementById("same").checked) {
		document.getElementById("shippingName").value =
			document.getElementById("billingName").value;
		document.getElementById("shippingAddress").value =
			document.getElementById("billingAddress").value;
		document.getElementById("shippingPhoneno").value =
			document.getElementById("billingPhoneno").value;
		document.getElementById("shippingTaxno").value =
			document.getElementById("billingTaxno").value;
	} else {
		document.getElementById("shippingName").value = "";
		document.getElementById("shippingAddress").value = "";
		document.getElementById("shippingPhoneno").value = "";
		document.getElementById("shippingTaxno").value = "";
	}
}


var cleaveBlocks = new Cleave('#cardNumber', {
	blocks: [4, 4, 4, 4],
	uppercase: true
});

var genericExamples = document.querySelectorAll('[data-plugin="cleave-phone"]');
Array.from(genericExamples).forEach(function (genericExamp) {
	var element = genericExamp;
	new Cleave(element, {
		delimiters: ['(', ')', '-'],
		blocks: [0, 3, 3, 4]
	});
});

let viewobj;
var invoices_list = localStorage.getItem("invoices-list");
var options = localStorage.getItem("option");
var invoice_no = localStorage.getItem("invoice_no");
var invoices = JSON.parse(invoices_list);

if (localStorage.getItem("invoice_no") === null && localStorage.getItem("option") === null) {
	viewobj = '';
	var value = "#VL" + Math.floor(11111111 + Math.random() * 99999999);
    document.getElementById("invoicenoInput").value = value;
} else {
    viewobj = invoices.find(o => o.invoice_no === invoice_no);
}

// Invoice Data Load On Form
if ((viewobj != '') && (options == "edit-invoice")) {
	
	document.getElementById("registrationNumber").value = viewobj.company_details.legal_registration_no;
	document.getElementById("companyEmail").value = viewobj.company_details.email;
	document.getElementById('companyWebsite').value = viewobj.company_details.website;
	new Cleave("#compnayContactno", {
		prefix: viewobj.company_details.contact_no,
		delimiters: ['(', ')', '-'],
		blocks: [0, 3, 3, 4]
	});
	document.getElementById("companyAddress").value = viewobj.company_details.address;
	document.getElementById("companyaddpostalcode").value = viewobj.company_details.zip_code;

	var preview = document.querySelectorAll(".user-profile-image");
    if (viewobj.img !== ''){
        preview.src = viewobj.img;
    }

	document.getElementById("invoicenoInput").value = "#VAL" + viewobj.invoice_no;
	document.getElementById("invoicenoInput").setAttribute('readonly',true);
	document.getElementById("date-field").value = viewobj.date;
	document.getElementById("choices-payment-status").value = viewobj.status;
	document.getElementById("totalamountInput").value = "$" + viewobj.order_summary.total_amount;

	document.getElementById("billingName").value = viewobj.billing_address.full_name;
	document.getElementById("billingAddress").value = viewobj.billing_address.address;
	new Cleave("#billingPhoneno", {
		prefix: viewobj.company_details.contact_no,
		delimiters: ['(', ')', '-'],
		blocks: [0, 3, 3, 4]
	});
	document.getElementById("billingTaxno").value = viewobj.billing_address.tax;

	document.getElementById("shippingName").value = viewobj.shipping_address.full_name;
	document.getElementById("shippingAddress").value = viewobj.shipping_address.address;
	new Cleave("#shippingPhoneno", {
		prefix: viewobj.company_details.contact_no,
		delimiters: ['(', ')', '-'],
		blocks: [0, 3, 3, 4]
	});

	document.getElementById("shippingTaxno").value = viewobj.billing_address.tax;

	var paroducts_list = viewobj.prducts;
	var counter = 1;
	do {
		counter++;
		if (paroducts_list.length > 1) {
            document.getElementById("add-item").click();
        }
	} while (paroducts_list.length - 1 >= counter);

	var counter_1 = 1;

	setTimeout(() => {
		Array.from(paroducts_list).forEach(function (element) {
			document.getElementById("productName-" + counter_1).value = element.product_name;
			document.getElementById("productDetails-" + counter_1).value = element.product_details;
			document.getElementById("productRate-" + counter_1).value = element.rates;
			document.getElementById("product-qty-" + counter_1).value = element.quantity;
			document.getElementById("productPrice-" + counter_1).value = "$" + ((element.rates) * (element.quantity));
			counter_1++;
		});
	}, 300);

	document.getElementById("cart-subtotal").value = "$" + viewobj.order_summary.sub_total;
	document.getElementById("cart-tax").value = "$" + viewobj.order_summary.estimated_tex;
	document.getElementById("cart-discount").value = "$" + viewobj.order_summary.discount;
	document.getElementById("cart-shipping").value = "$" + viewobj.order_summary.shipping_charge;
	document.getElementById("cart-total").value = "$" + viewobj.order_summary.total_amount;

	document.getElementById("choices-payment-type").value = viewobj.payment_details.payment_method;
	document.getElementById("cardholderName").value = viewobj.payment_details.card_holder_name;

	var cleave = new Cleave('#cardNumber', {
		prefix: viewobj.payment_details.card_number,
		delimiter: ' ',
		blocks: [4, 4, 4, 4],
		uppercase: true
	});
	document.getElementById("amountTotalPay").value = "$" + viewobj.order_summary.total_amount;

	document.getElementById("exampleFormControlTextarea1").value = viewobj.notes;

}

document.addEventListener("DOMContentLoaded", function () {
	// //Form Validation
	var formEvent = document.getElementById('invoice_form');
	var forms = document.getElementsByClassName('needs-validation');

	// Loop over them and prevent submission
	formEvent.addEventListener("submit", function (event) {
		event.preventDefault();

		// get fields value
		var i_no = (document.getElementById("invoicenoInput").value).slice(4);
		var email = document.getElementById("companyEmail").value;
		var date = document.getElementById("date-field").value;
        var invoice_amount = (document.getElementById("totalamountInput").value).slice(1);
        var status = document.getElementById("choices-payment-status").value;
        var billing_address_full_name = document.getElementById("billingName").value;
        var billing_address_address = document.getElementById("billingAddress").value;
        var billing_address_phone = (document.getElementById("billingPhoneno").value).replace(/[^0-9]/g, "");
        var billing_address_tax = document.getElementById("billingTaxno").value;
        var shipping_address_full_name = document.getElementById("shippingName").value;
        var shipping_address_address = document.getElementById("shippingAddress").value;
        var shipping_address_phone = (document.getElementById("shippingPhoneno").value).replace(/[^0-9]/g, "");
        var shipping_address_tax = document.getElementById("shippingTaxno").value;
        var payment_details_payment_method = document.getElementById("choices-payment-type").value;
        var payment_details_card_holder_name = document.getElementById("cardholderName").value;
        var payment_details_card_number = (document.getElementById("cardNumber").value).replace(/[^0-9]/g, "");
        var payment_details_total_amount = (document.getElementById("amountTotalPay").value).slice(1);
        var company_details_legal_registration_no = (document.getElementById("registrationNumber").value).replace(/[^0-9]/g, "");
        var company_details_email = document.getElementById("companyEmail").value;
        var company_details_website = document.getElementById('companyWebsite').value;
        var company_details_contact_no = (document.getElementById("compnayContactno").value).replace(/[^0-9]/g, "");
		var company_details_address = document.getElementById("companyAddress").value;
		var company_details_zip_code = document.getElementById("companyaddpostalcode").value;
		var order_summary_sub_total = (document.getElementById("cart-subtotal").value).slice(1);
		var order_summary_estimated_tex = (document.getElementById("cart-tax").value).slice(1);
		var order_summary_discount = (document.getElementById("cart-discount").value).slice(1);
		var order_summary_shipping_charge = (document.getElementById("cart-shipping").value).slice(1);
		var order_summary_total_amount = (document.getElementById("cart-total").value).slice(1);
		var notes = document.getElementById("exampleFormControlTextarea1").value;

		// get product value and make array
		var products = document.getElementsByClassName("product");
		var count = 1;
		var new_product_obj = [];
		Array.from(products).forEach(element => {
			var product_name = element.querySelector("#productName-"+count).value;
			var product_details = element.querySelector("#productDetails-"+count).value;
			var product_rate = parseInt(element.querySelector("#productRate-"+count).value);
			var product_qty = parseInt(element.querySelector("#product-qty-"+count).value);
			var product_price = (element.querySelector("#productPrice-"+count).value).split("$");;
			
			var product_obj = {
				product_name: product_name,
				product_details: product_details,
				rates: product_rate,
				quantity: product_qty,
				amount: parseInt(product_price[1])
			}
			new_product_obj.push(product_obj);
			count++;
		});
		
		if (formEvent.checkValidity() === false) {
			formEvent.classList.add("was-validated");
		} else {
			if ((options == "edit-invoice") && (invoice_no == i_no)) {
				objIndex = invoices.findIndex((obj => obj.invoice_no == i_no));

				invoices[objIndex].invoice_no = i_no;
				invoices[objIndex].customer = billing_address_full_name;
				invoices[objIndex].img = '';
				invoices[objIndex].email = email;
				invoices[objIndex].date = date;
				invoices[objIndex].invoice_amount = invoice_amount;
				invoices[objIndex].status = status;
				invoices[objIndex].billing_address = {
					full_name: billing_address_full_name,
					address: billing_address_address,
					phone: billing_address_phone,
					tax: billing_address_tax
				};
				invoices[objIndex].shipping_address = {
					full_name: shipping_address_full_name,
					address: shipping_address_address,
					phone: shipping_address_phone,
					tax: shipping_address_tax
				};
				invoices[objIndex].payment_details = {
					payment_method: payment_details_payment_method,
					card_holder_name: payment_details_card_holder_name,
					card_number: payment_details_card_number,
					total_amount: payment_details_total_amount
				};
				invoices[objIndex].company_details = {
					legal_registration_no: company_details_legal_registration_no,
					email: company_details_email,
					website: company_details_website,
					contact_no: company_details_contact_no,
					address: company_details_address,
					zip_code: company_details_zip_code
				};
				invoices[objIndex].order_summary = {
					sub_total: order_summary_sub_total,
					estimated_tex: order_summary_estimated_tex,
					discount: order_summary_discount,
					shipping_charge: order_summary_shipping_charge,
					total_amount: order_summary_total_amount,
				};
				invoices[objIndex].prducts = new_product_obj;
				invoices[objIndex].notes = notes;

				localStorage.removeItem("invoices-list");
				localStorage.removeItem("option");
				localStorage.removeItem("invoice_no");
				localStorage.setItem("invoices-list", JSON.stringify(invoices));
			} else {
				var new_data_object = {
					invoice_no: i_no,
					customer: billing_address_full_name,
					img: '',
					email: email,
					date: date,
					invoice_amount: invoice_amount,
					status: status,
					billing_address: {
						full_name: billing_address_full_name,
						address: billing_address_address,
						phone: billing_address_phone,
						tax: billing_address_tax
					},
					shipping_address: {
						full_name: shipping_address_full_name,
						address: shipping_address_address,
						phone: shipping_address_phone,
						tax: shipping_address_tax
					},
					payment_details: {
						payment_method: payment_details_payment_method,
						card_holder_name: payment_details_card_holder_name,
						card_number: payment_details_card_number,
						total_amount: payment_details_total_amount
					},
					company_details: {
						legal_registration_no: company_details_legal_registration_no,
						email: company_details_email,
						website: company_details_website,
						contact_no: company_details_contact_no,
						address: company_details_address,
						zip_code: company_details_zip_code
					},
					order_summary:{
						sub_total: order_summary_sub_total,
						estimated_tex: order_summary_estimated_tex,
						discount: order_summary_discount,
						shipping_charge: order_summary_shipping_charge,
						total_amount: order_summary_total_amount
					},
					prducts: new_product_obj,
					notes: notes
				};
				localStorage.setItem("new_data_object", JSON.stringify(new_data_object));
			}
			window.location.href = "invoices-list.html";
		}
	});
});

  </script>
<script>
       $("#product").change(function(){ 
        var element = $(this).find('option:selected'); 
        var myTag = element.attr("data-price"); 
        
        console.log("mtag",myTag); 
     //   $('#setMyTag').val(myTag); 
    }); 
    </script>
@endpush