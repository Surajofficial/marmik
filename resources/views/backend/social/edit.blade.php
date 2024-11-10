@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Update Social</h5>
    <div class="card-body">
    <form method="post" action="{{route('social.update',$social->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        
        <div class="form-group">
          <label for="social" class="col-form-label">Iframe</label>
        <select class="form-control" id="social" name="social">
          <option disabled>---select option----</option>
          <option name="facebook">Facebook</option>
          <option name="instagram">Instagram</option>
          <option name="youtube">Youtube</option>

        </select>
          @error('smedia')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="iframe" class="col-form-label">Title</label>
          <textarea   class="form-control" id="iframe"  name="iframe">{{$social->iframe}}</textarea>
          @error('iframe')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea  value="{{$social->description}}" class="form-control" id="description" name="description">{{$social->description}}</textarea>
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
         <div class="form-group">
          <label for="slink" class="col-form-label">Social Link <span class="text-danger">*</span></label>
          <input value="{{$social->slink}}" id="slink" type="text" name="slink" placeholder="Enter Social Media Link"  class="form-control">
          @error('slink')
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
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$social->photo}}">
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('photo')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <sub style="color:red;"></sub>
            <div class="form-group">
          <label  class="col-form-label">Video <span class="text-danger">*</span></label>
          <div class="input-group">
              
          <input  class="form-control btn" type="file" value="{{$social->video}}" name="video" >
        </div>
        <div id="holder" style="margin-top:15px;max-height:100px;"></div>
          @error('video')
          <span class="text-danger">{{$message}}</span>
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

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
<script>
  $('#concern_id').change(function(){
    var concern_id=$(this).val();
  //   alert(concern_id);
    if(concern_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/concern/"+concern_id+"/child",
        data:{
          _token:"{{csrf_token()}}",
          id:concern_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub concern----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_concern_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_concern_div').addClass('d-none');
          }
          $('#child_concern_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
@endpush