@extends('layouts.app')
@section('title', $title)

@section('content')
<form action="{{ $url }}"
    method="POST"
    class="d-flex flex-column align-items-center mx-4"
    id="card-form">

    <div class="mb-4 card col-md-6 p-4">    
        @csrf
        <div class="w-100">
            <h5>{{ $title }}</h5>
        </div>

        <div class="input-group">
            <label for="module_name">Name</label>
            <input type="text" 
                name="module_name" 
                id="module_name" 
                autocomplete="off"
                class="form-control @error('module_name') is-invalid @enderror"
                value="{{ ($mode == "update") ? $data->module_name : old('module_name') }}"
                required>

            @error('module_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if ($mode == 'update')
        @method('PUT')
        <input type="hidden" 
            name="id" 
            value="{{ ($mode == 'update') ? $data->id : ''}}">
        @endif

        <input type="hidden" id="mode" value="{{ $mode }}">
        <input type="hidden" id="index_page" value="{{ route('module_management.index') }}">

        <div class="actions w-100">
            <button type="button" 
            class="btn btn-outline-secondary mr-1" 
            id="btn-back">Back</button>

            <button type="reset"
            class="btn btn-outline-secondary mr-1" 
            id="btn-reset">Reset</button>

            <button type="submit"
            class="btn btn-primary" 
            id="btn-submit">{{ ($mode == 'update') ? 'Submit Changes' : 'Submit' }}</button>
        </div>
    </div>
</form>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
    var mode = $('#mode').val();
    var index_page = $('#index_page').val();

    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });
</script>
@endsection