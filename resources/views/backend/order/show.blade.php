@extends('backend.layouts.master')

@section('title', 'Order Detail')
<div class="modal fade" id="shipModal" tabindex="-1" role="dialog" aria-labelledby="shipModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shipModalLabel">Create Shipping Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if($order)
            <form id="shipForm">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="order_number" value="{{ $order->order_number }}">
                <input type="hidden" name="user_id" value="{{ $order->user_id }}">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <label for="length">Length (cm) :</label>
                            <input type="text" id="length" name="length" required class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="breadth">Breadth (cm) :</label>
                            <input type="text" id="breadth" name="breadth" required class="form-control">
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-6">
                            <label for="height">Height (cm) :</label>
                            <input type="text" id="height" name="height" required class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="weight">Weight (kg) :</label>
                            <input type="text" id="weight" name="weight" required class="form-control">
                        </div>
                    </div>
                    {{-- <div class="row mt-2">
                        <div class="col-6">
                            <label for="city">City:</label>
                            <input type="text" id="city" value="{{$order->city ? $order->city : 'Null'}}" name="city" required class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="state">State:</label>
                            <input type="text" id="state" value="{{$order->state ? $order->state : 'Null'}}" name="state" required class="form-control">
                        </div>
                    </div> --}}
                    <label for="pickup_address" class="mt-2">Pickup Address:</label>
                    <select name="pickup_address" id="pickup_address" class="form-control">
                        <option value="">--Select Pickup Location--</option>
                        @foreach ($pickup_loc as $loc)
                            {{$address = $loc->address.' '.$loc->address_2}}
                            <option value="{{$loc->id}}">{{$loc->address}}</option>
                        @endforeach
                    </select>
                    {{-- <label for="pickup_address" class="mt-2">Pickup Address:</label>
                    @php $order_add = $order->address1.' '. $order->address2; @endphp
                    <textarea id="pickup_address" name="pickup_address" required class="form-control">{{$order_add}}</textarea> --}}
                </div>
                <div class="modal-footer">
                    <button type="submit" name="ship-submit" id="ship-submit" class="btn btn-primary text-right">Submit</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <div id="error" class="text-danger"></div>
                    <div id="success" class="text-success"></div> --}}
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
{{-- {{dd($order);}} --}}

