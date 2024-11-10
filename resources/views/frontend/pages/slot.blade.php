@extends('frontend.layouts.master')

@section('title', 'Dr. Awish || Book An Appointment')

@section('main-content')

    <style>
        #slotContainer {
            display: flex;
            justify-content: space-between;
        }
    </style>

    <section class="section bg-color-light mt-5 mb-3" style="padding-top:100px">

        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb  justify-content-center mt-4" style="color:black !important">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item">Book An Appointment</li>
                        </ol>
                    </nav>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </section>

    <p class="h3 lh-base mx-5 m-lg-0 my-5 text-center  ">Please Fill In The Details To Book An Appointment</p>

    <section>
        {{-- Error field add by Saurav --}}
        <form class="form container py-3 px-5 bg-color-light mt-3 mb-4 rounded-4" method="post"
            action="{{ route('book_slot.save_slot') }}">
            @csrf
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mt-3">
                        <label for="nameInput" class="form-label mx-2">Name<span class="text-danger">*</span></label>
                        <input name="name" id="name" type="text" class="form-control rounded-pill"
                            placeholder="Enter name" value="{{old('name')}}" required>
                        @if ($errors->has('name'))
                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                                {{ $errors->first('name') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mt-3">
                        <label for="emailInput" class="form-label mx-2">Email<span class="text-danger">*</span></label>
                        <input name="email" type="email" type="email" class="form-control rounded-pill"
                            placeholder="Enter email" value="{{old('email')}}" required>
                        @if ($errors->has('email'))
                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                                {{ $errors->first('email') }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="form-group mt-3">
                        <label for="phone" class="form-label mx-2">Phone<span class="text-danger">*</span></label>
                        <input type="number" class="form-control rounded-pill" id="phone" name="phone" type="text"
                            placeholder="Enter Phone Number" maxlength="10" value="{{old('phone')}}" required>
                        @if ($errors->has('phone'))
                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                                {{ $errors->first('phone') }}</div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group mt-3">
                        <label for="reason" class="form-label mx-2">Date Of Consultation<span
                                class="text-danger">*</span></label>
                        <input name="date" class="form-control rounded-pill" value="{{old('date')}}" type="date" id="myDate"
                            onfocus="disablePastDates()" required>
                        @if ($errors->has('date'))
                            <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                                {{ $errors->first('date') }}</div>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <label class="mt-3 form-label mx-2">Select A Time Slot<span class="text-danger">*</span></label>
                <div class="row row-cols-auto radiogroup" id="slotContainer">

                    @foreach ($list as $l)
                        <div class="col p-2 mx-2 mb-2 border form-group bg-white rounded-pill">
                            <input class="form-check-input" type="radio" name="slot" value="{{ $l }}"
                                id="{{ $l }}">
                            <label class="form-check-label pt-1" for="{{ $l }}">
                                {{ $l }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @if ($errors->has('slot'))
                    <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                        {{ $errors->first('slot') }}</div>
                @endif
            </div>
            <div class="col-lg-12">
                <div class="form-group mt-3">
                    <label for="description" class="form-label ms-2">Description<span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="4" class="form-control rounded-4"
                        placeholder="Enter Description..." required>{{ old('description') }}</textarea>
                    @if ($errors->has('description'))
                        <div class=" text-danger" style="padding-left: 10px; font-size:16px;">
                            {{ $errors->first('description') }}</div>
                    @endif
                </div>
            </div>
            <div class="text-center mt-4">
                <button type="submit" name="submit" class="btn btn-dark  rounded-pill">Book Appointment<i
                        class="bi bi-arrow-right-short align-middle fs-16 ms-1"></i></button>
            </div>
        </form>
        {{-- Error field add by Saurav --}}
    </section>
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                title: "Good job!",
                text: "{{ session('success') }}",
                confirmButtonText: "OK"
            });
        </script>
    @endif
    <script type="text/javascript">
        function disablePastDates() {
            var today = new Date();
            var dd = String(today.getDate()).padStart(2, '0');
            var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
            var yyyy = today.getFullYear();

            // today = yyyy + '-' + mm + '-' + dd;
            today = dd + '-' + mm + '-' + yyyy;
            document.getElementById("myDate").setAttribute("min", today);
        }

        document.querySelector('.radiogroup').addEventListener('change', (evt) => {
            evt.currentTarget
                .querySelectorAll('.border-primary')
                .forEach(element => {
                    element.classList.remove('border-primary')
                })
            evt.target
                .closest('.col')
                .classList.add('border-primary');
        }, true);
        $(document).ready(function() {
            $('#myDate').change(function() {
                var selectedDate = $(this).val();

                $.ajax({
                    url: '{{ route('available_slots') }}',
                    type: 'GET',
                    data: {
                        date: selectedDate
                    },
                    success: function(response) {
                        var slotContainer = $('#slotContainer');
                        slotContainer.empty(); // Clear existing slots

                        response.forEach(function(slot) {
                            slotContainer.append(
                                '<div class="col p-2 mx-2 mb-2 border form-group bg-white rounded-pill">' +
                                '<input class="form-check-input" type="radio" name="slot" value="' +
                                slot + '" id="' + slot + '">' +
                                '<label class="form-check-label pt-1" for="' +
                                slot + '">' +
                                slot +
                                '</label>' +
                                '</div>'
                            );
                        });
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });
        });
    </script>
