@extends('frontend.layouts.master')

@section('title', 'Dr Awish || {{ $title }}')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->


    <section class="section mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                        <li class="breadcrumb-item"><a href="{{URL::to('/')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">{{ $title }}</a></li>

                    </ol>
                </nav>
                <!-- <div class="col-lg-12">
                        <div class="mb-5 text-center">
                            <h2 class="mb-3">{{ $title }}</h2>
                            <p class="text-muted fs-15 mb-0">Browser the collection of our top {{ $title }}.</p>
                        </div>
                    </div> -->
                <!--end col-->
            </div><!--end row-->

            @if ($type)

                <div class="row justify-content-center">
                    @foreach ($type as $types)
                        <div class="col-lg-3 col-md-6 m-3">
                            <div class="card concern-card img-hover-zoom overflow-hidden img-hover-zoom--slowmo shadow-lg overflow-hidden br-5 w-100 "
                                style="border-radius: 25px">

                                @php
                                    $photo = explode(',', $types->photo);
                                    //dd($types);
                                    if ($types->parent_id == null) {
                                        $url = $href . $types->slug;
                                    } else {
                                        $link = $_SERVER['PHP_SELF'];
                                        $link_array = explode('/', $link);
                                        $page = end($link_array);
                                        $url = '../' . $href . $page . '/' . $types->slug;
                                    }

                                @endphp
                                @foreach ($photo as $data)
                                    @if ($title != 'Brand')
                                        <img src="{{ $data }}" alt="{{ $data }}" class=" img-fluid w-100 ">
                                    @endif
                                @endforeach
                                <div class="card-img-overlay1 category-btn2">
                                    <div class="d-flex align-items-center justify-content-between p-3 ">
                                        <div>
                                            <h6 class="fw-500 mb-2">{{ $types->title }} </h6>
                                            <p class="fs-14 text-muted"> 23 items</p>
                                        </div>

                                        <a href="{{ $url }}"> <span
                                                href="{{ $url }}"class="btn btn-icon btn-topbar btn-light-dark  rounded-circle  fw-bold shadow-lg"><i
                                                    class="bi bi-arrow-right-short fs-bold text-light1 fs-1"></i></span></a>
                                    </div>
                                </div>
                            </div><!--end card-->
                        </div><!--end col-->
                    @endforeach
                </div><!--end row-->

            @endif
        </div><!--end container-->
    </section>
    @include('frontend.layouts.newsletter')


    <script>
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 1,
            spaceBetween: 15,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
                clickable: true,
            },
            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            breakpoints: {
                640: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 4,
                },
            },
        });
    </script>
@endsection
