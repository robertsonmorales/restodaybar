var defaultColDef = {
    sortingOrder: ['desc', 'asc', null],
    resizable: true,
    sortable: true,
    filter: true,
    editable: false,
    flex: 1,
};

var gridOptions = {
    defaultColDef: defaultColDef,
    columnDefs: {},
    rowData: {},
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
    api: "",
    columnApi: "",
    onGridReady: function () {
        autoSizeAll();
        // gridOptions.api.sizeColumnsToFit();
        gridOptions.columnApi.moveColumn('controls', 0);
    }
};

// IMPORT
$('#import_file').on('change', function(){
    var btnSubmit = $('#btn-import-submit');

    if($(this)[0].files.length == 0){
        btnSubmit.prop('disabled', true);
        btnSubmit.css('cursor', 'not-allowed');
    }else{
        btnSubmit.prop('disabled', false);
        btnSubmit.css('cursor', 'pointer');
    }
});

$('#btn-import').on('click', function(){
    $('#import-form-submit').attr('style', 'display: flex;');

    // if($('#import_file')[0].files.length == 0){
    //     $('#btn-import-submit').prop('disabled', true);
    //     $('#btn-import-submit').css('cursor', 'not-allowed');
    // }else{
    //     $('#btn-import-submit').prop('disabled', false);
    //     $('#btn-import-submit').css('cursor', 'pointer');
    // }
});

$('#btn-import-cancel').on('click', function(){
    $('#import-form-submit').hide();
});

$("#btn-cancel").on('click', function(){
    $('.modal').hide();
});

$(".btn-dismiss").on('click', function(){
    $("#btn-cancel").trigger('click');
});

// ENDS HERE

function initAgGrid(data, icons='', showControls=false, url=''){
    const aggrid = document.querySelector('#myGrid');
    var width = 150;
    var minWidth = 140;

    if(showControls === true){
        var columnDefs = {
            headerName: 'Controls',
            field: 'controls',
            sortable: false,
            filter: false,
            editable: false,
            flex: 1,
            maxWidth: 250,
            minWidth: 230,
            pinned: 'left',
            cellRenderer: function(params){
                var editURL = url.replace(':id', params.data.id);
                var el = document.createElement('div');
                el.className = "d-flex align-items-center";

                el.innerHTML +='<button id="'+params.data.id+'" title="Edit" class="btn btn-edit ml-1">'+ icons['edit'] + ' <span class="ml-1" style="font-size:13px;">Edit</span></button>&nbsp;&nbsp;';

                // Button Control Add-Ons
                // switch (window.location.pathname) {
                //     case '/user_accounts':
                //         el.innerHTML +='<button id="'+params.data.id+'" title="Email" class="btn btn-controls btn-success btn-email">'+ icons['email_icon'] +'</button>&nbsp;&nbsp;';
                //         el.innerHTML +='<button id="'+params.data.id+'" title="Lock User" class="btn btn-controls btn-warning btn-lock text-white">'+ icons['lock_icon'] +'</button>&nbsp;&nbsp;';
                //         break;
                //     default:
                //         break;
                // }
                // Ends here

                el.innerHTML +='<button id="'+params.data.id+'" title="Remove" class="btn btn-remove mr-1">'+ icons['remove'] +' <span class="ml-1" style="font-size:13px;">Remove</span></button>';

                var btnEdit = el.querySelectorAll('.btn-edit')[0];
                var btnRemove = el.querySelectorAll('.btn-remove')[0];

                btnEdit.addEventListener('click', function() {
                    window.location.href = editURL;
                });

                btnRemove.addEventListener('click', function() {
                    $('#form-submit').attr('style', 'display: flex;');
                    $('.modal-content').attr('id', params.data.id);
                });
                
                return el;
            }
        };

        data.column.push(columnDefs);
    }

    gridOptions.columnDefs = data.column;
    gridOptions.rowData = data.rows;

    // setup the grid after the page has finished loading
    new agGrid.Grid(aggrid, gridOptions);
}

function autoSizeAll(skipHeader) {
    var allColumnIds = [];
    gridOptions.columnApi.getAllColumns().forEach(function(column) {
        allColumnIds.push(column.colId);
    });

    gridOptions.columnApi.autoSizeColumns(allColumnIds, skipHeader);
}

// SEARCH HERE
$("#search-filter").on("keyup", function() {
    search($(this).val());
});

function search(data) {
  gridOptions.api.setQuickFilter(data);
}
// ENDS HERE

// PAGE SIZE
$("#pageSize").on('change', function(){
    var size = $(this).val();
    pageSize(size);
});

function pageSize(value){
    gridOptions.api.paginationSetPageSize(value);
}
// ENDS HERE

// EXPORT AS CSV
$('#btn-export').on('click', function(){
    gridOptions.api.exportDataAsCsv();
});
// ENDS HERE