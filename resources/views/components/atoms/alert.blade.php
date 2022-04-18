<!-- alert -->
@if(session()->get('success'))
<div class="alert alert-success alert-dismissible fade show alerts mb-3 mx-4 px-3 py-2" role="alert">
    <span><i data-feather="check"></i> {{ session()->get('success') }}</span>
    <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
    </button>
</div>
@endif

@if(session()->get('error'))
<div class="alert alert-danger alert-dismissible fade show alerts mb-3 mx-4 px-3 py-2" role="alert">
    <span><i data-feather="alert-circle"></i> {{ session()->get('error') }}</span>
    <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
    </button>
</div>
@endif

@if(session()->get('warning'))
<div class="alert alert-success alert-dismissible fade show alerts mb-3 mx-4 px-3 py-2" role="alert">
    <span><i data-feather="alert-triangle"></i> {{ session()->get('warning') }}</span>
    <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
    </button>
</div>
@endif

@if(session()->get('import'))
<div class="alert alert-success alert-dismissible fade show alerts mb-3 mx-4 px-3 py-2" role="alert">
    <span><i data-feather="check"></i> {{ session()->get('import') }}</span>
    <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
    </button>
</div>
@endif

@if(session()->get('import_failed'))
<div class="alert alert-success alert-dismissible fade show alerts mb-3 mx-4 px-3 py-2" role="alert">
    <span><i data-feather="alert-circle"></i> {{ session()->get('import_failed') }}</span>
    <button type="button" class="close px-3 py-2" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true" class="dismiss-icon"><i data-feather="x"></i> </span>
    </button>
</div>
@endif
<!-- ends here -->