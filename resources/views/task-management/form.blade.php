<div class="row mx-4">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Title') }} <span class="text-red">*</span></label>
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $task->title) }}" autocomplete="name" autofocus placeholder="Name">

            @error('title')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('Due Date') }} <span class="text-red">*</span></label>
            {{-- <span class="fdr" placeholder="{{$task->due_date ?? "Due Date"}}">
                <input type="datetime-local" name="due_date"  value="{{$task->due_date}}" class="form-control @error('due_date') is-invalid @enderror fdr" placeholder="Due Date">
            </span> --}}
            <input id="due_date" type="datetime-local" class="form-control @error('due_date') is-invalid @enderror " name="due_date" value="{{ old('due_date', $task->due_date) }}" autocomplete="due_date" autofocus placeholder="Due Date">

            @error('due_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="col-md-12 my-3">
        <div class="form-group">
            <label>{{ __('Description') }} <span class="text-red">*</span></label>
            <textarea class="form-control @error('description') is-invalid @enderror" rows="7" cols="30" id="description" name="description" placeholder="Description">{{$task->description}}</textarea>
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

