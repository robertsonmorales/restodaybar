<!-- The Modal -->
<form class="modal" 
    action="" 
    method="POST" 
    id="form-submit">
    
    @csrf

    @method('DELETE')

    <div class="modal-content">
        <button class="btn btn-dismiss text-dark">
            <em data-feather="x"></em>
        </button>

        <div class="modal-header">      

            <x-atoms.circle-icon 
                value="alert-triangle" 
                type="bg-danger text-white" />

            <div class="modal-body">
                <h4 class="mb-0">You are about to remove a record.</h4>
                <p>This will be permanently removed and this action cannot be undone.</p>
            </div>
        </div>

        <div class="modal-footer bg-light">
            <button type="button" 
                class="btn btn-danger" 
                id="btn-remove">Remove</button>
            <button type="button" 
                class="btn btn-outline-secondary" 
                id="btn-cancel">Cancel</button>
        </div>
    </div>
</form>
<!-- Ends here -->