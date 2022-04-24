@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('auth')
<div class="row justify-content-center align-items-center vh-100">
    <div class="col-md-4">
        <form class="row no-gutters auth-card" 
            method="POST" 
            action="{{ route('password.email') }}"
            id="auth-form">

            @csrf

            <div class="card p-2">
                <div class="card-header border-0 bg-white">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="h3">Password Recovery</div>
                    <div class="h6 font-weight-normal">We will send you an email containing a password reset link</div>
                </div>

                <div class="card-body pt-0">
                    <div class="form-group row flex-column inputs">
                        <label for="email" class="col">{{ __('Email Address') }}</label>
                        <div class="col">
                            <input id="email" 
                                type="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                name="email" 
                                value="{{ old('email') }}"  
                                autocomplete="email" 
                                autofocus>

                            <span class="position-absolute icon text-muted">
                                <i data-feather="mail"></i>
                            </span>

                            @error('email')
                            <span class="invalid-feedback font-size-sm" role="alert">{{ $message }}</span>
                            @enderror

                            <span class="text-danger font-size-sm" id="invalid-email"></span>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col d-flex align-items-center justify-content-between">

                            @if (Route::has('login'))
                            <a href="{{ route('login') }}" class="btn btn-outline-primary px-3">Back</a>
                            @endif

                            <button type="button" id="btn-recover" class="btn btn-primary btn-submit px-3">Recover Password</button>
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
function validateFields(){
    $('.invalid-feedback').html('');

    if($('#email').val() == ""){
        $('#email').focus();
        $('#email').addClass('is-invalid');
        $('#invalid-email').html('The email field is required.');
    }else{
        $('#invalid-email').html('');
        $('#email').removeClass('is-invalid');
    }

    if($('#email').val() != ""){
        return true;
    }else{
        return false;
    }
}

function validateEmail(){
    var validRegex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    
    if(!$('#email').val().match(validRegex)){
        $('#email').focus();
        $('#email').addClass('is-invalid');
        $('#invalid-email').html('The email must be a valid email address.');

        return false;
    }else{
        return true;
    }
}

$('#btn-recover').on('click', function(){
    var fields = validateFields();
    var emailAddress = validateEmail();

    if(fields == true && emailAddress == true){
        $(this).prop('disabled', true);
        $(this).css('cursor', 'not-allowed');
        $(this).html('Recovering Password...');

        $('#auth-form').submit();
    }
});
</script>
@endsection