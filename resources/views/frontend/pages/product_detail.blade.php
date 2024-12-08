@extends('frontend.layouts.master')

@section('meta')
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='copyright' content=''>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="{{ $product_detail->summary }}">
    <meta property="og:url" content="{{ route('product-detail', $product_detail->slug) }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $product_detail->title }}">
    <meta property="og:image" content="{{ $product_detail->photo }}">
    <meta property="og:description" content="{{ $product_detail->description }}">
    <style>
        .wrapper {
            display: inline-block;
        }

        .wrapper * {
            float: right;
        }

        .wrapper input {
            display: none;
        }

        .wrapper label {
            font-size: 30px;
        }

        .wrapper input:hover~label {
            color: orange;
        }

        .wrapper input:checked~label {
            color: orange;
        }
    </style>
    <style>
        .custom-file-label {
            display: inline-flex;
            /* Use flex to align icon and text */
            align-items: center;
            /* Center the icon and text vertically */
            background: #0b1729;
            color: white;
            padding: 8px 12px;
            /* Reduced padding */
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            /* Smaller font size */
            transition: background 0.3s, transform 0.3s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .custom-file-label i {
            margin-right: 4px;
            /* Reduced spacing between icon and text */
        }

        .custom-file-label:hover {
            background: #0b1729;
            transform: translateY(-1px);
            /* Slightly reduced hover effect */
        }

        .custom-file-input {
            display: none;
            /* Hide the default file input */
        }

        .file-preview {
            display: flex;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .file-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;

            border-radius: 5px;
            margin-right: 10px;
            margin-bottom: 10px;
        }
    </style>
    <style>
        .image-gallery {
            display: flex;
            /* Align items in a row */
            flex-wrap: nowrap;
            /* Ensure images don't wrap to the next line */
            gap: 10px;
            /* Space between images */
            overflow-x: auto;
            /* Horizontal scroll if there are too many images */
        }

        .image-item img {
            width: 100px;
            /* Set image width */
            height: auto;
            /* Maintain aspect ratio */
            border: 1px solid #ccc;
            /* Add a border around each image */
            border-radius: 5px;
            /* Slightly rounded corners */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
        }

        @media(max-width:320px) {
            #product-quantity {
                width: 2em !important;
            }
        }
    </style>

