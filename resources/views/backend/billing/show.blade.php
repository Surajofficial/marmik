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
                                <h4 class="mb-sm-0">Bill</h4>

                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="javascript: void(0);">Bill</a></li>
                                    </ol>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
					@php
                                $settings=DB::table('settings')->get();
                           
   
                            @endphp
                    <div class="row justify-content-center">
                        <div class="col-xxl-12">
                        @php
                                $settings=DB::table('settings')->get();
								$product = explode(',',$billing->product);
//dd($product);

$nproduct=DB::table('products')->whereIn('id',$product)->get();

                            @endphp
                        <div class="card mb-0" id="demo">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card-header border-bottom-dashed p-4">
                                        <div class="d-sm-flex">
                                            <div class="flex-grow-1">
                                            <img src="@foreach($settings as $data) {{$data->logo}} @endforeach"  class="card-logo card-logo-dark" alt="logo" height="26">
                                                <div class="mt-sm-5 mt-4">
                                                    <h6 class="text-muted text-uppercase fw-semibold fs-14">Address</h6>
                                                    <h6 id="billing-name"> @foreach($settings as $data) {{$data->address}} @endforeach</h6>
                                                    
                            <p class="text-muted mb-1"><span>Phone: +</span><span id="billing-phone-no"> @foreach($settings as $data) {{$data->phone}} @endforeach</span></p>
                                                </div>
                                            </div>
                                            <div class="flex-shrink-0 mt-sm-0 mt-3">
                                                <h6><span class="text-muted fw-normal">Legal Registration No:</span> <span id="legal-register-no"></span></h6>
                                                <h6><span class="text-muted fw-normal">Email:</span> <span id="email">@foreach($settings as $data) {{$data->email}} @endforeach</span></h6>
                                                <h6><span class="text-muted fw-normal">Website:</span> <a href="https://www.awwish.com/" class="link-primary" target="_blank" id="website">www.awwish.com</a></h6>
                                                <h6 class="mb-0"><span class="text-muted fw-normal">Contact No: </span><span id="contact-no"> @foreach($settings as $data) {{$data->phone}} @endforeach</span></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end card-header-->
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="row g-3">
                                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Invoice ID</p>
                            <h5 class="fs-14 mb-0"><span id="invoice-no">{{@$billing->id}}</span></h5>
                        </div>
                        <!--end col-->
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Date</p>
                            <h5 class="fs-14 mb-0"><span id="invoice-date">{{@$billing->created_at}}</span> <small class="text-muted" id="invoice-time">{{@$billing->update_at}}</small></h5>
                        </div>
                        <!--end col-->
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Payment Status</p>
                            <span class="badge bg-success-subtle text-success  fs-11" id="payment-status">{{@$billing->pstatus}}</span>
                        </div>
                        <div class="col-lg-3 col-6">
                            <p class="text-muted mb-2 text-uppercase fw-medium fs-12">Payment Method</p>
                            <span class="badge bg-success-subtle text-success  fs-11" id="payment-status">{{@$billing->pmethod}}</span>
                        </div>
                        
                        <!--end col-->
                    
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="card-body p-4 border-top border-top-dashed">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <h6 class="text-muted text-uppercase fw-semibold fs-14 mb-3">Billing Address</h6>
                                                <h6 id="billing-name">{{@$billing->billingName}}</h6>
                            <p class="text-muted mb-1" id="billing-address-line-1">{{@$billing->billingAddress}}</p>
                          
                                            </div>
                                            <!--end col-->
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                                <div class="col-lg-12">
                                    <div class="card-body p-4">
                                        <div class="table-responsive">
                                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                                <thead>
                                                    <tr class="table-active">
                                                        <th scope="col" style="width: 50px;">Billing</th>
                                                        <th scope="col">Product Details</th>
                                                        <th scope="col">Rate</th>
                                                        <th scope="col">Cgst(%)</th>
                                                        <th scope="col">Sgst(%)</th>
                                                        <th scope="col">Quantity</th>
                                                        <th scope="col" class="text-end">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="products-list">
												
                                                @php 
                                                $a=1;
                                                for($i=0;$i< count($nproduct);$i++)
                                                {
												
												@endphp

                                                    <tr>
                                                        <th scope="row">{{@$a}}</th>
                                                        <td class="text-start" style="padding:10px;margin-left:20px;">
                                                            {{@$nproduct[$i]->title}}
                                                          
                                                        </td>
                                                        @php 
                                                       $total_tax= (int)@$nproduct[$i]->cgst + (int)$nproduct[$i]->sgst;
								$qty = explode(',',$billing->qty);
								$nqty = $qty[$i];
								 $product = DB::table('products')->where('status','active')->where('id',$nproduct[$i]->id)->decrement('stock', $nqty);
								$pr = @$nproduct[$i]->price * $nqty ;
								$ptotal = $pr + ($pr * (@$nproduct[$i]->cgst  +@$nproduct[$i]->cgst))/100

                                            @endphp
                                  
                                                        <td>{{number_format(@$nproduct[$i]->price,2)}}</td>
                                                        <td>{{@$nproduct[$i]->cgst}}</td>
                                                        <td>{{@$nproduct[$i]->sgst}}</td>
                                                        <td>{{@$nqty}}</td>
                                                        <td class="text-end">{{$ptotal}}</td>
                                                    </tr>
                                                  
                                                @php
												$a++;
												}
												@endphp
                                                </tbody>
                                            </table><!--end table-->
                                        </div>
                                        <div class="border-top border-top-dashed mt-2">
                                            <table class="table table-borderless table-nowrap align-middle mb-0 ms-auto" style="width:250px">
                                            <tbody>
											<tr class="table">
                                                <th>Sub Total (INR) :</th>
                                                <td class="text-end">
                                              
                                                    <span class="fw-semibold cart-total">{{$billing->ptotal}}</span>
                                                </td>
                                            </tr>
											<tr class="table">
                                                <th>Discount (%) :</th>
                                                <td class="text-end">
                                              
                                                    <span class="fw-semibold cart-total">{{$billing->discount}}</span>
                                                </td>
                                            </tr>
                                            <tr class="table-active">
                                                <th>Total (INR) :</th>
                                                <td class="text-end">
                                              
                                                    <span class="fw-semibold cart-total">{{$billing->subtotal}}</span>
                                                </td>
                                            </tr>
											
                                            <tr>
                                           
                                            </tr>
                                        </tbody>
                                            </table>
                                            <!--end table-->
                                        </div>
                                        <div class="mt-3">
                                        @php
                        @$method=@$billing->pmethod;
                        @endphp
                                            <h6 class="text-muted text-uppercase fw-semibold mb-3">Payment Details:</h6>
                                            <p class="text-muted mb-1">Payment Method: <span class="fw-medium" id="payment-method">{{@$method}}</span></p>
                                        
                                            <p class="text-muted">Total Amount(words): <span class="fw-medium"></span><span id="card-total-amount"> {{Helper::inwords(@$billing->subtotal, $true = false)}}</span> Rupees Only</p>
                                        </div>
                                        <div class="mt-4">
                                            <div class="alert alert-info">
                                                <p class="mb-0"><span class="fw-semibold">NOTES:</span>
                                                    <span id="note">All accounts are to be paid within 7 days from receipt of invoice. To be paid by cheque or
                                                        credit card or direct payment online. If account is not paid within 7
                                                        days the credits details supplied as confirmation of work undertaken
                                                        will be charged the agreed quoted fee noted above.
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="hstack gap-2 justify-content-end mt-4">
                                           <button  id="print" onclick="invoice()" class="btn btn-primary"  ><i class="ri-download-2-line align-bottom me-1"></i> Print</button>

                                        </div>
                                    </div>
                                    <!--end card-body-->
                                </div><!--end col-->
                            </div><!--end row-->
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
              function invoice()
              {
                $("#accordionSidebar").attr("style","display:none;");
                $(".navbar").attr("style","display:none;");
                $("#print").attr("style","display:none;");
                $(".copyright").attr("style","display:none;");
                window.print();
              }

            </script>

@endpush