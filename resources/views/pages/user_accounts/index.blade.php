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

var editURL = '{{ route("user_accounts.edit", ":id") }}';
var removeURL = '{{ route("user_accounts.destroy", ":id") }}';
var importURL = '{{ route("user_accounts.import") }}';

// icon['lock_icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';
// icon['email_icon'] = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>';

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