@extends('backend.layouts.master')
@section('title','Dr Awish || All Notifications')
@section('main-content')
<div class="card">
    <div class="row">
        <div class="col-md-12">
           @include('backend.layouts.notification')
        </div>
    </div>
  <h5 class="card-header">Notifications</h5>
  <div class="card-body">
    @php
        $notificationsData = Helper::getOrderNotifications();
    @endphp

    @if($notificationsData > 0)
    <table class="table table-hover admin-table" id="notification-dataTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Order ID</th>
                <th scope="col">Messages</th>
                <th scope="col">Time</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
                $notificationsToShow = $notificationsData['notifications'];
            @endphp
            @foreach ($notificationsToShow as $notification)
            <tr class="@if (is_null($notification->read_at)) table-warning @else table @endif">
                <td scope="row">{{$loop->index + 1}}</td>
                <td>{{$notification->order_id}}</td>
                <td>{{$notification->message}}</td>
                <td>{{$notification->created_at->format('F d, Y h:i A')}}</td>
                <td>
                    <a href="{{ route('order.show', $notification['order_id']) }}" id="notify" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:33px;border-radius:50%" data-toggle="tooltip" title="View" data-placement="bottom"><i class="fas fa-eye"></i></a>

                    {{-- <form method="POST" action="{{ route('admin.notification.OrdDelete', $notification->order_id) }}">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger btn-sm dltBtn" data-id="{{$notification->order_id}}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                    </form> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <h2>Notifications Empty!</h2>
    @endif

    
  </div>
</div>
@endsection
@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@endpush
@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#notification-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                    "targets":[4]
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
        // $('.dltBtn').click(function(e){
        //   var form=$(this).closest('form');
        //     var dataID=$(this).data('id');
        //     // alert(dataID);
        //     e.preventDefault();
        //     swal({
        //           title: "Are you sure?",
        //           text: "Once deleted, you will not be able to recover this data!",
        //           icon: "warning",
        //           buttons: true,
        //           dangerMode: true,
        //       })
        //       .then((willDelete) => {
        //           if (willDelete) {
        //             form.submit();
        //           } else {
        //               swal("Your data is safe!");
        //           }
        //       });
        // });
    });

  </script>
@endpush