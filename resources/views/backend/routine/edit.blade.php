@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit returns</h5>
    <div class="card-body">
      <form method="post" action="{{route('returns.update',$returns->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="age">Age </label><br>
          <input type="checkbox" name='age' id='is_featured' value='1' > Yes                  
          <input type="checkbox" name='age' id='is_featured' value='2' > Yes                        
          <input type="checkbox" name='age' id='is_featured' value='3' > Yes                        
          <input type="checkbox" name='age' id='is_featured' value='4' > Yes                        
        </div>
        <div class="form-group">
  <label for="concern_id">Skin Type <span class="text-danger">*</span></label>
  <select name="concern_id" id="concern_id" class="form-control" required="true">
      <option value="">--Select any Concern--</option>
  </select>
</div>
      
        {{-- {{$concern}} --}}

        <div class="form-group">
          <label for="size">Primary Concern</label>
          <select required="true" name="size" class="form-control"  data-live-search="true">
              <option value="" disabled="disabled">--Select any Quantity--</option>
            
              <option  value=""></option>
         
          </select>
        </div>
        <div class="form-group">
          <label for="size">Secondary Concern</label>
          <select required="true" name="size" class="form-control"  data-live-search="true">
              <option value="" disabled="disabled">--Select any Quantity--</option>
              <option  value=""></option>
          </select>
        </div>
        <div class="form-group">
          <label for="age">Sensitive </label><br>
          <input type="radio" name='age' id='is_featured' value='1' > Yes                  
          <input type="radio" name='age' id='is_featured' value='2' > No                                                
        </div>
        <div class="form-group">
          <label for="age">Pregnant or breastfeeding </label><br>
          <input type="radio" name='age' id='is_featured' value='1' > Yes                  
          <input type="radio" name='age' id='is_featured' value='2' > No                            


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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />

@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

    $(document).ready(function() {
      $('#quote').summernote({
        placeholder: "Write short Quote.....",
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
</script>
@endpush