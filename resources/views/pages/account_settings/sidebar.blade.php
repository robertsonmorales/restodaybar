<div class="col-md-4 col-lg-3 mb-4 mb-md-0 mr-md-4 account-sidebar">
    <div class="list-group">
        <a href="{{ route('account_settings.index') }}"
            data-id="account-settings"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="user"></i></span>
            <span>Profile Information</span>
        </a>
        <a href="{{ route('account_settings.email') }}" 
            data-id="email"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="mail"></i></span>
            <span>Email</span>
        </a>

        <a href="{{ route('account_settings.password') }}" 
            data-id="password"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="lock"></i></span>
            <span>Password</span>
        </a>

        <a href="#" 
            data-id="preferences"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="sliders"></i></span>
            <span>Preferences</span>
        </a>

        <a href="#" 
            data-id="browser-sessions"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="monitor"></i></span>
            <span>Browser Sessions</span>
        </a>

        <a href="{{ route('account_settings.delete_account') }}" 
            data-id="delete-account"
            class="list-group-item list-group-item-action">
            <span class="mr-2"><i data-feather="trash"></i></span>
            <span>Delete Account</span>
        </a>
    </div>
</div>

@section('scripts')
<script type="text/javascript">
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
</script>
@endsection