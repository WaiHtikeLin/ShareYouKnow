	@extends('layouts.main')

	@section('content')
	<div class="row main">
		@include('sidenav')
		<div class="col-md-6 articles">

		@foreach($posts as $post)

				<article id="article_{{ $post->id }}">
				<a href="/profile/{{ $post->user_id }}"><p>
					<img src="{{ $post->owner->getImage() }}" id="profile">{{ $post->owner->name }}</p></a>

				<p>{{ $post->created_at }}&nbsp;&nbsp;&nbsp;<span><em>{{ $post->category }}</em></span>&nbsp;&nbsp;&nbsp;</p>
				<h3 class="post-title">{{ $post->title }}</h3>
				<p id="avg-rating{{ $post->id }}"><em>{{ $post->getAvgRating() }}</em></p>
				<p class="post-des">
					{{ $post->description }}
				</p>
			<p><button onclick="displayStats({{ $post->id }})" class="stats" id="stat_{{ $post->id }}">
					{!! $post->getStats() !!}
				</button></p>

				@can('rate',$post)
				<div class="btn-group btn-group-sm rating" role="group" id="rating{{ $post->id }}">
					<button class="btn btn-primary rate-btn {{ $post->getRating()!='Bad' ? '': 'active' }}" value="{{ $post->id }}">Bad</button>
					<button class="btn btn-primary rate-btn {{ $post->getRating()!='Poor' ? '': 'active' }}" value="{{ $post->id }}">Poor</button>
					<button class="btn btn-primary rate-btn {{ $post->getRating()!='Nice' ? '': 'active' }}" value="{{ $post->id }}">Nice</button>
					<button class="btn btn-primary rate-btn {{ $post->getRating()!='Good' ? '': 'active' }}" value="{{ $post->id }}">Good</button>
					<button class="btn btn-primary rate-btn {{ $post->getRating()!='Great' ? '': 'active' }}" value="{{ $post->id }}">Great</button>
				</div>

				@endcan

				<div class="btn-group btn-group-md" role="group">

					@can('rate',$post)
					<button class="btn btn-outline-dark text-light rate" onclick="updateRateForPost({{ $post->id }},this)" id="rate{{ $post->id }}">{{ $post->getRating() }}</button>
					@endcan

					<button class="btn btn-outline-dark text-light" type="button" onclick="updateLikesForPost({{ $post->id }},this)">{{ $post->isLiked() }}</button>



					<button class="btn btn-outline-dark text-light" type="button" onclick="getComments({{ $post->id }})">Comment</button>


					@can('update',$post)

					<a href="/articles/{{ $post->id }}/edit"><button class="btn btn-secondary" type="button">Edit</button></a>

					@else
					<button class="btn btn-outline-dark text-light" type="button" onclick="updateSaves({{ $post->id }},this)">{{ $post->isSaved() }}</button>

					@endcan
				</div>


				<div id="stats_{{ $post->id }}" ></div>
				<div id="comments_{{ $post->id }}" ></div>

			</article>
		@endforeach


		</div>
		<div class="col-md-3 aside">
			<h3>Sort by</h3>
			<p>&nbsp;&nbsp;&nbsp;<a href="#">latests</a></p>
			<p>&nbsp;&nbsp;&nbsp;<a href="#">populars</a></p>
			<p>&nbsp;&nbsp;&nbsp;<a href="#">ratings</a></p>
		</div>
	</div>
	@endsection
