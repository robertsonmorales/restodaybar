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
            <h5>{{ ucfirst($mode).' '.\Str::Singular($title) }}</h5>
        </div>

        <div class="input-group">
            <label for="name">Name</label>
            <input type="text" 
                name="name" 
                id="name" 
                autocomplete="off"
                class="form-control @error('name') is-invalid @enderror"
                value="{{ ($mode == "update") ? $data->name : old('name') }}"
                required>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="no_seats">No. of Seats</label>
            <input type="text" 
                name="no_seats" 
                id="no_seats" 
                autocomplete="off"
                class="form-control @error('no_seats') is-invalid @enderror"
                value="{{ ($mode == "update") ? $data->no_seats : old('no_seats') }}"
                required>

            @error('no_seats')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="status">Status</label>
            <select name="status" 
                id="status" 
                class="custom-select form-control @error('status') is-invalid @enderror"
                required>
                <option value="1" {{ ($mode == 'update' && $data->status == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($mode == 'update' &&  $data->status == 0) ? 'selected' : '' }}>In-active</option>
            </select>

            @error('status')
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
    var mode = @json($mode);
    var index_page = @json(route('table_management.index'));

    $(() => {
        $('.select2-selection--single').addClass('form-control');

        $('#card-form').on('submit', function(){
            $('.actions button').prop('disabled', true);
            $('.actions button').css('cursor', 'not-allowed');

            $('#btn-submit').html((mode == "update") ? "Submitting Changes.." : "Submitting..");

            $(this).submit();
        });
    });

    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });
</script>
@endsection