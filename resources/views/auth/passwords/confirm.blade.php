@extends('layouts.auth')

@section('title', 'Password Confirmation')

@section('auth')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-7">

        <form class="row no-gutters auth-card" 
            method="POST" 
            action="{{ route('password.confirm') }}" 
            id="auth-form">

            @csrf

            <div class="col-md d-none d-lg-flex login-banner">
                <img src="{{ asset('images/logo/login-banner.png') }}" 
                    alt="login-banner" 
                    class="img-fluid"
                    width="382"
                    height="382">
            </div>

            <div class="col">
                <div class="card p-2">
                    <div class="card-header border-0 bg-white">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="h3">Confirm Password</div>
                        <div class="h6 font-weight-normal">Please confirm your password before continuing.</div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="form-group row flex-column inputs">
                            <label for="password" 
                            class="col">{{ __('Password') }}</label>

                            <div class="col">
                                <input id="password" 
                                type="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                name="password" 
                                required 
                                autocomplete="current-password">

                                <span class="position-absolute icon text-muted">
                                    <i data-feather="lock"></i>
                                </span>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col d-flex align-items-center justify-content-between">
                                @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                                @endif
                                <button type="submit" id="btn-confirm" class="btn btn-primary btn-submit px-3">Confirm</button>
                            </div>
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
    $('#auth-form').on('submit', function(){
        $('#btn-confirm').prop('disabled', true);
        $('#btn-confirm').css('cursor', 'not-allowed');
        $('#btn-confirm').html('Confirming...');

        $(this).submit();
    });
});
</script>
@endsection