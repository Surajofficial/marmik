@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Edit Admin</h5>
    <div class="card-body">
        <form method="post" action="{{ route('admin.update') }}">
            @csrf
            <div class="form-group">
                <label for="center_id">Select Center</label>
                <select name="center_id" id="center_id" class="form-control">
                    <option value="">Select Center</option>
                    @foreach($centers as $center)
                        <option value="{{ $center->id }}" {{ $admin->center_id == $center->id ? 'selected' : '' }}>
                            {{ $center->center_name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-3">
                <button class="btn btn-success" type="submit">Update</button>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- @push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');
        $('#lfm1').filemanager('image');
        $('#lfm2').filemanager('image');
        $(document).ready(function () {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        $(document).ready(function () {
            $('#quote').summernote({
                placeholder: "Write short Quote.....",
                tabsize: 2,
                height: 100
            });
        });
        $(document).ready(function () {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
    </script>
@endpush -->