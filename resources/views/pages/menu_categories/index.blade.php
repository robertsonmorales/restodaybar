@extends('layouts.app')
@section('title', $title)

@section('content')
@include('includes.alerts')

<div class="content mx-4">
    <!-- filter -->
    <div class="filters-section flex-column flex-md-row p-4">
        <div class="filters-child mb-3 mb-md-0">
            @include('includes.pagesize')
        </div>
        <div class="filters-child">
            <div class="position-relative mr-2">
                <input type="text" name="search-filter" class="form-control font-size-sm" id="search-filter" placeholder="Search here..">
                <span class="position-absolute icon"><i data-feather="search"></i></span>
            </div>a

            <div class="btn-group">
                <button class="btn text-dark btn-dropdown rounded d-flex align-items-center font-size-sm" data-toggle="dropdown">
                    <span>Actions</span>
                    <span class="ml-2"><i data-feather="chevron-down"></i></span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
                    <a href="{{ route($create) }}" class="dropdown-item py-2">
                        <span>Add New Record</span>
                    </a>

                    <button class="dropdown-item py-2" id="btn-import">
                        <span>Import CSV</span>
                    </button>

                    <button class="dropdown-item py-2" id="btn-export">
                        <span>Export as CSV</span>                        
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- ends here -->

    <div id="myGrid" class="ag-theme-material"></div>
</div>

@include('includes.modal')
@include('includes.modal-import')

<br>
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
        headerName: 'CONTROLS',
        field: 'controls',
        sortable: false,
        filter: false,
        editable: false,
        maxWidth: 220,
        minWidth: 210,
        // pinned: 'left',
        cellRenderer: function(params){
            var edit_url = '{{ route("menu_categories.edit", ":id") }}';
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

    for (var i = data.column.length - 1; i >= 0; i--) {       
        if (data.column[i].field == "color_tag") {
            data.column[i].cellRenderer = function display(params) {
                if (params.data.color_tag) {
                    return renderTag(params.data.color_tag);
                }
            }
        }
    }

    function renderTag(color){
        return "<span class='badge text-white p-2 font-size-sm' style='background-color: " + color + ";'>" + color + "</span>";
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
        document.getElementById("import-form-submit").action = "{{ route('menu_categories.import') }}";
        document.getElementById("import-form-submit").submit(); 
    });
    // ends here

    $("#btn-cancel").on('click', function(){
        $('.modal').hide();
    });

    $('#btn-remove').on('click', function(){
        var destroy = '{{ route("menu_categories.destroy", ":id") }}';
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