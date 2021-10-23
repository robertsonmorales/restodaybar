@extends('layouts.auth')

@section('title', 'Password Confirmation')

@section('auth')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-6 col-lg-8">
        <div class="row no-gutters auth-card">
            <div class="col-md d-none d-lg-flex login-banner p-4">
                <img src="{{ asset('images/svg/login.svg') }}" alt="login-banner" class="img-fluid">
            </div>
            <div class="col card p-2">
                <div class="card-header border-0 bg-white">
                    <div class="font-weight-bold h2">{{ __('Confirm Password') }}</div>
                    <div class="font-weight-lighter text-muted h6">{{ __('Please confirm your password before continuing.') }}</div>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="form-group row flex-column inputs">
                            <label for="password" 
                            class="col">{{ __('Password') }}</label>

                            <div class="col">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
                                <a href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                                @endif
                                <button type="submit" class="btn btn-primary btn-submit">{{ __('Confirm') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>  
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        $('form').on('submit', function(){
            $('.btn-submit').prop('disabled', true);
            $('.btn-submit').css('cursor', 'not-allowed');
            $('.btn-submit').html('Confirming...');

            $(this).submit();
        });
    });
</script>
@endsection