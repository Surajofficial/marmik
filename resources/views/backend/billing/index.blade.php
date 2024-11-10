@extends('backend.layouts.master')
@section('title', 'Dr Awish || Supplier List')
@section('main-content')

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('backend.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary float-left">Biling List</h6>
        <a href="{{ route('billing.create') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
            data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Invoice</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">

            @if (count($billing) > 0)
                    <table class="table fs-15 align-middle table-nowrap">
                        <thead>
                            <tr>
                                <th scope="col">Billing ID</th>
                                <th scope="col">Gst Type</th>
                                <th scope="col">Bill Date</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">product</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Billing Name</th>
                                <th scope="col">Billing Address</th>
                                <th scope="col">Tax</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col">Payment Method</th>
                                <th scope="col">Billing Created</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($billing as $billings)
                                            @php
                                                $product = explode(',', $billing[9]->product);
                                                //dd($product);
                                                $nproduct = DB::table('products')->whereIn('id', $product)->get();
                                                $title = [];
                                                for ($i = 0; $i < count($nproduct); $i++) {
                                                    $title[$i] = $nproduct[$i]->title;
                                                }
                                                $ntitile = implode(',', $title);
                                            @endphp

                                            <tr>
                                                <td>
                                                    <a href="#" class="text-body">{{ $billings->id }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->gtype }}</a>
                                                </td>
                                                <td>
                                                    <a href="#"
                                                        class="text-body">{{ \Carbon\Carbon::parse($billings->bdate)->format('d/m/Y') }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->pstatus }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body">{{ $ntitile }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->qty }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->billingName }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->billingAddress }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body">{{ $billings->alltax }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->subtotal }}</a>
                                                </td>
                                                <td>
                                                    <a href="#" class="text-body"> {{ $billings->pmethod }}</a>
                                                </td>

                                                <td><span class="text-muted">{{ $billings->created_at }}</span></td>


                                                <td>
                                                    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#invoiceModal_{{ $billings->id }}">Bill</button> -->
                                                    <a href="{{ route('billing.show', $billings->id) }}"
                                                        class="btn btn-warning btn-sm float-left mr-1"
                                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view"
                                                        data-placement="bottom"><i class="fas fa-eye"></i></a>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            @else
                <h6 class="text-center mt-5">No Invoice found!!! </h6>
            @endif
        </div>
    </div>
</div>


@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }
    </style>
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#banner-dataTable').DataTable({
            "columnDefs": [{
                "billingsable": false,
                "targets": [3, 4]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }
    </script>
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function (e) {
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