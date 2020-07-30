<div class="tabbable" id="tabs-71061">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a class="nav-link active" href="#tab1_{{ $id }}" data-toggle="tab">Likes({{ $likes->count() }})</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="#tab2_{{ $id }}" data-toggle="tab">Saves({{ $saves->count() }})</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1_{{ $id }}">
						@foreach ($likes as $like)
							<a href="/profile/{{ $like->user_id }}"><p>
								<img src="{{ $like->liker->getImage() }}" id="profile">{{ $like->liker->name }}</p></a>

						@endforeach
					</div>
					<div class="tab-pane" id="tab2_{{ $id }}">
						@foreach ($saves as $save)
							<a href="/profile/{{ $save->id }}"><p>
								<img src="{{ $save->getImage() }}" id="profile">{{ $save->name }}</p></a>

						@endforeach
					</div>
				</div>
			</div>
	
