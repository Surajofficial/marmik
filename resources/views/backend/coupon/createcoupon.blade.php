<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Coupon</h5>
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


    <form method="post" action="{{route('coupon.store')}}">
    @csrf
        <!-- <div class="form-group">
            <label for="code">Coupon Code:</label>
            <div class="input-group">
                <input type="text" class="form-control" id="code" name="code" required>
                <div class="input-group-append">
                    <button type="button" class="btn btn-secondary" id="generateCoupon">Generate</button>
                </div>
            </div>
        </div> -->

        <!-- <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div> -->
        <div class="form-group">
            <label for="discount_type">Discount Type:</label>
            <select class="form-control" id="discount_type" name="discount_type" required>
                <option value="percentage">Percentage (%)</option>
                <!-- <option value="fixed">Fixed Amount</option> -->
            </select>
        </div>
        
        <div class="form-group">
            <label for="discount_value">Discount Value:</label>
            <input type="number" class="form-control" id="discount_value" name="discount_value" required>
        </div>

        <div class="form-group">
            <label for="discount_value">Min Order:</label>
            <input type="number" class="form-control" id="min_order" name="min_order" required>
        </div>

        <div class="form-group">
            <label for="discount_value">Max Discount:</label>
            <input type="number" class="form-control" id="max_discount" name="max_discount" required>
        </div>
        
        <div class="form-group">
            <label for="expires_at">Expiration Date:</label>
            <input type="date" class="form-control" id="expires_at" name="expires_at">
        </div>

        <div class="form-group">
            <label>Select Product <span class="text-danger">(if coupon is only for single product)</span></label><br>
            <select name="product_ids[]" id="product_ids" class="form-control">
                <option value="all">For All Products</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->title }}</option>
                @endforeach
            </select>

        </div>


        <div class="form-group">
            <label>Assign to:</label><br>
            <input type="radio" id="all_users" name="assign_to" value="all" checked>
            <label for="all_users">All Users</label><br>
            <input type="radio" id="selected_users" name="assign_to" value="selected">
            <label for="selected_users">Selected Users</label>
        </div>

        <div id="user_selection" class="form-group" style="display: none;">
            <label for="users">Select Users:</label><br>
            <select name="users[]" id="users" class="form-control" multiple="multiple">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }} {{ $user->mobile }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Coupon</button>
    </form>
      
    </div>

</div>
<!-- 
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to generate a random coupon code with 3 uppercase letters followed by 3 digits
        function generateCouponCode() {
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            let result = '';

            // Generate 3 random uppercase letters
            for (let i = 0; i < 3; i++) {
                result += letters.charAt(Math.floor(Math.random() * letters.length));
            }

            // Generate 3 random digits
            for (let i = 0; i < 3; i++) {
                result += numbers.charAt(Math.floor(Math.random() * numbers.length));
            }

            return result;
        }

        // Event listener for the Generate button
        const generateButton = document.getElementById('generateCoupon');
        generateButton.addEventListener('click', function () {
            const couponCode = generateCouponCode(); // Generate the coupon code with the required format
            const codeInput = document.getElementById('code');
            codeInput.value = couponCode;
        });
    });
</script> -->



<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Function to toggle user selection visibility
        function toggleUserSelection() {
            const userSelection = document.getElementById('user_selection');
            userSelection.style.display = this.value === 'selected' ? 'block' : 'none';
        }

        // Select all radio buttons with name 'assign_to'
        const assignToRadios = document.querySelectorAll('input[name="assign_to"]');

        // Attach change event to each radio button
        assignToRadios.forEach(radio => {
            radio.addEventListener('change', toggleUserSelection);
        });

        // Initial check to set the visibility correctly on page load
        toggleUserSelection.call(assignToRadios[0]); // Call with the first radio button
    });
</script>

<!-- here is ajax for create coupons -->


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Toggle user selection visibility
        $('input[name="assign_to"]').change(function () {
            $('#user_selection').toggle(this.value === 'selected');
        });

        // Handle form submission with AJAX
        $('#couponForm').on('submit', function (e) {
            e.preventDefault(); // Prevent the default form submission

            // Gather form data
            const formData = $(this).serialize();

            // AJAX request
            $.ajax({
                type: 'POST',
                url: '{{ route("coupon.store") }}',
                data: formData,
                success: function (response) {
                    // Handle success (e.g., show a success message)
                    alert('Coupon added successfully!');
                    $('#couponForm')[0].reset(); // Reset the form
                    $('#user_selection').hide(); // Hide user selection
                },
                error: function (xhr) {
                    // Handle error (e.g., show validation errors)
                    const errors = xhr.responseJSON.errors;
                    let errorMessage = 'Please fix the following errors:\n';
                    for (let key in errors) {
                        errorMessage += errors[key].join('\n') + '\n';
                    }
                    alert(errorMessage);
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#users').select2({
            placeholder: "Select users",
            allowClear: true
        });
    });

    // Example: Toggle the visibility of the user selection field
    $('#assign_to_selected').on('change', function() {
        if ($(this).is(':checked')) {
            $('#user_selection').show();
        } else {
            $('#user_selection').hide();
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#product_ids').select2({
            placeholder: 'Select products',
            allowClear: true,
            // Additional options can be added here
        });
    });
</script>

<!-- here is ajax for create coupons -->

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