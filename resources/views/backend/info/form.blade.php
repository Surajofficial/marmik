@extends('backend.layouts.master')

@section('title', 'Dr Awish || Certified Create')

@section('main-content')

    <div class="card">
        <h5 class="card-header">Add Information</h5>
        <div class="card-body">
            <form method="post" action="{{ isset($info) ? route('information.update', $info->id) : route('information.store') }}">
                @csrf
                @if (isset($info))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="info" class="col-form-label">Information Text <span class="text-danger">*</span></label>
                    <input id="info" type="text" name="info" placeholder="Enter Information Text"
                        value="{{ old('info', isset($info) ? $info->info : '') }}" class="form-control">
                    @error('info')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">{{ isset($info) ? 'Update' : 'Submit' }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush
