@foreach ($likes as $like)
	<p><a href="/profile/{{ $like->user_id }}"><img src="{{ $like->liker->getImage() }}" id="profile">{{ $like->liker->name }}</a></p>

@endforeach