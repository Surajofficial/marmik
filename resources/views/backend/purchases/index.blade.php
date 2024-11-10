@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Purchase Lists</h6>
      <a href="{{route('purchases.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Purchase</a>    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($purchases)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
        <thead>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Purchase Cost</th>
                                    <th>Quantity</th>
                                    <th>Expire Date</th>                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Medicine Name</th>
                                    <th>Category</th>
                                    <th>Supplier</th>
                                    <th>Purchase Cost</th>
                                    <th>Quantity</th>
                                    <th>Expire Date</th>                                </tr>
</tfoot>
         
          <tbody>

          @foreach ($purchases as $purchase)
              @php
                             
                                $category=DB::table('categories')->where('id',$purchase->category_id)->get();
                                $supplier=DB::table('suppliers')->where('id',$purchase->supplier_id)->get();
                                $products=DB::table('products')->where('id',$purchase->product)->get();
                           //    dd($purchase->supplier_id);
             
              @endphp
              <tr>
                                    <td>
                                        <span class="table-avatar">
                                            @if(!empty($purchase->image))
                                            <span class="avatar avatar-sm mr-2">
                                                <img class="avatar-img" src="{{asset('storage/purchases/'.$purchase->image)}}" alt="product image">
                                            </span>
                                            @endif
                                            {{$products[0]->title}}
</span>
                                    </td>
                                    @if(!empty($purchase->category_id))
                                    <td> {{$category[0]->title}}</td>
                                    @else
                                    <td></td>
                                    
                                    
                                    @endif
                                 
                                    
                                    @if($purchase->supplier_id != null)
                                    <td>  {{$supplier[0]->name}}</td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{{$purchase->price}}</td>
                                    <td>{{$purchase->quantity}}</td>
                                  
                                    <td>{{date_format(date_create($purchase->expiry_date),"d M, Y")}}</td>
                                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Purchases found!!! Please Add Purchase</h6>
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
                    "targets":[3,4,5]
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
