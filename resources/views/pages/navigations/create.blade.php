@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
@endsection

@section('content')
<form action="{{ ($mode == 'update') ? route('navigations.update', $data->id) : route('navigations.store') }}"
    method="POST"
    class="d-flex flex-column align-items-center mx-4"
    id="card-form"
    enctype="multipart/form-data">
    <div class="mb-4 card col-md-8 p-4">
        @csrf

        <div class="w-100">
            <h5>{{ ucfirst($mode).' '.\Str::Singular($title) }}</h5>
        </div>

        <div class="input-group">
            <label for="name">Name</label>
            <input type="text"
            name="name" 
            id="name" 
            autocomplete="name" 
            class="form-control @error('name') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->nav_name : old('name')}}"
            required autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="route">Route</label>
            <input type="text"
            name="route" 
            id="route" 
            autocomplete="route" 
            class="form-control @error('route') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->nav_route : old('route')}}"
            required>

            @error('route')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="icon">Icon</label>

            <select name="icon" 
            id="icon" 
            class="custom-select form-control @error('category_icon') is-invalid @enderror" 
            required>
                <option value="" style="display: none;">Select icon...</option>
            </select>

            @error('icon')
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
                <option value="0" {{ ($mode == 'update' && $data->status == 0) ? 'selected' : '' }}>In-active</option>
            </select>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="type">Type</label>
            <select name="type" 
            id="type" 
            class="custom-select form-control @error('type') is-invalid @enderror"
            required>
                <option value="single" {{ ($mode == 'update' && $data->nav_type == 'single') ? 'selected' : '' }}>Single</option>
                <option value="main" {{ ($mode == 'update' && $data->nav_type == 'main') ? 'selected' : '' }}>Main</option>
                <option value="sub" {{ ($mode == 'update' && $data->nav_type == 'sub') ? 'selected' : '' }}>Sub</option>
            </select>

            @error('type')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group controller">
            <label for="controller">Controller</label>
            <input type="text"
            name="controller" 
            id="controller" 
            autocomplete="controller" 
            class="form-control @error('controller') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->nav_controller : old('controller')}}"
            required>

            @error('controller')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @include('pages.navigations.table')

        @if ($mode == 'update')
        @method('PUT')
        <input type="hidden" name="id" value="{{ ($mode == 'update') ? $data->id: ''}}">
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
$(function(){
    var mode = @json($mode);
    var index_page = @json(route('navigations.index'));
    
    $('.select2-selection--single').addClass('form-control');

    $('#type').on('change', function(){
        if ($(this).val() == "main"){
            $('#ifMainNavigation').show(500);
            $('.route').hide(500);
            $('.controller').hide(500);

            $('#table-tbody input').attr('required', true);
            $('#controller').attr('required', false);
        }else{
            $('#ifMainNavigation').hide(500);
            $('.route').show(500);
            $('.controller').show(500);

            $('#table-tbody input').attr('required', false);
            $('#controller').attr('required', true);
        }
    });

    $('#btn-new-row').on('click', function(){
        var x = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>';
        var btnRemovesLength = document.getElementsByClassName('btn-remove').length;
        var tbodyLength = $("#table-tbody").children().length;
        var maxAddRow = 5;
        var row_container = '\
            <tr>\
                <td>\
                    <input type="text" class="form-control" name="sub_name[]" id="sub_name" autocomplete="off">\
                    @error("sub_name.*")\
                    <span class="invalid-feedback" role="alert">\
                        <strong>{{ $message }}</strong>\
                    </span>\
                    @enderror\
                </td>\
                <td>\
                    <input type="text" class="form-control" name="sub_route[]" id="sub_route" autocomplete="off">\
                    @error("sub_route.*")\
                    <span class="invalid-feedback" role="alert">\
                        <strong>{{ $message }}</strong>\
                    </span>\
                    @enderror\
                </td>\
                <td>\
                    <input type="text" class="form-control" name="sub_controller[]" id="sub_controller" autocomplete="off">\
                    @error("sub_controller.*")\
                    <span class="invalid-feedback" role="alert">\
                        <strong>{{ $message }}</strong>\
                    </span>\
                    @enderror\
                </td>\
                <td>\
                    <input type="text" class="form-control" name="sub_order[]" id="sub_order" autocomplete="off" maxlength="2" value="'+ (btnRemovesLength + 2) +'" readonly>\
                    @error("sub_order.*")\
                    <span class="invalid-feedback" role="alert">\
                        <strong>{{ $message }}</strong>\
                    </span>\
                    @enderror\
                </td>\
                <td>\
                    <button title="Remove Row" class="btn btn-remove btn-remove-'+btnRemovesLength+'" onclick="removeRow('+btnRemovesLength+')" type="button">'+ x +'</button>\
                </td>\
            </tr>';
        if (tbodyLength < maxAddRow){
            $('#table-tbody').append(row_container);
            $('#rows').val(tbodyLength + 1);
        }else{
            $(this).prop('disabled', true);
            $(this).css('cursor', 'not-allowed');
            $('#max-add-row').text('You have reached the maximum number of adding rows.');
            $('.alerts').removeClass('d-none');
        }
    });
    
    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });

    $('#btn-reset').on('click', function(){
        $('#ifMainNavigation').hide(500);
        $('.route').show(500);
        $('.controller').show(500);
    });

    $('#card-form').on('submit', function(){
        var mode = "{{ $mode }}";
        
        $('.actions button').prop('disabled', true);
        $('.actions button').css('cursor', 'not-allowed');

        $('#btn-submit').html((mode == "update") ? "Submitting Changes.." : "Submitting..");

        $(this).submit();
    });
});

function redirect(route){
    window.location.href = route;
}

function getIcons(){
    $.get('{{ asset("js/icons.json") }}',function(icons){
        $.each(icons, function(index, value){
            var options = "<option data-select2-id='"+index+"' data-select2-svg='"+ value +"' value='"+index+"'>"+index+"</option>";
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

function removeRow(rowIndex){
    var tbodyLength = $("#table-tbody").children().length;
    $('.btn-remove-'+rowIndex).parent().parent().remove();

    $('#btn-new-row').prop('disabled', false);
    $('#btn-new-row').css('cursor', 'pointer');
    $('#max-add-row').empty();
    $('.alerts').addClass('d-none');

    $('#rows').val(tbodyLength - 1);
}

function checkNavType(){
    if ($('#type').val() == "main"){
        $('#ifMainNavigation').show(500);
        $('.route').hide(500);
        $('.controller').hide(500);

        $('#table-tbody input').attr('required', true);
        $('#controller').attr('required', false);
    }else{
        $('#ifMainNavigation').hide(500);
        $('.route').show(500);
        $('.controller').show(500);

        $('#table-tbody input').attr('required', false);
        $('#controller').attr('required', true);
    }
}

getIcons();
checkNavType();

</script>
@endsection