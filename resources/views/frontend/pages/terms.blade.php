@extends('frontend.layouts.master')

@section('title', 'Marmik || Terms & Condition')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->
    @php
        $terms = DB::table('terms')->get();
    @endphp
    <!-- <section class="term-condition bg-primary1">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="text-center">
                            <h1 class="text-white mb-2">Terms of Conditions</h1>
                            <p class="text-white-75 mb-0">Last Updated {{ @$terms[0]->updated_at }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->
    <section class="section bg-ghost-dark mt-5 mb-0" style="padding-top:100px">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Terms & Conditions</li>
                        </ol>
                    </nav>
                        <div class="text-center">
                            <p class="h3 lh-base mx-5 m-lg-0  ">Terms & Conditions</p>
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
                            @foreach ($terms as $data)
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


@endsection
