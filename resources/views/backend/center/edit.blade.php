@extends('backend.layouts.master')
@section('title', 'Dr Awish || Brand Edit')
@section('main-content')

    <div class="card">
        <h5 class="card-header">Edit Center</h5>
        <div class="card-body">
            <form method="post" action="{{ route('centers.update', $center->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Center Name <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="center_name" placeholder="Enter Center Name"
                        value="{{ $center->center_name }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>

@endsection
