<div class="col">
	<div class="card card-account mb-4 p-4">
		<div class="w-100">
			<h5>Email</h5>
		</div>

		<form action="{{ route('account_settings.email_update', Auth::user()->id) }}" 
			method="post" 
			id="settings-form" 
			class="w-100">
			
			@csrf

			<div class="input-group">
				<label for="email">Your current email address is <span class="text-primary font-weight-600">{{ Auth::user()->email }}</span></label>
			</div>
			<div class="input-group">
				<label for="email">New Email Address</label>
				<input type="email" 
				name="email" 
				id="email" 
				class="form-control"
				class="form-control @error('email') is-invalid @enderror" 
				autocomplete="off" 
				autofocus>

				@error('email')
				<span class="invalid-feedback" role="alert">
					<strong>{{ $message }}</strong>
				</span>
				@enderror
			</div>

			@method('PUT')
			<input type="hidden" name="id" value="{{ Auth::user()->id }}">

			<div class="actions">                        
				<button type="reset" class="btn btn-outline-primary mr-1" id="btn-reset">Reset</button>
				<button type="submit" class="btn btn-primary" id="btn-save">Save Changes</button>
			</div>
		</form>
	</div>
</div>