@extends('backend.layouts.master')

@section('title','Review Edit')

@section('main-content')

<style>
.form-group {
    margin-bottom: 15px;
}

#rating {
    font-size: 18px; /* Adjust font size for better visibility */
}

#rating option {
    font-size: 20px; /* Increase font size for options */
}

</style>
<div class="card">
  <h5 class="card-header">Review Edit</h5>
  <div class="card-body">
  <form action="{{ route('review.update', $review->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PATCH')

    <div class="form-group">
        <label for="name">Review By:</label>
        <input type="text" disabled class="form-control" value="{{ $review->user_info->name }}">
    </div>
    <div class="form-group">
    <label for="name">Rating:</label>
    

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
        <textarea name="review" id="" cols="20" rows="10" class="form-control">{{ $review->review }}</textarea>
    </div>

    <div class="form-group">
        <label for="status">Status:</label>
        <select name="status" id="" class="form-control">
            <option value="">--Select Status--</option>
            <option value="active" {{ $review->status == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ $review->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
    </div>

    <!-- Display Existing Images -->
    <div class="image-gallery d-flex flex-wrap mb-3">
        @php
            $images = !empty($review->image) ? explode(',', $review->image) : [];
        @endphp

        @foreach ($images as $index => $image)
            <div class="image-item position-relative me-2 mb-2">
                <input type="checkbox" name="delete_images[]" value="{{ $image }}" class="position-absolute top-0 start-0 ms-2 mt-2" style="z-index: 10;">
                <img src="{{ asset($image) }}" alt="Product Photo" class="img-thumbnail" width="100">
            </div>
        @endforeach
    </div>

    <!-- Upload New Images -->
    <div class="mb-3">
        <label for="productPhotos" class="form-label">Upload New Images</label>
        <input type="file" name="productPhotos[]" id="productPhotos" class="form-control" multiple>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
</form>

  </div>
</div>
@endsection

@push('styles')
<style>
    .order-info,.shipping-info{
        background:#ECECEC;
        padding:20px;
    }
    .order-info h4,.shipping-info h4{
        text-decoration: underline;
    }
</style>
@endpush