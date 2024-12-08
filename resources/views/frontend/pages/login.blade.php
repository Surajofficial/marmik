@extends('frontend.layouts.master')

@section('title', 'MARMIK || Login Page')

@section('main-content')
    <section
        class="auth-page-wrapper position-relative bg-light min-vh-100 d-flex align-items-center justify-content-between">

        <div class="w-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <div class="auth-card mx-lg-3">
                            <div class="card border-0 mb-0">
                                <div class="card-header bg-dark border-0">
                                    <div class="row">
                                        <div class="col-lg-9 col-9">
                                            <h1 class="text-white lh-base ">Welcome to Marmik</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-dark bg-opacity-50 m-2 mt-0"
                                    style="box-shadow: -9px 1px 10px #b8b6b6;">
                                    <p class="fs-15">Sign in to continue to Marmik.</p>

                                    @if (session('error'))
                                        <p class="text-danger">
                                            {{ session('error') }}
                                        </p>
                                    @endif

                                    <div class="p-2">
                                        <form class="form" method="post" action="{{ route('verify.otp') }}"
                                            id="otpForm">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">Mobile Number</label>
                                                <input type="text" name="mobile" class="form-control rounded-pill"
                                                    id="mobile" placeholder="Enter Mobile">
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="mb-3 d-none" id="otp">

                                                <label class="form-label" for="otp_code">OTP</label>
                                                <div class="position-relative auth-pass-inputgroup mb-3">
                                                    <input type="number" name="otp_code"
                                                        class="form-control pe-5 password-input rounded-pill"
                                                        placeholder="Enter OTP" id="otp_code">
                                                </div>
                                                @error('otp_code')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            {{-- <div class="mb-3 d-flex justify-content-end">
                                            <a href="#" id="toggleForm" style="font-size:15px; font-weight:600; color:#548ce4;">Login with Email</a>
                                        </div> --}}

                                            <div class="mt-4 d-flex justify-content-center ">
                                                <button class="btn btn-dark rounded-pill w-75" id="send_otp"
                                                    type="button">Send
                                                    OTP</button>
                                            </div>
                                            <div class="mt-4 d-flex justify-content-center d-none" id="submit">
                                                <button class="btn btn-dark rounded-pill w-75"
                                                    type="submit">Submit</button>
                                            </div>
                                        </form>
                                        <!-- Email/Password Form -->
                                        {{-- <form class="form d-none" method="post" action="{{ route('login.social') }}" id="emailPasswordForm"> --}}
                                        <form class="form d-flex justify-content-center" method="post"
                                            action="{{ route('login.social') }}">
                                            @csrf
                                            {{-- <div class="mt-4 d-flex justify-content-center">
                                            <button class="btn btn-white w-60" style="border:1px solid #000; box-shadow: 5px 3px 5px rgba(0,0,0,.5);" type="submit">continue with Google</button>
                                        </div> --}}

                                            <div class="mt-4 d-flex justify-content-center bg-white p-0">
                                                <button type="submit">
                                                    <img src="{{ asset('images/1-2.png') }}" alt=""
                                                        style="width: 160px;height: 35px;" />
                                                </button>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->


            <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
            <script>
                // $(document).ready(function() {
                //     // Toggle between forms
                //     $('#toggleForm').click(function(e) {
                //         e.preventDefault();
                //         $('#otpForm').toggleClass('d-none');
                //         $('#emailPasswordForm').toggleClass('d-none');
                //     });

                //     // Send OTP button click
                //     $('#send_otp').click(function() {
                //         // Send OTP logic here
                //         // For example, AJAX call to send OTP (not implemented here)

                //         // Show OTP input and submit button
                //         $('#otp').removeClass('d-none');
                //         $('#submit').removeClass('d-none');
                //     });

                //     // Form submission for OTP
                //     $('#otpForm').submit(function(e) {
                //         e.preventDefault();
                //         // Optionally validate fields here

                //         // Submit form using AJAX or allow default submission
                //         this.submit(); // For regular submission
                //     });

                //     // Form submission for Email/Password
                //     $('#emailPasswordForm').submit(function(e) {
                //         e.preventDefault();
                //         // Optionally validate fields here

                //         // Submit form using AJAX or allow default submission
                //         this.submit(); // For regular submission
                //     });
                // });
            </script>


            <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
                crossorigin="anonymous"></script>
            <script>
                $(document).ready(function() {
                    $('#send_otp').on('click', function() {
                        var mobile = $('#mobile').val();
                        $.ajax({
                            url: '{{ route('send.otp') }}',
                            type: 'POST',
                            data: {
                                mobile: mobile,
                                _token: "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                @if ($host == 'local')
                                    $('#submit').removeClass('d-none');
                                    $('#send_otp').addClass('d-none');
                                    $('#otp').removeClass('d-none'); // Show OTP input field
                                    $('#mobile').attr('readonly', true); // Make the input readonly}
                                @else
                                    if (response == 'success') {
                                        $('#submit').removeClass('d-none');
                                        $('#send_otp').addClass('d-none');
                                        $('#otp').removeClass('d-none'); // Show OTP input field
                                        $('#mobile').attr('readonly', true); // Make the input readonly}
                                    } else {
                                        alert(response.error[0].message)
                                    }
                                @endif
                            },
                            error: function(xhr) {
                                console.log(xhr.responseJSON.error);
                            }
                        });
                    });
                });
            </script>
        @endsection
