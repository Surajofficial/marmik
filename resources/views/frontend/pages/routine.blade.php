@extends('frontend.layouts.master')
@section('title', 'Marmik || Routine')
@section('main-content')


    <section class="section">
        <div class="container">

            <div class="row g-0 align-items-center" id="first" style="display:block;">
                <div class="col-lg-6">
                    <div class="p-4 h-100">
                        <span class="badge text-info  fs-13"></span>
                        <h2 class="display-6 mt-2 mb-3">Build Your Personalized Skincare Routine</h2>
                        <p>Get your personalized routine by just answering a simple 2-minute quiz. Our professionals will
                            review and evaluate your concerns and we will create the best suitable regime for you</p>
                        <button class="btn btn-warning" onclick="quiz()">Start Quiz</button>

                    </div>

                </div>

            </div>
            <form class="needs-validation" method="post" action="{{ route('routine.submit') }}">
                @csrf
                <div class="mb-3">
                    <label for="mobile" class="form-label">Hi, let’s start with an introduction <span
                            class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" id="name" placeholder="Enter name"
                        value="{{ old('name') }}" required>
                    <div class="invalid-feedback">
                        Name
                    </div>
                </div>
                <div class="mb-3">
                    <label for="useremail" class="form-label">Age Group <span class="text-danger">*</span></label>
                    <input type="radio" name="age" id="age" placeholder="Enter email address" value="1">12
                    to 18
                    <input type="radio" name="age" id="age" placeholder="Enter email address" value="2">12
                    to 18
                    <input type="radio" name="age" id="age" placeholder="Enter email address" value="3">12
                    to 18
                    <input type="radio" name="age" id="age" placeholder="Enter email address" value="4">12
                    to 18



                </div>
                <div class="mb-3">
                    <label for="useremail" class="form-label">Skin Type <span class="text-danger">*</span></label>
                    <input type="radio" name="skin" id="age" placeholder="Enter email address"
                        value="oily">Oily
                    <input type="radio" name="skin" id="age" placeholder="Enter email address" value="dry">Dry
                    <input type="radio" name="skin" id="age" placeholder="Enter email address"
                        value="normal">Normal



                </div>
                <div class="mb-3">
                    <label for="useremail" class="form-label">What is your primary skin concern ? <span
                            class="text-danger">*</span></label>
                    <input type="radio" name="pconcern_id" id="age" placeholder="Enter email address"
                        value="1">Acne
                    <input type="radio" name="pconcern_id" id="age" placeholder="Enter email address"
                        value="2">Ace
                    <input type="radio" name="pconcern_id" id="age" placeholder="Enter email address"
                        value="3">Oiliness



                </div>
                <div class="mb-3">
                    <label for="useremail" class="form-label">What is your secondary skin concern ? <span
                            class="text-danger">*</span></label>
                    <input type="radio" name="sconcern_id" id="age" placeholder="Enter email address"
                        value="1">Acne
                    <input type="radio" name="sconcern_id" id="age" placeholder="Enter email address"
                        value="2">Ace
                    <input type="radio" name="sconcern_id" id="age" placeholder="Enter email address"
                        value="3">Oiliness
                </div>

                <div class="mb-3">
                    <label for="useremail" class="form-label">Is your skin sensitive, kshyiz?? <span
                            class="text-danger">*</span></label>
                    <input type="radio" name="sensitive" id="age" placeholder="Enter email address"
                        value="1">yes
                    <input type="radio" name="sensitive" id="age" placeholder="Enter email address"
                        value="2">no
                    <input type="radio" name="sensitive" id="age" placeholder="Enter email address"
                        value="3">sometimes
                </div>

                <div class="mb-3">
                    <label for="useremail" class="form-label">Are you pregnant or breastfeeding? <span
                            class="text-danger">*</span></label>
                    <input type="radio" name="pb" id="age" placeholder="Enter email address"
                        value="1">yes
                    <input type="radio" name="pb" id="age" placeholder="Enter email address"
                        value="2">no
                </div>


                <div class="mb-3">
                    <label for="username" class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="text" name="email" class="form-control" id="username"
                        placeholder="Enter username" value="{{ old('name') }}" required>
                    <div class="invalid-feedback">
                        Please enter email
                    </div>
                </div>



                <div class="mb-4">
                    <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the <a
                            href="{{ route('terms') }}"
                            class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary w-100" type="submit">Sign Up</button>
                </div>

            </form>
            <!--end row-->
        </div>
        <!--end container-->
    </section>

    @include('frontend.layouts.newsletter')
    <script>
        function quiz() {
            console.log(document.getElementById("first"));
            document.getElementById("first").style = "display:none";
            document.getElementById("regForm").style = "display:block";
        }
    </script>



@endsection
