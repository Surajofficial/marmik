@php
    $settings = DB::table('settings')->get();
@endphp
@foreach ($settings as $data)
    {!! html_entity_decode(@$data->analytics) !!}
@endforeach


<style>
    @media (max-width: 470px) {
        .product .d-flex {
            flex-direction: column;
            /* Stack elements vertically */
        }

        .product .flex-grow-1 {
            order: 1;
            /* Move this section below */
            margin-top: 15px;
            /* Optional: add some spacing */
        }

        .product .flex-shrink-0 {
            order: 1;
            /* Keep the first shrink section on top */
        }

        .product .flex-shrink-0.d-flex.flex-column {
            order: 0;
            /* Keep the second shrink section on top */
            margin-top: 10px;
            /* Optional: add some spacing */
        }

        .d-flex.flex-column {
            flex-direction: column;
            /* Ensure it's a column layout */
            align-items: flex-end;
            /* Align items to the right */
        }

        .flex-shrink-0 {
            margin-bottom: 10px;
            /* Optional: add spacing between the two sections */
        }

        .vr {
            display: none;
        }

        .price-hide {
            display: none;
        }

        .ri-close-fill {
            font-size: 25px !important;
        }

        .list-group-item .gap-3 {
            gap: 0 !important;
        }
    }

</style>

<section class="section footer-landing mt-0 pb-0 border-top-1 " style="background-color: black;">
    <div class="container-fluid pb-1 pt-3 ">
        <div class="row justify-content-between">
            <div class="col-lg-4">
                <div class="footer-info">

                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo"
                        class="logo-light logo">
                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo"
                        class="logo-dark logo">

                    <p class="footer-desc mt-4 mb-2 me-3 fw-light lh-lg text-justify-center text-light">
                        @foreach ($settings as $data)
                            {!! $data->short_des !!}
                        @endforeach.
                    </p>

                    <div class="footer-social mt-4">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item">
                                <a href="@foreach ($settings as $data) {{ @$data->facebook }} @endforeach"
                                    class="text-reset"><i class="mdi mdi-facebook text-light"></i></a>
                            </li>
                            <li class="list-inline-item">
                                <a href="@foreach ($settings as $data) {{ @$data->instagram }} @endforeach"
                                    class="text-reset"><i class="mdi mdi-instagram text-light"></i></a>
                            </li>
                            <!-- <li class="list-inline-item">
                                <a href="@foreach ($settings as $data) {{ @$data->youtube }} @endforeach"
                                    class="text-reset"><i class="mdi mdi-youtube text-light"></i></a>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="row gap- ps-0 ps-lg-3">
                    <div class="col-md-4 col-6">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title text-light">Information</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('about-us') }}">About Us</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('account') }}">Ordering</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('contact') }}">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title text-light">My Account</h5>
                            <ul class="list-unstyled footer-link mt-3">
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('cart') }}">View Cart</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('account') }}">My Wishlist</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('account') }}">Track My
                                        Order</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('faq') }}">Help</a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="mt-lg-0 mt-4">
                            <h5 class="footer-title text-light">Customer Service</h5>
                            <ul class="list-unstyled footer-link mt-3">

                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('returns') }}">Returns</a>
                                </li>
                                <li>
                                    <a class="link-effect link-warning text-light" href="{{ route('terms') }}">Terms &
                                        Conditions</a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row footer-border-alt mt-4 align-items-center">
            <div class="col-sm-6">
                <script>
                    document.write(new Date().getFullYear())
                </script> Design &amp; Develop by <a href="/" target="_blank"
                    class="text-reset text-decoration-underline text-light">Awish</a>
            </div>
            <div class="col-sm-6">
                <div class="text-sm-end d-none d-sm-block">
                    <ul class="list-inline mb-0">
                        <li class="list-inline-item">
                            <a href="#!"><img src="../assets/images/ecommerce/payment/visa.png" alt=""
                                    height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="../assets/images/ecommerce/payment/discover.png" alt=""
                                    height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="../assets/images/ecommerce/payment/american-express.png"
                                    alt="" height="30"></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="#!"><img src="../assets/images/ecommerce/payment/paypal.png" alt=""
                                    height="30"></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-end product-list" tabindex="-1" id="ecommerceCart"
    aria-labelledby="ecommerceCartLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="ecommerceCartLabel">My Cart <span
                class="badge bg-dark align-middle ms-1 cartitem-badge cart">{{ Helper::cartCount() }}</span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body px-0" style="padding: 0px">
        <div data-simplebar class="h-100">
            <ul class="list-group list-group-flush cartlist" id="cart-list">

            </ul>
        </div>
    </div>
    <div class="offcanvas-footer border-top p-3 text-center">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="m-0 fs-16 text-muted">Total:</h6>
            <div class="px-2">
                <h6 class="m-0 fs-16 cart-total" id="total"></h6>
            </div>
        </div>
        <div class="row g-2">
            <div class="col-12">
                <a href="{{ route('cart') }}" id="procidetopay"
                    class="btn btn-dark rounded-pill w-100 {{ Helper::cartCount() == 0 ? 'disabled' : '' }}"
                    disabled>Proceed To Pay</a>
            </div>
        </div>
    </div>
