@extends('frontend.layouts.master')
@section('title', 'MARMIK || HOME PAGE')
@section('main-content')
@php
    $settings = DB::table('settings')->get();

    foreach ($settings as $data) {
        $cartcolor = $data->cartcolor;
    }

@endphp
<style>
    .card-img {
        margin: 10px;
        padding: 20px
    }

    .latest-slider .bg-light {
        background-color: transparent !important;
    }

    .latest-slider .bg-light img {
        display: block;
        margin: auto;
    }

    .latest-slider .category-btn1 .btn {
        font-size: 15px
    }

    .swiper-slide img {
        display: block;
        margin: auto;
        width: 100vw;
        height: auto;
        /* min-height: 300px; */
        margin-top: 40px;
    }

    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .hero-slider {
        padding: 0 30rem;
    }

    .social-content h2 {
        font-size: 25px !important;
        background: #fff;
        max-width: 290px;
        margin: auto;
        padding: 3px;
        border-radius: 20px;
        box-shadow: 6px 5px 15px rgba(0, 0, 0, .5);
    }
    .gallery-product:hover .scl{
        transform: scale(1.04) !important;
    }
    .nav .nav-link{
        color: #aaa;
    }
    .nav .nav-link:hover{
        color: #aaa;
    }
    .nav .nav-link.active {
        color: #fff !important; /* Active tab color */
    }

    @media(max-width:410px) {
        .sale-btn .nav-item button {
            font-size: 18px !important;
        }
    }

    @media(max-width:450px) {
        .social-content h2 {
            font-size: 18px !important;
            background: #fff;
            max-width: 250px;
            margin: auto;
        }

        .featured .nav-item button {
            /* font-size: 16px; */
            width: 110px;
        }
    }
</style>
<section class="position-relative p-0">
    <div class="swiper-container mt-2" id="homepage_slider">
        <div class="swiper-wrapper">

            @foreach ($banners as $key => $banner)
                        @php
                            $banner_photo = explode(',', $banner->photo);
                        @endphp
                        <div class="swiper-slide">
                            <picture>
                                <source media="(max-width: 760px)" srcset="{{ $banner_photo[0] ?? '' }}">
                                <source media="(min-width: 761px)" srcset="{{ $banner_photo[1] ?? '' }}">
                                <img src="{{ $banner_photo[0] ?? '' }}" alt="Image" loading="lazy">
                            </picture>
                        </div>
            @endforeach
        </div>
    </div>
    <div class="control-btn col-12">
        <span class="swiper-button-prev-banner prev swiper_btn"></span>
        <span class="swiper-button-next-banner next swiper_btn"></span>
    </div>
    </div>

