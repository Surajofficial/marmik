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
            <h6 class="m-0 font-weight-bold text-primary float-left">Slot Lists</h6>

        </div>
        <div class="card-body">
        <div class="table-responsive">
    @if (count($slot) > 0)
    <table class="table table-bordered table-striped table-hover" id="product-dataTable" width="100%" cellspacing="0">
        <thead class="thead-dark">
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Description</th>
                <th>Slot</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Description</th>
                <th>Slot</th>
            </tr>
        </tfoot>
        <tbody>
            @foreach ($slot as $item)
            <tr>
                <td>{{ $loop->iteration }}</td> <!-- Dynamic numbering -->
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ \Carbon\Carbon::parse($item->date)->format('d-m-Y') }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->slot }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Showing {{ $slot->firstItem() }} to {{ $slot->lastItem() }} of {{ $slot->total() }} entries
        </div>
        <div>
            {{ $slot->links('pagination::bootstrap-4') }}
        </div>
    </div>
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
            /* Animation */
        }

        .zoom:hover {
            transform: scale(5);
        }

        #pagination {
            overflow: hidden;
            width: 100%
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
            "scrollX": false,
            "scrollY": "400px", // Use "scrollY" for setting the height
            "columnDefs": [{
                "orderable": false,
                "targets": [10, 11, 12]
            }],
            "paging": true, // Enable pagination
            "info": true, // Show table information
            "searching": true, // Enable searching
            "autoWidth": false, // Disable auto width to prevent misalignment
            "responsive": true // Enable responsiveness for better UI
        });
    </script>
@endpush
