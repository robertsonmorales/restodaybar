<div class="col">
    <div class="card card-account mb-4 p-4">
        <h5>You're signed into these devices</h5>

        <ul class="list-group">
            @foreach($sessions as $val)
            <li class="list-group-item mb-1">
                {{-- <i data-feather="monitor" class="mr-2"></i> --}}
                <h5 class="mb-2">{{ $val->plaform_family }}</h5>

                <div>{{ $val->browser }}</div>
                <div>{{ $val->ip_address }}</div>
                <div>{{ $val->created_at }}</div>

                <div class="mt-2"></div>
                <a href="#" class="font-weight-500" style="color: dodgerblue;">More Details</a>
            </li>
            @endforeach
        </ul>

        <form class="actions mt-2" 
            method="POST" 
            action="{{ route('account_settings.logout_all_sessions') }}">
            @csrf
            
            <button type="submit" class="btn btn-primary" id="btn-save">Logout All Sessions</button>
        </form>
    </div>
</div>