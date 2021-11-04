@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-grid.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-theme_material.css') }}">
@endsection

@section('content')
<div class="content mx-4">
    @include('includes.filter')

    <div id="myGrid" class="ag-theme-material"></div>
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