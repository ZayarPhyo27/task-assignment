<div class="row mx-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Name') }} <span class="text-red">*</span></label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" autocomplete="name" autofocus placeholder="Name">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('Color') }} <span class="text-red">*</span></label>
                    <input id="color" type="text" class="form-control @error('color') is-invalid @enderror" name="color" value="{{ old('color', $product->color) }}" autocomplete="color" autofocus placeholder="Color">

                    @error('color')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('Size') }} <span class="text-red">*</span></label>
                    <input id="size" type="text" class="form-control @error('size') is-invalid @enderror" name="size" value="{{ old('size', $product->size) }}" autocomplete="size" autofocus placeholder="Size">

                    @error('size')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <div class="form-group">
                 <label>Image</label><br>
                 <img id="imagePreview"
                    src="{{ $product->image ? asset('storage/' . $product->image) : '#' }}"
                    alt="Preview"
                    style="max-width: 150px; {{ $product->image ? '' : 'display:none;' }} border: 1px solid #ccc; padding: 3px;">
                {{-- @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" width="100" class="mb-2">
                @endif --}}
                <input type="file" name="image" id="imageInput" class="form-control">

                {{-- <div class="mt-2">
                    <img id="imagePreview" src="#" alt="Preview" style="max-width: 150px; display: none;border: 1px solid #ccc; padding: 3px;">
                </div> --}}
        </div>

    </div>

     <div class="col-md-6">
                <div class="form-group">
                    <label>{{ __('Price') }} <span class="text-red">*</span></label>
                    <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" autocomplete="price" autofocus placeholder="price">

                    @error('price')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

    <div class="col-md-12 my-3">
        <div class="form-group">
            <label>{{ __('Description') }} <span class="text-red">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" rows="7" cols="30" id="description" name="description" placeholder="Description">{{$product->description}}</textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>

    <div class="row ">
        <div class="col-8">
        </div>
        <div class="col-2 mr-3 ml-2">
            <button type="submit" class="form-control hpy-btn btn btn-success save-btn">
                {{ __('Save') }}
            </button>
        </div>
        <div class="col-2 mr-3">
            <a class="form-control btn btn-danger hpy-btn " href="{{url($route)}}">
                {{ __('Cancel') }}
            </a>
        </div>
    </div><br>

</div>

<script>
    $('#imageInput').change(function(e) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').attr('src', e.target.result).show();
        }
        reader.readAsDataURL(e.target.files[0]);
    });
</script>

