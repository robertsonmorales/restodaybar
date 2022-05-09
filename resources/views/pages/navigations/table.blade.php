<div id="ifMainNavigation" style="display: none;">
    <button class="btn btn-primary mb-3" id="btn-new-row" type="button">
        <i data-feather="plus"></i>
        <span class="ml-1">Add New Row</span>
    </button>
    <input type="hidden" name="rows" id="rows" value="{{ ($mode == 'update') ? $rows : '1' }}">

    <div class="alert alert-warning alert-dismissible fade show alerts d-none mb-3 px-3 py-2" 
    role="alert">
        <span class="font-size-sm">
            <i data-feather="alert-triangle"></i>
            <span id="max-add-row"></span>
        </span>
        <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
        </button>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col" class="font-weight-500">Name</th>
                <th scope="col" class="font-weight-500">Route</th>
                <th scope="col" class="font-weight-500">Controller</th>
                <th scope="col" class="font-weight-500">Order</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody id="table-tbody">
            @if($mode == "create")

            <tr>
                <td>
                    <input type="text" class="form-control" name="sub_name[]" id="sub_name" autocomplete="off">
                    @error('sub_name.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_route[]" id="sub_route" autocomplete="off">
                    @error('sub_route.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_controller[]" id="sub_controller" autocomplete="off">
                    @error('sub_controller.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_order[]" id="sub_order" autocomplete="off" maxlength="2" value="1" readonly>
                    @error('sub_order.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    {{-- <button title="Remove row" class="btn btn-remove" type="button">
                        <i data-feather="x"></i>
                    </button> --}}
                </td>
            </tr>

            @elseif($mode == "update")
            @foreach($sub as $val)
            <tr>
                <td>
                    <input type="text" class="form-control" name="sub_name[]" id="sub_name" autocomplete="off" value="{{ $val['nav_name'] }}">
                    @error('sub_name.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_route[]" id="sub_route" autocomplete="off" value="{{ $val['nav_route'] }}">
                    @error('sub_route.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_controller[]" id="sub_controller" autocomplete="off" value="{{ str_replace('\\', '/', $val['nav_controller']) }}">
                    @error('sub_controller.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <input type="text" class="form-control" name="sub_order[]" id="sub_order" autocomplete="off" maxlength="2" value="{{ $val['nav_suborder'] }}" readonly>
                    @error('sub_order.*')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </td>
                <td>
                    <button title="Remove Navigation" class="btn btn-danger btn-remove" type="button">
                        <i data-feather="trash"></i>
                    </button>
                </td>
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>