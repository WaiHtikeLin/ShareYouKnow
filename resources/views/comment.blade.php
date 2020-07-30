<div id="commentform_{{ $post->id }}">
				
						<input type="text" name="comment" id="send_to_{{ $post->id }}">
						<span id="invalidcommentstatus"></span>
						
						<button onclick="sendComment({{ $post->id }})" type="button">Send</button>
				</div>
@foreach ($comments as $comment)
<div id='comment_{{ $comment->id }}'>
	<a href="/profile/{{ $comment->user_id }}"><p><img src="{{ $comment->owner->getImage() }}" id="profile">{{ $comment->owner->name }}</p></a>

	<p>{{ $post->getUserRating($comment->user_id) }}</p>
	<p>{{ $comment->created_at }}</p>
	<p class="comment-words">{{ $comment->words }}</p>
	<p>{{ $comment->photo }}</p>

	<p><button onclick="displayLikeStats({{ $comment->id }},'comment')" class="stats" id="commentstat_{{ $comment->id }}">
		{!! $comment->getStats() !!}

	</button></p>

	<div class="btn-group btn-group-lg" role="group">
					 
		<button class="btn btn-secondary" type="button" onclick="updateLikesForComment({{ $comment->id }},this)">{{ $comment->isLiked() }}</button> 

		<button class="btn btn-secondary" type="button" onclick="getReplies({{ $comment->id }},this)">Reply</button>

		@can('update',$comment)
		<a id="modal-397945" href="#comment_form_{{ $comment->id }}" role="button" class="btn" data-toggle="modal">Edit</a>

		<div class="modal fade" id="comment_form_{{ $comment->id }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								Edit Comment
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="text" value="{{ $comment->words }}" id="update_comment_{{ $comment->id }}">
							<span id="invalidupdatecommentstatus"></span>
						</div>
						<div class="modal-footer">
							 
							<button type="button" class="btn btn-primary" onclick="updateComment({{ $comment->id }},{{ $comment->post->id }})" id="updatecommenttrigger{{ $comment->id }}">
								Save changes
							</button> 
							<button type="button" class="btn btn-secondary" onclick="deleteComment({{ $comment->id }},{{ $comment->post->id }})" data-dismiss="modal">
								Delete
							</button>
							<button type="button" class="btn btn-secondary" data-dismiss="modal">
								Close
							</button>
						</div>
					</div>
</div>
		</div>
		@endcan
	</div>
	
	<div id="comment_likes_{{ $comment->id }}" ></div>
	<div id="replies_{{ $comment->id }}" class="replies"></div> 


</div>


@endforeach