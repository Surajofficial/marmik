@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">{{ isset($product) ? 'Update' : 'Add' }} Product</h5>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    Something went wrong, please check all fields carefully.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="post"
                action="{{ isset($product) ? route('product.update', $product->id) : route('product.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if (isset($product))
                    @method('PUT')
                @endif

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
                    <input id="inputTitle" type="text" name="title" placeholder="Enter title"
                        value="{{ old('title', $product->title ?? '') }}" class="form-control" required="true">
                    @error('title')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="summary" name="summary">{{ old('summary', $product->summary ?? '') }}</textarea>
                    @error('summary')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="col-form-label">Description</label>
                    <textarea class="form-control" id="description" name="description">{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="how_to_use" class="col-form-label">How to use</label>
                    <textarea class="form-control" id="how_to_use" name="how_to_use">{{ old('how_to_use', $product->how_to_use ?? '') }}</textarea>
                    @error('how_to_use')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="evidence" class="col-form-label">Evidence</label>
                    <textarea class="form-control" id="evidence" name="evidence">{{ old('evidence', $product->evidence ?? '') }}</textarea>
                    @error('evidence')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="presc">Is Prescribed</label><br>
                    <input type="checkbox" name='presc' id='presc' value='1'
                        {{ old('presc', $product->presc ?? '') ? 'checked' : '' }}> Yes
                </div>

                <div class="form-group">
                    <label for="combo">Is Combo</label><br>
                    <input type="checkbox" name='combo' id='combo' value='1'
                        {{ old('combo', $product->combo ?? '') ? 'checked' : '' }}> Yes
                </div>
                @php
                    // Initialize arrays for selected values
                    $selectedConcerns = [];
                    $selectedPtypes = [];
                    $selectedCategories = [];

                    // Check if $product is set and has related data
                    if (isset($product)) {
                        $selectedConcerns = $product->concerns->pluck('id')->toArray() ?? [];
                        $selectedPtypes = $product->ptypes->pluck('id')->toArray() ?? [];
                        $selectedCategories = $product->categories->pluck('id')->toArray() ?? [];
                    }
                @endphp

                <!-- Concerns -->
                <div class="form-group">
                    <label for="concern_id">Concern <span class="text-danger">*</span></label>
                    <select name="concern_id[]" id="concern_id" class="form-control select" multiple>
                        @foreach ($concerns as $concern)
                            <option value="{{ $concern->id }}"
                                {{ in_array($concern->id, old('concern_id', $selectedConcerns)) ? 'selected' : '' }}>
                                {{ $concern->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('concern_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group d-none" id="child_concern_div">
                    <label for="child_concern_id">Sub Concern</label>
                    <select name="child_concern_id" id="child_concern_id" class="form-control">
                        <option value="">--Select any Concern--</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="ptype_id">Product Type <span class="text-danger">*</span></label>
                    <select name="ptype_id[]" id="ptype_id" class="form-control select" multiple>
                        @foreach ($ptypes as $ptype)
                            <option value="{{ $ptype->id }}"
                                {{ in_array($ptype->id, old('ptype_id', $selectedPtypes)) ? 'selected' : '' }}>
                                {{ $ptype->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('ptype_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group d-none" id="child_type_div">
                    <label for="child_ptype_id">Sub Product Type</label>
                    <select name="child_ptype_id" id="child_ptype_id" class="form-control">
                        <option value="">--Select any Product Type--</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="cat_id">Category <span class="text-danger">*</span></label>
                    <select name="cat_id[]" id="cat_id" class="form-control select" multiple>
                        <option value="">--Select any category--</option>
                        @foreach ($categories as $cat_data)
                            <option value="{{ $cat_data->id }}"
                                {{ in_array($cat_data->id, old('cat_id', $selectedCategories)) ? 'selected' : '' }}>
                                {{ $cat_data->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('cat_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group d-none" id="child_cat_div">
                    <label for="child_cat_id">Sub Category</label>
                    <select name="child_cat_id" id="child_cat_id" class="form-control">
                        <option value="">--Select any category--</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="pts" class="col-form-label">PTS</label>
                    <input id="pts" type="number" name="pts" min="0"
                        value="{{ old('pts', $product->pts ?? 0) }}" max="100" placeholder="Enter PTS"
                        class="form-control">
                    @error('pts')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="psr" class="col-form-label">PSR</label>
                    <input id="psr" type="number" name="psr" min="0"
                        value="{{ old('psr', $product->psr ?? 0) }}" max="100" placeholder="Enter PSR"
                        class="form-control">
                    @error('psr')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brand_id">Supplier</label>
                    <select name="brand_id" class="form-control select">
                        <option value="">--Select Supplier--</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}"
                                {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>
                                {{ $brand->title }}</option>
                        @endforeach
                    </select>
                    @error('brand_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cgst">Tax(CGST %)</label>
                    <input type="number" name="cgst" class="form-control"
                        value="{{ old('cgst', $product->cgst ?? '') }}" />
                    @error('cgst')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="sgst">Tax(SGST %)</label>
                    <input required="true" type="number" name="sgst" class="form-control"
                        value="{{ old('sgst', $product->sgst ?? '') }}" />
                    @error('sgst')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="tax">Tax(Other %)</label>
                    <input required="true" type="number" name="tax" class="form-control"
                        value="{{ old('tax', $product->tax ?? '') }}" />
                    @error('tax')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="hsn_no">HSN Code</label>
                    <input type="text" name="hsn_no" class="form-control" placeholder="Enter HSN Code"
                        value="{{ old('hsn_no', $product->hsn_no ?? '') }}" />
                    @error('hsn_no')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder"
                                class="btn btn-primary text-white">
                                <i class="fas fa-image"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ old('photo', $product->photo ?? '') }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>
                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="video" class="col-form-label">Video <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input class="form-control" type="file" name="video"
                            value="{{ old('video', $product->video ?? '') }}">
                    </div>
                    @error('video')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">{{ isset($product) ? 'Update' : 'Submit' }}</button>
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
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select').select2({
                'placeholder': 'Select Option'
            });
        });
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
            $('#how_to_use').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
            $('#evidence').summernote({
                placeholder: "Write detail description.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>
    @isset($product)
        <script>
            var child_cat_id = '{{ $product->child_cat_id ?? '' }}';
            $('#cat_id').change(function() {
                var cat_id = $(this).val();
                if (cat_id) {
                    // Ajax call
                    $.ajax({
                        url: "/admin/category/" + cat_id + "/child",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (typeof(response) != 'object') {
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value=''>--Select any one--</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data) {
                                    $('#child_cat_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "' " + (
                                                child_cat_id == id ? 'selected' : '') + ">" +
                                            title + "</option>";
                                    });
                                } else {
                                    console.log('no response data');
                                }
                            } else {
                                $('#child_cat_div').addClass('d-none');
                            }
                            $('#child_cat_id').html(html_option);
                        }
                    });
                }
            });
            if (child_cat_id) {
                $('#cat_id').change();
            }

            var child_concern_id = '{{ $product->child_concern_id ?? '' }}';
            $('#concern_id').change(function() {
                var concern_id = $(this).val();
                if (concern_id) {
                    // Ajax call
                    $.ajax({
                        url: "/admin/concern/" + concern_id + "/child",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (typeof(response) != 'object') {
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value=''>--Select any one--</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data) {
                                    $('#child_concern_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "' " + (
                                                child_concern_id == id ? 'selected' : '') + ">" +
                                            title + "</option>";
                                    });
                                } else {
                                    console.log('no response data');
                                }
                            } else {
                                $('#child_concern_div').addClass('d-none');
                            }
                            $('#child_concern_id').html(html_option);
                        }
                    });
                }
            });
            if (child_concern_id) {
                $('#concern_id').change();
            }
        </script>
    @endisset

    @empty($product)
        <script>
            $('#cat_id').change(function() {
                var cat_id = $(this).val();
                if (cat_id) {
                    // Ajax call
                    $.ajax({
                        url: "/admin/category/" + cat_id + "/child",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: cat_id
                        },
                        success: function(response) {
                            if (typeof(response) != 'object') {
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value=''>----Select sub category----</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data) {
                                    $('#child_cat_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "'>" + title +
                                            "</option>";
                                    });
                                }
                            } else {
                                $('#child_cat_div').addClass('d-none');
                            }
                            $('#child_cat_id').html(html_option);
                        }
                    });
                }
            });

            $('#concern_id').change(function() {
                var concern_id = $(this).val();
                if (concern_id) {
                    // Ajax call
                    $.ajax({
                        url: "/admin/concern/" + concern_id + "/child",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: concern_id
                        },
                        success: function(response) {
                            if (typeof(response) != 'object') {
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value=''>----Select sub concern----</option>";
                            if (response.status) {
                                var data = response.data;
                                if (data) {
                                    $('#child_concern_div').removeClass('d-none');
                                    $.each(data, function(id, title) {
                                        html_option += "<option value='" + id + "'>" + title +
                                            "</option>";
                                    });
                                }
                            } else {
                                $('#child_concern_div').addClass('d-none');
                            }
                            $('#child_concern_id').html(html_option);
                        }
                    });
                }
            });
        </script>
    @endempty


@endpush
