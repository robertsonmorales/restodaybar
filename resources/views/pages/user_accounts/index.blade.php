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
        headerName: 'Controls',
        field: 'controls',
        sortable: false,
        filter: false,
        editable: false,
        maxWidth: 230,
        minWidth: 220,
        pinned: 'left',
        cellRenderer: function(params){
            var lock_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';
            var email_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>';

            icon_for['lock_icon'] = lock_icon;
            icon_for['email_icon'] = email_icon;

            var edit_url = '{{ route("user_accounts.edit", ":id") }}';
            edit_url = edit_url.replace(':id', params.data.id);

            var eDiv = document.createElement('div');
            eDiv.className = "d-flex align-items-center";

            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Edit" class="btn btn-controls btn-primary btn-edit ml-1">'+ icon_for['edit'] +'</button>&nbsp;&nbsp;';
            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Email" class="btn btn-controls btn-success btn-email text-white">'+ icon_for['email_icon'] +'</button>&nbsp;&nbsp;';
            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Lock" class="btn btn-controls btn-warning btn-lock text-white">'+ icon_for['lock_icon'] +'</button>&nbsp;&nbsp;';
            eDiv.innerHTML+='<button id="'+params.data.id+'" title="Delete" class="btn btn-controls btn-danger btn-remove">'+ icon_for['remove'] +'</button>';

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

    for (var i = data.column.length - 1; i >= 0; i--) {       
        // if (data.column[i].field == "account_status") {
        //     data.column[i].cellRenderer = function display(params) {
        //         if (params.data.account_status == "Active") {
        //             return '<div class="badge border border-success text-success p-1 font-size-sm">'+ params.data.account_status +'</div>';
        //         }else if (params.data.account_status == "Deactivated"){
        //             return '<div class="badge border border-dark text-secondary p-1 font-size-sm">'+ params.data.account_status +'</div>';
        //         }else if (params.data.account_status == "Locked"){
        //             return '<div class="badge border border-gray text-secondary p-1 font-size-sm">'+ params.data.account_status +'</div>';
        //         }
        //     }
        // }

        if (data.column[i].field == "created_at") {
            data.column[i].cellRenderer = function display(params) {
                if (params.data.created_at) {
                    return getNewDateTime(params.data.created_at);
                }
            }
        }

        if (data.column[i].field == "updated_at") {
            data.column[i].cellRenderer = function display(params) {
                if (params.data.updated_at) {
                    return getNewDateTime(params.data.updated_at);
                }
            }
        }
    }

    function getNewDateTime(format){
        date = new Date(format); //'2013-08-0302:00:00Z'
        year = date.getFullYear();
        month = date.getMonth()+1;
        today = date.getDate();
        hours = date.getHours();
        minutes = date.getMinutes();
        seconds = date.getSeconds();

        if (month < 10) {month = '0' + month;}
        if (today < 10) {today = '0' + today;}
        if (hours < 10) {hours = '0' + hours;}
        if (minutes < 10) {minutes = '0' + minutes;}
        if (seconds < 10) {seconds = '0' + seconds;}
        return year + '-' + month + '-' + today + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    data.column.push(columnDefs);

    var gridOptions = {
        defaultColDef: {
            sortingOrder: ['desc', 'asc', null],
            resizable: true,
            sortable: true,
            filter: true,
            editable: false,
            flex: 1,
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
            gridOptions.columnApi.moveColumn('controls', 0);
        }
    };

    function autoSizeAll(skipHeader) {
        var allColumnIds = [];
        gridOptions.columnApi.getAllColumns().forEach(function(column) {
            allColumnIds.push(column.colId);
        });

        gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);
    }

    // EXPORT AS CSV
    $('#btn-export').on('click', function(){
        gridOptions.api.exportDataAsCsv();
    });
    // ENS HERE

    // SEARCH HERE
    function search(data) {
      gridOptions.api.setQuickFilter(data);
    }

    $("#search-filter").on("keyup", function() {
      search($(this).val());
    });
    // ENDS HERE

    // PAGE SIZE
    function pageSize(value){
        gridOptions.api.paginationSetPageSize(value);
    }

    $("#pageSize").change(function(){
        var size = $(this).val();
        pageSize(size);
    });
    // ENDS HERE

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
        document.getElementById("import-form-submit").action = "{{ route('user_levels.import') }}";
        document.getElementById("import-form-submit").submit(); 
    });
    // ends here

    $("#btn-cancel").on('click', function(){
        $('.modal').hide();
    });

    $('#btn-remove').on('click', function(){
        var destroy = '{{ route("user_accounts.destroy", ":id") }}';
        url = destroy.replace(':id', $('.modal-content').attr('id'));

        $('#btn-cancel').prop('disabled', true);
        $('#btn-remove').prop('disabled', true);
        $('#btn-cancel').css('cursor', 'not-allowed');
        $('#btn-remove').css('cursor', 'not-allowed');

        $('#btn-remove').html("Removing...");

        document.getElementById("form-submit").action = url;
        document.getElementById("form-submit").submit();
    });
});
</script>
@endsection