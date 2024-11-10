@extends('backend.layouts.master')
@section('title','Dr Awish || Quantity Page')
@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Quanity List</h6>
      <a href="{{route('strep.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Quantity</a>
    </div>
    <div class="card-body">
    <div class="table-responsive">
    @if(count($streps) > 0)
    <table class="table table-bordered table-striped table-hover" id="banner-dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
            <tr>
                <th>S.N.</th>
                <th>Quantity</th>
                <th>Slug</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
      
        <tbody>
            @foreach($streps as $strep)   
            <tr>
                <td>{{$loop->iteration}}</td> <!-- Using loop variable for proper numbering -->
                <td>{{$strep->title}}</td>
                <td>{{$strep->slug}}</td>
                <td>
                    @if($strep->status == 'active')
                    <span class="badge badge-success">{{$strep->status}}</span>
                    @else
                    <span class="badge badge-warning">{{$strep->status}}</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('strep.edit', $strep->id)}}" class="btn btn-primary btn-sm" style="height:30px; width:30px; border-radius:50%; margin-right: 5px;" data-toggle="tooltip" title="Edit" data-placement="bottom">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form method="POST" action="{{route('strep.destroy', [$strep->id])}}" style="display:inline-block;">
                        @csrf 
                        @method('delete')
                        <button class="btn btn-danger btn-sm dltBtn" data-id="{{$strep->id}}" style="height:30px; width:30px; border-radius:50%;" data-toggle="tooltip" data-placement="bottom" title="Delete">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>  
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Showing {{ $streps->firstItem() }} to {{ $streps->lastItem() }} of {{ $streps->total() }} entries
        </div>
        <div>
            {{$streps->links('pagination::bootstrap-4')}}
        </div>
    </div>
    @else
    <h6 class="text-center">No Strep found!!! Please create Strep</h6>
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