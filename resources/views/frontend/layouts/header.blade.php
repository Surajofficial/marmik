@php
    $settings = DB::table('settings')->get();
@endphp
<style>
    .marquee {
        position: fixed;
        top: 0px;
        background-color: black;
        color: white;
        height: 60px;
        margin: auto;
        font-size: 20px;
        z-index: 999999;
        padding: 15px;
        text-transform: uppercase
    }

    .new-header {
        margin-bottom: 30px
    }
</style>


<style>
  @media (min-width: 983px) {
    .hide-on-large {
      display: none;
    }
  }

  /* Dropdown styling */
  .dropdown-menu {
        min-width: 250px;
        max-width: 400px;
    }

    /* Focus and hover effects */
    .form-control:focus {
        box-shadow: none;
        border-color: #007bff;
    }

    .input-group .form-control {
        padding-left: 15px;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    @media(max-width:350px)
    {
        .navbar-new #navebaricon1 .hide-btn{
            display: none;
        }
        .navbar-new .show-btn{
            display: block;
        }
    }

</style>
<header class="new-header" id="new-header">
    <nav class="navbar-new container-fluid px-lg-5 py-1 ">
        <div class="navbar-new-inner">
            <a class="navbar-brand  " href="{{ route('home') }}">
                <div class="logo-dark">
                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo"
                        class="logo w-50">
                </div>
                <div class="logo-light">
                    <img src="@foreach ($settings as $data) {{ $data->logo }} @endforeach" alt="logo"
                        class="logo">
                </div>
            </a>
            {{-- li nav --}}
            <div class="d-flex gap-1 align-items-center d-block d-lg-none" id="navebaricon1">
                <div class="topbar-head-dropdown ms-1 header-item hide-btn">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"
                        data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" id="brandecommercecard"
                        aria-controls="ecommerceCart">
                        <i class="ph-shopping-cart fs-20"></i>
                        <span class="position-absolute topbar-badge cartitem-badge translate-middle badge rounded-pill bg-dark cart">{{ Helper::cartCount() != 0 ? Helper::cartCount() : '' }}</span>
                    </button>
                </div>
                <div class="dropdown header-item dropdown-hover-end hide-btn">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"
                        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ph-user fs-20"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="z-index:20;">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome </h6>
    
                        <a class="dropdown-item"href="{{ route('faq') }}"><i
                                class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
    
                        @if (auth()->user() != '')
                            <a class="dropdown-item" href="{{ route('account') }}"><i
                                    class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Dashboard</span></a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                    class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                        @else
                            <a class="dropdown-item"href="{{ route('login.form') }}"><i
                                    class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Login</span></a>
                            <a class="dropdown-item" href="{{ route('register.form') }}"><i
                                    class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Register</span></a>
                        @endif
                    </div>
                </div>
                <div class="dropdown header-item dropdown-hover-end ">
                    <!-- Search Button Icon -->
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"
                        id="page-header-search-dropdown " data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="bi bi-search fs-20"></i>
                    </button>
    
                    <!-- Dropdown with Search Form -->
                    <div class="dropdown-menu dropdown-menu-end p-3" style="z-index:20; width: 300px;">
                        <!-- Search Form -->
                        <form method="POST" action="{{ route('product.search') }}" id="dropdownSearchForm">
                            @csrf
                            <div class="input-group">
                                <input type="search" class="form-control" name="q" placeholder="Search..." aria-label="Search"
                                    aria-describedby="search-button" style="border-radius: 20px;">
                                <button class="btn btn-dark" type="submit" id="search-button"
                                    style="border-radius: 20px; margin-left: 5px;">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold">
                    <div class="burger " id="burger">
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                        <span class="burger-line"></span>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="navbar-new-block" id="menus">
            <ul class="menus">
                
                <li class="menus-item">
                    <a href="{{ route('home') }}" class="menus-link">Home</a>
                </li>

                <!-- <li class="menus-item dropdowns">
                    <span class="dropdowns-toggle menus-link">
                        @foreach ($settings as $data)
                            {{ $data->concerntext }}
                        @endforeach
                        <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdowns-content">
                        <div class="dropdowns-column">
                            <div class="dropdowns-column1 row py-md-5 px-5 py-2  justify-content-center">
                                {!! Helper::getHeaderConcern() !!}
                            </div>
                        </div>
                    </div>
                </li> -->
                <li class="menus-item dropdowns">
                    <span class="dropdowns-toggle menus-link">
                        @foreach ($settings as $data)
                            {{ $data->categorytext }}
                        @endforeach
                        <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdowns-content">
                        <div class="dropdowns-column1 row py-md-5 px-5 justify-content-center ">
                            {!! Helper::getHeaderProductType() !!}
                        </div>
                    </div>
                </li>

                <!-- <li class="menus-item dropdowns">
                    <span class="dropdowns-toggle menus-link">
                        Category <i class="bx bx-chevron-down"></i>
                    </span>
                    <div class="dropdowns-content">
                        <div class="row  py-md-5 px-5 justify-content-center">
                            {!! Helper::getHeaderCategory() !!}
                        </div>
                    </div>
                </li> -->
                <li class="menus-item"><a href="{{ route('contact') }}" class="menus-link">Contact Us</a></li>
                <!-- <li class="menus-item text-white bg-black"><a href="{{ route('book_slot') }}"
                        class="menus-link text-white">Free
                        Consultation</a>
                </li> -->

                <li class="menus-item text-white bg-black show-btn">
                    <button type="button" class=" menus-link btn btn-icon btn-topbar text-white fw-bold"
                        data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" id="brandecommercecard"
                        aria-controls="ecommerceCart">
                        <i class="ph-shopping-cart fs-20"></i>Cart
                        <span class="position-absolute topbar-badge cartitem-badge translate-middle badge rounded-pill bg-dark cart">{{ Helper::cartCount() != 0 ? Helper::cartCount() : '' }}</span>
                    </button>
                </li>

                <li class="menus-item show-btn text-white bg-black">
                    <button type="button" class="menus-link btn btn-icon btn-topbar text-white btn-white fw-bold"
                        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ph-user fs-20"></i> User
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="z-index:20;">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome </h6>

                        <a class="dropdown-item"href="{{ route('faq') }}"><i
                                class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>

                        @if (auth()->user() != '')
                            <a class="dropdown-item" href="{{ route('account') }}"><i
                                    class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Dashboard</span></a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                    class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                        @else
                            <a class="dropdown-item"href="{{ route('login.form') }}"><i
                                    class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Login</span></a>
                            <a class="dropdown-item" href="{{ route('register.form') }}"><i
                                    class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Register</span></a>
                        @endif
                    </div>
                </li>

                {{-- <li class="menus-item dropdowns text-white bg-black">
                    <button type="button" class="menus-link btn btn-icon btn-topbar text-white btn-white fw-bold"
                        id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="ph-user fs-20"></i> User
                    </button>
                    <div class="dropdown-menu dropdown-menu-end" style="z-index:20;">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome </h6>
    
                        <a class="dropdown-item"href="{{ route('faq') }}"><i
                                class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>
    
                        @if (auth()->user() != '')
                            <a class="dropdown-item" href="{{ route('account') }}"><i
                                    class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Dashboard</span></a>
                            <a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                    class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">Logout</span></a>
                        @else
                            <a class="dropdown-item"href="{{ route('login.form') }}"><i
                                    class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Login</span></a>
                            <a class="dropdown-item" href="{{ route('register.form') }}"><i
                                    class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">Register</span></a>
                        @endif
                    </div>
                </li> --}}

            </ul>
        </div>
        <div class="d-flex align-items-center d-none d-lg-flex" id="navebaricon1">
            <div class="dropdown header-item search-container-main1">
                <div class="search-container">
                    <form method="POST" action="{{ route('product.search') }}" id="searchForm">
                        @csrf
                        <input class="search expandright" id="searchright" type="search" name="q" placeholder="Search" style="display: none;">
                        <label class="button searchbutton" for="searchright" id="searchLabel">
                            <span class="mglass btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"> 
                                <i class="bi bi-search fs-18"></i>
                            </span>
                        </label>
                    </form>
                </div>
            </div>
            
            <div class="topbar-head-dropdown ms-1 header-item">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"
                    data-bs-toggle="offcanvas" data-bs-target="#ecommerceCart" id="brandecommercecard"
                    aria-controls="ecommerceCart">
                    <i class="ph-shopping-cart fs-24"></i>
                    <span
                        class="position-absolute topbar-badge cartitem-badge fs-10 translate-middle badge rounded-pill bg-dark cart">{{ Helper::cartCount() != 0 ? Helper::cartCount() : '' }}</span>
                </button>
            </div>
            <div class="dropdown header-item dropdown-hover-end ">
                <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle fw-bold"
                    id="page-header-user-dropdown" data-bs-toggle="dropdown-" aria-haspopup="true"
                    aria-expanded="false">
                    <i class="ph-user fs-24"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-end" style="z-index:20;">
                    <!-- item-->
                    <h6 class="dropdown-header">Welcome </h6>

                    <a class="dropdown-item"href="{{ route('faq') }}"><i
                            class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span
                            class="align-middle">Help</span></a>
                    <div class="dropdown-divider"></div>

                    @if (auth()->user() != '')
                        <a class="dropdown-item" href="{{ route('account') }}"><i
                                class="bi bi-speedometer2 text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Dashboard</span></a>
                        <a class="dropdown-item" href="{{ route('user.logout') }}"><i
                                class="bi bi-box-arrow-right text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    @else
                        <a class="dropdown-item"href="{{ route('login.form') }}"><i
                                class="bi bi-cart4 text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Login</span></a>
                        <a class="dropdown-item" href="{{ route('login.form') }}"><i
                                class="bi bi-truck text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Register</span></a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- <marquee class="marquee" behavior="" direction="">
    <a href="{{ route('book_slot') }}">Book your FREE appointment with Skin and Hair Doctor</a>
