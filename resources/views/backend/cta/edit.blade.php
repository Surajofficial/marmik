@extends('backend.layouts.master')
@section('title','E-SHOP || CTA Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit CTA</h5>
    <div class="card-body">
      <form method="post" action="{{route('cta.update',$ctas->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$ctas->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$ctas->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
        <div class="input-group">
            <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                <i class="fa fa-picture-o"></i> Choose
                </a>
            </span>
          <input id="thumbnail" class="form-control" type="text" name="image" value="{{$ctas->image}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('image')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Url <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="url" placeholder="Enter url"  value="{{$ctas->url}}" class="form-control">
        @error('url')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        <div class="form-group">
          <label for="condition">Start Date</label>
        <input type="date" name="sdate" value="{{$ctas->sdate}}" class="form-control"/>
        
        </div>

        <div class="form-group">
          <label for="condition">End Date</label>
        <input type="date" name="enddate" value="{{$ctas->enddate}}" class="form-control"/>
        
        </div>
        
       
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
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