</div>

<!-- JAVASCRIPT -->

<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- Countdown js -->
{{-- <script src="{{ asset('assets/js/pages/coming-soon.init.js') }}"></script> --}}
{{-- <script src="{{ asset('assets/js/frontend/menu.init.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
    crossorigin="anonymous"></script>
<script type="text/javascript">
    // Toggle to show and hide navbar-new menus
    const navbarmenu = document.getElementById("menus");
    const burgermenu = document.getElementById("burger");

    burgermenu.addEventListener("click", () => {
        navbarmenu.classList.toggle("is-active");
        burgermenu.classList.toggle("is-active");
    });

    // Toggle to show and hide dropdowns menus
    const dropdowns = document.querySelectorAll(".dropdowns");

    dropdowns.forEach((item) => {
        const dropdownsToggle = item.querySelector(".dropdowns-toggle");

        dropdownsToggle.addEventListener("click", () => {
            const dropdownsShow = document.querySelector(".dropdowns-show");
            toggledropdownsItem(item);

            // Remove 'dropdowns-show' class from other dropdowns
            if (dropdownsShow && dropdownsShow != item) {
                toggledropdownsItem(dropdownsShow);
            }
        });
    });

    // Function to display the dropdowns menus
    const toggledropdownsItem = (item) => {
        const dropdownsContent = item.querySelector(".dropdowns-content");

        // Remove other dropdowns that have 'dropdowns-show' class
        if (item.classList.contains("dropdowns-show")) {
            dropdownsContent.removeAttribute("style");
            item.classList.remove("dropdowns-show");
        } else {
            // Added max-height on active 'dropdowns-show' class
            dropdownsContent.style.height = dropdownsContent.scrollHeight + "px";
            item.classList.add("dropdowns-show");
        }
    };

    // Fixed dropdowns menus on window resizing
    window.addEventListener("resize", () => {
        if (window.innerWidth > 992) {
            document.querySelectorAll(".dropdowns-content").forEach((item) => {
                item.removeAttribute("style");
            });
            dropdowns.forEach((item) => {
                item.classList.remove("dropdowns-show");
            });
        }
    });

    // Fixed navbar-new menus on window resizing
    window.addEventListener("resize", () => {
        if (window.innerWidth > 992) {
            if (navbar - newmenu.classList.contains("is-active")) {
                navbar - newmenu.classList.remove("is-active");
                burgermenu.classList.remove("is-active");
            }
        }
    });
</script>
<style>
    #ecommerceCart {
        margin-top: 60px;
        width: 500px !important;
    }

    #cart-list .product h5,
    #cart-list .product h5 a {
        display: block;
        width: 250px !important;
        overflow-wrap: break-word;
        word-break: break-all;
        hyphens: auto;
        white-space: normal;
        /* Ensure text can wrap */
    }
