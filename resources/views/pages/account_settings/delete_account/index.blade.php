@extends('layouts.app')
@section('title', $title)

@section('content')

<div class="row no-gutters align-items-start mx-4">
    @include('pages.account_settings.sidebar')

    <div class="col">
        <div class="card mb-4 p-4">
            <div class="w-100">
                <h5>Delete Account</h5>
            </div>

            <div class="input-group">
                <p class="text-muted font-size-sm">Once you delete your account, you will loose all data associated with it.</p>
            </div>

            <div class="actions w-100">                        
                <button type="button" class="btn btn-danger" id="btn-delete">Delete Account</button>
            </div>
        </div>
    </div>
</div>

<!-- The Modal -->
<form class="modal" 
    action="{{ route('account_settings.destroy', Auth::id()) }}" 
    method="post" 
    id="settings-form">

    @csrf
    @method('DELETE')

    <div class="modal-content">
        <div class="modal-header">      
            <x-atoms.circle-icon 
                value="alert-triangle" 
                type="bg-danger text-white" />

            <div class="modal-body">
                <h5>Delete Your Account</h5>
                <p>Are you sure? This action cannot be undone.</p>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="submit" class="btn btn-danger" id="btn-remove">Yes, I understand</button>
            <button type="button" class="btn btn-outline-secondary" id="btn-cancel">Cancel</button>
        </div>
    </div>

</form>
<!-- Ends here -->
@endsection

@section('script-src')
<script type="text/javascript">
$(document).ready(function(){
    $("#btn-delete").click(function(){
        $('.modal').addClass('d-flex');
    });

    $('#btn-cancel').on('click', function(){
        $('.modal').removeClass('d-flex');
    });

    $('#settings-form').on('submit', function(){
        $('.modal-footer .btn').prop('disabled', true);
        $('#btn-remove').html("Deleting Account..");
    });
});
</script>
@endsection