@section('main-content')
    <div class="card">
        <h5 class="card-header">Order <a href="{{ route('billings', $order->id) }}"
                class=" btn btn-sm btn-primary shadow-sm float-right {{ $order->tracking_id ?? 'add_tracking' }}"
                target="blank"><i class="fas fa-download fa-sm text-white-50"></i>
                Generate Bill </a>
                <button type="button" class="btn btn-sm btn-primary shadow-sm float-right mr-2" data-toggle="modal" data-target="#shipModal">
                    <i class="fas fa-ship fa-sm text-white-50"></i>Shipping
                </button>
        </h5>
        <div class="card-body">
            @if ($order)
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Order No.</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Quantity</th>
                            <th>Charge</th>
                            <th>Total Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td>{{ $order->email }}</td>
                            <td>{{ $order->quantity }}</td>
                            <td>Rs. {{ @$order->shipping->price }}</td>
                            <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <section class="confirmation_part section_padding">
                    <div class="order_boxes">
                        <div class="row">
                            <div class="col-lg-6 col-lx-4">
                                <div class="order-info">
                                    <h4 class="text-center pb-4">ORDER INFORMATION</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Order Number</td>
                                            <td> : {{ $order->order_number }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Date</td>
                                            <td> : {{ $order->created_at->format('D d M, Y') }} at
                                                {{ $order->created_at->format('g : i a') }} </td>
                                        </tr>
                                        <tr>
                                            <td>Quantity</td>
                                            <td> : {{ $order->quantity }}</td>
                                        </tr>
                                        <tr>
                                            <td>Order Status</td>
                                            <td> : {{ $order->status }}</td>
                                        </tr>
                                        <tr>
                                            <td>Shipping Charge</td>
                                            <td> : Rs {{ @$order->shipping->price }}</td>
                                        </tr>
                                        <tr>
                                            <td>Coupon</td>
                                            <td> : Rs {{ number_format($order->coupon, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Total Amount</td>
                                            <td> : Rs {{ number_format($order->total_amount, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Method</td>
                                            <td> : {{ $order->payment_method }} @if ($order->payment_method == 'cod')
                                                    Cash on Delivery
                                                @else
                                                    Paypal
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Payment Status</td>
                                            <td> : {{ $order->payment_status }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="col-lg-6 col-lx-4">
                                <div class="shipping-info">
                                    <h4 class="text-center pb-4">SHIPPING INFORMATION</h4>
                                    <table class="table">
                                        <tr class="">
                                            <td>Full Name</td>
                                            <td> : {{ $order->first_name }} {{ $order->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td> : {{ $order->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Phone No.</td>
                                            <td> : {{ $order->phone }}</td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td> : {{ $order->address1 }}, {{ $order->address2 }}</td>
                                        </tr>
                                        <tr>
                                            <td>Country</td>
                                            <td> : {{ $order->country }}</td>
                                        </tr>
                                        <tr>
                                            <td>Post Code</td>
                                            <td> : {{ $order->post_code }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S.N.</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Discount</th>
                            <th>price after discount</th>
                            <th>Total Cost</th>
                            <th>Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            dd($order->cart_info )
                        @endphp --}}
                        {{-- {{dd($order->cart_info)}} --}}
                        @foreach ($order->cart_info as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->product->product->title }}</td>
                                <td>{{ $item->product->price }}</td>
                                <td>{{ $item->product->discount }}%</td>
                                <td>{{ $item->product->price - ($item->product->price * $item->product->discount) / 100 }}
                                </td>
                                <td>{{ ($item->product->price - ($item->product->price * $item->product->discount) / 100) * $item->quantity }}
                                </td>
                                <td>{{ $item->quantity }}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif

        </div>
    </div>
    <div class="modal fade" id="trackingModal" tabindex="-1" aria-labelledby="trackingModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="trackingModalLabel">Add Tracking Information</h5>
                    <button type="button" class="btn-close" id="close" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <form id="trackingForm">
                        @csrf
                        <div class="mb-3">
                            <label for="trackingNumber" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" id="trackingNumber" name="tracking_number" required>
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                        </div>
                        <!-- Add more fields as needed -->
                        <button type="submit" class="btn btn-primary">Save Tracking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-info,
        .shipping-info {
            background: #ECECEC;
            padding: 20px;
        }

        .order-info h4,
        .shipping-info h4 {
            text-decoration: underline;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Show the modal on button click
            $(document).on('click', '.add_tracking', function(e) {
                e.preventDefault();
                $('#trackingModal').modal('show');
            });
            $(document).on('click', '#close', function(e) {
                e.preventDefault();
                $('#trackingModal').modal('hide');
            });

            // Handle the form submission
            $('#trackingForm').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('submit-tracking') }}",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            title: "Success!",
                            text: "Appointment booked successfully.",
                            icon: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then(function() {
                            window.location.href =
                                "{{ route('billings', $order->id) }}";
                        });
                        $('#trackingModal').modal('hide');
                    },
                    error: function(xhr, status, error) {
                        Swal.fire({
                            title: "Error!",
                            text: "There was an issue adding tracking information.",
                            icon: "error"
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#shipForm').on('submit', function(e) {
                e.preventDefault(); 
    
                const formData = $(this).serialize();

                
                $.ajax({
                    type: 'POST',
                    url: '/api/shipping',
                    data: formData,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        alert('Shipping order created successfully!'); 
                        $('#shipModal').modal('hide'); 
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        for (const key in errors) {
                            errorMessage += errors[key].join(' ') + '\n'; 
                        }
                        alert(errorMessage); 
                    }
                });
            });
        });
    </script>
    
@endpush
