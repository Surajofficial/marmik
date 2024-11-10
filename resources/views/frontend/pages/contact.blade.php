@extends('frontend.layouts.master')

@section('main-content')
    <section class="section bg-ghost-dark mt-5 mb-0">
        <div class="">
            <div class="row justify-content-center">
                <div class="col-lg-6" style="margin-top: 60px;">
                    <div class="text-center">
                        <!-- @if (isset($type[0]))
    <h1 class="text-white mb-0">{{ $type[0]->title }} </h1>
@else
    <h1 class="text-white mb-0">Product </h1>
    @endif -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                                <li class="breadcrumb-item"><a href="{{ URL::to('/') }}">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Contact Us</a></li>

                            </ol>
                        </nav>
                        <div class="text-center">
                            <p class="h3 lh-base mx-5 m-lg-0  ">Contact Us</p>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class=" col-lg-7">
                    <p class="h3 lh-base mx-2 mx-lg-0 mb-5 text-center ">Let's start something great together. Get in touch
                        with one of
                        the team today!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card border border-opacity-25 rounded-4">
                        <div class="card-body p-4 bg-dark bg-opacity-50 rounded-4">
                            <div class="d-flex">
                                <div class="avatar-sm flex-shrink-0">
                                    <div class="avatar-title bg-dark-subtle text-dark rounded fs-17">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </div>
                                </div>
                                @php
                                    $settings = DB::table('settings')->get();
                                @endphp
                                <div class="ms-3 flex-grow-1 ">
                                    <h5 class="fs-17 lh-base mb-2">Our Main Office</h5>
                                    <p class="fs-14 mb-0">
                                        @foreach ($settings as $data)
                                            {{ $data->address }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card border border-opacity-25 rounded-4">
                        <div class="card-body p-4 bg-dark bg-opacity-50 rounded-4">
                            <div class="d-flex">
                                <div class="avatar-sm flex-shrink-0">
                                    <div class="avatar-title bg-dark-subtle text-dark rounded fs-17">
                                        <i class="bi bi-telephone-fill"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h5 class="fs-17 lh-base mb-2">Phone Number</h5>
                                    <p class="fs-14 mb-0">
                                        @foreach ($settings as $data)
                                            {{ $data->phone }}
                                            <br />
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card border border-opacity-25  rounded-4">
                        <div class="card-body p-4 bg-dark bg-opacity-50 rounded-4">
                            <div class="d-flex">
                                <div class="avatar-sm flex-shrink-0">
                                    <div class="avatar-title bg-dark-subtle text-dark rounded fs-17">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                </div>
                                <div class="ms-3 flex-grow-1">
                                    <h5 class="fs-17 lh-base mb-2">Email</h5>
                                    <p class="fs-14 mb-0">
                                        @foreach ($settings as $data)
                                            {{ $data->email }}
                                        @endforeach
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="custom-form card p-4 p-lg-5   bg-dark bg-opacity-50 rounded-4"
                        >
                        {{-- Error field add by Saurav --}}
                        <form class="" method="get" action="{{ route('contact.store') }}">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="text-center mb-4">
                                        <h3 class="text-capitalize">Get In Touch with us for more Information</h3>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mt-3">
                                        <label for="nameInput" class="form-label">Name<span
                                                class="text-danger">*</span></label>
                                        <input name="name" id="name" type="text" value="{{ old('name') }}"
                                            class="form-control rounded-pill" placeholder="Enter name">
                                        @if ($errors->has('name'))
                                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">{{ $errors->first('name') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group mt-3">
                                        <label for="emailInput" class="form-label">Email<span
                                                class="text-danger">*</span></label>
                                        <input name="email" type="email" type="email" value="{{ old('email') }}"
                                            class="form-control rounded-pill" placeholder="Enter email">
                                        @if ($errors->has('email'))
                                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">{{ $errors->first('email') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label for="phone" class="form-label">Phone<span
                                                class="text-danger">*</span></label>
                                        <input type="number" class="form-control rounded-pill" id="phone"
                                            name="phone" type="text" value="{{ old('phone') }}"
                                            placeholder="Enter Your Phone..">
                                        @if ($errors->has('phone'))
                                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">{{ $errors->first('phone') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label for="phone" class="form-label">Subject<span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control rounded-pill"
                                            value="{{ old('subject') }}" name="subject" type="text"
                                            placeholder="Enter Subject..">
                                        @if ($errors->has('subject'))
                                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">{{ $errors->first('subject') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group mt-3">
                                        <label for="message" class="form-label">Message<span
                                                class="text-danger">*</span></label>
                                        <textarea name="message" id="message" rows="4" class="form-control rounded-4"
                                            placeholder="Enter message..."></textarea>
                                        @if ($errors->has('message'))
                                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">{{ $errors->first('message') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="text-end mt-4">
                                        <button type="submit" name="submit" class="btn btn-dark  rounded-pill">Send
                                            Message <i
                                                class="bi bi-arrow-right-short align-middle fs-16 ms-1"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        {{-- Error field add by Saurav --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <div class="container-fluid px-0">
            <div class="row g-0">
                <div class="col-lg-12">
                    <div class="map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3024.4645962375394!2d-74.01354043428768!3d40.7077878458095!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sSoHo%2094%20Broadway%20St%20New%20York%2C%20NY%201001!5e0!3m2!1sen!2sin!4v1669110084163!5m2!1sen!2sin"
                            class="w-100" height="400" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="modal fade mt-5" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body d-flex">
                    <p class="text-success">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        @if (session('success'))
            $('#success').modal('show');
            setTimeout(function() {
                $('#success').modal('hide');
            }, 2000); // 5 seconds
        @endif
    });
</script>

@push('scripts')
    <script src="{{ asset('frontend/js/jquery.form.js') }}"></script>
    <script src="{{ asset('frontend/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('frontend/js/contact.js') }}"></script>
@endpush