@endsection
@section('title', 'Dr Awish || PRODUCT DETAIL')
@section('main-content')
    <section class="section page-wrapper">
        <div class="container mt-5 pt-5 text-justify">
            <form action="#" method="POST" style="padding-top:40px">
                <div class="row gx-2">
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="bg-light1 rounded-5 position-relative ribbon-box overflow-hidden">
                                    <div class="ribbon ribbon-danger ribbon-shape trending-ribbon">
                                        <span class="trending-ribbon-text"></span> <i
                                            class="ri-flashlight-fill text-white align-bottom float-end ms-1"></i>
                                    </div>
                                    <div class="swiper mySwiper" style="">
                                        <div class="swiper-wrapper" style="width:100%; height:100%;">
                                            @php
                                                $photo = explode(',', $product_detail->photo);
                                            @endphp
                                            @foreach ($photo as $data)
                                                <div class="swiper-slide img-zoom-container">
                                                    <img src="{{ $data }}" alt="{{ $data }}"
                                                        class="img-fluid myimage" style="object-fit: cover" />
                                                </div>
                                            @endforeach
                                            @php
                                                $video = explode(',', $product_detail->video);
                                            @endphp
                                            {{-- @if (isset($product_detail->video))
                                                @foreach ($video as $data1)
                                                    <div class="swiper-slide ">
                                                        <video src="/assets/uploads/{{ $data1 }}" type="video/mp4"
                                                            autoplay loop muted class="hover-to-play w-100"
                                                            style="">
                                                        </video>
                                                    </div>
                                                @endforeach
                                            @endif --}}
                                        </div>
                                        <div class="swiper-button-next bg-transparent"></div>
                                        <div class="swiper-button-prev bg-transparent"></div>
                                    </div>
                                </div>
                            </div><!--end col-->

                        </div><!--end row-->
                    </div><!--end col-->
                    <div class="col-lg-5 ms-auto justify-text">
                        <div class="ecommerce-product-widgets mt-4 mt-lg-0">
                            <div class="mb-5 p-3 mt-2">
                                @if ($product_detail->presc == 1)
                                    <span class="bg-danger text-white rounded px-1 fw-500"
                                        style=" font-size:0.8rem">Prescription Required</span>
                                @endif
                                <h1 class="fw-500  fs-3 mb-2 mt-3">{{ $product_detail->title }}</h1>
                                <div class="d-flex gap-3 mb-2">
                                    <div id="myresult" class="img-zoom-result" style="display:none;"></div>
                                    <div class="fs-15 text-warning">
                                        @php
                                            $rate = ceil($product_detail->getReview->avg('rate'));
                                        @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($rate >= $i)
                                                <i class="ri-star-fill align-bottom"></i>
                                            @else
                                                <i class="ri-star-half-fill align-bottom"></i>
                                            @endif
                                        @endfor

                                    </div>
                                    <span class="fw-medium">({{ $product_detail['getReview']->count() }})</span>
                                </div>
                                @php
                                    $after_discount = $product->price - ($product->price * $product->discount) / 100;
                                @endphp
                                <h5 class="fs-24 mb-2 fw-500 mt-2">
                                    @if ($product->display_price == $product->price)
                                        <span id="price">₹ {{ number_format($after_discount, 2) }}</span>
                                        @if ($product->discount > 0)
                                            <span class="text-muted fs-14 text-decoration-line-through">
                                                <del id="dprice">₹ {{ number_format($product->price, 2) }}</del>
                                            </span>
                                            <span class="fs-14 ms-2 text-success" id="discount">
                                                ({{ $product->discount }}% off)
                                            </span>
                                        @endif
                                    @else
                                        <span id="price">₹ {{ number_format($product->display_price, 2) }}</span>
                                        @if ($product->discount > 0)
                                            <span class="text-muted fs-14 text-decoration-line-through">
                                                <del id="dprice">₹ {{ number_format($product->price, 2) }}</del>
                                            </span>
                                        @endif
                                    @endif

                                </h5>
                                <p class="text-muted mb-4 w-100 ml-2 h-100 lh-base" style="font-size: 0.8rem;">
                                    {!! $product_detail->summary !!}
                                </p>
                                @if (isset($variant))
                                    <div class="col-md-6 mt-3">
                                        <div>
                                            <ul class="clothe-size list-unstyled hstack gap-2 mb-0 flex-wrap">
                                                @foreach ($variant as $psize)
                                                    @php
                                                        $psizes = explode(',', $psize->size);

                                                        $strep1 = DB::table('streps')->where('id', $psizes)->get();
                                                    @endphp
                                                    @if ($product->id == $psize->id)
                                                        <li>
                                                            <input class="variant" type="radio" name="variant"
                                                                data-id="{{ $strep1[0]->id }}"
                                                                id="product-color-{{ $strep1[0]->id }}"
                                                                value="{{ $product->id }}" checked>
                                                            <label
                                                                class="avatar-xs btn btn-soft-dark text-uppercase fs-12 d-flex align-items-center p-3 justify-content-center  h-50"
                                                                for="product-color-{{ $strep1[0]->id }}"
                                                                style="width:100%;">{{ $strep1[0]->title }}
                                                            </label>
                                                        </li>
                                                    @else
                                                        <li>
                                                            <a href="{{ route('product-detail', [$product->product->slug, $psize->id]) }}"
                                                                class="avatar-xs btn btn-soft-dark text-uppercase fs-12 d-flex align-items-center p-3 justify-content-center  h-50"
                                                                for="product-color-{{ $strep1[0]->id }}"
                                                                style="width:100%;">{{ $strep1[0]->title }}
                                                            </a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                @endif

                                <ul class="list-unstyled vstack gap-2 my-2">
                                    <li class="">
                                        @if ($product->stock > 0)
                                            <i class="bi bi-check2-circle me-2 align-middle text-success"></i>In stock
                                        @else
                                            <i class="bi bi-check2-circle me-2 align-middle text-danger"></i>Out of
                                            stock
                                        @endif
                                    </li>
                                </ul>
                                @if ($product->stock > 0)
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="input-step rounded-pill me-3" style="height:2.5rem">
                                            <button type="button" class="minus_btn_all bg-white rounded-pill">-</button>
                                            <input type="number" class="product-quantity disable" id="product-quantity"
                                                value="1" min="0" max="100" readonly>
                                            <button type="button" class="plus_btn_all bg-white rounded-pill">+</button>
                                        </div>
                                        <div class="d-flex align-items-center mb-3" style="margin-top: 15px;">
                                            <a id="addTocart" href="#" data-variant="{{ $product->id }}"
                                                class="btn btn-outline-dark rounded-pill w-100">
                                                <i class="bi bi-cart me-2"></i> Add To Cart
                                            </a>
                                        </div>

                                    </div>
                                    <a id="buyNow" data-variant="{{ $product->id }}" href="#"
                                        class="btn btn-dark rounded-pill w-100">
                                        <i class="bi bi-basket me-2"></i>Buy Now
                                    </a>
                                @else
                                    {{-- <a id="notifyme" href="#" class="btn btn-outline-dark rounded-pill w-100">
                                        <i class="bi bi-bell me-2"></i>Notify Me
                                    </a> --}}
                                    <a id="notifyme" href="{{ route('home') }}"
                                        class="btn btn-outline-dark rounded-pill w-100">
                                        Continue Shopping
                                    </a>
                                @endif
                            </div>
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button border-0 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne"
                                            style="background-color :white; color:black; border: 0 !important;">
                                            Overview
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <table class="table table-sm table-borderless align-middle">
                                                @if (!empty($ptype[0]))
                                                    <tr>
                                                        <th>Product Type</th>
                                                        <td><a
                                                                href="{{ route('product-type', $ptype[0]->slug) }}">{{ @$ptype[0]->title }}</a>
                                                        </td>
                                                    </tr>
                                                @endif

                                                @if ($product_detail->cat_id)
                                                    <tr>
                                                        <th>Category</th>
                                                        <td><a
                                                                href="{{ route('product-cat', $product_detail->cat_info['slug']) }}">{{ @$product_detail->cat_info['title'] }}</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if (@$product_detail->sub_cat_info)
                                                    <tr>
                                                        <th>Sub Category</th>
                                                        <td><a
                                                                href="{{ route('product-sub-cat', [$product_detail->cat_info['slug'], $product_detail->sub_cat_info['slug']]) }}">{{ @$product_detail->sub_cat_info['title'] }}</a>
                                                        </td>
                                                    </tr>
                                                @endif


                                                @if (!empty($concern) == false)
                                                    <tr>
                                                        <th>Concern</th>
                                                        <td><a
                                                                href="{{ route('product-concern', $concern[0]->slug) }}">{{ @$concern[0]->title }}</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if (!empty($brand) == false)
                                                    <tr>
                                                        <th>Brand</th>
                                                        <td><a
                                                                href="{{ route('product-brand', $concern[0]->slug) }}">{{ @$brand[0]->title }}</a>
                                                        </td>
                                                    </tr>
                                                @endif
                                                @if (count($product->batches) != 0)
                                                    @php
                                                        $batch = $product->batches[0];
                                                    @endphp
                                                    <tr>
                                                        <th>Expiry</th>
                                                        <td><span id="expiry"
                                                                class="">{{ $batch->expiry }}</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Manufacture Date:</th>
                                                        <td><span id="mfg">{{ $batch->mfg }}</span>
                                                        </td>
                                                    </tr>
                                                @endif

                                            </table>
                                            <p class="text-muted fs-15">{!! $product_detail->description !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button border-0 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true"
                                            aria-controls="collapseOne"
                                            style="background-color :white; color:black; border: 0 !important;">
                                            How To Use
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <p class="text-muted fs-15">{!! $product_detail->how_to_use !!}</p>
                                        </div>
                                    </div>

                                </div>
                                <hr />
                                <div class="accordion-item border-0">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button border-0 collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                            aria-expanded="true" aria-controls="collapseOne"
                                            style="background-color :white; color:black; border: 0 !important;">
                                            Evidence
                                        </button>
                                    </h2>
                                    <div id="collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">

                                            <p class="text-muted fs-15">{!! $product_detail->evidence !!}</p>
                                        </div>
                                    </div>

                                </div>
                                <hr />
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
        </div>
        </div>
        </div>
        </div><!--end col-->

        </div><!--end row-->
        </form>
        </div><!--end container-->
    </section>
    <div class="container mb-3">
        <div class="d-flex flex-wrap gap-4 justify-content-between align-items-center mt-4">
            <div class="flex-shrink-0">
                <h5 class="fs-15 mb-3 fw-medium">Total Rating's</h5>
                <h2 class="fw-bold mb-3">{{ ceil($product_detail->getReview->count()) }}</h2>
                <p class="text-muted mb-0">Growth in reviews on this year</p>
            </div>
            <hr class="vr">
            <div class="flex-shrink-0">
                <h5 class="fs-15 mb-3 fw-medium">Average Rating</h5>

                <h2 class="fw-bold mb-3">
                    {{ number_format($product_detail->getReview->avg('rate'), 1) }}<span
                        class="fs-16 align-middle text-warning ms-2">
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-fill"></i>
                        <i class="ri-star-half-fill"></i>
                    </span>
                </h2>
                <p class="text-muted mb-0">Average rating on this year</p>
            </div>
            <hr class="vr">
        </div>
        <div class="mt-4" data-simplebar>
            @foreach ($product_detail['getReview'] as $data)
                @if ($data->review != '' && $data->review != null)
                    <div class="d-flex p-3 border-bottom border-bottom-dashed">
                        <div class="flex-shrink-0 me-3">
                            @if ($data->user_info['photo'])
                                <img class="avatar-xs rounded-circle" src="{{ asset($data->user_info['photo']) }}"
                                    alt="{{ $data->user_info['photo'] }}">
                            @else
                                <i class="ph-user fs-24"></i>
                            @endif

                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex mb-3">
                                <div class="flex-grow-1">
                                    <div>
                                        <div class="mb-2 fs-12">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($data->rate >= $i)
                                                    <span> <i class="ri-star-fill text-warning align-bottom"></i></span>
                                                @else
                                                    <span> <i
                                                            class="ri-star-half-fill  text-warning align-bottom"></i></span>
                                                @endif
                                            @endfor

                                        </div>
                                        <h6 class="mb-0">{{ $data->user_info['name'] }}</h6>
                                    </div>
                                </div>
                                <div class="flex-shrink-0">
                                    <p class="mb-0 text-muted"><i
                                            class="ri-calendar-event-fill me-2 align-middle"></i>{{ $data->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="mb-0">
                                    {{ $data->review }}
                                </p>
                            </div>
                            @php
                                // Check if $data->image is not null or empty before splitting it into an array
                                $images = !empty($data->image) ? explode(',', $data->image) : [];
                            @endphp

                            <div class="image-gallery d-flex flex-wrap">
                                @forelse ($images as $image)
                                    <div class="image-item p-2">
                                        <img src="{{ asset($image) }}" alt="Product Photo" class="img-thumbnail">
                                    </div>
                                @empty
                                    <div class="p-2">
                                        <p></p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
        <div class="pt-3">
            <h5 class="fs-18">Add a Review</h5>
            <div>
                @auth
                    <form class="form" method="post" action="{{ route('review.user.store', $product_detail->slug) }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="d-flex align-items-center mb-3">
                            <span class="fs-14">Your rating:</span>
                            <div class="ms-3">
                                @error('rate')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <!-- Other form fields -->

                        <div class="form-group">
                            <label for="productPhotos" class="custom-file-label">
                                <i class="ph-file fs-24"></i> Upload Product Photos
                            </label>
                            <input type="file" name="productPhotos[]" id="productPhotos" multiple
                                class="custom-file-input" accept="image/*" capture>
                            <div id="file-preview" class="file-preview"></div>
                        </div>


                        <label for="productPhotos">Rating</label>
                        <div class="form-group">

                            <div class="wrapper">
                                <input type="radio" id="r1" name="rate" value="5">
                                <label for="r1">&#10038;</label>
                                <input type="radio" id="r2" name="rate" value="4">
                                <label for="r2">&#10038;</label>
                                <input type="radio" id="r3" name="rate" value="3">
                                <label for="r3">&#10038;</label>
                                <input type="radio" id="r4" name="rate" value="2">
                                <label for="r4">&#10038;</label>
                                <input type="radio" id="r5" name="rate" value="1">
                                <label for="r5">&#10038;</label>
                            </div>
                        </div>

                </div>

                <div class="mb-3">
                    <textarea class="form-control rounded-5" name="review" placeholder="Enter your comments & reviews" rows="6"></textarea>
                </div>
                <div class="text-end">
                    <button class="btn btn-dark btn-hover rounded-pill" type="submit" value="Submit">Send Review
                        <i class="ri-send-plane-2-line align-bottom ms-1"></i></button>
                </div>
                </form>
            @else
                <p class="text-center p-5">
                    You need to <a href="{{ route('login.form') }}" style="color:rgb(54, 54, 204)">Login</a> OR <a
                        style="color:blue" href="{{ route('login.form') }}">Register</a>
                </p>
                <!--/ End Form -->
            @endauth
        </div>
    </div>
    </div>

    <section class="section" style="background-color:black">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-1">
                        <h4 class="flex-grow-1 mb-0 text-light">Similar Products</h4>
                        <div class="flex-shrink-0">
                            <a href="#" class="text-light">All Products <i
                                    class="ri-arrow-right-line ms-1 align-bottom"></i></a>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
            <div class="row">
                @foreach ($recent_products as $data)
                    @if ($data->id != $product_detail->id)
                        <div class="col-xxl-3 col-lg-4 col-sm-6">
                            <div
                                class="card ecommerce-product-widgets border-0 rounded-4 shadow-none overflow-hidden card-animate">
                                <div class="rounded py-4 position-relative">
                                    @php
                                        $photo = explode(',', $data->product->photo);
                                        // dd($data);
                                    @endphp
                                    <a href="{{ route('product-detail', [$data->product->slug, $data->id]) }}">
                                        <img src="{{ $photo[0] }}" alt="{{ $photo[0] }}"
                                            style="max-height: 200px;max-width: 100%;" class="mx-auto d-block rounded-2">
                                    </a>
                                    <div class="action vstack gap-2">
                                        <button type="button"
                                            class="wishlist-toggle btn btn-danger btn-sm custom-toggle rounded-5 ${checkinput}"
                                            data-product-id="{{ $data->product->id }}"
                                            data-product_variants-id="{{ $data->id }}">
                                            <i
                                                class="mdi mdi-heart{{ in_array($data->product->id, $wishlist_ids) ? '' : '-outline' }} align-bottom fs-15"></i>
                                        </button>
                                    </div>
                                    @if ($data->discount > 0)
                                        <div class="avatar-xs label">
                                            <div class="avatar-title bg-danger rounded-circle fs-11">
                                                {{ $data->discount }}
                                                %
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="pb-4" style="padding: 0 20px;">

                                    <a href="{{ route('product-detail', [$data->product->slug, $data->id]) }}">
                                        <h6 class="text-capitalize fs-15 lh-base text-truncate mb-0 ">
                                            {{ $data->product->title }}
                                        </h6>
                                    </a>
                                    <div class="mt-2">
                                        @php
                                            $after_discount = $data->price - ($data->discount * $data->price) / 100;
                                        @endphp
                                        <span class="float-end">4.1 <i
                                                class="ri-star-half-fill text-warning align-bottom"></i></span>
                                        <h5 class="mb-0">₹ {{ number_format($after_discount, 2) }}</h5>
                                    </div>
                                    <div class="mt-3">
                                        @if ($data->stock > 0)
                                            <a id="addTocarts" data-slug="{{ $data->product->slug }}"
                                                data-variant="{{ $data->id }}"
                                                class="btn btn-dark rounded-pill w-100 add-btn "><i
                                                    class="mdi mdi-cart me-1"></i> Add To Cart</a>
                                        @else
                                            <a class="btn btn-danger rounded-pill w-100 add-btn "><i
                                                    class="mdi mdi-cart me-1"></i> Out of stock</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    @endif
                @endforeach
            </div><!--end row-->
        </div><!--end section-->
    </section>

    @include('frontend.layouts.newsletter')

    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        const clip = document.querySelectorAll(".hover-to-play");
        for (let i = 0; i < clip.length; i++) {
            clip[i].addEventListener("mouseenter", function(e) {
                clip[i].play();
            });
            clip[i].addEventListener("mouseout", function(e) {
                clip[i].pause();
            });
        }
    </script>
    <script>
        function imageZoom(imgID, resultID) {
            document.getElementById("myresult").style = "display:block;";
            var img, lens, result, cx, cy;
            img = document.getElementById(imgID);
            result = document.getElementById(resultID);
            /* Create lens: */
            lens = document.createElement("DIV");
            lens.setAttribute("class", "img-zoom-lens");
            /* Insert lens: */
            //console.log("lens",img);
            img.parentElement.insertBefore(lens, img[0]);
            /* Calculate the ratio between result DIV and lens: */
            cx = result.offsetWidth / lens.offsetWidth;
            cy = result.offsetHeight / lens.offsetHeight;
            /* Set background properties for the result DIV */
            result.style.backgroundImage = "url('" + img.src + "')";
            result.style.backgroundSize = (img.width * cx) + "px " + (img.height * cy) + "px";
            /* Execute a function when someone moves the cursor over the image, or the lens: */
            lens.addEventListener("mousemove", moveLens);
            img.addEventListener("mousemove", moveLens);
            /* And also for touch screens: */
            lens.addEventListener("touchmove", moveLens);
            img.addEventListener("touchmove", moveLens);

            function moveLens(e) {
                var pos, x, y;
                /* Prevent any other actions that may occur when moving over the image */
                e.preventDefault();
                /* Get the cursor's x and y positions: */
                pos = getCursorPos(e);
                /* Calculate the position of the lens: */
                x = pos.x - (lens.offsetWidth / 2);
                y = pos.y - (lens.offsetHeight / 2);
                /* Prevent the lens from being positioned outside the image: */
                if (x > img.width - lens.offsetWidth) {
                    x = img.width - lens.offsetWidth;
                }
                if (x < 0) {
                    x = 0;
                }
                if (y > img.height - lens.offsetHeight) {
                    y = img.height - lens.offsetHeight;
                }
                if (y < 0) {
                    y = 0;
                }
                /* Set the position of the lens: */
                lens.style.left = x + "px";
                lens.style.top = y + "px";
                /* Display what the lens "sees": */
                result.style.backgroundPosition = "-" + (x * cx) + "px -" + (y * cy) + "px";
            }

            function getCursorPos(e) {
                var a, x = 0,
                    y = 0;
                e = e || window.event;
                /* Get the x and y positions of the image: */
                a = img.getBoundingClientRect();
                /* Calculate the cursor's x and y coordinates, relative to the image: */
                x = e.pageX - a.left;
                y = e.pageY - a.top;
                /* Consider any page scrolling: */
                x = x - window.pageXOffset;
                y = y - window.pageYOffset;
                return {
                    x: x,
                    y: y
                };
            }
        }

        function imageZoom1() {
            document.getElementById("myresult").style = "display:none;";

        }
    </script>
    <script>
        $(document).on('click', '#addTocart', function(e) {
            e.preventDefault();
            @if (Auth::check())
                var slug = $(this).data('slug');
                var variant = $(this).data('variant');
                var quantity = Number($('#product-quantity').val());
                // alert(slug+' '+variant+' '+quantity);

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    type: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}', // Add CSRF token for security
                        'slug': slug,
                        'q': quantity,
                        'variant': variant
                    },
                    success: function(response) {
                        if (response.status === 'true') {
                            $('.cart').text(response.cart);
                            // alert('Product added to cart successfully!'); 
                        } else {
                            // alert(response.message); 
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            @else
                window.location.href = '/user/login';
            @endif
        });

        $(document).on('click', '#addTocarts', function(e) {
            e.preventDefault();
            @if (Auth::check())
                var slug = $(this).data('slug');
                var variant = $(this).data('variant');
                var quantity = 1;

                $.ajax({
                    url: "{{ route('add.to.cart') }}",
                    type: 'post',
                    data: {
                        '_token': '{{ csrf_token() }}', // Add CSRF token for security
                        'slug': slug,
                        'q': quantity,
                        'variant': variant
                    },
                    success: function(response) {
                        if (response.status === 'true') {
                            $('.cart').text(response.cart);
                            // alert('Product added to cart successfully!'); 
                        } else {
                            // alert(response.message); 
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred: ' + error);
                    }
                });
            @else
                window.location.href = '/user/login';
            @endif
        });


        $(document).on('click', '#buyNow', function(e) {
            e.preventDefault()

            @if (Auth::user() == null)
                window.location.href = '/user/login';
            @endif
            var slug = "{{ $product_detail->slug }}";
            var variant = $(this).data('variant');
            var quantity = Number($('#product-quantity').val());

            $.ajax({
                url: `{{ route('buy') }}`,
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}', // Add CSRF token for security
                    'slug': slug,
                    'q': quantity,
                    'variant': variant
                },
                success: function(response) {
                    window.location.href = '/cart';
                },
                error: function(xhr, status, error) {
                    /// alert('An error occurred: ' + error);
                }
            });
        })
    </script>

    <script>
        $(document).ready(function() {
            $('.disable').on('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    console.log("Entered number:", $(this).val());
                }
            });
        });


        $(document).ready(function() {
            $('#productPhotos').on('change', function() {
                const filePreview = $('#file-preview');
                filePreview.empty(); // Clear previous previews

                const files = this.files;
                for (let i = 0; i < files.length; i++) {
                    const file = files[i];
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        const img = $('<img>').attr('src', e.target.result); // Create an img element
                        filePreview.append(img); // Append the image to the preview container
                    }

                    reader.readAsDataURL(file); // Read the file as a data URL
                }
            });
        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('.wishlist-toggle').on('click', function(e) {
                e.preventDefault();

                alert
                @if (Auth::check())
                    var button = $(this);
                    var productId = button.data('product-id');
                    var productVariantsId = button.data('product_variants-id');



                    $.ajax({
                        url: '{{ route('wishlist.toggle') }}', // Update with your wishlist toggle route
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            product_id: productId,
                            product_variants_id: productVariantsId
                        },
                        success: function(response) {
                            if (response.wishlisted) {
                                // Update the icon to filled heart
                                button.find('i').removeClass('mdi-heart-outline').addClass(
                                    'mdi-heart');
                            } else {
                                // Update the icon to outlined heart
                                button.find('i').removeClass('mdi-heart').addClass(
                                    'mdi-heart-outline');
                            }
                        },
                        error: function() {
                            alert('Something went wrong, please try again.');
                        }
                    });
                @else
                    window.location.href = '/user/login';
                @endif
            });
        });
    </script> --}}


@endsection
