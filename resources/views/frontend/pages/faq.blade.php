@extends('frontend.layouts.master')

@section('title', 'Dr Awish || FAQ')

@section('main-content')


    <section class="section bg-ghost-dark mt-5 mb-0" style="padding-top:6.15rem">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">FAQ's</li>
                        </ol>
                    </nav>
                    <p class="h3 lh-base mx-5 m-lg-0  ">Frequently Asked Questions</p>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>

    <section class="section mb-0">
        <div class="container">
            {{-- <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="text-center">
                        <h3>Have any Questions ?</h3>
                        <p class="text-muted mb-4">You can ask anything you want to know about Feedback.</p>
                        <div class="hstack flex-wrap gap-2 justify-content-center">
                            <button type="button" class="btn btn-danger btn-label rounded-pill"><i
                                    class="ri-mail-line label-icon align-middle rounded-pill fs-16"></i> Email Us</button>
                            <button type="button" class="btn btn-info btn-label rounded-pill"><i
                                    class="ri-twitter-line label-icon align-middle rounded-pill fs-16"></i> Send Us
                                Tweet</button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="row mt-5">
                <div class="col-lg-3 col-md-6">
                    <div class="card text-center br-5 mt-4 position-relative">
                        <div class="card-body">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-dark-subtle text-dark rounded-circle h1 m-0">
                                    <i class="bi bi-box-seam"></i>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Order</a></h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center br-5 mt-4">
                        <div class="card-body">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-dark-subtle text-dark rounded-circle h1 m-0">
                                    <i class="bi bi-cash-coin"></i>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Payments</a></h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center br-5 mt-4">
                        <div class="card-body">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-dark-subtle text-dark rounded-circle h1 m-0">
                                    <i class="bi bi-truck"></i>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Delivery</a></h5>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="card text-center br-5 mt-4">
                        <div class="card-body">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-dark-subtle text-dark rounded-circle h1 m-0">
                                    <i class="bi bi-bag-dash"></i>
                                </div>
                            </div>
                            <h5 class="fs-16 mb-3"><a href="#" class="text-body stretched-link">Returns</a></h5>
                        </div>
                    </div>
                </div>
            </div>
        </div><!--end container-->
    </section>
    <section class="section bg-color-light mb-0">
        <div class="container">
            <div class="row gy-4 justify-content-center mt-2">
                <div class="col-xxl-8 col-lg-8">
                    <div>
                        <div class="mb-4">
                            <h5 class="fs-16 mb-0 fw-semibold">General Questions</h5>
                        </div>
                        @php
                            $terms = DB::table('faqs')->get();
                            // dd($terms);
                        @endphp
                        <div class="accordion accordion-border-box" id="genques-accordion">
                            @foreach ($terms as $key => $data)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="genques-heading{{ $key }}">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#genques-collapse{{ $key }}" aria-expanded="true"
                                            aria-controls="genques-collapse{{ $key }}">
                                            {{ $data->title }}
                                        </button>
                                    </h2>
                                    <div id="genques-collapse{{ $key }}"
                                        class="accordion-collapse collapse show bg-white"
                                        aria-labelledby="genques-heading{{ $key }}"
                                        data-bs-parent="#genques-accordion">
                                        <div class="accordion-body">
                                            {!! $data->answer !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--end accordion-->
                    </div>
                </div><!--end col-->
            </div>
        </div>
    </section>

    <section class="section"
        style="background-image: url('../assets/images/profile-bg.jpg'); background-size: cover;background-position: center;">
        <div class="bg-overlay bg-secondary" style="opacity: 0.85;"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="d-sm-flex align-items-center">
                        <h2 class="text-white text-capitalize mb-0 flex-grow-1">Let us know how we can help you</h2>
                        <div class="flex-shrink-0 mt-3 mt-sm-0">
                            <a href="{{ route('contact') }}" class="btn btn-darken-secondary btn-hover"><i
                                    class="ph-phone align-middle me-1"></i> Contact Us</a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>
    <!-- End About Us -->



    <!-- End Shop Services Area -->

@endsection
