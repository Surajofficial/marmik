@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Review</h5>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card-body">
        <form method="post" action="{{route('add.review.backend.post')}}"  enctype="multipart/form-data">
            {{csrf_field()}}

            <div class="form-group">
                <label for="user">Select User:</label>
                <select name="user_id" id="user" class="form-control">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">
                            {{ $user->name }} - {{ $user->email }} ({{ $user->mobile }})
                        </option>
                    @endforeach
                </select>
            </div>
          

            <div class="form-group">
                <label for="user">Select Product:</label>
                <select name="product_id" id="product" class="form-control">
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">
                            {{ $product->title }} - {{ $product->slug }} 
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="rating">Rating:</label>
                <select name="rate" id="rate" class="form-control">
                    <option value="0">Select Rating</option>
                    <option value="1">&#9733; (1 Star)</option>
                    <option value="2">&#9733;&#9733; (2 Stars)</option>
                    <option value="3">&#9733;&#9733;&#9733; (3 Stars)</option>
                    <option value="4">&#9733;&#9733;&#9733;&#9733; (4 Stars)</option>
                    <option value="5">&#9733;&#9733;&#9733;&#9733;&#9733; (5 Stars)</option>
                </select>
            </div>





            <div class="form-group">
                <label for="review">Review</label>
                <textarea name="review" id="" cols="20" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
                    <label for="productPhotos" class="custom-file-label">
                        <i class="ph-file fs-24"></i> Upload Product Photos
                    </label>
                    <input type="file" name="productPhotos[]" id="productPhotos" multiple class="" accept="image/*" capture>
                 
                </div>


            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button class="btn btn-success" type="submit">Submit</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
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