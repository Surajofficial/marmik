@extends('frontend.layouts.master')

@section('title', 'Dr Awish || Login Page')

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
                                            <h1 class="text-white lh-base ">Let's Get Started</h1>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body bg-color-light m-2 mt-0" style="box-shadow: -9px 1px 10px #b8b6b6;">
                                    <p class="text-muted fs-15">Get your free account now</p>
                                    <div class="p-2">
                                        <form class="needs-validation" method="post"
                                            action="{{ route('register.submit') }}">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control rounded-pill"
                                                    id="name" placeholder="Enter name" value="{{ old('name') }}"
                                                    required>

                                                <div class="invalid-feedback">
                                                    Please enter email
                                                </div>

                                            </div>
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">Mobile Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="mobile" class="form-control rounded-pill"
                                                    id="mobile" placeholder="Enter Mobile Number"
                                                    value="{{ old('mobile') }}" required>
                                                <div class="invalid-feedback">
                                                    Mobile Number
                                                </div>
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

                                            <div class="mt-4 d-flex justify-content-center">
                                                <button class="btn btn-dark rounded-pill w-75" id="send_otp"
                                                    type="button">Send
                                                    OTP</button>
                                            </div>
                                            <div class="mt-4 d-flex justify-content-center d-none" id="submit">
                                                <button class="btn btn-dark rounded-pill w-75" type="submit">Sign
                                                    Up</button>
                                            </div>

                                            <div class="mb-4 mt-2">
                                                <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the
                                                    <a href="{{ route('terms') }}"
                                                        class="text-primary text-decoration-underline fst-normal fw-medium">Terms
                                                        of Use</a>
                                                </p>
                                            </div>
                                        </form>
                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Already have an account ? <a href="{{ route('login.form') }}"
                                                    class="fw-semibold text-primary text-decoration-underline"> Signin </a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!--end col-->
                    </div><!--end row-->
                </div><!--end container-->
            </div>
    </section>
    <script src="../assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/libs/simplebar/simplebar.min.js"></script>
    <script src="../assets/js/plugins.js"></script>

    <script src="../assets/js/pages/password-addon.init.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script>
        $('#send_otp').on('click', function() {
            var mobile = $('#mobile').val();
            $.ajax({
                url: '{{ route('send.otp.register') }}',
                type: 'POST',
                data: {
                    mobile: mobile,
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    if (response == 'success') {
                        $('#submit').removeClass('d-none');
                        $('#send_otp').addClass('d-none');
                        $('#otp').removeClass('d-none'); // Show OTP input field
                        $('#mobile').attr('readonly', true); // Make the input readonly}
                    } else {
                        alert(response.error[0].message)
                    }
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON.error);
                }
            });
        });
    </script>
@endsection
