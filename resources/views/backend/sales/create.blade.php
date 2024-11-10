@extends('backend.layouts.master')

@section('title','Sales')

@section('main-content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
                <!-- Create Sale -->
                <form method="POST" action="{{route('sales.store')}}">
					@csrf
					<div class="row form-row">
						<div class="col-12">
							<div class="form-group">
								<label>Product <span class="text-danger">*</span></label>
								
								<select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any Product--</option>
              @foreach($products as $key=>$cat_data)
                  <option value='{{$cat_data->id}}'>{{$cat_data->name}}</option>
              @endforeach
          </select>
							</div>
						</div>
						<div class="col-12">
							<div class="form-group">
								<label>Quantity</label>
								<input type="number" value="1" class="form-control" name="quantity">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary btn-block">Save Changes</button>
				</form>
                <!--/ Create Sale -->
			</div>
		</div>
	</div>			
</div>
@endsection	