</section>
<!-- START PRODUCT -->
<section class="py-5" style="background-color: black;" id="shopbyproducttype">
    <div class="container position-relative">
        <ul class="nav mb-3 featured" id="pills-tab" role="tablist">
            <li class="nav-item tab-item" role="presentation">
                <button class="nav-link tab-link fs-2 active" id="pills-home-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">Featured</button>
            </li>
            <li class="nav-item tab-item active" role="presentation">
                <button class="nav-link tab-link fs-2" id="pills-profile-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false">Bestseller</button>
            </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active " id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                @if ($featured)
                            <div class="row justify-content-center">
                                @foreach ($featured as $product)
                                                @php
                                                    $photo = explode(',', $product->product->photo);
                                                @endphp
                                                <div class="col-sm-10 col-md-6 col-lg-3 mb-3">
                                                    <div class="card shadow-lg overflow-hidden element-item rounded-4 p-0 h-100 w-100" >
                                                        <div class="gallery-product overflow-hidden">
                                                            {{-- @if ($product->stock > 0)
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                                    <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                                        style=" border-radius: 20px 20px 0 0;" class="img-fluid w-100 m-0"
                                                                        loading="lazy">
                                                                </a>
                                                            @else
                                                                <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                                    style=" border-radius: 20px 20px 0 0;" class="img-fluid w-100 m-0"
                                                                    loading="lazy">
                                                            @endif --}}
                                                            <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                                <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                                    style=" border-radius: 20px 20px 0 0;" class="img-fluid w-100 m-0"
                                                                    loading="lazy">
                                                            </a>
                                                        </div>
                                                        @if ($product->stock > 0)
                                                            <div class="product-btn">
                                                                <button data-slug="{{ $product->product->slug }}" data-variant="{{ $product->id }}"
                                                                    class="btn px-2 product-btn-hover rounded-pill w-75 add-btn addtocart card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Add to Cart</button>
                                                            </div>
                                                        @else
                                                            <div class="product-btn">
                                                                <button class="btn px-2 product-btn-hover rounded-pill w-75 add-btn  card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Out of Stock</button>
                                                            </div>
                                                        @endif
                                                        <div class="gallery-product-actions card-image-overlay">
                                                            <div class="mb-2">
                                                                <button type="button"
                                                                    class="wishlist-toggle btn btn-danger btn-sm custom-toggle rounded-5"
                                                                    data-product-id="{{ $product->product->id }}"
                                                                    data-product_variants-id="{{ $product->id }}">
                                                                    <i
                                                                        class="mdi mdi-heart{{ in_array($product->product->id, $wishlist_ids) ? '' : '-outline' }} align-bottom fs-15"></i>
                                                                </button>
                                                            </div>

                                                            <div>
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    class="btn btn-success btn-sm custom-toggle rounded-5 ">
                                                                    <span class="icon-on"><i
                                                                            class="mdi mdi-eye-outline align-bottom fs-15"></i></span>
                                                                    <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body pb-0">
                                                            <div>
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    class="w-100" style="white-space: unset;">
                                                                    <h6 class="fs-16 fw-500 mb-3 lh-base truncate-text  ">
                                                                        {{ $product->product->title }}
                                                                    </h6>
                                                                </a>
                                                                @php
                                                                    $after_discount =
                                                                        $product->price - ($product->price * $product->discount) / 100;

                                                                @endphp
                                                                @if ($product->stock <= 0)
                                                                    <div class="d-inline">
                                                                        <h4 class="fw-500 d-inline text-danger">Out of stock</h4>
                                                                        <h5 class=" d-inline fw-500">Rs.{{ $product->price }}
                                                                        </h5>
                                                                    </div>
                                                                @else
                                                                    @if ($product->display_price == $product->price)
                                                                        @if ($product->discount > 0)
                                                                            <h5 class="mb-0  fw-500">
                                                                                Rs.{{ number_format($after_discount, 2) }}
                                                                                <span class="fs-12 text-decoration-line-through"><del>Rs.
                                                                                        {{ number_format($product->price, 2) }}</del></span>
                                                                            </h5>
                                                                        @else
                                                                            <h5 class="mb-0 fw-500 ">
                                                                                Rs.{{ number_format($after_discount, 2) }}
                                                                            </h5>
                                                                        @endif
                                                                    @else
                                                                        <h5 class="mb-0  fw-500 ">
                                                                            Rs.{{ number_format($product->display_price) }}
                                                                            <span class=" fs-12 text-decoration-line-through"><del>Rs.
                                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                                        </h5>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                @endforeach

                            </div>
                            <!-- end product -->
                @endif
            </div>
            <div class="tab-pane fade " id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">

                @if ($best_seller)
                            <div class="row">

                                @foreach ($best_seller as $product)
                                                @php
                                                    $photo = explode(',', $product->product->photo);
                                                @endphp
                                                <div class="col-sm-12 col-md-4 col-lg-3 mb-3">
                                                    <div class="card shadow-lg overflow-hidden element-item rounded-4 p-0 h-100 w-100">
                                                        <div class="gallery-product overflow-hidden">
                                                            <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                                <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                                    style=" border-radius: 20px 20px 0 0;" class="img-fluid w-100 m-0">
                                                            </a>
                                                        </div>
                                                        @if ($product->stock > 0)
                                                            <div class="product-btn">
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    data-slug="{{ $product->product->slug }}" data-variant="{{ $product->id }}"
                                                                    class="btn px-2 product-btn-hover rounded-pill w-75 add-btn addtocart card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Add to Cart</a>
                                                            </div>
                                                        @else
                                                            <div class="product-btn">
                                                                <a href="javascript:void(0);"
                                                                    class="btn px-2 product-btn-hover rounded-pill w-75 add-btn card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Out of Stock</a>
                                                            </div>

                                                        @endif
                                                        <div class="gallery-product-actions card-image-overlay">
                                                            <div class="mb-2">
                                                                <!-- TODO:checkinput -->
                                                                <button type="button"
                                                                    class="wishlist-toggle btn btn-danger btn-sm custom-toggle rounded-5 ${checkinput}"
                                                                    data-product-id="{{ $product->product->id }}"
                                                                    data-product_variants-id="{{ $product->id }}">
                                                                    <i
                                                                        class="mdi mdi-heart{{ in_array($product->product->id, $wishlist_ids) ? '' : '-outline' }} align-bottom fs-15"></i>
                                                                </button>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    class="btn btn-success btn-sm custom-toggle rounded-5 ">
                                                                    <span class="icon-on"><i
                                                                            class="mdi mdi-eye-outline align-bottom fs-15"></i></span>
                                                                    <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body pb-0">
                                                            <div>
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    class="w-100" style="white-space: unset;">
                                                                    <h6 class="fs-16 fw-500 mb-3 lh-base truncate-text ">
                                                                        {{ $product->product->title }}
                                                                    </h6>
                                                                </a>
                                                                @php
                                                                    $after_discount =
                                                                        $product->price - ($product->price * $product->discount) / 100;
                                                                @endphp
                                                                {{-- @if ($product->display_price == $product->price)
                                                                    @if ($product->discount > 0)
                                                                        <h5 class="mb-0  fw-500 ">
                                                                            Rs.{{ number_format($after_discount, 2) }}
                                                                            <span class=" fs-12 text-decoration-line-through"><del>Rs.
                                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                                        </h5>
                                                                    @else
                                                                        <h5 class="mb-0 fw-500">
                                                                            Rs.{{ number_format($after_discount, 2) }}
                                                                        </h5>
                                                                    @endif
                                                                @else
                                                                    <h5 class="mb-0  fw-500 ">
                                                                        Rs.{{ number_format($product->display_price) }}
                                                                        <span class="fs-12 text-decoration-line-through"><del>Rs.
                                                                                {{ number_format($product->price, 2) }}</del></span>
                                                                    </h5>
                                                                @endif --}}

                                                                @if ($product->stock <= 0)
                                                                    <div class="d-inline">
                                                                        <h4 class="fw-500 d-inline text-danger">Out of stock</h4>
                                                                        <h5 class=" d-inline fw-500">Rs.{{ $product->price }}
                                                                        </h5>
                                                                    </div>
                                                                @else
                                                                    @if ($product->display_price == $product->price)
                                                                        @if ($product->discount > 0)
                                                                            <h5 class="mb-0  fw-500  ">
                                                                                Rs.{{ number_format($after_discount, 2) }}
                                                                                <span class=" fs-12 text-decoration-line-through"><del>Rs.
                                                                                        {{ number_format($product->price, 2) }}</del></span>
                                                                            </h5>
                                                                        @else
                                                                            <h5 class="mb-0 fw-500">
                                                                                Rs.{{ number_format($after_discount, 2) }}
                                                                            </h5>
                                                                        @endif
                                                                    @else
                                                                        <h5 class="mb-0  fw-500  ">
                                                                            Rs.{{ number_format($product->display_price) }}
                                                                            <span class=" fs-12 text-decoration-line-through"><del>Rs.
                                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                                        </h5>
                                                                    @endif
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                @endforeach

                            </div>
                            <!-- end product -->
                @endif
            </div>
            <div class="allProductButton  text-center mb-md-5 mt-4 mt-md-0">
                <a href="/" class="link-dark  link-effect border-bottom border-white text-light ">Shop All Products</a>
            </div>
        </div>
