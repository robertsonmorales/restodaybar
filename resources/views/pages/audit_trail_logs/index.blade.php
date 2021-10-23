@extends('layouts.app')
@section('title', $title)

@section('content')
<div class="content mx-4">
    <!-- filter -->
    <div class="filters-section flex-column flex-md-row p-4">
        <div class="filters-child mb-3 mb-md-0">
            <label for="pageSize" class="mb-0 mr-2 font-size-sm">Show</label>
            <select name="pageSize" id="pageSize" class="custom-select mr-2 font-size-sm">
                @for($i=0;$i < count($pagesize); $i++)
                    <option value="{{ $pagesize[$i] }}">{{ $pagesize[$i] }}</option>
                @endfor
                
            </select>
            <label for="pageSize" class="mb-0 font-size-sm">entries</label>
        </div>
        <div class="filters-child">
            <div class="position-relative mr-2">
                <input type="text" name="search-filter" class="form-control font-size-sm" id="search-filter" placeholder="Search here..">
                <span class="position-absolute icon"><i data-feather="search"></i></span>
            </div>

            <div class="btn-group">
                <button class="btn text-dark btn-dropdown rounded d-flex align-items-center font-size-sm" data-toggle="dropdown">
                    <span>Actions</span>
                    <span class="ml-2"><i data-feather="chevron-down"></i></span>
                </button>

                <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
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
<br>  
@endsection
@section('scripts')
<script>
$(document).ready(function(){
    var data = @json($data, JSON_PRETTY_PRINT);
    data = JSON.parse(data);

    // assign agGrid to a variable
    var gridDiv = document.querySelector('#myGrid');

    for (var i = data.column.length - 1; i >= 0; i--) {
        // if (data.column[i].field == "ip") {
        //     data.column[i].cellRenderer = function display(params) {
        //         return '<div class="badge border border-info text-info p-1 font-size-sm">'+ params.data.ip +'</div>';
        //     }
        // }

        if (data.column[i].field == "created_at") {
            data.column[i].cellRenderer = function display(params) {
                if (params.data.created_at) {
                    return getNewDateTime(params.data.created_at);
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
        }
    }

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
        // console.log(size);
        pageSize(size);
    });
    // ENDS HERE

    // setup the grid after the page has finished loading
    new agGrid.Grid(gridDiv, gridOptions);
});
</script>
@endsection