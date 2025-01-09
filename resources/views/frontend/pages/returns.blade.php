@extends('frontend.layouts.master')

@section('title', 'Marmik || Returns')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->
    @php
        $returns = DB::table('returns')->get();
    @endphp
    <section class="section bg-ghost-dark mt-5 mb-0" style="padding-top:100px">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Return Policy</li>
                        </ol>
                    </nav>
                    
                    <div class="text-center">
                            <p class="h3 lh-base mx-5 m-lg-0  ">Return Policy</p>
                        </div>
                    <!-- <p class="h3 lh-base mx-5 m-lg-0  ">Last Updated {{ @$terms[0]->updated_at }}</p> -->
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>

    <section class="section ">
        <div class="container">
            <div class="card term-card1 br-5 mb-0">
                <div class="card-body p-5">
                    <div class="row">
                        <div class="col-lg-12">
                            @foreach ($returns as $data)
                                <h5 class="fs-18 fw-500 mb-3">{{ $data->title }}</h5>

                                <p class="lh-sm">{!! $data->description !!}</p>
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
