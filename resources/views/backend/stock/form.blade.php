@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Add Product Variants</h5>
        <div class="card-body">
            <form method="post" action="{{ isset($stock) ? route('stocks.update', $stock->id) : route('stocks.store') }}">
                @csrf
                @if (isset($stock))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="variant_id">Product <span class="text-danger">*</span></label>
                    <select name="variant_id" id="variant_id" class="form-control">
                        <option value="">--Select any Product--</option>
                        @foreach ($varients as $varient)
                            <option value="{{ $varient->id }}"
                                {{ old('variant_id') == $varient->id || (isset($stock) && $stock->variant_id == $varient->id) ? 'selected' : '' }}>
                                {{ $varient->product->title }} {{ @$varient->strep->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="center_id">Center <span class="text-danger">*</span></label>
                    <select name="center_id" id="center_id" class="form-control">
                        <option value="">--Select any Center--</option>
                        @foreach ($centers as $center)
                            <option value='{{ $center->id }}'
                                {{ old('center_id') == $center->id || (isset($stock) && $stock->center_id == $center->id) ? 'selected' : '' }}>
                                {{ $center->center_name }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input required="true" id="price" type="number" name="price" placeholder="Enter price"
                        value="{{ old('price', $stock->price ?? '') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="discount" class="col-form-label">Discount(%)</label>
                    <input id="discount" type="number" name="discount" min="0"
                        value="{{ old('discount', $stock->discount ?? 0) }}" max="100" placeholder="Enter discount"
                        class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="stock" class="col-form-label">Stock</label>
                    <input id="stock" type="number" name="stock" min="1"
                        value="{{ old('stock', $stock->stock ?? 1) }}" placeholder="Enter Stock" class="form-control">
                    @error('stock')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="batch_no" class="col-form-label">Batch Number <span class="text-danger">*</span></label>
                    <input id="batch_no" type="text" name="batch_no"
                        value="{{ old('batch_no', $stock->batch_no ?? '') }}" placeholder="Enter Batch Number"
                        class="form-control">
                    @error('batch_no')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>


                <div class="form-group">
                    <label for="expiry">Expiry Date</label>
                    <input required="true" type="month" id="expiry" name="expiry"
                        value="{{ old('expiry', $stock->expiry ?? '') }}" class="form-control" />
                    @error('expiry')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="mfg">MFG Date</label>
                    <input required="true" type="month" id="mfg" name="mfg"
                        value="{{ old('mfg', $stock->mfg ?? '') }}" class="form-control" />
                    @error('mfg')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group mb-3">
                    <button type="reset" class="btn btn-warning">Reset</button>
                    <button class="btn btn-success" type="submit">Submit</button>
                </div>
            </form>


        </div>
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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    <style>
        .select2-container .select2-selection--single .select2-selection__rendered {
            --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e) !important;
            display: block;
            width: 100%;
            padding: .375rem 2.25rem .375rem .75rem;
            -moz-padding-start: calc(0.75rem - 3px);
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            color: var(--bs-body-color);
            background-color: var(--bs-form-control-bg);
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right .75rem center;
            background-size: 16px 12px;
            border: var(--bs-border-width) solid var(--bs-border-color);
            border-radius: .375rem;
            transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }

        .select2-container .select2-selection--single {
            box-sizing: border-box;
            cursor: pointer;
            display: block;
            height: 38px;
            user-select: none;
            -webkit-user-select: none;
        }
    </style>
    <script>
        $('#variant_id').select2();
    </script>

    <script>
        $('#cat_id').change(function() {
            var cat_id = $(this).val();
            // alert(cat_id);
            if (cat_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/category/" + cat_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: cat_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub category----</option>"
                        if (response.status) {
                            var data = response.data;
                            // alert(data);
                            if (response.data) {
                                $('#child_cat_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "'>" + title +
                                        "</option>"
                                });
                            }
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            }
        })
    </script>
    <script>
        $('#concern_id').change(function() {
            var concern_id = $(this).val();
            //   alert(concern_id);
            if (concern_id != null) {
                // Ajax call
                $.ajax({
                    url: "/admin/concern/" + concern_id + "/child",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: concern_id
                    },
                    type: "POST",
                    success: function(response) {
                        if (typeof(response) != 'object') {
                            response = $.parseJSON(response)
                        }
                        // console.log(response);
                        var html_option = "<option value=''>----Select sub concern----</option>"
                        if (response.status) {
                            var data = response.data;
                            // alert(data);
                            if (response.data) {
                                $('#child_concern_div').removeClass('d-none');
                                $.each(data, function(id, title) {
                                    html_option += "<option value='" + id + "'>" + title +
                                        "</option>"
                                });
                            }
                        } else {
                            $('#child_concern_div').addClass('d-none');
                        }
                        $('#child_concern_id').html(html_option);
                    }
                });
            }
        })
    </script>
@endpush
