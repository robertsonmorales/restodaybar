<div class="col">
    <div class="card mb-4 p-4">
        <h5>You're signed into these devices</h5>

        <ul class="list-group">
            @foreach($sessions as $val)
            <li class="list-group-item mb-1">
                {{-- <i data-feather="monitor" class="mr-2"></i> --}}
                <div class="d-flex align-items-center">
                    <div class="mb-0 h5">{{ $val->plaform_family }}</div>
                    <div class="badge badge-primary ml-2">{{ $val->browser }}</div>
                </div>

                <div class="item-details">
                    <div class="font-size-sm">{{ $val->ip_address }}</div>
                    <div class="font-size-sm">{{ $val->created_at }}</div>
                </div>

                <div class="mt-2"></div>
                <a href="#" class="font-weight-500 font-size-sm text-primary">More Details</a>
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