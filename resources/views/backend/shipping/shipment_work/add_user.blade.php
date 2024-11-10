@extends('backend.layouts.master')

@section('main-content')
    <div class="card ">
        <h5 class="card-header">Add API New User 
            {{-- <a href="{{URL::to('admin/generate_token')}}" class="btn btn-primary float-right" style="width:10%">Generate Token</a> --}}
        </h5>
        <div class="card-body" style="min-height:65vh !important;">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    @if(session('success'))
                        <div class="alert alert-success">{{session('success')}}</div>
                    @elseif(session('error'))
                        <div class="alert alert-danger">{{session('error')}}</div>
                    @endif
                    <form id="shipUser" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="email">Email</label>
                                <input type="email" placeholder="Enter Email Here..." id="email" name="email" class="form-control">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="pass">Password</label>
                                <input type="password" placeholder="Enter Password Here..." id="password" name="password" class="form-control">
                            </div>
                        </div>
                        <button type="submit" name="submit" class="btn btn-success mt-2">Submit</button>
                        
                    </form>
                </div>
            </div>
        </div>
        <table class="table table-hover">
            <thead>
                <th>S. No.</th>
                <th>Email</th>
                <th>Token At</th>
                <th>Updated At</th>
                <th>Action</th>
            </thead>
            <tbody>
                @foreach ($index as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->email}}</td>
                    <td>{{$item->token_at}}</td>
                    <td>{{$item->updated_at}}</td>
                    <td style="width: 30%;">
                        <a href="javascript:void(0);" class="btn btn-info generateToken" data-id="{{$item->id}}"><i class="fa-solid fa-ticket"></i>Generate Token</a>
                        <a href="javascript:void(0);" class="btn btn-danger"><i class="fa-solid fa-ticket"></i>Change Password</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/summernote/summernote.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('backend/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#description').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>

    <script>
        $(document).ready(function(){
            $('#shipUser').on('submit',function(e){
                e.preventDefault();
                
                var formData = $(this).serialize(); // Serialize form data

                // Send AJAX request
                $.ajax({
                    url: '{{ route("shipUser") }}', // Your route URL for the shipUserCreate function
                    method: 'POST',  // Use POST method
                    data: formData,  // Serialized form data
                    dataType: 'json', // Expect JSON response
                    success: function(response) {
                        if(response.success) {
                            // If the user is created successfully, append the new user to the table
                            var user = response.data; // Get the user data from the response

                            // Add a new row to the table with the new user data
                            var newRow = `
                                <tr>
                                    <td>${user.id}</td>
                                    <td>${user.email}</td>
                                    <td>${user.token_at}</td>
                                    <td>${user.updated_at}</td>
                                    <td style="width: 30%;">
                                        <a href="javascript:void(0);" class="btn btn-info">
                                            <i class="fa-solid fa-ticket"></i>Generate Token
                                        </a>
                                        <a href="javascript:void(0);" class="btn btn-danger">
                                            <i class="fa-solid fa-ticket"></i>Change Password
                                        </a>
                                    </td>
                                </tr>
                            `;

                            // Append the new row to the table body
                            $('table tbody').append(newRow);

                            // Reset the form after submission
                            $('#shipUser')[0].reset();

                            // Show success message (optional)
                            alert('User created successfully!');
                        } else {
                            alert('Error: ' + response.message); // Display error message
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle error in the request
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(field, message) {
                                $('#' + field).next('.text-danger').remove();
                                $('#' + field).after('<div class="text-danger">' + message + '</div>');
                            });
                        } else if (xhr.status === 401 || xhr.status === 400) {
                            // Handle specific errors like email/password mismatch
                            var errorMessage = xhr.responseJSON.error || 'An unexpected error occurred.';
                            alert(errorMessage); 
                        } else {
                            alert('Something went wrong: ' + error);
                        }
                    }
                });
                                
            });
        });

        $(document).ready(function(){
            $(document).on('click','.generateToken',function(e){
                e.preventDefault();
                
                id = $(this).data('id');
                console.log(id);
                
                $.ajax({
                    url : '{{ route("generateToken") }}',
                    method : 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', 
                        user_id: id 
                    },
                    dataType : 'json',
                    success: function(response) {
                        if(response.success) {
                            alert('Token generated successfully!');

                            $('#token-' + userId).text(response.token); 
                        } else {
                            alert('Error: ' + response.message);
                        }
                    },
                });

            });
        });
    </script>

@endpush
