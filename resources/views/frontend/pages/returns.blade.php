@extends('frontend.layouts.master')

@section('title', 'Marmik || Returns')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->
    @php
        $returns = DB::table('returns')->get();
    @endphp
    <section class="term-condition bg-primary1" style="margin-top: 120px;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="text-center">
                        <h1 class="text-white mb-2">Return Policy</h1>
                        <p class="text-white-75 mb-0">Last Updated {{ @$returns[0]->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="position-relative">
        <div class="svg-shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="1440"
                height="120" preserveAspectRatio="none" viewBox="0 0 1440 120">
                <g mask="url(&quot;#SvgjsMask1039&quot;)" fill="none">
                    <rect width="1440" height="120" x="0" y="0" fill="var(--tb-primary)"></rect>
                    <path d="M 0,85 C 288,68.8 1152,20.2 1440,4L1440 120L0 120z" fill="var(--tb-body-bg)"></path>
                </g>
                <defs>
                    <mask id="SvgjsMask1039">
                        <rect width="1440" height="120" fill="#ffffff"></rect>
                    </mask>
                </defs>
            </svg>
        </div>
    </div>

    <section class="section pt-0">
        <div class="container">
            <div class="card term-card mb-0" style="margin-top: 0px;">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach ($returns as $data)
                                <h5 class="fs-18 mb-3">{{ $data->title }}</h5>
                                <div class="d-flex gap-2 mb-2">
                                    <div class="flex-shrink-0">
                                        <i class="ri-flashlight-fill text-primary fs-15"></i>
                                    </div>
                                    <p class="text-muted fs-15  mb-0">{!! $data->description !!}</p>
                                </div>
                            @endforeach

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
