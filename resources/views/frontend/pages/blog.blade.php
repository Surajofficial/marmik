@extends('frontend.layouts.master')

@section('title', 'Marmik || Blog Page')
<link href="../frontend/css/style.css" rel="stylesheet" type="text/css">

@section('main-content')
    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- Start Blog Single -->
    <section class="blog-single shop-blog grid section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12">
                    <div class="row">
                        @foreach ($posts as $post)
                            {{-- {{$post}} --}}
                            <div class="col-lg-6 col-md-6 col-12">
                                <!-- Start Single Blog  -->
                                <div class="shop-single-blog">
                                    <img src="{{ $post->photo }}" alt="{{ $post->photo }}">
                                    <div class="content">
                                        <p class="date"><i class="fa fa-calendar" aria-hidden="true"></i>
                                            {{ $post->created_at->format('d M, Y. D') }}
                                            <span class="float-right">
                                                <i class="fa fa-user" aria-hidden="true"></i>
                                                {{ $post->author_info->name ?? 'Anonymous' }}
                                            </span>
                                        </p>
                                        <a href="{{ route('blog.detail', $post->slug) }}"
                                            class="title">{{ $post->title }}</a>
                                        <p>{!! html_entity_decode($post->summary) !!}</p>
                                        <a href="{{ route('blog.detail', $post->slug) }}" class="more-btn">Continue
                                            Reading</a>
                                    </div>
                                </div>
                                <!-- End Single Blog  -->
                            </div>
                        @endforeach
                        <div class="col-12">
                            <!-- Pagination -->
                            {{-- {{$posts->appends($_GET)->links()}} --}}
                            <!--/ End Pagination -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="main-sidebar">
                        <!-- Single Widget -->
                        <div class="single-widget search">
                            <form class="form" method="GET" action="{{ route('blog.search') }}">
                                <input type="text" class="form-control w-10" placeholder="Search Here..." name="search">
                                <button class="button btn btn-primary" type="sumbit"><i
                                        class="fa fa-search"></i>Submit</button>
                            </form>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget category">
                            <h3 class="title">Blog Categories</h3>
                            <ul class="categor-list">
                                @if (!empty($_GET['category']))
                                    @php
                                        $filter_cats = explode(',', $_GET['category']);
                                    @endphp
                                @endif
                                <form action="{{ route('blog.filter') }}" method="POST">
                                    @csrf
                                    {{-- {{count(Helper::postCategoryList())}} --}}
                                    @foreach (Helper::postCategoryList('posts') as $cat)
                                        <li>
                                            <a href="{{ route('blog.category', $cat->slug) }}">{{ $cat->title }} </a>
                                        </li>
                                    @endforeach
                                </form>

                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget recent-post">
                            <h3 class="title">Recent post</h3>
                            @foreach ($recent_posts as $post)
                                <!-- Single Post -->
                                <div class="single-post">
                                    <div class="image">
                                        <img src="{{ $post->photo }}" alt="{{ $post->photo }}">
                                    </div>
                                    <div class="content">
                                        <h5><a href="#">{{ $post->title }}</a></h5>
                                        <ul class="comment">
                                            <li><i class="fa fa-calendar"
                                                    aria-hidden="true"></i>{{ $post->created_at->format('d M, y') }}</li>
                                            <li><i class="fa fa-user" aria-hidden="true"></i>
                                                {{ $post->author_info->name ?? 'Anonymous' }}
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- End Single Post -->
                            @endforeach
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget side-tags">
                            <h3 class="title">Tags</h3>
                            <ul class="tag">
                                @if (!empty($_GET['tag']))
                                    @php
                                        $filter_tags = explode(',', $_GET['tag']);
                                    @endphp
                                @endif
                                <form action="{{ route('blog.filter') }}" method="POST">
                                    @csrf
                                    @foreach (Helper::postTagList('posts') as $tag)
                                        <li>
                                        <li>
                                            <a href="{{ route('blog.tag', $tag->title) }}">{{ $tag->title }} </a>
                                        </li>
                                        </li>
                                    @endforeach
                                </form>
                            </ul>
                        </div>
                        <!--/ End Single Widget -->
                        <!-- Single Widget -->
                        <div class="single-widget newsletter">
                            <h3 class="title">Newslatter</h3>
                            <div class="letter-inner">
                                <h4>Subscribe & get news <br> latest updates.</h4>
                                <form method="POST" action="{{ route('subscribe') }}" class="form-inner">
                                    @csrf
                                    <input class="form-control" type="email" name="email"
                                        placeholder="Enter your email">
                                    <button class="btn btn-primary" type="submit" class="btn "
                                        style="width: 100%">Submit</button>
                                </form>
                            </div>
                        </div>
                        <!--/ End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/ End Blog Single -->
    <!-- Jquery -->
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-migrate-3.0.0.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery-ui.min.js') }}"></script>
    <!-- Popper JS -->
    <script src="{{ asset('frontend/js/popper.min.js') }}"></script>
    <!-- Bootstrap JS -->
    <script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
    <!-- Color JS -->
    <script src="{{ asset('frontend/js/colors.js') }}"></script>
    <!-- Slicknav JS -->
    <script src="{{ asset('frontend/js/slicknav.min.js') }}"></script>
    <!-- Owl Carousel JS -->
    <script src="{{ asset('frontend/js/owl-carousel.js') }}"></script>
    <!-- Magnific Popup JS -->
    <script src="{{ asset('frontend/js/magnific-popup.js') }}"></script>
    <!-- Waypoints JS -->
    <script src="{{ asset('frontend/js/waypoints.min.js') }}"></script>
    <!-- Countdown JS -->
    <script src="{{ asset('frontend/js/finalcountdown.min.js') }}"></script>
    <!-- Nice Select JS -->
    <script src="{{ asset('frontend/js/nicesellect.js') }}"></script>
    <!-- Flex Slider JS -->
    <script src="{{ asset('frontend/js/flex-slider.js') }}"></script>
    <!-- ScrollUp JS -->
    <script src="{{ asset('frontend/js/scrollup.js') }}"></script>
    <!-- Onepage Nav JS -->
    <script src="{{ asset('frontend/js/onepage-nav.min.js') }}"></script>
    {{-- Isotope --}}
    <script src="{{ asset('frontend/js/isotope/isotope.pkgd.min.js') }}"></script>
    <!-- Easing JS -->
    <script src="{{ asset('frontend/js/easing.js') }}"></script>

    <!-- Active JS -->
    <script src="{{ asset('frontend/js/active.js') }}"></script>
@endsection
@push('styles')
    <style>
        .pagination {
            display: inline-flex;
        }
    </style>
@endpush