</section>



<!-- @if ($concern) -->
    <!-- <section class="py-5 bg-color-light" id="shopbyproducttype">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-content text-center mb-5">
                        <h2 class="display-6"> <b> Shop By Concern</b></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="swiper latest-slider  " id="common_slider">
                        <div class="swiper-wrapper">
                            @foreach ($concern as $item)
                                @php
                                    $photo = explode(',', $item->photo);
                                    $url = 'product-concern' . '/' . $item->slug;
                                @endphp
                                <div class="col-lg-12 col-md-6 swiper-slide">
                                    <div class="card concern-card img-hover-zoom img-hover-zoom--slowmo shadow-lg overflow-hidden br-5"
                                        style="border-radius: 25px">
                                        <a href="{{ route('product-concern', $item->slug) }}" class="overflow-hidden">
                                            <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}" class=" img-fluid w-100"
                                                loading="lazy"></a>
                                        <div class="card-img-overlay1 category-btn2">
                                            <div class="d-flex align-items-center justify-content-between p-3 ">
                                                <div>
                                                    <h6 class="fw-500 mb-2">{{ $item->title }} </h6>
                                                </div>

                                                <a href="{{ route('product-concern', $item->slug) }}"> <span
                                                        href="{{ route('product-concern', $item->slug) }}"
                                                        class="btn btn-icon btn-topbar btn-light-dark  rounded-circle  fw-bold shadow-lg"><i
                                                            class="bi bi-arrow-right-short fs-bold text-light1 fs-1"></i></span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                    <div class="control-btn col-12">
                        <span class="swiper-button-prev-top prev"></span>
                        <span class="swiper-button-next-top next"></span>
                    </div>
                </div>

            </div>

        </div>
    </section> -->
