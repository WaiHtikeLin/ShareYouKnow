@extends('layouts.main')

	@section('content')
	<div class="row main">
		@include('sidenav')
		<div class="col-md-6" id="articleform">

			<form method="post" action="/articles/{{ $post->id }}" accept-charset="UTF-8">
				@csrf
				@method('patch')
			<select name="category">
				<option value="Automobile">Automobile</option>
				<option value="Crime">Crime</option>
				<option value="Foodie">Foodie</option>
				<option value="Health">Health</option>
				<option value="Movie">Movie</option>
				<option value="Music">Music</option>
				<option value="Politics">Politics</option>
				<option value="Science">Science</option>
				<option value="Sports">Sports</option>
				<option value="Technology">Technology</option>

		</select>

			<input type="text" name="title" value="{{ $post->title }}" />
			@error('title')
			<span>{{ $message }}</span>
			@enderror

			<textarea name="description">{{ $post->description }}</textarea>


			@error('description')
			<span>{{ $message }}</span>
			@enderror

			<input type="submit" value="Update">
			</form>
			<form method="post" action="/articles/{{ $post->id }}">
				@csrf
				@method('delete')
				<input type="submit" value="Delete">

			</form>
		</div>
	</div>
	@endsection
