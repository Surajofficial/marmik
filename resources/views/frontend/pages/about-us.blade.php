@extends('frontend.layouts.master')

@section('title', 'Marmik || About Us')

@section('main-content')

    <section class="section bg-ghost-dark mt-5 mb-0">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-lg-6" style="margin-top: 60px;">
                    <div class="text-center">

                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                                <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">About Us</a></li>
                            </ol>
                        </nav>
                        <div class="text-center">
                            <p class="h3 lh-base mx-5 m-lg-0  ">About Us</p>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </section>

    <!-- About Us -->
    <section class="ecommerce-about bg-dark" style="padding-top:0px">
        <div class="effect d-none d-md-block">
            <div class="ecommerce-effect bg-primary"></div>
            <div class="ecommerce-effect bg-info"></div>
        </div>
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6">
                    @php
                        $settings = DB::table('settings')->get();
                    @endphp

                    <p class="fs-16 text-muted1 mb-5 mb-lg-3 lh-base">
                        @foreach ($settings as $data)
                            {!! $data->description !!}
                        @endforeach
                    </p>
                </div>
                <div class="col-lg-5">

                    <div class="ourStory img-hover-zoom img-hover-zoom--slowmo  br-5">
                        <img src="{{ $settings[0]->about_image }}" alt="about us" height="" class="img-fluid">

                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- <div class="ecommerce-about-cta1 mb-4 mb-md-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card card-animate br-5">
                        <div class="card-body">
                            <lord-icon src="https://cdn.lordicon.com/fcoczpqi.json" trigger="hover" target="div"
                                style="width:70px;height:70px">
                            </lord-icon>
                            <h5 class="fs-16 fw-500 my-3">25,000+ Happy Customer</h5>
                            <p class="text-muted">Customer happiness goes beyond customer satisfaction by creating an
                                emotional connection with a brand's.</p>

                            <a href="#!" class="link-effect link-dark my-3">Read More <i
                                    class="bi bi-arrow-right ms-2 "></i></a>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-animate br-5">
                        <div class="card-body">
                            <lord-icon src="https://cdn.lordicon.com/hbwqfgcf.json" trigger="hover" target="div"
                                style="width:70px;height:70px">
                            </lord-icon>
                            <h5 class="fs-16 fw-500 my-3">6+ Years of Experiences</h5>
                            <p class="text-muted">The years of experience you list on your resume represent the work
                                experience you have if you have little experience.</p>

                            <a href="#!" class="link-effect link-dark my-3">Read More <i
                                    class="bi bi-arrow-right ms-2"></i></a>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-animate br-5">
                        <div class="card-body">
                            <lord-icon src="https://cdn.lordicon.com/xhbsnkyp.json" trigger="hover" target="div"
                                style="width:70px;height:70px">
                            </lord-icon>
                            <h5 class="fs-16 fw-500 my-3">14 Awards Won</h5>
                            <p class="text-muted">The Global Content Awards celebrate excellence in content marketing and
                                rewards agencies and in-house teams.</p>

                            <a href="#!" class="link-effect link-dark my-3">Read More <i
                                    class="bi bi-arrow-right ms-2"></i></a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    @include('frontend.layouts.newsletter')

    <!-- End About Us -->

@endsection