<!-- @endif -->
<!-- End Midium Banner -->
<!-- End Most Popular Area -->
@if ($product_type)
    <section class=" pb-5 mt-5" id="shopbyconcern">
        <div class="container-fluid p-2">
            <div class="row justify-content-center">
                <div class="col-lg-7">
                    <div class="section-content text-center mb-5">
                        <h2 class="display-6"> <b> Shop By Product Type</b></h2>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                <div class="col-12">
                    <div class="swiper latest-slider" id="common_slider">
                        <div class="swiper-wrapper">
                            @foreach ($product_type as $item)
                                @php
                                    $photo = explode(',', $item->photo);
                                @endphp
                                <div class="col-lg-12 col-md-6  swiper-slide">
                                    <div class="card  text-light concern-card img-hover-zoom img-hover-zoom--slowmo shadow-lg overflow-hidden br-5"
                                        style="border-radius: 25px; background-color:rgb(0,0,0)">
                                        <a href="{{ route('product-type', $item->slug) }}" class="overflow-hidden">
                                            <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}" class=" img-fluid w-100"
                                                loading="lazy"></a>
                                        <div class="card-img-overlay1 category-btn2">
                                            <div class="d-flex align-items-center justify-content-between p-3 ">
                                                <div>
                                                    <h6 class="fw-500 mb-2 text-light">{{ $item->title }} </h6>
                                                </div>
                                                <a href="{{ route('product-type', $item->slug) }}"> <span
                                                        href="{{ route('product-concern', $item->slug) }}"
                                                        class="btn btn-icon btn-topbar btn-light-dark  rounded-circle  fw-bold shadow-lg"><i
                                                            class="bi bi-arrow-right-short fs-bold text-light1 fs-1"></i></span></a>
                                            </div>

                                        </div>
                                    </div>
                                </div><!--end col-->
                            @endforeach
                        </div>

                    </div>
                    <div class="control-btn col-12">
                        <span class="swiper-button-prev-top prev"></span>
                        <span class="swiper-button-next-top next"></span>
                    </div>
                </div>

            </div><!--end row-->
        </div><!--end container-fluid-->
    </section>
@endif


<!-- @if ($promise)
    <section class="pt-4 pb-3 bg-dark bg-opacity-50 border-top border-bottom">
        <div class="container-fluid1">

            <marquee scrollamount="15">
                <div class="d-flex gy-5">
                    @foreach ($promise as $key => $promises)
                                @php
                                    $photo = explode(',', $promises->photo);
                                @endphp
                                <div class="certified-box1 text-center d-flex align-items-center gap-4">
                                    <div class="marquee-img">
                                        <img src="{{ $photo[0] }}" alt="" class="img-fluid" loading="lazy">
                                    </div>
                                    <span class="fs-1 text-capitalize mb-0">{{ $promises->title }}</span>
                                </div>
                    @endforeach

                </div>
            </marquee>
        </div>
    </section>
@endif -->

