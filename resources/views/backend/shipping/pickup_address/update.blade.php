@extends('backend.layouts.master')

@section('main-content')
    <div class="card ">
        <h5 class="card-header">Update Pickup Location Form</h5>
        <div class="card-body">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    <form id="pickup-form" action="{{route('pickup_update',$data->id)}}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="nickname">PickUp Location Nickname <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nickname" value="{{old('nickname',$data->pickup_location_nickname)}}">
                                    @error('nickname')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="shiperName">Shiper Name<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="shiperName" value="{{old('shiperName',$data->shiper_name)}}">
                                    @error('shiperName')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" value="{{old('email',$data->email)}}">
                                    @error('email')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="phone">Phone<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="phone" value="{{old('phone',$data->phone)}}">
                                    @error('phone')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">Address <span class="text-danger">*</span></label>
                                    <textarea name="address" class="form-control" id="" cols="30" rows="5">{{old('address',$data->address)}}</textarea>
                                    @error('address')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="address">Address 2 </label>
                                    <textarea name="address2" class="form-control" id="" cols="30" rows="5">{{old('address2',$data->address_2)}}</textarea>
                                    @error('address2')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="city">City <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="city" value="{{old('city',$data->city)}}">
                                    @error('city')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="state">State<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="state" value="{{old('state',$data->state)}}">
                                    @error('state')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="country">Country <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="country" value="{{old('country',$data->country)}}">
                                    @error('country')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="pincode">Pin Code<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="pincode" value="{{old('pincode',$data->pin_code)}}">
                                    @error('pincode')<div class="text-danger">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success">Submit</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>



@endpush
