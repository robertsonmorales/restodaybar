<div class="filters-section flex-column flex-md-row p-4">
    <div class="filters-child mb-3 mb-md-0">
        <label for="pageSize" class="mb-0 mr-2 font-size-sm">Show</label>
        <select name="pageSize" id="pageSize" class="custom-select mr-2 font-size-sm">
            @for($i=0;$i < count($pagesize['options']); $i++)
            <option value="{{ $pagesize['options'][$i] }}">{{ $pagesize['options'][$i] }}</option>
            @endfor
        </select>
        <label for="pageSize" class="mb-0 font-size-sm">entries</label>
    </div>
    <div class="filters-child">
        <div class="position-relative mr-2">
            <input type="text" 
                name="search-filter" 
                class="form-control font-size-sm" 
                id="search-filter" 
                placeholder="Search here..">
            <span class="position-absolute icon"><i data-feather="search"></i></span>
        </div>

        <div class="btn-group">
            <button class="btn btn-dropdown rounded d-flex align-items-center font-size-sm"
                data-toggle="dropdown">
                <span>Actions</span>
                <span class="ml-2"><i data-feather="chevron-down"></i></span>
            </button>

            <div class="up-arrow"></div>
            <div class="dropdown-menu dropdown-menu-right mt-2 py-2">
                <a href="{{ $route }}"
                    class="dropdown-item py-2">Add New Record</a>
                <button class="dropdown-item py-2"
                    id="btn-import">Import CSV</button>
                <button class="dropdown-item py-2"
                    id="btn-export">Export as CSV</button>
                <button class="dropdown-item py-2"
                    id="btn-deleteAll">Delete All Records</button>
            </div>
        </div>
    </div>
</div>