</style>
<script>
    $(document).ready(function() {
        $(document).on('click', '#brandecommercecard', function() {
            if ("{{ Auth::user() }}") {
                load_cart()
            } else {
                window.location.href = '/user/login';
            }

        });
    });

    function load_cart() {
        $.ajax({
            url: '{{ route('cart.data') }}',
            type: 'GET',
            success: function(data) {
                $('#cart-list').empty();
                if (data.cart.length > 0) {
                    $('#procidetopay').removeClass('disabled')
                }
                data.cart.forEach(function(data) {
                    var product_variant = data.product
                    var product = data.product.product
                    var photo = product.photo.split(',');
                    var totalPrice = data.amount;
                    totalPrice = totalPrice.toFixed(2)
                    var listItem = `
                            <li class="list-group-item product">
                                <div class="d-flex gap-3">
                                    <div class="flex-shrink-0">
                                        <div class="avatar-md" style="height: 100%;">
                                            <div class="avatar-title bg-warning-subtle rounded-3">
                                                <img src="${photo[0]}" alt="${photo[0]}" class="avatar-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <a href="#!">
                                            <h5 class="fs-15"><a href="/product-detail/${product.slug}" target="_blank">${product.title}</a></h5>
                                        </a>
                                        <div class="d-flex mb-3 gap-2">
                                            <div class="text-muted fw-medium mb-0">Rs. <span class="product-price">${data.amount.toFixed(2)}</span></div>
                                            <div class="vr"></div>
                                            <span class="text-success fw-medium">In Stock</span>
                                        </div>
                                        <div class="input-step">
                                            <form action="{{ route('add.to.cart') }}" class='addcart' method="post">
                                                @csrf
                                                <button type="submit" class="minusCart">-</button>
                                                <input type="number" value="${data.quantity}" name='quantity' class="product-quantity" readonly>
                                                <input type="hidden" name="variant" value="${product_variant.id}" />
                                                <input type="hidden" name="q" value="-1" />
                                            </form>
                                            <form action="{{ route('add.to.cart') }}" class='addcart' method="post">
                                                @csrf
                                                <input type="hidden" name="variant" value="${product_variant.id}" />
                                                <input type="hidden" value="${data.quantity}" name='quantity'  class="product-quantity"  readonly>
                                                <input type="hidden" name="q" value="1" />
                                                <input type="hidden" name="slug" value="${product.slug}" />
                                                <button type="submit" class="addcart addcartbtn" data-slug='${product.slug}' data-variant='${product_variant.id}'>+</button>
                                            </form>
                                            
                                        </div>
                                    </div>
                                    <div class="flex-shrink-0 d-flex flex-column justify-content-between align-items-end">
                                        <button type="button" data-id="${data.id}" class="btn btn-icon btn-sm btn-ghost-secondary remove-item-btn" aria-label="Remove item">
                                            <i class="ri-close-fill fs-16"></i>
                                        </button>
                                        <div class="fw-medium mb-0 fs-16 price-hide">
                                            Rs.<span class="product-line-price">${totalPrice}</span>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        `;
                    $('#cart-list').append(listItem);
                });
                $('#total').text(`Rs. ${data.total}`);
            },
            error: function(error) {
                console.log('Error:', error);
            }
        });
    }
</script>

