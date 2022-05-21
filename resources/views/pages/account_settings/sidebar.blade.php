<div class="col-md-4 col-lg-3 mb-4 mb-md-0 mr-md-4 account-sidebar">
    <div class="list-group">
        <a href="{{ route('account_settings.index') }}"
            data-id="account-settings"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="user"></em></span>
            <span>Profile Information</span>
        </a>
        <a href="{{ route('account_settings.email') }}" 
            data-id="email"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="mail"></em></span>
            <span>Email</span>
        </a>

        <a href="{{ route('account_settings.password') }}" 
            data-id="password"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="lock"></em></span>
            <span>Password</span>
        </a>

        <a href="#" 
            data-id="preferences"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="sliders"></em></span>
            <span>Preferences</span>
        </a>

        <a href="{{ route('account_settings.browser_sessions') }}" 
            data-id="browser-sessions"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="monitor"></em></span>
            <span>Browser Sessions</span>
        </a>

        <a href="{{ route('account_settings.delete_account') }}" 
            data-id="delete-account"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><em data-feather="trash"></em></span>
            <span>Delete Account</span>
        </a>
    </div>
</div>

@section('vendors-script')
<script src="{{ asset('vendors/jquery/jquery-3.4.1.min.js') }}"></script>
@endsection

@section('scripts')
<script type="text/javascript">
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

    function loadSidebar(){
        var pathname = window.location.pathname;
        var selectedTab = pathname.split('/').reverse()[0];
        var dataId = selectedTab.replace('_', '-');
        var anchor = document.querySelectorAll('.account-sidebar .list-group-item-action');

        for (let i = 0; i < anchor.length; i++) {
            if(anchor[i].getAttribute('data-id') == dataId){
                anchor[i].classList.add('active');
            }else{
                anchor[i].classList.remove('active');
            }
        }
    }

    loadSidebar();
});
</script>
@endsection