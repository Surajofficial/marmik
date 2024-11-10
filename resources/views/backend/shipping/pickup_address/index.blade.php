@extends('backend.layouts.master')

@section('main-content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
            <div class="card-header py-3 col-md-12">
                <h6 class="m-0 font-weight-bold text-primary float-left">PickUp Address List</h6>
                <a href="{{ route('pickup_create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                    data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add PickUp Address</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    @if (count(@$pickup) > 0)
                        <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Pickup Location</th>
                                    <th>name</th>
                                    <th>email</th>
                                    <th>phone</th>
                                    <th>address</th>
                                    <th>city</th>
                                    <th>state</th>
                                    <th>country</th>
                                    <th>pin_code</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($pickup as $key => $pickLoc)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$pickLoc->pickup_location_nickname}}</td>
                                        <td>{{$pickLoc->shiper_name}}</td>
                                        <td>{{$pickLoc->email}}</td>
                                        <td>{{$pickLoc->phone}}</td>
                                        <td>{{$pickLoc->address.' '.$pickLoc->address_2}}</td>
                                        <td>{{$pickLoc->city}}</td>
                                        <td>{{$pickLoc->state}}</td>
                                        <td>{{$pickLoc->country}}</td>
                                        <td>{{$pickLoc->pin_code}}</td>
                                        {{-- <td>
                                            <a href="{{ route('pickup_edit', $pickLoc->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                            <form method="POST" action="{{ route('stocks.destroy', [$stock->id]) }}">
                                                @csrf
                                                @method('delete')
                                                <button class="btn btn-danger btn-sm dltBtn" data-id={{ $pickLoc->id }}
                                                    style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                    data-placement="bottom" title="Delete"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{-- <span style="float:right" id="pagination">{{ $products->links() }}</span> --}}
                    @else
                        <h6 class="text-center">No Products found!!! Please create Product</h6>
                    @endif
                </div>
            </div>
        </div>
    @endsection

    @push('styles')
        <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
        <style>
            .zoom {
                transition: transform .2s;
            }

            .zoom:hover {
                transform: scale(5);
            }
        </style>
    @endpush

    @push('scripts')
        <!-- Page level plugins -->
        <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
        <script>
            $('#product-dataTable').DataTable({
                "columnDefs": [{
                    "orderable": true,
                    "targets": [1]
                }]
            });


            // Sweet alert

            function deleteData(id) {

            }
        </script>
        <script>
            $("#filter").change(function() {
                if (this.value == "all") {
                    location.href = "/admin/product";
                } else {
                    location.href = "/admin/product?filter=" + this.value;
                }

            });
        </script>
        <script>
            $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('.dltBtn').click(function(e) {
                    var form = $(this).closest('form');
                    var dataID = $(this).data('id');
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