<!-- Start Special Offer -->
<section class="py-5" style="background-color: black;" id="shopbyproducttype">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col text-center text-light">
                <h2 class="display-6 text-light">Because you need time for yourself.</h2>
                <h2 class="display-6 mb-4 text-light"> Blend beauty in you</h2>
                <a href="/" class=" link-effect border-bottom border-black mb-5 text-light">Shop All Products</a>
                <h2> </h2>
            </div>
        </div>
        <ul class="nav mb-3 sale-btn" id="pills-tab" role="tablist">
            <li class="nav-item tab-item" role="presentation">
                <button class="nav-link tab-link fs-2 active" id="pills-sale-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-sale" type="button" role="tab" aria-controls="pills-sale"
                    aria-selected="true">Sale upto 15% off</button>
            </li>
            <li class="nav-item tab-item active" role="presentation">
                <button class="nav-link tab-link fs-2" id="pills-under-tab" data-bs-toggle="pill"
                    data-bs-target="#pills-under" type="button" role="tab" aria-controls="pills-under"
                    aria-selected="false">Under 499</button>
            </li>

        </ul>
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active " id="pills-sale" role="tabpanel" aria-labelledby="pills-sale-tab">
                @if ($discount30)
                            <div class="row">

                                @foreach ($discount30 as $product)
                                    @php
                                        $photo = explode(',', $product->product->photo);
                                    @endphp
                                    <div class="col-12 col-md-4 col-lg-3 mb-3" >
                                        <div class="card shadow-lg overflow-hidden element-item rounded-5 p-0 h-100 w-100">
                                            <div class="gallery-product overflow-hidden">
                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                    <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                        style=" border-radius: 25px 25px 0 0;" class="img-fluid w-100 m-0"
                                                        loading="lazy">
                                                </a>
                                            </div>
                                            @if ($product->stock <= 0)
                                                
                                                <div class="product-btn">
                                                    <a href="javascript:void(0);" class="btn  product-btn-hover rounded-pill w-75 add-btn card-mg-overlay"><i
                                                            class="mdi mdi-cart me-1"></i> Out of Stock</a>
                                                </div>
                                                <span style="color:red;width: 100%; margin-left:1rem; margin-top:1rem  ">Out of
                                                    stock</span>
                                            @else
                                                <div class="product-btn">
                                                    <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                        data-slug="{{ $product->product->slug }}" data-variant="{{ $product->id }}"
                                                        class="btn  product-btn-hover rounded-pill w-75 add-btn addtocart card-mg-overlay"><i
                                                            class="mdi mdi-cart me-1"></i> Add to Cart</a>
                                                </div>
                                            @endif
                                            <div class="gallery-product-actions card-image-overlay">
                                                <div class="mb-2">
                                                    <button type="button"
                                                        class="wishlist-toggle btn btn-danger btn-sm custom-toggle rounded-5"
                                                        data-product-id="{{ $product->product->id }}"
                                                        data-product_variants-id="{{ $product->id }}">
                                                        <i
                                                            class="mdi mdi-heart{{ in_array($product->product->id, $wishlist_ids) ? '' : '-outline' }} align-bottom fs-15"></i>
                                                    </button>
                                                </div>
                                                <div>
                                                    <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                        class="btn btn-success btn-sm custom-toggle rounded-5 ">
                                                        <span class="icon-on"><i
                                                                class="mdi mdi-eye-outline align-bottom fs-15"></i></span>
                                                        <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body pb-0">
                                                <div>

                                                    <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                        <h6 class="fs-16 fw-500 mb-3 lh-base truncate-text text-wrap">
                                                            {{ $product->product->title }}
                                                        </h6>
                                                    </a>
                                                    @php
                                                        $after_discount =
                                                            $product->price - ($product->price * $product->discount) / 100;
                                                    @endphp
                                                    <h5 class="mb-0 ">Rs.{{ number_format($after_discount, 2) }}
                                                        <span class="fs-12 text-decoration-line-through"><del>Rs.
                                                                {{ number_format($product->price, 2) }}</del></span>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <!-- end product -->
                @endif
            </div>
            <div class="tab-pane fade " id="pills-under" role="tabpanel" aria-labelledby="pills-under-tab">

                @if ($under499)
                            <div class="row">

                                @foreach ($under499 as $product)
                                                @php
                                                    $photo = explode(',', $product->product->photo);
                                                @endphp
                                                <div class="col-6 col-md-4 col-lg-3 mb-3">
                                                    <div class="card  shadow-lg overflow-hidden element-item rounded-5 p-0 h-100 w-100">
                                                        <div class="gallery-product overflow-hidden" style="">
                                                            <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                                <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                                                    style=" border-radius: 25px 25px 0 0;" class="img-fluid w-100 m-0"
                                                                    loading="lazy">
                                                            </a>
                                                        </div>
                                                        @if ($product->stock <= 0)
                                                            <div class="product-btn">
                                                                <a href="javascript:void(0);" class="btn  product-btn-hover rounded-pill w-75 add-btn card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Out of Stock</a>
                                                            </div>
                                                            <h5 style="color:red;width: 100%; margin-left:1rem; margin-top:1rem  ">Out of
                                                                stock</h5>
                                                        @else
                                                            <div class="product-btn">
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    data-slug="{{ $product->slug }}" data-variant="{{ $product->id }}"
                                                                    class="btn  product-btn-hover rounded-pill w-75 add-btn addtocart card-mg-overlay"><i
                                                                        class="mdi mdi-cart me-1"></i> Add to Cart</a>
                                                            </div>
                                                        @endif
                                                        <div class="gallery-product-actions card-image-overlay">
                                                            <div class="mb-2">
                                                                <!-- TODO:checkinput -->
                                                                <button type="button"
                                                                    class="wishlist-toggle btn btn-danger btn-sm custom-toggle rounded-5 ${checkinput}"
                                                                    data-product-id="{{ $product->product->id }}"
                                                                    data-product_variants-id="{{ $product->id }}">
                                                                    <i
                                                                        class="mdi mdi-heart{{ in_array($product->product->id, $wishlist_ids) ? '' : '-outline' }} align-bottom fs-15"></i>
                                                                </button>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}"
                                                                    class="btn btn-success btn-sm custom-toggle rounded-5 ">
                                                                    <span class="icon-on"><i
                                                                            class="mdi mdi-eye-outline align-bottom fs-15"></i></span>
                                                                    <span class="icon-off"><i class="mdi mdi-eye align-bottom fs-15"></i></span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="card-body  pb-0" style="background-color:rgb(0,0,0)">
                                                            <div>

                                                                <a href="{{ route('product-detail', [$product->product->slug, $product->id]) }}">
                                                                    <h6 class="fs-16 fw-500 mb-3 lh-base truncate-text text-wrap ">
                                                                        {{ $product->product->title }}
                                                                    </h6>
                                                                </a>
                                                                @php
                                                                    $after_discount =
                                                                        $product->price - ($product->price * $product->discount) / 100;
                                                                @endphp
                                                                @if ($product->display_price == $product->price)
                                                                    @if ($product->discount > 0)
                                                                        <h5 class="mb-0  fw-500 ">
                                                                            Rs.{{ number_format($after_discount, 2) }}
                                                                            <span class="text-muted fs-12 text-decoration-line-through"><del>Rs.
                                                                                    {{ number_format($product->price, 2) }}</del></span>
                                                                        </h5>
                                                                    @else
                                                                        <h5 class="mb-0 fw-500 ">
                                                                            Rs.{{ number_format($after_discount, 2) }}
                                                                        </h5>
                                                                    @endif
                                                                @else
                                                                    <h5 class="mb-0  fw-500 ">
                                                                        Rs.{{ number_format($product->display_price) }}
                                                                        <span class="text-muted fs-12 text-decoration-line-through"><del>Rs.
                                                                                {{ number_format($product->price, 2) }}</del></span>
                                                                    </h5>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                @endforeach

                            </div>
                            <!-- end product -->
                @endif

            </div>
