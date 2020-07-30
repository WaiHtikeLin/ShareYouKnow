@extends('layouts.main')
	
	@section('content')
	<div class="row main">
		@include('sidenav')
		<div class="col-md-6 articles">
			<div>
			<p>{{ $profile->user->name }}</p>
			<p>{{ $profile->user->email }}</p>
			<p id="stable_ph_no">{{ $profile->ph_no }}</p>
			<p id="stable_address">{{ $profile->address }}</p>
			<p id="stable_about">{{ $profile->about }}</p>
			</div>

			@can('update',$profile)
			<a id="modal-397945" href="#profile_form" role="button" class="btn" data-toggle="modal">Edit Profile</a>

		<div class="modal fade" id="profile_form" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="post" action="/profile/{{ $profile->user_id }}" enctype="multipart/form-data" id="profileform">
						@method('PATCH')


						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								Edit Profile
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						
						<div class="modal-body">

							@if($profile->photo)
							<label for="profile">Change profile picture</label>

							@else
							<label for="profile">Add profile picture</label>

							@endif

							<input type="file" name="pic" id="pic">
						</div>

						<div class="modal-body">
							
							
								
								@if($profile->ph_no)

								<input type="text" value="{{ $profile->ph_no }}" name="ph_no" id="ph_no">
							<button type="button" onclick="remove('#update_profile_ph_no_{{ $profile->user_id }}','a phone number',this)">remove</button>
								
								@else

								<input type="text" value="" name="ph_no" id="update_profile_ph_no_{{ $profile->user_id }}" style="display: none;">

								<button type="button" onclick="remove('#update_profile_ph_no_{{ $profile->user_id }}','a phone number',this)">Add a phone number</button>


								@endif

								
								<p class="text text-danger" id="ph_no_error"></p>


						</div>
						<div class="modal-body">
							
								
								@if($profile->address)
								<input type="text" value="{{ $profile->address }}" id="update_profile_address_{{ $profile->user_id }}" name="address">
							<button type="button" onclick="remove('#update_profile_address_{{ $profile->user_id }}','an address',this)">remove</button>
								

								@else

								<input type="text" value="{{ $profile->address }}" id="update_profile_address_{{ $profile->user_id }}" name="address" style="display: none;">

								<button type="button" onclick="remove('#update_profile_address_{{ $profile->user_id }}','an address',this)">Add an adress</button>

								@endif

						</div>
						<div class="modal-body">
								
								@if($profile->about)
								<input type="text" value="{{ $profile->about }}" id="update_profile_about_{{ $profile->user_id }}" name="about">
							<button type="button" onclick="remove('#update_profile_about_{{ $profile->user_id }}','about you',this)">remove</button>
								

								@else

								<input type="text" value="{{ $profile->about }}" id="update_profile_about_{{ $profile->user_id }}" name="about" style="display: none;">

								<button type="button" onclick="remove('#update_profile_about_{{ $profile->user_id }}','about you',this)">Add something about you</button>

								@endif

							
						</div>
						<div class="modal-footer">
							 
							<button type="submit" class="btn btn-primary" value="{{ $profile->user_id }}" id="saveprofile">Save</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Close
							</button>
						</div>
					</form>
						</div>
					</div>
</div>
		
			@endcan
			
		</div>
		<div class="col-md-3 aside">
			<h1>csfvfdvd</h1>
		</div>
	</div>
	@endsection
