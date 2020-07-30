@foreach ($comments as $comment)
<div>
	<p>{{ $comment->owner->name }}</p>
<p>{{ $comment->words }}</p>
<p>{{ $comment->photo }}</p>

<p class="stats">
		<span id="commentlikestat_{{ $comment->id }}">{{ $comment->getLikeStats() }}</span>
		<span  id="replystat_{{ $comment->id }}">{{ $comment->getReplyStats() }}</span>
		
	</p>
	<div class="btn-group btn-group-lg" role="group">
					 
		<button class="btn btn-secondary" type="button" onclick="updateLikesForComment({{ $comment->id }},this)">{{ $comment->isLiked() }}</button> 

		<button class="btn btn-secondary" type="button" onclick="getReplies({{ $comment->id }})">Reply</button> 
	</div>


	
	

</div>
@endforeach 