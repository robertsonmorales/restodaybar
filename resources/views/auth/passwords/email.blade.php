@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('auth')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-6 col-lg-8">
        <div class="row no-gutters auth-card">
            <div class="col-md d-none d-lg-flex login-banner p-4">
                <img src="{{ asset('images/svg/login.svg') }}" alt="login-banner" class="img-fluid">
            </div>
            <div class="col card p-2">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <div class="card-header border-0 bg-white">
                    <div class="h2">{{ __('Forgot Password?') }}</div>
                    <div class="h6 font-weight-normal">{{ __("Please provide your email address.") }}</div>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row flex-column inputs">
                            <label for="email" class="col">{{ __('Email Address') }}</label>
                            <div class="col">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                <span class="position-absolute icon text-muted">
                                    <i data-feather="mail"></i>
                                </span>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col d-flex align-items-center justify-content-between">
                                <a href="{{ route('login') }}" class="btn btn-link text-primary">{{ __('Back') }}</a>
                                <button type="submit" class="btn btn-primary btn-submit">{{ __('Send Password Reset Link') }}</button>
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
            $('.btn-submit').html('Sending Password Reset Link...');

            $(this).submit();
        });
    });
</script>
@endsection