<script>
    $(document).on('click', '.remove-item-btn', function(e) {
        e.preventDefault();
        const itemId = $(this).data('id');
        $.ajax({
            url: `{{ route('cart-remove', '') }}/${itemId}`,
            type: 'POST',
            data: {
                id: itemId,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                load_cart();
                if (response.status === 'true') {
                    $('.cart').text(response.cart);
                    load_cart();
                } else {
                    alert('Error removing item: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                alert('An error occurred: ' + error);
            }
        });

    });


    $(document).on('click', '.addtocart', function(e) {
        e.preventDefault();
        @if (Auth::check())
            var slug = $(this).data('slug');
            var variant = $(this).data('variant');
            var quantity = '1';
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
                    load_cart()
                    if (response.status === 'true') {
                        $('.cart').text(response.cart);
                        // alert('Product added to cart successfully!'); 
                    } else {
                        alert(response.message);  
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        @else
            window.location.href = '/user/login';
        @endif
    })

    $(document).on('submit', '.addcart', function(e) {
        e.preventDefault();
        const form = $(this);
        const submitButton = form.find('.addcartbtn, .minusCart');
        submitButton.attr('disabled', true);
        @if (Auth::check())
            const data = form.serializeArray();

            // Check for specific conditions in data values
            if (data[1] && data[1].value == 1) {
                return; // Exit if the condition is met
            }

            $.ajax({
                url: "{{ route('add.to.cart') }}",
                type: 'POST',
                data: data,
                success: function(response) {
                    // Update cart

                    if (response.status === 'true') {
                        load_cart();
                        $('.cart').text(response.cart); // Update cart count
                    } 
                    if(response.status === 'false'){
                        alert(response.message); // Display message if necessary
                    }
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error); // Error handling
                },
                complete: function() {
                    // form.find('.addcart, .minusCart').removeAttr('disabled'); // Re-enable buttons
                }
            });
        @else
            window.location.href = '/user/login';
        @endif
    });

    $(document).on('click', '.plus_cart', function(e) {
        e.preventDefault()
        slug = $(this).data('slug')
        quantity = 1
        $.ajax({
            url: `/add-to-cart/${slug}/${quantity}`,
            type: 'GET', // Use 'POST' if your route accepts POST requests
            success: function(response) {
                // Handle the response here
                if (response.status = 'true') {
                    load_cart()
                    $('.cart').text(response.cart)
                }
            },
            error: function(xhr, status, error) {
                // Handle the error here
                window.location.href = '/user/login';
            }
        });
    })
    $(document).on('click', '.minus_cart', function(e) {
        q = $(this).data('q')
        if (q != 1) {
            slug = $(this).data('slug')
            quantity = -1
            $.ajax({
                url: `/add-to-cart/${slug}/${quantity}`,
                type: 'GET', // Use 'POST' if your route accepts POST requests
                success: function(response) {
                    // Handle the response here
                    if (response.status = 'true') {
                        load_cart()
                        $('.cart').text(response.cart)
                    }
                },
                error: function(xhr, status, error) {
                    window.location.href = '/user/login';
                }
            });
        }
    });

    

    const swiper_home = new Swiper('#homepage_slider', {
        // Optional parameters
        spaceBetween: 28,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next-banner',
            prevEl: '.swiper-button-prev-banner',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
    const swiper_product = new Swiper('#common_slider', {
        // Optional parameters
        slidesPerView: 4,
        spaceBetween: 28,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: true,
        },

        // Navigation arrows
        navigation: {
            nextEl: '.swiper-button-next-banner',
            prevEl: '.swiper-button-prev-banner',
        },

        // And if we need scrollbar
        scrollbar: {
            el: '.swiper-scrollbar',
        },
    });
    var swiper3 = new Swiper("#feedback-slider", {
        spaceBetween: 28,
        loop: true,
        autoplay: {
            delay: 2000,
            disableOnInteraction: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1024: {
                slidesPerView: 3,
            },
            1500: {
                slidesPerView: 4,
            },
        },

    });
    var swiper = new Swiper(".productSwiper", {
        spaceBetween: 10,
        slidesPerView: 4,
        mousewheel: true,
        freeMode: true,
        watchSlidesProgress: true,
        MouseEvents: true,
        breakpoints: {
            992: {
                slidesPerView: 4,
                spaceBetween: 10,
                direction: "vertical",
            },
        },
    });
    var swiper2 = new Swiper(".productSwiper2", {
        slidesPerView: 1,
        loop: true,
        spaceBetween: 10,
        autoplay: {
            delay: 2000,
            disableOnInteraction: true,
        },

        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        thumbs: {
            swiper: swiper,
        },
    });
    var swiper3 = new Swiper(".latest-slider", {
        spaceBetween: 24,
        loop: true,
        // autoplay: {
        //     delay: 2500,
        //     disableOnInteraction: false,
        // },
        navigation: {
            nextEl: ".swiper-button-next-top",
            prevEl: ".swiper-button-prev-top",
        },
        breakpoints: {
            471: {
                slidesPerView: 2,
            },
            600: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 4,
            },
            1500: {
                slidesPerView: 4,
            },
        },
    });
    var swiper = new Swiper(".mySwiper", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
    $(document).off('.plus'); // Removes all event listeners from elements with class 'plus'
    $(document).off('.minus'); // Removes all event listeners from elements with class 'minus'
    $(document).on('click', '.plus_btn_all', function(e) {
        plus_q = $('#product-quantity').val()
        $('#product-quantity').val(Number(plus_q) + 1)
    })
    $(document).on('click', '.minus_btn_all', function(e) {
        minus_q = $('#product-quantity').val()
        if (minus_q > 1) {
            $('#product-quantity').val(Number(minus_q) - 1)
        }
    });

    // search by click


    $(document).ready(function() {
        $('#searchLabel').on('click', function(e) {
            e.preventDefault(); 
            
            var searchInput = $('#searchright');
            var inputValue = searchInput.val().trim();

            if (searchInput.is(':visible')) {
                if (inputValue !== "") {
                    $('#searchForm').submit(); 
                }
                searchInput.show().focus();
            } else {
                searchInput.show().focus(); 
            }
        });
    });


    // wishlist
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
    //end Wishlist
</script>
