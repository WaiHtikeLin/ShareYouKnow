@extends('layouts.main')

	@section('content')
	<div class="row main">
		@include('sidenav')
		<div class="col-md-6" id="articleform">

			<form method="post" action="/articles">
				@csrf
			<select name="category">
				<option value="automobile">Automobile</option>
				<option value="crime">Crime</option>
				<option value="foodie">Foodie</option>
				<option value="health">Health</option>
				<option value="movie">Movie</option>
				<option value="music">Music</option>
				<option value="politics">Politics</option>
				<option value="science">Science</option>
				<option value="sports">Sports</option>
				<option value="technology">Technology</option>
			</select>

			<input type="text" name="title" placeholder="Enter title..." value="{{ old('title') }}" />
			@error('title')
			<span>{{ $message }}</span>
			@enderror
			<textarea name="description" placeholder="Enter description...">

				{{ old('description') }}
			</textarea>
			@error('description')
			<span>{{ $message }}</span>
			@enderror
			<input type="submit" value="create">
			</form>
		</div>
	</div>
	@endsection