</section>


<!-- testimonial start -->
@if ($testimonial)
    <section class="section pt-4 ">
        <div class="container-fluid">

            <h2 class="display-6 mt-3 mb-4 text-center"> <b> Over 2,000 Happy reviews</b></h2>

            <div class="row">
                <div class="col-lg-12">
                    <div class="swiper " id="feedback-slider">
                        <div class="swiper-wrapper">

                            @foreach ($testimonial as $testimonials)
                                <div class="card card-animate swiper-slide shadow-lg br-5 text-light" style="width: 18rem; background-color:black">
                                    <div class="card-body ml-100 p-0">
                                        <!-- style="text-align:center;border:2px solid white;border-radius:50%;" -->
                                        <div class="pt-10 ml-100" style="width:100%;">
                                            <div class="align-items-center d-flex  ">
                                                <img src="{{ $testimonials->photo }}" alt="{{ $testimonials->photo }}"
                                                    class=" img-fluid aligns-center" style="max-height:300px" loading="lazy">
                                                <!-- style="width:150px;height:150px;border:2px solid white;border-radius:200px;" -->
                                            </div>
                                        </div>
                                        <div class="client-desc p-4 ">
                                            <div class="flex-grow-11 mb-3 text-light ">
                                                <h4 class=" fw-500 mb-1 text-capitalize text-light">{{ $testimonials->title }}
                                                </h4>
                                                <div class="mb-2 text-warning">
                                                    <i class="bi bi-star-fill fs-caption"></i>
                                                    <i class="bi bi-star-fill fs-caption"></i>
                                                    <i class="bi bi-star-fill fs-caption"></i>
                                                    <i class="bi bi-star-fill fs-caption"></i>
                                                    <i class="bi bi-star-fill fs-caption"></i>
                                                </div>
                                            </div>
                                            <p class="mb-0 fs-16 text-start text-light">{!! $testimonials->description !!}</p>


                                        </div>

                                    </div>
                                </div>
                            @endforeach


                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
@endif



