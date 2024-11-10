@extends('backend.layouts.master')
@section('title', 'Dr Awish || Center Create')
@section('main-content')
    <div class="card">
        <h5 class="card-header">Add Center</h5>
        <div class="card-body">
            <form method="post" action="{{ route('centers.store') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Center Name <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="center_name" placeholder="Enter Center Name"
                        value="{{ old('center_name') }}" class="form-control">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
