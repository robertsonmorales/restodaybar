@extends('layouts.app')
@section('title', $title)

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
@endsection

@section('content')
<form action="{{ ($mode == 'update') ? route('user_accounts.update', $user->id) : route('user_accounts.store') }}"
    method="POST"
    class="d-flex flex-column align-items-center mx-4"
    id="card-form">

    <div class="mb-4 card col-md-6 p-4">    
        @csrf
        <div class="w-100">
            <h5>{{ ucfirst($mode).' '.\Str::Singular($title) }}</h5>
        </div>
        
        <div class="input-group">
            <label for="first_name">First Name</label>
            <input type="text" 
            name="first_name" 
            id="first_name" 
            autocomplete="first_name"
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ ($mode == 'update') ? $user->first_name : old('first_name') }}"
            required>

            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="last_name">Last Name</label>
            <input type="text" 
            name="last_name" 
            id="last_name" 
            autocomplete="off"
            class="form-control @error('last_name') is-invalid @enderror"
            value="{{ ($mode == 'update') ? $user->last_name : old('last_name') }}"
            required>

            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if($mode == 'create')
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" 
            name="email" 
            id="email" 
            autocomplete="off"
            class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email') }}"
            required>

            @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" 
            name="username" 
            id="username" 
            autocomplete="off"
            class="form-control @error('username') is-invalid @enderror"
            value="{{ old('username') }}"
            required>

            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" 
            name="password" 
            id="password" 
            autocomplete="off"
            class="form-control @error('password') is-invalid @enderror"
            value="{{ old('password') }}"
            required>

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" 
            name="password_confirmation" 
            id="password_confirmation"  
            autocomplete="off"
            class="form-control @error('password_confirmation') is-invalid @enderror" 
            required>

            @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="contact_number">Contact Number</label>
            <input type="text" 
            name="contact_number" 
            id="contact_number" 
            autocomplete="off"
            class="form-control @error('contact_number') is-invalid @enderror"
            value="{{ old('contact_number') }}"
            required>

            @error('contact_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        @endif

        <div class="input-group">
            <label for="address">Address</label>
            <input type="text" 
            name="address" 
            id="address" 
            autocomplete="off"
            class="form-control @error('address') is-invalid @enderror"
            value="{{ ($mode == 'update') ? $user->address : old('address') }}"
            required>

            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="user_level_id">User Level</label>
            <select name="user_level_id" 
            id="user_level_id" 
            class="custom-select form-control @error('user_level_id') is-invalid @enderror"
            required>
                <option value="">Select User Level...</option>
                @foreach($user_levels as $value)
                <option value="{{ $value->id }}" {{ ($mode == 'update' && $value->id == $user->user_level_id) ? 'selected' : '' }}>{{ $value->name }}</option>
                @endforeach
            </select>

            @error('user_level_id')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="account_status">Status</label>
            <select name="account_status" 
            id="account_status" 
            class="custom-select form-control @error('account_status') is-invalid @enderror"
            required>
                <option value="1" {{ ($mode == 'update' && $user->account_status == 1) ? 'selected' : '' }}>Active</option>
                <option value="2" {{ ($mode == 'update' &&  $user->account_status == 2) ? 'selected' : '' }}>Deactivate</option>
                <option value="3" {{ ($mode == 'update' &&  $user->account_status == 3) ? 'selected' : '' }}>Lock</option>
            </select>

            @error('account_status')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @if ($mode == 'update')
        @method('PUT')
        <input type="hidden" name="id" value="{{ ($mode == 'update') ? $user->id : ''}}">
        @endif

        <div class="actions w-100">
            <button type="button" 
            class="btn btn-outline-secondary mr-1" 
            id="btn-back">Back</button>

            <button type="reset"
            class="btn btn-outline-secondary mr-1" 
            id="btn-reset">Reset</button>

            <button type="submit" class="btn btn-primary" id="btn-submit">{{ ($mode == 'update') ? 'Submit Changes' : 'Submit' }}</button>
        </div>
    </div>
</form>
@endsection

@section('vendors-style')
<link rel="stylesheet" href="{{ asset('/vendors/select2/select2.min.css') }}">
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('/vendors/select2/select2.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function(){
    var mode = @json($mode);
    var index_page = @json(route('user_accounts.index'));

    $('#card-form').on('submit', function(){
        var mode = "{{ $mode }}";

        $('.actions button').prop('disabled', true);
        $('.actions button').css('cursor', 'not-allowed');

        $('#btn-submit').html((mode == "update") ? "Submitting Changes.." : "Submitting..");

        $(this).submit();
    });

    $('#btn-back').on('click', function(){
        window.location.href = index_page;
    });
});
</script>
@endsection