@if (isset($story))
    <section class="section mt-3" style="background-color: black;">
        <div class="container-fluid">
            <div class="row align-items-center  gap-md-5">
                <div class="col-12 col-sm-5">
                    <div class="ourStory img-hover-zoom img-hover-zoom--slowmo  br-5">
                        <img src="{{ $story->photo }}" alt="logo" height="" class="img-fluig " loading="lazy">
                    </div>
                </div><!--end col-->
                <div class="col-12 col-sm-6">

                    <div class="section-content">
                        <h2 class="display-6 mt-4 mt-md-0 mb-3 text-light"> <b>Our Story</b> </h2>

                        <h2 class="title text-capitalize lh-base fw-normal text-light my-3">{{ $story->title }}</h2>
                        <p class="text-light">{!! html_entity_decode($story->description) !!} </p>

                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div><!--end container-->
    </section>

    @include('frontend.layouts.newsletter')
@endif
<!-- @if ($certified)
    <section class="ecommerce-about-team1 py-3 bg-dark bg-opacity-50">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-6">
                    <h2 class="fs-1 text-center mb-2 fw-500"> <b>Certified By</b> </h2>
                </div>
            </div>
            <div class="row1 d-flex align-items-center justify-content-around">

                @foreach ($certified as $key => $cert)
                    <div class="1col-4 1col-md-2">
                        <div class="certified-box text-center">
                            <div class="team-img">
                                <img src="{{ $cert->photo }}" alt="" class="img-fluid certified-img" loading="lazy">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif -->

<!-- <section class="section">
    <div class="container-fluid container-custom">
        <div class="row justify-content-center">
            <div class="col-11">
                <div class="section-content text-center mb-5 ">
                    <h2 class="display-6">Drawish products are evidence-based and certified,</h2>
                    <h2 class="display-6 mb-4">Ensuring scientifically proven effectiveness and trusted quality.</h2>
                    <a href="/about-us" class="link-dark link-effect border-bottom border-black">About Us</a>


                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-12 col-md-4">
                <div class="position-relative element-item br-5" style="height:100%">
                    <div class="social-content">
                        {{-- <a href="#">
                            <h2 class="fs-2 fw-500 mb-md-4 mb-2" style="border: 1px solid #ccc">News, tips, reviews</h2>
                        </a> --}}
                        <a id="/" href="#" class="btn btn-dark rounded-pill px-0 px-md-2 px-lg-5 w-75 ">
                            News, tips, reviews
                        </a>
                    </div>
                    <div class="gallery-product h-100">
                        <img src="/assets/images/blog.jpg" alt="" class="img-fluid " style="width:100%; height:100%;"
                            loading="lazy">
                    </div>
                </div>
            </div>


            <div class="col-12 col-md-4">
                <div class="position-relative element-item br-5">
                    <div class="gallery-product h-100">
                        <img src="/assets/images/imagelocation.jpg" alt="" class="img-fluid scl"
                            style="width:100%; height:100%; margin-bottom:20px;" loading="lazy">

                        <div id="store-list">
                            @if ($stores->isEmpty())
                                <p>No stores available.</p> 
                            @else
                                @foreach ($stores->take(3) as $store)
                                    <div class="gallery-product h-100">
                                        <h4 class="mt-2 text-white p-1 rounded"
                                            style="display: inline-block; background-color: rgb(0,0,0);">
                                            {{ $store->title }}
                                        </h4>
                                        <p>
                                            <span class="address-wrapper">
                                                <a href="{{ $store->locationurl }}" target="_blank">{{ $store->address }}</a>
                                            </span>
                                        </p>
                                        <div class="star-rating">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="star {{ $i <= $store->rating ? 'filled' : '' }}">&#9733;</span>
                                            @endfor
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>




            <div class="col-12 col-md-4">
                <div class="position-relative element-item br-5" style="height:100%">
                    <div class="social-content">
                        {{-- <a href="https://www.instagram.com/drawishproduct?igsh=cXYyMmR5OTViZ3Nx">
                            <h2 class="fs-2 fw-500 mb-md-4 mb-2" style="border: 1px solid #c78651">On The Gram</h2>
                        </a> --}}
                        <a id="/" href="https://www.instagram.com/drawishproduct?igsh=cXYyMmR5OTViZ3Nx"
                            class="btn btn-dark rounded-pill px-0 px-md-2 px-lg-5 w-75 ">
                            {{-- @~Dr. Vijay Kumar --}}
                            On The Gram
                        </a>
                    </div>
                    <div class="gallery-product h-100">
                        <img src="/assets/images/insta.jpg" alt="" class="img-fluid " style="width:100%; height:100%;"
                            loading="lazy">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section> -->

