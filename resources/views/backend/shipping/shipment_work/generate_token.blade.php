@extends('backend.layouts.master')

@section('main-content')
    <div class="card ">
        <h5 class="card-header">Generate Token Form <a href="{{URL::to('admin/add_user')}}" class="btn btn-primary float-right" style="width:8%">Add User</a></h5>
        
        <div class="card-body" style="min-height:70vh !important;">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    <form id="" action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="email">Email</label>
                                <input type="email" placeholder="Enter Email Here..." name="email" class="form-control">
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="pass">Password</label>
                                <input type="password" placeholder="Enter Password Here..." name="pass" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success mt-2">Generate Token</button>
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
