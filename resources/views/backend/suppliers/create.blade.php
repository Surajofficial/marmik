@extends('backend.layouts.master')
@section('title','Dr Awish || Supplier Create')
@section('main-content')
<div class="row">
	<div class="col-sm-12">
		<div class="card">
			<div class="card-body custom-edit-service">
				
		
			<!-- Add Supplier -->
			<form method="post" enctype="multipart/form-data" action="{{route('suppliers.store')}}">
				@csrf
			
				<fieldset>
  <legend>Personal Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					<div class="col-lg-3">
							<label>Company Name<span class="text-danger">*</span></label>
							<select name="company" id="company" class="form-control">
      <option value="">--Select any Brand--</option>
      @foreach($brand as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
  </select>
						</div>
						<div class="col-lg-3">
							<div class="form-group">
								<label>Name<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="name">
								
							</div>
							
						</div>
						<div class="col-lg-3">
							<label>Email<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="email" id="email">
						</div>
						<div class="col-lg-3">
							<label>Phone<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="phone" id="phone">
						</div>
						<div class="col-lg-4">
						<div class="form-group">
								<label>Address <span class="text-danger">*</span></label>
							
								<textarea name="address" class="form-control" cols="10" rows="2"></textarea>
							</div>
							
						</div>
						<div class="col-lg-2">
							<label>City</label>
							<input class="form-control" type="text" name="city" id="city">
						</div>
						<div class="col-lg-2">
							<label>State</label>
							<select name="state" id="state" class="form-control">
							<option value="">--Select any state--</option>
	  <option value="up">Uttar Pradesh</option>
	  <option value="delhi">Delhi</option>
	  <option value="mp">MP</option>
	  <option value="haryana">Haryana</option>
	  <option value="gurgram">Gurgram</option>
  </select>
						</div>
						<div class="col-lg-2">
							<label>Pincode</label>
							<input class="form-control" type="text" name="pin" id="pin">
						</div>
					</div>
				</div>
				


			
  <legend>Bank Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					
						<div class="col-lg-4">
							<div class="form-group">
								<label>Bank Name</label>
								<input class="form-control" type="bname" name="bname">
								
							</div>
							
						</div>
						<div class="col-lg-4">
							<label>Bank A/C No.</label>
							<input class="form-control" type="text" name="bnumber" id="bnumber">
						</div>
						<div class="col-lg-4">
							<label>IFSC Code<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="bcode" id="bcode">
						</div>
						
						
					</div>
				</div>
			


  <legend>Tax Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					
						<div class="col-lg-4">
							<div class="form-group">
								<label>Pan  No.<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="pno">
								
							</div>
							
						</div>
						<div class="col-lg-4">
							<label>GSTIN<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="gst" id="gst">
						</div>
						<div class="col-lg-4">
							<label>State<span class="text-danger">*</span></label>
							<select name="state" id="state" class="form-control">
      <option value="">--Select any Brand--</option>
      @foreach($brand as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
      @endforeach
  </select>
						</div>
						
						
					</div>
				</div>


  <legend>Tax Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					
						<div class="col-lg-4">
							<div class="form-group">
								<label>Openinng Balance (₹)<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="opening">
								
							</div>
							
						</div>
						<div class="col-lg-4">
							<label>Type<span class="text-danger">*</span></label>
							<div><input type="radio" name="type" id="type"> Debit &nbsp;
							<input type="radio" name="type" id="type"> Credit</div>
						</div>
						
						
						
					</div>
				</div>


  <legend>Contact Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					
						<div class="col-lg-6">
							<div class="form-group">
								<label>Contact Person<span class="text-danger">*</span></label>
								<input class="form-control" type="text" name="contactp">
								
							</div>
							
						</div>
						<div class="col-lg-6">
							<label>Contact No.<span class="text-danger">*</span></label>
							<input class="form-control" type="text" name="contactn" id="contactn">
						</div>
						
					</div>
				</div>


  <legend>Other Details:</legend>
				<div class="service-fields mb-3">
					<div class="row">
					<div class="col-lg-6">
						<div class="form-group">
								<label>Remark / Note <span class="text-danger">*</span></label>
							
								<textarea name="odetail" class="form-control" cols="10" rows="10"></textarea>
							</div>
							
						</div>
					
</div>
						
						
					</div>
			
				<div class="submit-section">
					<button class="btn btn-primary submit-btn" type="submit" name="form_submit" value="submit">Submit</button>
				</div>
			</form>
			<!-- /Add Medicine -->


			</div>
		</div>
	</div>			
</div>
@endsection	

@push('page-js')
	<!-- Datetimepicker JS -->
	<script src="{{asset('assets/js/moment.min.js')}}"></script>
	<script src="{{asset('assets/js/bootstrap-datetimepicker.min.js')}}"></script>	
@endpush