<!-- <section class="py-5 bg-dark bg-opacity-50 " id="shopbyproducttype">
    <div class="container-fluid px-md-5">

        <div class="row px-xl-5 align-content-center">
            <div class="col-12 col-md-6 col-lg-3 pb-md-5">
                <div class="text-center text-md-start">
                    <h2 class="fs-2 fw-500 mb-4 ">We're answerable!</h2>
                    <p class="mb-4">We create safe products that really work and are designed to make you feel good.
                        Any question about our products?
                    </p>
                    <p>
                        Check if you can find them here or
                        Contact us</p>
                    <a id="buyNow" href="/faq" class="btn btn-dark rounded-pill px-5 mt-5">
                        See More Answers
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4  d-flex align-items-end justify-content-center">
                <img src="/assets/images/faq-new.webp" alt="" class="img-fluid rounded-lg" loading="lazy">
            </div>
            <div class="col-12  col-lg-5">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fs-6" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Does my piece come in any packaging?
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse py-3 border-top bg-white show"
                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <hr class="m-0" width="80%" >
                            <div class="accordion-body lh-sm text-dark fs-caption">Paceholder content for this
                                accordion, which is intended to demonstrate the <code>.accordion-</code> class. This is
                                the first item's accordion body.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button fs-6 collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Do you ship internationally?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse py-3 border-top bg-white"
                            aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body lh-sm text-dark fs-caption">Shipping usually takes 3-7 business
                                days, depending on your location. Expedited shipping options are available for faster
                                delivery. Contact us for any specific shipping inquiries.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button fs-6 collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Does my piece come in any packaging?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse py-3 border-top bg-white"
                            aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body lh-sm text-dark fs-caption">Placeholder content for this
                                accordion, which is intended to demonstrate the <code>.accordion-</code> class. This is
                                the third item's accordion body. Nothing more exciting happening here in terms of
                                content, but just filling up the space to make it look, at least at first glance, a bit
                                more representative of how this would look in a real-world application.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="heading4">
                            <button class="accordion-button fs-6 collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                How long does shipping take?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse py-3 border-top bg-white"
                            aria-labelledby="heading4" data-bs-parent="#accordionExample">
                            <div class="accordion-body lh-sm text-dark fs-caption">Shipping usually takes 3-7 business
                                days, depending on your location. Expedited shipping options are available for faster
                                delivery. Contact us for any specific shipping inquiries.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section> -->
<style>
    #feedback-slider .swiper-slide-next {
        transform: scaleY(2n) !important
    }

    .star {
        font-size: 20px;
        color: gold;
    }

    .star.filled {
        color: gold;
    }

    .gallery-product {
        /* min-width: 250px; */
        /* Adjust based on your layout */
    }

    .address-wrapper {
        display: inline-block;
        /* Allows padding and margins */
        background-color: #f0f0f0;
        /* Light grey background */
        border-radius: 5px;
        /* Rounded corners */
        padding: 5px 10px;
        /* Padding around the text */
        max-width: 100%;
        /* Allow full width, adjust as needed */
        overflow-wrap: break-word;
        /* Break long words to prevent overflow */
    }

    .address-wrapper a {
        color: #333;
        /* Text color */
        font-weight: bold;
        /* Bold text */
        text-decoration: none;
        /* Remove underline */
        text-wrap: wrap;
    }

    .address-wrapper a:hover {
        color: #007bff;
        /* Change color on hover */
        text-decoration: underline;
        /* Underline on hover */
    }
</style>
@endsection

@push('scripts')

    {{-- <script>
        $(document).ready(function () {
            $('.wishlist-toggle').on('click', function (e) {
                e.preventDefault();

                alert
                @if(Auth::check())
                    var button = $(this);
                    var productId = button.data('product-id');
                    var productVariantsId = button.data('product_variants-id');



                    $.ajax({
                        url: '{{ route("wishlist.toggle") }}', // Update with your wishlist toggle route
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            product_variants_id: productVariantsId
                        },
                        success: function (response) {
                            if (response.wishlisted) {
                                // Update the icon to filled heart
                                button.find('i').removeClass('mdi-heart-outline').addClass('mdi-heart');
                            } else {
                                // Update the icon to outlined heart
                                button.find('i').removeClass('mdi-heart').addClass('mdi-heart-outline');
                            }
                        },
                        error: function () {
                            alert('Something went wrong, please try again.');
                        }
                    });
                @else
                    window.location.href = 'user/login';
                @endif
            });
        });

    </script> --}}

@endpush