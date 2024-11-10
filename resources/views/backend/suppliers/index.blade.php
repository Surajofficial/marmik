<link rel="shortcut icon" href="https://themesbrand.com/toner/html/assets/images/favicon.ico">

<!-- Sweet Alert css-->
<link href="../backend/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css">

<!-- Layout config Js -->
<script src="../backend/assets/js/layout.js"></script>
<!-- Bootstrap Css -->
<link href="../backend/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<!-- Icons Css -->
<link href="../backend/css/icons.min.css" rel="stylesheet" type="text/css">
<!-- App Css-->
<link href="../assets/css/app.min.css" rel="stylesheet" type="text/css">
<!-- custom Css-->
<link href="../assets/css/custom.min.css" rel="stylesheet" type="text/css">

@extends('backend.layouts.master')
@section('title','Dr Awish || Supplier List')
@section('main-content')

 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Supplier List</h6>
      <a href="{{route('suppliers.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Suppliier</a>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($suppliers)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
		  <tr>
								<th>No.</th>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Address</th>
								<th class="action-btn">Action</th>
							</tr>
          </thead>
          <tfoot>
      
          </tfoot>
          <tbody>
		  @foreach ($suppliers as $supplier)
                <tr>
				<td>										
									{{$supplier->id}}
								</td>
								<td>{{$supplier->name}}</td>
								<td>{{$supplier->phone}}</td>
								<td>{{$supplier->email}}</td>
								<td>{{$supplier->address}}</td>
								<td>
									<div class="actions">
										
										<a href="{{route('suppliers.edit',$supplier->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <form method="POST" action="{{route('suppliers.destroy',[$supplier->id])}}">
                          @csrf 
                          @method('delete')
                              <button class="btn btn-danger btn-sm dltBtn" data-id="{{$supplier->id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
									
									</div>
								</td>
                 
                   
                </tr>  
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Supplier found!!! Please create Supplier</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
      div.dataTables_wrapper div.dataTables_paginate{
          display: none;
      }
      .zoom {
        transition: transform .2s; /* Animation */
      }

      .zoom:hover {
        transform: scale(3.2);
      }
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      
      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[3,4]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){
            
        }
  </script>
  <script>
      $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush


