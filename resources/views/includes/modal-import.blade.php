<!-- The Import Modal -->
<form class="modal" 
    method="POST"
    id="import-form-submit"
    enctype="multipart/form-data">
    
    @csrf
    <div class="modal-content">
        <div class="modal-header">      
            <div class="modal-icon bg-primary text-white">
                <i data-feather="alert-triangle"></i>
            </div>

            <div class="modal-body pt-0 pr-0">
                <h5>Upload Records</h5>

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
            <button type="button" class="btn btn-outline-primary" id="btn-import-cancel">Cancel</button>
            <button type="button" class="btn btn-primary" id="btn-import-submit">Upload File</button>
        </div>
    </div>
</form>
<!-- ends here -->