</marquee> -->

<a href="https://api.whatsapp.com/send/?phone=919310032619&text=Hey+there%21&type=phone_number&app_absent=0"
    class="btn btn-success position-fixed bottom-0 m-3 z-3 btn-hover" id="whatsappbtn" target="_blank"><i
        class="bi bi-whatsapp align-middle " style="font-size:20px;"></i> </a>

<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-info btn-icon" style="bottom: 50px;" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<div class="modal fade" id="subscribeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0">
            <div class="modal-body p-0 bg-info-subtle rounded">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-6">
                        <div class="p-4 h-100">
                            <span class="badge bg-info-subtle text-info  fs-13"></span>
                            <h2 class="display-6 mt-2 mb-3">Rewards Points</h2>
                            <p class="mb-4 pb-lg-2 fs-16">Earn more Reward Points for different actions, and turn those
                                Reward Points into awesome rewards!

                            </p>

                            <h3>Way To Earn</h3>
                            <p>1. PLACE AN ORDER<span>
                                    (3 Reward Points for every ₹100 spent)</span></p>
                            <h3>Way To Order</h3>
                            <p>1. Order Discount<span>
                                    (1 Reward Point = Rs. 1)</span></p>

                        </div>

                    </div>
                    <div class="col-lg-6">
                        <div class="p-11 pb-0">
                            <img src="../assets/images/rewards.png" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Simple validation before form submit
    document.getElementById('dropdownSearchForm').addEventListener('submit', function(e) {
        const searchInput = document.querySelector('input[name="q"]');
        if (searchInput.value.trim() === "") {
            e.preventDefault(); // Prevent empty form submission
        }
    });

//     $('#page-header-user-dropdown').on('click', function(event) {
//     event.stopPropagation(); // Only if needed
// });

    // navebaricon1

    // document.addEventListener('click','#page-header-user-dropdown',function()
    // {

    // });

//     document.addEventListener('click', function (event) {
        
//     if (event.target.matches('#page-header-user-dropdown')) {
//         event.preventDefault();
//         const dropdownMenu = event.target.nextElementSibling;
//         dropdownMenu.classList.toggle('show'); 
//     } else {
        
//         const dropdownMenu = document.querySelector('.dropdown-menu');
//         if (dropdownMenu && dropdownMenu.classList.contains('show')) {
//             dropdownMenu.classList.remove('show'); 
//         }
//     }
// });


</script>