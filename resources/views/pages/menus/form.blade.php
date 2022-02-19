@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
@endsection

@section('content')
<form action="{{ $url }}"
    method="POST"
    class="d-flex flex-column align-items-center mx-4"
    id="card-form"
    enctype="multipart/form-data">

    <div class="mb-4 card col-md-6 p-4">    
        @csrf
        <div class="w-100">
            <h5>{{ $subtitle }}</h5>
        </div>
        
        <div class="input-group">
            <label for="img_src">Image Thumbnail</label>
            <input type="file"
            accept=".png, .jpg, .jpeg, .gif"
            name="img_src" 
            id="img_src" 
            autocomplete="off"
            class="form-control @error('img_src') is-invalid @enderror"
            value="{{ ($mode == "update") ? $data->img_src : old('img_src') }}">

            <img id="img-preview" 
            width="200" 
            height="auto"
            class="{{ ($mode == 'update') ? 'border rounded mt-3' : '' }}" 
            src="{{ ($mode == 'update') ? asset($data->img_src) : '' }}"
            alt="{{ ($mode == 'update') ? $data->name : '' }}">

            @error('img_src')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="status">Category</label>
            <select name="category" 
            id="category" 
            class="custom-select form-control @error('category') is-invalid @enderror"
            required>
                <option value="" style="display: none;">Select category...</option>

                @foreach ($categories as $item)
                <option value="{{ $item->id }}"
                    {{ ($mode == 'update' && $item->id == $data->categoryMenu->menu_category_id)
                        ? 'selected'
                        : ''
                    }}>{{ $item->name }}</option>
                @endforeach
            </select>

            @error('category')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="status">Subcategory</label>
            <select name="subcategory" 
            id="subcategory" 
            class="custom-select form-control @error('subcategory') is-invalid @enderror"
            disabled></select>

            @error('subcategory')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="name">Name</label>
            <input type="text" 
            name="name" 
            id="name" 
            autocomplete="off"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ ($mode == "update") ? $data->name : old('name') }}"
            required>

            @error('name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="name">Price</label>
            <input type="text" 
            name="price" 
            id="price" 
            autocomplete="off"
            class="form-control @error('price') is-invalid @enderror"
            value="{{ ($mode == "update") ? $data->price : old('price') }}"
            required>

            @error('price')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" 
                class="custom-control-input" 
                name="is_processed_by_cook" 
                id="is_processed_by_cook"
                style="cursor: pointer;"
                {{ ($mode == 'update' && $data->is_processed_by_cook == 1) ? 'checked' : '' }}>
                <label class="custom-control-label font-size-sm" for="is_processed_by_cook">Process By Cook/Chef?</label>
            </div>

            @error('is_processed_by_cook')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" 
                class="custom-control-input" 
                name="is_inventoriable" 
                id="is_inventoriable"
                style="cursor: pointer;"
                {{ ($mode == 'update' && $data->is_inventoriable == 1) ? 'checked' : '' }}>
                <label class="custom-control-label font-size-sm" for="is_inventoriable">Inventoriable?</label>
            </div>

            @error('is_inventoriable')
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
                <option value="0" {{ ($mode == 'update' &&  $data->status == 0) ? 'selected' : '' }}>In-active</option>
            </select>

            @error('status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if ($mode == 'update')
        @method('PUT')
        <input type="hidden" 
            name="id" 
            value="{{ ($mode == 'update') ? $data->id : ''}}">
        @endif

        <div class="actions w-100">
            <button type="button" 
            class="btn btn-outline-secondary mr-1" 
            id="btn-back">Back</button>

            <button type="reset"
            class="btn btn-outline-secondary mr-1" 
            id="btn-reset">Reset</button>

            <button type="submit"
            class="btn btn-primary" 
            id="btn-submit">{{ ($mode == 'update') ? 'Submit Changes' : 'Submit' }}</button>
        </div>
    </div>
</form>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('/vendors/select2/select2.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
    var subcategories = @json($subcategories);
    var mode = @json($mode);
    var subcategory = @json(@$data);
    var index_page = @json(route('menus.index'));

    $(() => { $('.select2-selection--single').addClass('form-control'); });

    $('#img_src').on('change', function(){
        loadImage($(this).val());
    });

    $('#category').on('change', function(){
        getSubcategory($(this), $('#subcategory'));
    }).select2({
        placeholder: "Select category..."
    });

    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });

    $('#card-form').on('submit', function(){
        $('.actions button').prop('disabled', true);
        $('.actions button').css('cursor', 'not-allowed');

        $('#btn-submit').html((mode == "update") 
            ? "Submitting Changes.."
            : "Submitting.."
        );

        $(this).submit();
    });

    function loadImage(src){
        if(src != ""){
            var filename = src.split('\\').reverse()[0];
            var image = $('#img_src')[0];
            var reader = new FileReader();
              
            reader.onload = function (e) {
                $('#img-preview')
                .attr('src', e.target.result)
                .attr('alt', filename)
                .addClass('border rounded mt-3');
            }

            reader.readAsDataURL(image.files[0]);
        }
    }

    function getSubcategory(obj, target){
        var id = obj.val(),
            container = [],
            content = "";

        target.empty();

        if(mode == "update"){
            var subcategory_menu = subcategory.category_menu.menu_subcategory_id;
        }

        $.each(subcategories, function(index, value){
            if(id == value.menu_category_id){
                var selected = (mode == 'update' && value.id == subcategory_menu) ? 'selected' : '';

                content += "<option value='" + value.id + "' "+ selected +">"+ value.name +"</option>";
            }
        });

        target.append(content).prop('disabled', false);
    }

    getSubcategory($('#category'), $('#subcategory'));
</script>
@endsection