@extends('backend.layouts.master')

@section('main-content')
    <div class="card">
        <h5 class="card-header">Edit Post</h5>
        <div class="card-body">
            <form method="post" action="{{ route('settings.update') }}">
                @csrf

                <div class="form-group">
                    <label for="short_des" class="col-form-label">Short Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="quote" name="short_des">{{ @$data->short_des }}</textarea>
                    @error('short_des')
                        <span class="text-danger">{{ @$message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="description" class="col-form-label">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="description" name="description">{{ @$data->description }}</textarea>
                    @error('description')
                        <span class="text-danger">{{ @$message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Logo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm1" data-input="thumbnail1" data-preview="holder1" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail1" class="form-control" type="text" name="logo"
                            value="{{ @$data->logo }}">
                    </div>
                    <div id="holder1" style="margin-top:15px;max-height:100px;"></div>

                    @error('logo')
                        <span class="text-danger">{{ @$message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">Photo <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="photo"
                            value="{{ @$data->photo }}">
                    </div>
                    <div id="holder" style="margin-top:15px;max-height:100px;"></div>

                    @error('photo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPhoto" class="col-form-label">About Image <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm2" data-input="about_image_thumb" data-preview="about_image_pre"
                                class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="about_image_thumb" class="form-control" type="text" name="about_image"
                            value="{{ @$data->about_image }}">
                    </div>
                    <div id="about_image_pre" style="margin-top:15px;max-height:100px;"></div>
                    @error('about_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="col-form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required value="{{ @$data->name }}">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="delevery_fee_after" class="col-form-label">Delevery Fee Apply after <span
                            class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="delevery_fee_after"
                        value="{{ @$data->delevery_fee_after }}">
                    @error('delevery_fee_after')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="tracking_link" class="col-form-label">Tracking Link <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="tracking_link"
                        value="{{ @$data->tracking_link }}">
                    @error('tracking_link')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address" class="col-form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="address" required value="{{ @$data->address }}">
                    @error('address')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" class="form-control" name="email" required value="{{ @$data->email }}">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone" class="col-form-label">Phone Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="phone" required value="{{ @$data->phone }}">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="mobile" class="col-form-label">Mobile Number <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="mobile" required value="{{ @$data->mobile }}">
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address" class="col-form-label">Google Analytics (Script Tag Body) </label>
                    <textarea class="form-control" name="analytics" value="{{ $data->analytics }}">{{ @$data->analytics }}</textarea>
                    @error('analytics')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email" class="col-form-label">Google Tag Manager(Head)</label>
                    <textarea class="form-control" name="seo" value="{{ $data->seo }}">{{ @$data->seo }}</textarea>
                    @error('seo')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="boffer" class="col-form-label">Facebook Link </label>
                    <input type="text" class="form-control" name="facebook" value="{{ @$data->facebook }}">
                    @error('facebook')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="boffer" class="col-form-label">Instagram Link </label>
                    <input type="text" class="form-control" name="instagram" value="{{ @$data->instagram }}">
                    @error('instagram')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="boffer" class="col-form-label">Youtube Link</label>
                    <input type="text" class="form-control" name="youtube" value="{{ @$data->youtube }}">
                    @error('youtube')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="boffer" class="col-form-label">Banner offer <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="boffer" required value="{{ @$data->boffer }}">
                    @error('boffer')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="cartcolor" class="col-form-label">Add To Cart Button <span
                            class="text-danger">*</span></label>
                    <select name="cartcolor" class="form-control" required value="{{ $data->cartcolor }}">
                        <option value="btn-danger">Red</option>
                        <option value="btn-warning">Yellow</option>
                        <option value="btn-success">Green</option>
                        <option value="btn-primary">Blue</option>

                    </select>
                    @error('cartcolor')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="categorytext" class="col-form-label">Product Type Text <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="categorytext" required
                        value="{{ @$data->categorytext }}">

                    @error('categorytext')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="concerntext" class="col-form-label">Concern Text <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="concerntext" required
                        value="{{ @$data->concerntext }}">

                    @error('concerntext')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="brandtext" class="col-form-label">Brand Text <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="brandtext" required
                        value="{{ @$data->brandtext }}">

                    @error('brandtext')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="gst" class="col-form-label">GST <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="gst" required value="{{ @$data->gst }}">

                    @error('gst')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
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
        $('#lfm1').filemanager('image');
        $('#lfm2').filemanager('image');
        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short description.....",
                tabsize: 2,
                height: 150
            });
        });

        $(document).ready(function() {
            $('#quote').summernote({
                placeholder: "Write short Quote.....",
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
    </script>
@endpush
