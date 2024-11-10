@extends('frontend.layouts.master')

@section('title','Dr Awish || Order Track Page')

@section('main-content')
<section class="page-wrapper bg-primary1">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center d-flex align-items-center justify-content-between">
                        <h4 class="text-white mb-0">Order Confirm</h4>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-light justify-content-center mb-0 fs-15">
                                <li class="breadcrumb-item"><a href="#!">Shop</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Confirmation</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <!--end col-->
            </div>
            <!--end row-->
        </div>
        <!--end container-->
    </section>
    <!-- end page title -->

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body p-4 p-md-5">
                            <div class="text-center">
                                <img src="../assets/images/success-img.png" alt="" class="w-50">
                            </div>
                            <div class="text-center mt-5 pt-1">
                                <h4 class="mb-3 text-capitalize">Your Order Is Completed !</h4>
                                <p class="text-muted mb-2">You will receive an order confirmation email with details of your order.</p>
                                <p class="text-muted mb-0">Order Number: {{$order}}</p>
                                <div class="mt-4 pt-2 hstack gap-2 justify-content-center">
                                    <a href="{{route('account')}}" class="btn btn-primary btn-hover">View Order <i class="ri-arrow-right-line align-bottom ms-1"></i></a>
                                    <a href="{{route('home')}}" class="btn btn-soft-danger btn-hover">Back To Home <i class="ri-home-4-line align-bottom ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>
@endsection