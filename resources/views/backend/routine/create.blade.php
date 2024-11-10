@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Add Routine</h5>
    <div class="card-body">
      <form method="post" action="{{route('routine.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
          <label for="age">Age </label><br>
          <input type="checkbox" name='age[]' id='is_featured' value='1' > 12 to 18      <br/>            
          <input type="checkbox" name='age[]' id='is_featured' value='2' > 19 to 30    <br/>                  
          <input type="checkbox" name='age[]' id='is_featured' value='3' > 31 to 40   <br/>                 
          <input type="checkbox" name='age[]' id='is_featured' value='4' > 40 Above                       
        </div>
        <div class="form-group">
  <label for="concern_id">Skin Type <span class="text-danger">*</span></label><br/>
  <select name="skin[]" class="selectpicker form-control" multiple aria-label="Default select example" data-live-search="true">      <option value="">--Select any skin type--</option>
      <option value="oily">Oily</option>
      <option value="normal">Normal</option>
      <option value="skin">Skin</option>
  </select>
</div>
        <div class="form-group">
          <label for="size">Primary Concern</label><br/>
          <select name="pconcern_id[]" class="selectpicker form-control" multiple aria-label="Default select example" data-live-search="true">
              <option value="" disabled="disabled">--Select any Quantity--</option>
              @foreach($concern as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="size">Secondary Concern</label><br/>
          <select name="sconcern_id[]" class="selectpicker form-control" multiple aria-label="Default select example" data-live-search="true">
              <option value="" disabled="disabled">--Select any Quantity--</option>
               @foreach($concern as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
          </select>
        </div>
        <div class="form-group">
          <label for="sensitive">Sensitive </label><br>
          <input type="radio" name='sensitive' id='sensitive' value='yes' > Yes                  
          <input type="radio" name='sensitive' id='sensitive' value='no' > No                                                
        </div>
        <div class="form-group">
          <label for="pb">Pregnant or breastfeeding </label><br>
          <input type="radio" name='pb' id='pb' value='yes' > Yes                  
          <input type="radio" name='pb' id='pb' value='no' > No                            


        </div>
        <div class="form-group">
          <label for="product">Product</label>
          <br/>
          <select name="pid[]" class="selectpicker form-control" multiple aria-label="Default select example" data-live-search="true">
          @foreach($product as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
  </select>
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