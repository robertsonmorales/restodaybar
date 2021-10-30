<div class="card col-md-7 col-lg-6 mb-4 p-4">
    <div class="w-100">
        <h5>Profile Information</h5>
    </div>

    <form action="{{ route('account_settings.update', Auth::user()->id) }}"
        method="post"
        class="w-100"
        id="settings-form"
        enctype="multipart/form-data">

        @csrf

        <div class="input-group profile-preview">
            <div class="d-flex flex-column align-items-start">
                <img id="image-preview" 
                src="{{ (is_null(Auth::user()->profile_image))
                    ? "https://ui-avatars.com/api/?background=0061f2&color=fff&name=".Auth::user()->first_name."&format=svg&rounded=true&bold=true&font-size=0.4&length=1"
                    : asset('uploads/user_accounts/'.Auth::user()->profile_image) }}">

                <button type="button" class="btn btn-light btn-profile-image shadow-sm">
                    <span class="mr-2"><i data-feather="edit"></i></span>
                    <span>Edit Profile</span>
                </button>
            </div>
            
            <input type="file" 
            name="profile_image" 
            id="profile_image" 
            class="form-control d-none @error('profile_image') is-invalid @enderror" accept="image/*">
            @error('profile_image')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="first_name">First Name</label>
            <input type="text" 
            name="first_name" 
            id="first_name" 
            required
            class="form-control @error('first_name') is-invalid @enderror"
            value="{{ $users->first_name }}" 
            autocomplete="off" 
            autofocus>

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
            required 
            value="{{ $users->last_name }}"
            class="form-control @error('last_name') is-invalid @enderror"
            autocomplete="off" 
            autofocus>

            @error('last_name')
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
            required 
            autocomplete="off"
            class="form-control @error('username') is-invalid @enderror" 
            autofocus
            value="{{ $users->username }}" 
            autocomplete="off">
                
            @error('username')
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
            required 
            value="{{ $users->contact_number }}"
            class="form-control @error('contact_number') is-invalid @enderror" 
            autocomplete="off" 
            autofocus>

            @error('contact_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        
        <div class="input-group">
            <label for="address">Address</label>
            <input type="text" 
            name="address" 
            id="address" 
            required 
            value="{{ $users->address }}"
            class="form-control @error('address') is-invalid @enderror" 
            autocomplete="off" 
            autofocus>

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
<script>
$('document').ready(function(){
    $('.btn-profile-image').on('click', function(){
        $('#profile_image').trigger('click');
    });

    $('#profile_image').on('change', function(){
        var image = $(this)[0];
        var reader = new FileReader();
          
        reader.onload = function (e) {
            $('#image-preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(image.files[0]);
    });

    $('#settings-form').on('submit', function(){
        
        $('.actions button').prop('disabled', true);
        $('.actions button').css('cursor', 'not-allowed');

        $('#btn-save').html('Saving Changes..');

        $(this).submit();
    });
});
</script>
@endsection