<div class="col card card-account mb-4 p-4">
    <div class="w-100">
		<h5>Password</h5>
	</div>
    
    <form action="{{ route('account_settings.password_update') }}" method="POST" id="settings-form" class="w-100">
        @csrf
        <div class="input-group">
            <label for="current_password">Current Password</label>
            <input type="password" 
            name="current_password" 
            class="form-control @error('current_password') is-invalid @enderror" 
            id="current_password" 
            required 
            autofocus>

            @error('current_password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password">New Password</label>
            <input type="password" 
            name="password" 
            id="password" 
            autocomplete="off"
            class="form-control @error('password') is-invalid @enderror" 
            required
            autofocus>

            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" 
            name="password_confirmation" 
            id="password_confirmation"  
            autocomplete="off"
            class="form-control @error('password_confirmation') is-invalid @enderror" 
            required
            autofocus>

            @error('password_confirmation')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>

        <div class="input-group">
            <h6>Password Requirements:</h6>
            <ul class="font-size-sm ml-4">
              <li>Minimum 8 characters long, the more the better</li>
              <li>Contain at-least 1 uppercase character ([A-Z])</li>
              <li>Contain at-least 1 lowercase character ([a-z])</li>
              <li>And 1 numeric and 1 special character ([0-9], [!@#$%^&*()])</li>
            </ul>
        </div>

        @method('PUT')
        <input type="hidden" name="id" value="{{ Auth::user()->id }}">

        <div class="actions">                        
            <button type="reset" class="btn btn-outline-primary mr-1" id="btn-reset">Reset</button>
            <button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
        </div>
    </form>
</div>