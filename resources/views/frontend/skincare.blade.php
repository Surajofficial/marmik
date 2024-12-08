@extends('frontend.layouts.master')

@section('title', 'Marmik || {{ $title }}')

@section('main-content')

    <!-- Breadcrumbs -->

    <!-- End Breadcrumbs -->

    <!-- About Us -->
    <style>
        .form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            background-color: #ffffff;
            padding: 30px;
            width: 450px;
            border-radius: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        ::placeholder {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .form button {
            align-self: flex-end;
        }

        .flex-column>label {
            color: #151717;
            font-weight: 600;
        }

        .inputForm {
            border: 1.5px solid #ecedec;
            border-radius: 10px;
            height: 50px;
            display: flex;
            align-items: center;
            padding-left: 10px;
            transition: 0.2s ease-in-out;
        }

        .input {
            margin-left: 10px;
            border-radius: 10px;
            border: none;
            width: 100%;
            height: 100%;
        }

        .input:focus {
            outline: none;
        }

        .inputForm:focus-within {
            border: 1.5px solid #2d79f3;
        }

        .flex-row {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 10px;
            justify-content: space-between;
        }

        .flex-row>div>label {
            font-size: 14px;
            color: black;
            font-weight: 400;
        }

        .span {
            font-size: 14px;
            margin-left: 5px;
            color: #2d79f3;
            font-weight: 500;
            cursor: pointer;
        }

        .button-submit {
            margin: 20px 0 10px 0;
            background-color: #151717;
            border: none;
            color: white;
            font-size: 15px;
            font-weight: 500;
            border-radius: 10px;
            height: 50px;
            width: 100%;
            cursor: pointer;
        }

        .p {
            text-align: center;
            color: black;
            font-size: 14px;
            margin: 5px 0;
        }

        .btn {
            margin-top: 10px;
            width: 100%;
            height: 50px;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: 500;
            gap: 10px;
            border: 1px solid #ededef;
            background-color: white;
            cursor: pointer;
            transition: 0.2s ease-in-out;
        }

        .btn:hover {
            border: 1px solid #2d79f3;
            ;
        }
    </style>

    <section class="section mt-5">
        <div class="container">
            <div class="row justify-content-center">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Skin Care Routine</a></li>

                    </ol>
                </nav>
                <!-- <div class="col-lg-12">
                                                      
                                                    </div> -->
                <!--end col-->
            </div><!--end row-->

            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-12 m-3">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="form" action="{{ route('skincare.routine') }}" method="POST">
                        @csrf
                        <div class="flex-column">
                            <label>Name </label>
                        </div>


                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm9-1a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2h8zm-4-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                            </svg>

                            <input placeholder="Enter your Name" class="input" type="text" name="name">
                        </div>
                        <div class="flex-column">
                            <label>Gender </label>
                        </div>

                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M9 5a3 3 0 1 0-3 3 3 3 0 0 0 3-3zm-4.999.8a2 2 0 1 1 4-.001 2 2 0 0 1-4 0zM11 9h1.5a1 1 0 0 1 1 1v4h1.5a.5.5 0 0 1 0 1H12.5a.5.5 0 0 1-.5-.5V10h-1v4.5a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5V10h-1v4.5a.5.5 0 0 1-.5.5H5.5a.5.5 0 0 1 0-1H7V10H5v4a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H3V10a1 1 0 0 1 1-1H5V7a4 4 0 1 1 8 0v2z" />
                            </svg>

                            <input placeholder="Gender" class="input" type="text" name="gender">
                        </div>
                        <div class="flex-column">
                            <label>Age </label>
                        </div>

                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3.5 0a.5.5 0 0 1 .5.5v.5h8V.5a.5.5 0 0 1 1 0v.5h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2h-11a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM14 3a1 1 0 0 0-1-1h-1v.5a.5.5 0 0 1-1 0V2H4v.5a.5.5 0 0 1-1 0V2H2a1 1 0 0 0-1 1v2h13V3zM1 6v8a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1V6H1z" />
                            </svg>

                            <input placeholder="Age" class="input" type="text" name="age">
                        </div>
                        <div class="flex-column">
                            <label>Mobile </label>
                        </div>

                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V2zm2-1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H5zm3 12a.5.5 0 0 1 0 1 .5.5 0 0 1 0-1z" />
                            </svg>

                            <input placeholder="Mobile" class="input" name="mobile" type="text">
                        </div>
                        <div class="flex-column">
                            <label>Email </label>
                        </div>

                        <div class="inputForm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                viewBox="0 0 16 16">
                                <path
                                    d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383l-5.857 3.514a.5.5 0 0 1-.286.086.5.5 0 0 1-.286-.086L1 5.383V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5.383z" />
                            </svg>

                            <input placeholder="Enter your Email" class="input" type="text" name="email">
                        </div>


                        <button class="button-submit" type="submit">Check Routine</button>


                    </form>
                </div>
            </div>


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
