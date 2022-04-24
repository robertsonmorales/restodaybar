@extends('layouts.auth')

@section('title', 'Login Page')

@section('auth')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-4">
        <form class="auth-card" 
            method="POST" 
            action="{{ route('login') }}" 
            id="auth-form">

            @csrf

            <div class="card p-2">
                <div class="card-header border-0 bg-white">
                    @if(session('success'))
                    <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                    @endif

                    <div class="h3">Login</div>
                    <div class="h6 font-weight-normal">Welcome back, enter your credentials to start.</div>
                </div>

                <div class="card-body pt-0">
                    <div class="form-group row flex-column inputs">
                        <label for="username" 
                        class="col">Username</label>

                        <div class="col">
                            <input id="username" 
                                type="username" 
                                class="form-control @error('username') is-invalid @enderror"
                                name="username"
                                value="{{ old('username') }}" 
                                autofocus
                                autocomplete="off">

                            <span class="position-absolute icon text-muted">
                                <i data-feather="user"></i>
                            </span>

                            @error('username')
                            <span class="invalid-feedback font-size-sm" role="alert">{{ $message }}</span>
                            @enderror

                            <span class="text-danger font-size-sm" id="invalid-username"></span>
                        </div>
                    </div>

                    <div class="form-group row flex-column inputs">
                        <label for="password" 
                        class="col">Password</label>

                        <div class="col">
                            <input id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password"  
                                autocomplete="off">

                            <span class="position-absolute icon text-muted">
                                <i data-feather="lock"></i>
                            </span>

                            @error('password')
                            <span class="invalid-feedback font-size-sm" role="alert">{{ $message }}</span>
                            @enderror

                            <span class="text-danger font-size-sm" id="invalid-password"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} style="cursor: pointer;">
                                <label class="custom-control-label font-size-sm" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>
                        <div class="col text-right">
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="font-size-sm">{{ __('Forgot Password?') }}</a>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col">
                            <button type="button" id="btn-login" class="btn btn-primary font-weight-normal w-100">{{ __('Login') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>  
    </div>
</div>
@endsection

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
$(document).ready(function() {
    function validateFields(){
        $('.invalid-feedback').html('');

        if($('#username').val() == ""){
            $('#username').focus();
            $('#username').addClass('is-invalid');
            $('#invalid-username').html('The username field is required.');
        }else{
            $('#invalid-username').html('');
            $('#username').removeClass('is-invalid');
        }
        
        if($('#password').val() == ""){
            $('#password').addClass('is-invalid');
            $('#invalid-password').html('The password field is required.');
        }else{
            $('#invalid-password').html('');
            $('#password').removeClass('is-invalid');
        }

        if($('#password').val() != "" && $('#username').val() != ""){
            return true;
        }else{
            return false;
        }
    }

    $('#btn-login').on('click', function(){
        var validation = validateFields();

        if(validation == true){
            $(this).prop('disabled', true)
                .css('cursor', 'not-allowed')
                .text('Authenticating...');

            $('#auth-form').submit();
        }
    });
});
</script>
@endsection