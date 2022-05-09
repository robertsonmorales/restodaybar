@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-grid.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-theme_material.css') }}">
@endsection

@section('content')
<x-atoms.alert />

<div class="content mx-4">
    <x-molecules.table-filter
        :pagesize="$pagesize"
        :route="route($create)" />

    <x-atoms.ag-grid />
</div>

<x-molecules.modal />

@include('includes.modal-import')

<br>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('vendors/ag-grid/ag-grid.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/index.js') }}"></script>

<script type="text/javascript">
var data = @json($data, JSON_PRETTY_PRINT);
var icon = @json($icon_for, JSON_PRETTY_PRINT);
    data = JSON.parse(data);

var editURL = '{{ route("menus.edit", ":id") }}';
var removeURL = '{{ route("menus.destroy", ":id") }}';
var importURL = '{{ route("menus.import") }}';

initAgGrid(data, icon, true, editURL);

// IMPORT
$('#btn-import-submit').on('click', function(){
    $('#btn-import-cancel').prop('disabled', true);
    $(this).prop('disabled', true);
    $(this).html("Uploading File..");

    $('#import-form-submit').prop("action", importURL).submit();
});
// ENDS HERE

// BUTTON REMOVE
$('#btn-remove').on('click', function(){
    var url = removeURL.replace(':id', $('.modal-content').attr('id'));

    $('.modal-footer button').prop('disabled', true);
    $('.modal-footer button').css('cursor', 'not-allowed');

    $(this).html("Removing...");

    $('#form-submit').prop('action', url).submit();
});
// ENDS HERE

</script>
@endsection