@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Add Product Variants</h5>
        <div class="card-body">
            <form method="post"
                action="{{ isset($variant) ? route('variant.update', $variant->id) : route('variant.store') }}">
                @csrf
                @if (isset($variant))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="product_id">Product <span class="text-danger">*</span></label>
                    <select name="product_id" id="product_id" class="form-control">
                        <option value="">--Select any Product--</option>
                        @foreach ($products as $product)
                            <option value='{{ $product->id }}'
                                {{ isset($variant) && $variant->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="size">Size</label>
                    <select name="size" class="form-control select" data-live-search="true">
                        <option value="">--Select any Size--</option>
                        @foreach ($strep as $item)
                            <option value="{{ $item->id }}"
                                {{ old('size', $variant->size ?? '') == $item->id ? 'selected' : '' }}>
                                {{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('size')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="sku" class="col-form-label">SKU Number <span class="text-danger">*</span></label>
                    <input id="sku" type="text" name="sku" value="{{ old('sku', $variant->sku ?? '') }}"
                        placeholder="Enter SKU Number" class="form-control">
                    @error('sku')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="width">Width</label>
                    <input placeholder="Enter Width" type="number" name="width" class="form-control"
                        value="{{ old('width', $variant->width ?? '') }}" />
                    @error('width')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="height">Height</label>
                    <input placeholder="Enter Height" type="number" name="height" class="form-control"
                        value="{{ old('height', $variant->height ?? '') }}" />
                    @error('height')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="length">Length</label>
                    <input placeholder="Enter Length" type="number" name="length" class="form-control"
                        value="{{ old('length', $variant->length ?? '') }}" />
                    @error('length')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="weight">Weight</label>
                    <input placeholder="Enter Weight" type="number" name="weight" class="form-control"
                        value="{{ old('weight', $variant->weight ?? '') }}" />
                    @error('weight')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                @if (isset($variant) && $variant->rules != null)
                    @php
                        $rules = json_decode($variant->rules, true);
                    @endphp
                @else
                    @php
                        $rules = null;
                    @endphp
                @endif

                <div class="form-group">
                    <label for="buy_x">Buy X</label>
                    <input type="number" class="form-control" id="buy_x" name="buy_x" placeholder="Enter X value"
                        value="{{ old('buy_x', $rules['buy_x'] ?? 0) }}">
                    @error('buy_x')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="get_y">Get Y Free</label>
                    <input type="number" class="form-control" id="get_y" name="get_y" placeholder="Enter Y value"
                        value="{{ old('get_y', $rules['get_y'] ?? 0) }}">
                    @error('get_y')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="is_featured">Is Featured</label><br>
                    <input type="checkbox" name='is_featured' id='is_featured' value='1'
                        {{ old('is_featured', $variant->is_featured ?? '') ? 'checked' : '' }}> Yes
                </div>
                <div class="form-group">
                    <label for="is_best_seller">Is Bestseller</label><br>
                    <input type="checkbox" name='is_best_seller' id='is_best_seller' value='1'
                        {{ old('is_best_seller', $variant->is_best_seller ?? '') ? 'checked' : '' }}> Yes
                </div>

                <div class="form-group">
                    <label for="fearured_no">Featured Position</label><br>
                    <input type="number" class="form-control" name='fearured_no' id='fearured_no'
                        value="{{ old('fearured_no', $variant->fearured_no ?? '') }}">
                </div>

                <div class="form-group">
                    <label for="best_seller_no">Best Seller Position</label><br>
                    <input type="number" class="form-control" name='best_seller_no' id='best_seller_no'
                        value="{{ old('best_seller_no', $variant->best_seller_no ?? '') }}">
                </div>
                <div class="form-group">
                    <label for="price" class="col-form-label">Price <span class="text-danger">*</span></label>
                    <input required="true" id="price" type="number" name="price" placeholder="Enter price"
                        value="{{ old('price', $variant->price ?? '') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="special_price" class="col-form-label">Special Price
                        <span class="text-danger">*</span>
                    </label>
                    <input required="true" id="special_price" type="number" name="special_price"
                        placeholder="Enter Special Price"
                        value="{{ old('special_price', $variant->special_price ?? '') }}" class="form-control">
                    @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="discount" class="col-form-label">Discount %<span class="text-danger">*</span></label>
                    <input required="true" id="discount" type="number" name="discount" placeholder="Enter Discount"
                        value="{{ old('discount', $variant->discount ?? '') }}" class="form-control">
                    @error('discount')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                    <select name="status" class="form-control">
                        <option value="active" {{ isset($variant) && $variant->status == 'active' ? 'selected' : '' }}>
                            Active</option>
                        <option value="inactive"
                            {{ isset($variant) && $variant->status == 'inactive' ? 'selected' : '' }}>
                            Inactive</option>
                    </select>
                    @error('status')
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
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
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
                            } else {}
                        } else {
                            $('#child_cat_div').addClass('d-none');
                        }
                        $('#child_cat_id').html(html_option);
                    }
                });
            } else {}
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
                            } else {}
                        } else {
                            $('#child_concern_div').addClass('d-none');
                        }
                        $('#child_concern_id').html(html_option);
                    }
                });
            } else {}
        })
    </script>
@endpush
