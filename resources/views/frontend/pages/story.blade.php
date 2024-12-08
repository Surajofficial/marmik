@extends('frontend.layouts.master')

@section('title', 'Marmik || Our Story')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->
    @php
        $terms = DB::table('stories')->get();
    @endphp
    <!-- <section class="term-condition bg-primary1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h1 class="text-white mb-2">Our Story</h1>
                            <p class="text-white-75 mb-0">Last Updated {{ @$terms[0]->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <section class="section bg-ghost-dark mt-5 mb-0">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                                <li class="breadcrumb-item"><a href="/">Home</a></li>
                                <li class="breadcrumb-item">Story</li>
                            </ol>
                        </nav>
                        <div class="text-center">
                            <p class="h3 lh-base mx-5 m-lg-0  ">Our Story</p>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </section>

    <section class="section ">
        <div class="container">
            <div class="card term-card1 mb-0 br-5">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach ($terms as $data)
                                <h5 class="fs-18 fw-500 mb-3">{{ $data->title }}</h5>
                                <div class="d-flex gap-2 mb-2">
                                    <div class="flex-shrink-0">
                                        <i class="ri-flashlight-fill text-primary fs-15"></i>
                                    </div>
                                    <p>{!! $data->description !!}</p>
                                </div>
                            @endforeach
                            <!-- <div class="hstack justify-content-sm-end gap-2 mt-4">
                                    <a href="#!" class="btn btn-ghost-danger btn-hover me-3"><i class="ri-close-line align-bottom me-1"></i> Decline</a>
                                    <a href="#!" class="btn btn-success btn-hover">Accept Now</a>
                                </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('frontend.layouts.newsletter')

    <!-- End About Us -->



    <!-- End Shop Services Area -->

@endsection
