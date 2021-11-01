@extends('layouts.app')
@section('title', $title)

@section('content')
<form action="{{ ($mode == 'update') ? route('user_levels.update', $data->id) : route('user_levels.store') }}"
    method="POST"
    class="d-flex flex-column align-items-center mx-4"
    id="card-form"
    enctype="multipart/form-data">
    <div class="mb-4 card col-md-12 p-4">
        @csrf

        <div class="w-100">
            <h5>{{ ucfirst($mode).' '.\Str::Singular($title) }}</h5>
        </div>

        <div class="input-group">
            <label for="name">User Level Name</label>
            <input type="text"
            name="name" 
            id="name" 
            autocomplete="name" 
            class="form-control @error('name') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->name : old('name')}}"
            required autofocus>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="name">User Level Code</label>
            <input type="text"
            name="code" 
            id="code" 
            autocomplete="code" 
            class="form-control @error('code') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->code : old('code')}}"
            required autofocus>

            @error('code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="input-group">
            <label for="name">Description</label>
            <input type="text"
            name="description" 
            id="description" 
            autocomplete="description" 
            class="form-control @error('description') is-invalid @enderror"
            value="{{($mode == 'update') ? $data->description : old('description')}}"
            required autofocus>

            @error('description')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="status">Status</label>
            <select name="status" 
            id="status" 
            class="custom-select form-control @error('status') is-invalid @enderror"
            required>
                <option value="1" {{ ($mode == 'update' && $data->status == 1) ? 'selected' : '' }}>Active</option>
                <option value="0" {{ ($mode == 'update' && $data->status == 0) ? 'selected' : '' }}>In-active</option>
            </select>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
    </div>

    <div class="mb-4 card col-md-12 p-4">
        <div class="w-100">
            <h5>Module Permissions</h5>
        </div>

        <table class="table table-borderless">
            <tbody>
            @foreach($nav as $key => $value)
                <tr>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="allow-modules[]" id="allow-modules-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="allow-modules-{{ $key }}">{{ $value['nav_name'] }} @if($value['nav_type'] == 'single') <span class="font-size-sm" style="color: #bbb;">{{ $value['nav_route'] }}</span> @endif</label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="create[]" id="create-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="create-{{ $key }}"><span class="font-size-sm" style="color: #bbb;">Create</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="edit[]" id="edit-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="edit-{{ $key }}"><span class="font-size-sm" style="color: #bbb;">Edit</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="delete[]" id="delete-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="delete-{{ $key }}"><span class="font-size-sm" style="color: #bbb;">Delete</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="import[]" id="import-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="import-{{ $key }}"><span class="font-size-sm" style="color: #bbb;">Import</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="export[]" id="export-{{ $key }}" value="{{ $value['id'] }}">
                                    <label class="custom-control-label" for="export-{{ $key }}"><span class="font-size-sm" style="color: #bbb;">Export</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>

                @if(isset($value['sub']))
                @foreach($value['sub'] as $k => $sub)
                <tr>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" class="custom-control-input" name="allow-submodules[]" id="allow-submodules-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="allow-submodules-{{ $key.$k }}">{{ $sub['nav_name'] }} <span class="font-size-sm" style="color: #bbb;">{{ $sub['nav_route'] }}</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="create[]" id="create-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="create-{{ $key.$k }}"><span class="font-size-sm" style="color: #bbb;">Create</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="edit[]" id="edit-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="edit-{{ $key.$k }}"><span class="font-size-sm" style="color: #bbb;">Edit</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="delete[]" id="delete-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="delete-{{ $key.$k }}"><span class="font-size-sm" style="color: #bbb;">Delete</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="import[]" id="import-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="import-{{ $key.$k }}"><span class="font-size-sm" style="color: #bbb;">Import</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="form-group row mb-0">
                            <div class="col">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" name="export[]" id="export-{{ $key.$k }}" value="{{ $sub['id'] }}">
                                    <label class="custom-control-label" for="export-{{ $key.$k }}"><span class="font-size-sm" style="color: #bbb;">Export</span></label>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @endforeach
                @endif
            @endforeach
            </tbody>
        </table>

        @if ($mode == 'update')
        @method('PUT')
        <input type="hidden" name="id" value="{{ ($mode == 'update') ? $data->id: ''}}">
        @endif

        <div class="actions w-100">
            <a href="{{ route('user_levels.index') }}" class="btn btn-outline-primary mr-1" id="btn-back">Back</a>
            <button type="reset" class="btn btn-outline-primary mr-1" id="btn-reset">Reset</button>
            <button type="submit" class="btn btn-primary" id="btn-submit">{{ ($mode == 'update') ? 'Submit Changes' : 'Submit' }}</button>
        </div>
    </div>
</form>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    $('#card-form').on('submit', function(event){
        // if($("#card-form")[0].checkValidity() === false){
        //     event.preventDefault();
        //     event.stopPropagation();
        // }

        // $('#card-form')[0].classList.add('was-validated');


        var mode = "{{ $mode }}";
        
        $('#btn-submit').prop('disabled', true);
        $('#btn-reset').prop('disabled', true);
        $('#btn-back').prop('disabled', true);
        $('#btn-submit').css('cursor', 'not-allowed');
        $('#btn-reset').css('cursor', 'not-allowed');
        $('#btn-back').css('cursor', 'not-allowed');

        $('#btn-submit').html((mode == "update") ? "Submitting Changes.." : "Submitting..");

        $(this).submit();
    });
});
</script>
@endsection