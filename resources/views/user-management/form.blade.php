<div class="row mx-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Name') }} <span class="text-red">*</span></label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $user->name) }}" autocomplete="name" autofocus placeholder="Name">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('email') }} <span class="text-red">*</span></label>
            <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', $user->email) }}" autocomplete="email" autofocus placeholder="email">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>

    <div class="col-md-6 mt-2">
        <div class="form-group">
         <label for="password">{{ __('Password') }} <span class="text-red">*</span></label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" style="border: 1px solid;padding: 0.5rem;">

            @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6 mt-2">
         <div class="form-group">
        <label for="password-confirm">{{ __('Confirm Password') }}<span class="text-red">*</span></label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" style="border: 1px solid;padding: 0.5rem;">
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
