<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>




@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Coupon</h5>
    <div class="card-body">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="post" action="{{ route('coupon.update', $coupon->id) }}">
    @csrf
    @method('PATCH') <!-- This sets the form method to PATCH for updating -->

    <div class="form-group">
        <label for="code">Coupon Code:</label>
        <div class="input-group">
            <input type="text" class="form-control" id="code" name="code" value="{{ $coupon->code }}" required>
            <div class="input-group-append">
                <button type="button" class="btn btn-secondary" id="generateCoupon">Generate</button>
            </div>
        </div>
    </div>

    <!-- <div class="form-group">
        <label for="description">Description:</label>
        <textarea class="form-control" id="description" name="description" required>{{ $coupon->description }}</textarea>
    </div> -->

    <div class="form-group">
        <label for="discount_type">Discount Type:</label>
        <select class="form-control" id="discount_type" name="discount_type" required>
            <option value="percentage" {{ $coupon->discount_type == 'percentage' ? 'selected' : '' }}>Percentage</option>
            
        </select>
    </div>

    <div class="form-group">
        <label for="discount_value">Discount Value:</label>
        <input type="number" class="form-control" id="discount_value" name="discount_value" value="{{ $coupon->discount_value }}" required>
    </div>

    <div class="form-group">
        <label for="min_order">Min Order:</label>
        <input type="number" class="form-control" id="min_order" name="min_order" value="{{ $coupon->min_order }}" required>
    </div>

    <div class="form-group">
        <label for="max_discount">Max Discount:</label>
        <input type="number" class="form-control" id="max_discount" name="max_discount" value="{{ $coupon->max_discount }}" required>
    </div>

    <div class="form-group">
        <label for="expires_at">Expiration Date:</label>
        <input type="date" class="form-control" id="expires_at" name="expires_at"
            value="{{ $coupon->expires_at ? \Carbon\Carbon::parse($coupon->expires_at)->format('Y-m-d') : '' }}">
    </div>


        <div class="form-group">
            <label>Select Product <span class="text-danger">(if coupon is only for single product)</span></label><br>
            <select name="product_id" id="product_id" class="form-control">
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ $product->id == $coupon->product_id ? 'selected' : '' }}>
                        {{ $product->title }}
                    </option>
                @endforeach
            </select>

        </div>
        <div class="form-group">
            <label>Assign to:</label><br>
            <input type="radio" id="all_users" name="assign_to" value="all" 
                {{ $coupon->users->isEmpty() ? 'checked' : '' }}>
            <label for="all_users">All Users</label><br>
            <input type="radio" id="selected_users" name="assign_to" value="selected" 
                {{ $coupon->users->isNotEmpty() ? 'checked' : '' }}>
            <label for="selected_users">Selected Users</label>
        </div>

        <div id="user_selection" class="form-group" style="display: {{ $coupon->users->isNotEmpty() ? 'block' : 'none' }};">
            <label for="users">Select Users:</label><br>
            <select name="users[]" id="users" class="form-control" multiple="multiple">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $coupon->users->contains($user->id) ? 'selected' : '' }}>
                        {{ $user->name }} {{ $user->mobile }} 
                    </option>
                @endforeach
            </select>
        </div>

    <button type="submit" class="btn btn-primary">Update Coupon</button>
</form>

    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        // Initialize Select2
        $('#users').select2({
            placeholder: "Select users",
            allowClear: true
        });

        // Function to toggle the visibility of the user selection field
        function toggleUserSelection() {
            const userSelection = document.getElementById('user_selection');
            userSelection.style.display = this.value === 'selected' ? 'block' : 'none';
        }

        // Event listeners for radio button changes
        const assignToRadios = document.querySelectorAll('input[name="assign_to"]');
        assignToRadios.forEach(radio => {
            radio.addEventListener('change', toggleUserSelection);
        });

        // Initialize visibility on page load
        toggleUserSelection.call(document.querySelector('input[name="assign_to"]:checked'));
    });
</script>

<script>
    $(document).ready(function() {
        // Initialize Select2 on the product_id select element
        $('#product_id').select2({
            placeholder: 'Select a Product', // Optional: Placeholder text
            allowClear: true // Optional: Allow clear selection
        });
    });
</script>
<script>
    $(document).ready(function() {
    $('#updateCouponForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize(); // Serialize form data

        $.ajax({
            url: $(this).attr('action'), // The form's action attribute
            method: 'PUT', // The HTTP method to use
            data: formData, // The serialized form data
            success: function(response) {
                // If successful, show success message
                if (response.status === 'success') {
                    alert(response.message);
                    // Optionally, you can redirect or update the UI
                }
            },
            error: function(xhr) {
                // If an error occurs, show validation errors
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    // Display the errors on the form
                    for (let key in errors) {
                        alert(errors[key][0]); // For simplicity, using alert
                        // You can update the form with the errors instead of alerts
                    }
                } else {
                    // Other errors
                    alert('An error occurred while updating the coupon.');
                }
            }
        });
    });
});

</script>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
        $('#description').summernote({
        placeholder: "Write short description.....",
            tabsize: 2,
            height: 150
        });
    });
</script>
@endpush