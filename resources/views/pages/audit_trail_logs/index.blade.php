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
    data = JSON.parse(data);

initAgGrid(data);

</script>
@endsection