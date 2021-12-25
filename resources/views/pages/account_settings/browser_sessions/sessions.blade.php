<div class="card card-account col-md-7 col-lg-6 mb-4 p-4">
    <h5>Your History</h5>

    <ul class="list-group">
        @foreach($sessions as $val)
        <li class="list-group-item mb-1">
            <h5><i data-feather="monitor" class="mr-2"></i> {{ $val->plaform_family }}</h5>
            <p><span class="font-size-sm font-weight-600">Browser</span>: {{ $val->browser }}</p>
            <p><span class="font-size-sm font-weight-600">IP Address</span>: {{ $val->ip_address }}</p>
            <p><span class="font-size-sm font-weight-600">You logged in: </span>{{ $val->created_at }}</p>
        </li>
        @endforeach
    </ul>

    <form class="actions" 
        method="POST" 
        action="{{ route('account_settings.logout_all_sessions') }}">
        @csrf
        
        <button type="submit" class="btn btn-primary" id="btn-save">Logout All Sessions</button>
    </form>
</div>