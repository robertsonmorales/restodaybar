@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-grid.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/ag-grid/ag-theme_material.css') }}">
@endsection

@section('content')
@include('includes.alerts')

<div class="content mx-4">
    @include('includes.filter')

    <div id="myGrid" class="ag-theme-material"></div>
</div>

@include('includes.modal')
@include('includes.modal-import')

<br>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('vendors/ag-grid/ag-grid.js') }}"></script>
@endsection

@section('scripts')
<script>
$(document).ready(function(){
    var data = @json($data, JSON_PRETTY_PRINT);
    var icon_for = @json($icon_for, JSON_PRETTY_PRINT);
        data = JSON.parse(data);

    var gridDiv = document.querySelector('#myGrid');

    var columnDefs = [];
    columnDefs = {
        headerName: 'ACTIONS',
        field: 'actions',
        sortable: false,
        filter: false,
        editable: false,
        maxWidth: 220,
        minWidth: 150,
        pinned: 'left',
        cellRenderer: function(params){
            var edit_url = '{{ route("navigations.edit", ":id") }}';
            edit_url = edit_url.replace(':id', params.data.id);

            var eDiv = document.createElement('div');
            eDiv.className = "d-flex align-items-center";

            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Edit" class="btn btn-controls btn-primary btn-edit ml-1">'+ icon_for['edit'] +'</button>&nbsp;&nbsp;';
            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Delete" class="btn btn-controls btn-danger btn-remove">'+ icon_for['remove'] +'</button>&nbsp;';

            var btn_edit = eDiv.querySelectorAll('.btn-edit')[0];
            var btn_remove = eDiv.querySelectorAll('.btn-remove')[0];

            btn_edit.addEventListener('click', function() {
                window.location.href = edit_url;
            });

            btn_remove.addEventListener('click', function() {
                var data_id = $(this).attr("id");
                $('#form-submit').attr('style', 'display: flex;');
                $('.modal-content').attr('id', params.data.id);
            });
            
            return eDiv;
        }
    };

    data.column.push(columnDefs);    

    var gridOptions = {
        defaultColDef: {
            sortingOrder: ['desc', 'asc', null],
            resizable: true,
            sortable: true,
            filter: true,
            editable: false,
            minWidth: 140,
        },
        columnDefs: data.column,
        rowData: data.rows,
        groupSelectsChildren: true,
        suppressRowTransform: true,
        enableCellTextSelection: true,
        rowHeight: 55,
        animateRows: true,
        pagination: true,
        paginationPageSize: 25,
        pivotPanelShow: "always",
        colResizeDefault: "shift",
        rowSelection: "multiple",
        onGridReady: function () {
            autoSizeAll();
            // gridOptions.api.sizeColumnsToFit();
            gridOptions.columnApi.moveColumn('actions', 0);
        }
    };

    function autoSizeAll(skipHeader) {
        var allColumnIds = [];
        gridOptions.columnApi.getAllColumns().forEach(function(column) {
            allColumnIds.push(column.colId);
        });

        gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);
    }

    // export as csv
    $('#btn-export').on('click', function(){
        gridOptions.api.exportDataAsCsv();
    });

    function search(data) {
      gridOptions.api.setQuickFilter(data);
    }

    $("#search-filter").on("keyup", function() {
      search($(this).val());
    });

    // change page size
    function pageSize(value){
        gridOptions.api.paginationSetPageSize(value);
    }

    // PAGE SIZE
    $("#pageSize").change(function(){
        var size = $(this).val();
        pageSize(size);
    });

    // setup the grid after the page has finished loading
    new agGrid.Grid(gridDiv, gridOptions);

    // import
    $('#import_file').on('change', function(){
        if($(this)[0].files.length == 0){
            $('#btn-import-submit').prop('disabled', true);
            $('#btn-import-submit').css('cursor', 'not-allowed');
        }else{
            $('#btn-import-submit').prop('disabled', false);
            $('#btn-import-submit').css('cursor', 'pointer');
        }
    });

    $('#btn-import').on('click', function(){
        $('#import-form-submit').attr('style', 'display: flex;');

        if($('#import_file')[0].files.length == 0){
            $('#btn-import-submit').prop('disabled', true);
            $('#btn-import-submit').css('cursor', 'not-allowed');
        }else{
            $('#btn-import-submit').prop('disabled', false);
            $('#btn-import-submit').css('cursor', 'pointer');
        }
    });

    $('#btn-import-cancel').on('click', function(){
        $('#import-form-submit').hide();
        $('#btn-import-submit').html("Import File");
    });

    $('#btn-import-submit').on('click', function(){
        $('#btn-import-cancel').prop('disabled', true);
        $(this).prop('disabled', true);
        $(this).html("Importing File..");
        document.getElementById("import-form-submit").action = "{{ route('navigations.import') }}";
        document.getElementById("import-form-submit").submit(); 
    });
    // ends here

    // remove
    $('#btn-cancel').on('click', function(){
        $('#form-submit').hide();
    });

    $('#btn-remove').on('click', function(){
        var destroy = '{{ route("navigations.destroy", ":id") }}';
        url = destroy.replace(':id', $('.modal-content').attr('id'));

        $('#btn-cancel').prop('disabled', true);
        $('#btn-remove').prop('disabled', true);
        $('#btn-cancel').css('cursor', 'not-allowed');
        $('#btn-remove').css('cursor', 'not-allowed');
        
        $('#btn-remove').html("Removing...");

        document.getElementById("form-submit").action = url;
        document.getElementById("form-submit").submit();
    });
    // ends here
});
</script>
@endsection