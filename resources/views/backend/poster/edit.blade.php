@extends('backend.layouts.master')
@section('title','Dr Awish || Poster Edit')
@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Banner</h5>
    <div class="card-body">
      <form method="post" action="{{route('poster.update',$banner->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$banner->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputDesc" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description">{{$banner->description}}</textarea>
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
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$banner->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        

        <div class="form-group">
  <label for="position">Position <span class="text-danger">*</span></label>
  <select name="position" id="position" class="form-control">
      <option value="" disabled="true">--Select any Position--</option>

      <option  value='1' {{(($banner->position=='1')? 'selected' : '')}}>1</option>
          <option value='2' {{(($banner->position=='2')? 'selected' : '')}}>2</option>
          <option value='3' {{(($banner->position=='3')? 'selected' : '')}}>3</option>
          <option  value='4' {{(($banner->position=='4')? 'selected' : '')}}>4</option>
          <option value='5' {{(($banner->position=='5')? 'selected' : '')}}>5</option>
          <option value='6' {{(($banner->position=='6')? 'selected' : '')}}>6</option>

  </select>
</div>
<div class="form-group">
  <label for="page">Responsible Page <span class="text-danger">*</span></label>
  <select name="page" id="page" class="form-control">
      <option value="" disabled="true">--Select any page--</option>
      <option value="{{$banner->page}}" selected="true">{{$banner->page}}</option>

          <option  value='home' {{(($banner->page=='home')? 'selected' : '')}}>Home</option>
          <option value='about' {{(($banner->page=='about')? 'selected' : '')}}>About</option>
          <option value='contact' {{(($banner->page=='contact')? 'selected' : '')}}>Contact</option>

  </select>
</div>
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
            <option value="active" {{(($banner->status=='active') ? 'selected' : '')}}>Active</option>
            <option value="inactive" {{(($banner->status=='inactive') ? 'selected' : '')}}>Inactive</option>
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
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