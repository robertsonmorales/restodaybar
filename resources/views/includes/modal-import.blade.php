<!-- The Import Modal -->
<form class="modal" 
method="POST"
id="import-form-submit"
enctype="multipart/form-data">
    @csrf
    <div class="modal-content">
        <div class="modal-header">      
            <div class="modal-icon modal-icon-primary">
                <i data-feather="alert-triangle"></i>
            </div>

            <div class="modal-body">
                <h5>Import Records</h5>

                <p>This only accepts .csv file format.</p>

                <input type="file" 
                name="import_file" 
                id="import_file" mj
                class="form-control @error('import_file') is-invalid @enderror" 
                accept=".csv">

                @error('import_file')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

        </div>

        <div class="modal-footer bg-light">
            <button type="button" class="btn btn-primary" id="btn-import-submit">Import File</button>
            <button type="button" class="btn btn-dark mr-4" id="btn-import-cancel">Cancel</button>
        </div>
    </div>
</form>
<!-- ends here -->