@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
@endsection

@section('content')
<form action="{{ ($mode == 'update') ? route('menu_categories.update', $data->id) : route('menu_categories.store') }}"
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
            <label for="name">Icon</label>
            <select name="icon" 
                id="icon" 
                class="custom-select form-control @error('icon') is-invalid @enderror">
                <option value="" style="display: none;">Select icon...</option>
            </select>

            @error('icon')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="input-group">
            <label for="name">Color Tag</label>
            <input type="color" 
                name="color_tag" 
                id="color_tag" 
                autocomplete="off"
                class="form-control @error('color_tag') is-invalid @enderror"
                value="{{ ($mode == 'update') ? $data->color_tag : old('color_tag') }}"
                required>

            @error('color_tag')
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
<script src="{{ asset('/vendors/select2/select2.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    var mode = @json($mode);
    var index_page = @json(route('menu_categories.index'));
    
    $('.select2-selection--single').addClass('form-control');

    $('#card-form').on('submit', function(){
        $('.actions button').prop('disabled', true);
        $('.actions button').css('cursor', 'not-allowed');

        $('#btn-submit').html((mode == "update") ? "Submitting Changes.." : "Submitting..");

        $(this).submit();
    });

    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });
});

$('#icon').select2({
  // ...
  templateSelection: function (data, container) {
    // Add custom attributes to the <option> tag for the selected option
    $(data.element).attr('data-custom-attribute', data.customValue);
    return data.text;
  }
});

// Retrieve custom attribute value of the first selected element
$('#icon').find(':selected').data('custom-attribute');

function getIcons(){
    var mode = "{{ $mode }}";
    var iconSelected = "{{ @$data->icon }}";

    $.get('{{ asset("js/icons.json") }}',function(icons){
        $.each(icons, function(index, value){
            var selected = (mode == "update" && index == iconSelected) ? "selected" : "";
            var options = "<option data-select2-id='"+ index +"' data-select2-svg='"+ value +"' value='"+ index +"' "+ selected +">"+ index +"</option>";
            $('#icon').append(options);
        });
    });
}

function formatIcons (icons) {
  if (!icons.id) {
    return icons.text;
  }

  var svg = icons.element.getAttribute('data-select2-svg');

  var $icons = $('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-'+ icons.text +'">'+ svg + '</svg><span class="ml-2">' + icons.text + '</span></span>');
  return $icons;
}

$('#icon').select2({
    placeholder: "Select icon...",
    templateResult: formatIcons
});

getIcons();
</script>
@endsection