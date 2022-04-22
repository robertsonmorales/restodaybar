<!-- The Import Modal -->
<form class="modal" 
    method="POST"
    id="import-form-submit"
    enctype="multipart/form-data">
    
    @csrf
    <div class="modal-content">
        <button class="btn btn-dismiss text-dark">
            <em data-feather="x"></em>
        </button>

        <div class="modal-header">

            <x-atoms.circle-icon 
                type="bg-primary text-white"
                value="database" />

            <div class="modal-body">
                <h4 class="mb-0">Import CSV Template</h4>
                <p>This only accepts .csv file format.</p>

                <input type="file" 
                    name="import_file" 
                    id="import_file" 
                    class="form-control mt-2 @error('import_file') is-invalid @enderror" 
                    accept=".csv">

                @error('import_file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-outline-secondary" id="btn-import-cancel">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn-import-submit">Submit</button>
        </div>
    </div>
</form>
<!-- ends here -->