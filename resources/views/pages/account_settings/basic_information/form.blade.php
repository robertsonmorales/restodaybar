<div class="card col-md-7 col-lg-6 mb-4 p-4">
    <div class="w-100">
        <h5>Basic Information</h5>
    </div>

    <form action="{{ route('account_settings.update', Auth::user()->id) }}"
        method="post"
        class="w-100"
        id="settings-form">

        @csrf

        <div class="input-group">
            <label for="">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" required
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ Crypt::decryptString($users->first_name) }}" autocomplete="off" autofocus>

            @error('first_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" required value="{{ Crypt::decryptString($users->last_name) }}"
            class="form-control @error('last_name') is-invalid @enderror" autocomplete="off" autofocus>

            @error('last_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="">Username</label>
            <input type="text" name="username" id="username" required autocomplete="off"
                class="form-control @error('username') is-invalid @enderror" autofocus
                value="{{ $users->username }}" autocomplete="off">
                
            @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="input-group">
            <label for="">Contact Number</label>
            <input type="text" name="contact_number" id="contact_number" class="form-control" required value="{{ Crypt::decryptString($users->contact_number) }}"
            class="form-control @error('contact_number') is-invalid @enderror" autocomplete="off" autofocus>
            @error('contact_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="input-group">
            <label for="">Address</label>
            <input type="text" name="address" id="address" class="form-control" required value="{{ $users->address }}"
            class="form-control @error('address') is-invalid @enderror" autocomplete="off" autofocus>
            @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        @method('PUT')
        <input type="hidden" name="id" value="{{ Auth::user()->id }}">

        <div class="actions">                        
            <button type="reset" class="btn btn-outline-primary mr-1" id="btn-reset">Reset</button>
            <button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
        </div>
    </form>
</div>

@section('script-src')
<script type="text/javascript">
$(document).ready(function(){
    $('#settings-form').on('submit', function(){
        $('#settings-form button').prop('disabled', true);
        $('#settings-form button').css('cursor', 'not-allowed');

        $('#btn-save').html('Saving Changes..');

        $(this).submit();
    });
});
</script>
@endsection