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
            <h6 class="m-0 font-weight-bold text-primary float-left">Review Lists</h6>

            <a href="{{ route('add.review.backend') }}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Review</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($reviews) > 0)
                    <div class="row mb-3 d-flex align-items-center justify-content-end">
                      <form id="searchBtn" class="col-8">
                        <div class="row justify-content-end">
                          <div class="col-md-6">
                            <input type="text" id="customSearch" class="form-control" placeholder="Search reviews...">
                          </div>
                          <div class="col-md-1 p-0">
                              <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                          </div>
                        </div>
                      </form>
                       
                    </div>

                    <table class="table table-bordered table-striped table-hover" id="order-dataTable" width="100%"
                        cellspacing="0">
                        <thead class="thead-dark">
                            <tr>
                                <th>S.N.</th>
                                <th>Review By</th>
                                <th>Product Title</th>
                                <th class="d-none d-md-table-cell">Review</th>
                                <th>Rate</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>S.N.</th>
                                <th>Review By</th>
                                <th>Product Title</th>
                                <th class="d-none d-md-table-cell">Review</th>
                                <th>Rate</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($reviews as $review)
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td class="text-truncate" style="max-width: 100px;">{{ $review->user_info['name'] ?? '' }}
                                    </td>
                                    <td class="text-truncate" style="max-width: 150px;">{{ $review->product->title }}</td>
                                    <td class="d-none d-md-table-cell">{{ $review->review }}</td>
                                    <td>
                                        <ul style="list-style:none; padding: 0; margin: 0;">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($review->rate >= $i)
                                                    <li style="display:inline; color:#F7941D;"><i class="fa fa-star"></i>
                                                    </li>
                                                @else
                                                    <li style="display:inline; color:#F7941D;"><i class="far fa-star"></i>
                                                    </li>
                                                @endif
                                            @endfor
                                        </ul>
                                    </td>
                                    <td>{{ $review->created_at->format('M d, Y g:i a') }}</td>
                                    <td>
                                        @if ($review->status == 'active')
                                            <span class="badge badge-success">{{ $review->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $review->status }}</span>
                                        @endif
                                    </td>
                                    <td style="width:70px !important;">
                                        <a href="{{ route('review.edit', $review->id) }}" class="btn btn-primary btn-sm"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="Edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('review.destroy', [$review->id]) }}"
                                            style="display:inline-block;">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $review->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <h6 class="text-center">No reviews found!!!</h6>
                @endif
            </div>
        </div>

    </div>
@endsection

@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    {{-- <style>
  div.dataTables_wrapper div.dataTables_paginate {
    display: none;
  }
</style> --}}
@endpush

@push('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>

        $(document).ready(function() {
            var review_table = $('#order-dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('review.search') }}",
                    type: 'GET',
                    data: function(d) {
                        d.customSearch = $('#customSearch').val() ?? ''
                    }
                },
                columns: [{
                        data: 'id'
                    },
                    {
                        data: function(data) {
                            return (data.user_info && data.user_info.name) ? data.user_info.name : '';
                        }
                    },
                    {
                        data: function(data) {
                            return data.product.title
                        }
                    },
                    {
                        data: 'review'
                    },
                    {
                        data: 'rate',
                        render: function(data) {
                            let stars = '';
                            for (let i = 1; i <= 5; i++) {
                                stars += (i <= data) ?
                                    '<i class="fa fa-star" style="color: #F7941D;"></i>' :
                                    '<i class="far fa-star" style="color: #F7941D;"></i>';
                            }
                            return stars;
                        }
                    },
                    {
                        data: 'created_at',
                        render: function(data) {
                            const date = new Date(data); 
                            const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
                            return date.toLocaleDateString('en-US', options); 
                        },
                    },
                    {
                        data: 'status',
                        render: function(data) {
                            return data === 'active' ? '<span class="badge badge-success">' + data +
                                '</span>' : '<span class="badge badge-warning">' + data + '</span>';
                        }
                    },
                    {
                        data: null,
                        render: function(data) {
                            return `
                        <a href="{{ url('admin/review/${data.id}/edit') }}" class="btn btn-primary btn-sm" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                        <button class="btn btn-danger btn-sm dltBtn" data-id="${data.id}" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="Delete" data-placement="bottom"><i class="fas fa-trash-alt"></i></button>
                    `;
                        }
                    }
                ],
                columnDefs: [{
                    orderable: false,
                    targets: [5, 6, 7]
                }],
                searching: false
            });

            // delete buttons
            $('#order-dataTable tbody').on('click', '.dltBtn', function(e) {
                e.preventDefault();
                var button = $(this);
                var dataID = button.data('id');

                swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this data!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            var form = $('<form>', {
                                method: 'POST',
                                action: `{{ url('admin/review') }}/${dataID}`
                            }).append('@csrf').append('@method('delete')');
                            form.appendTo('body').submit();
                        } else {
                            swal("Your data is safe!");
                        }
                    });
            });
            $(document).on('submit', '#searchBtn', function(e) {
                e.preventDefault();
                review_table.ajax.reload()
            })
        });


        // Sweet alert

        function deleteData(id) {

        }
    </script>

    <script>
        // $(document).ready(function() {
        //   $.ajaxSetup({
        //     headers: {
        //       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        //   });
        //   $('.dltBtn').click(function(e) {
        //     var form = $(this).closest('form');
        //     var dataID = $(this).data('id');
        //     // alert(dataID);
        //     e.preventDefault();
        //     swal({
        //         title: "Are you sure?",
        //         text: "Once deleted, you will not be able to recover this data!",
        //         icon: "warning",
        //         buttons: true,
        //         dangerMode: true,
        //       })
        //       .then((willDelete) => {
        //         if (willDelete) {
        //           form.submit();
        //         } else {
        //           swal("Your data is safe!");
        //         }
        //       });
        //   });
        // });
    </script>
@endpush
