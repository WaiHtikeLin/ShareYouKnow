<div id="replyform_{{ $id }}">
				
		<input type="text" name="reply" id="send_reply_to_{{ $id }}">
		<button onclick="sendReply({{ $id }})" type="button">Send</button>
				</div>

@foreach ($replies as $reply)
<div id='reply_{{ $reply->id }}'>
	<a href="/profile/{{ $reply->user_id }}"><p><img src="{{ $reply->owner->getImage() }}" id="profile">{{ $reply->owner->name }}</p></a>
	<p>{{ $post->getUserRating($reply->user_id) }}</p>
	<p>{{ $reply->created_at }}</p>
	<p class="reply-words">{{ $reply->words }}</p>
	<p>{{ $reply->photo }}</p>

	<p><button class="stats" id="replylikestat_{{ $reply->id }}" onclick="displayLikeStats({{ $reply->id }},'reply')">{{ $reply->getLikeStats() }}</button></p>

	<div class="btn-group btn-group-lg" role="group">
					 
		<button class="btn btn-secondary" type="button" onclick="updateLikesForReply({{ $reply->id }},this)">{{ $reply->isLiked() }}</button> 

		@can('update',$reply)
		<a id="modal-397945" href="#reply_form_{{ $reply->id }}" role="button" class="btn" data-toggle="modal">Edit</a>

		<div class="modal fade" id="reply_form_{{ $reply->id }}" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

			<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="myModalLabel">
								Edit Reply
							</h5> 
							<button type="button" class="close" data-dismiss="modal">
								<span aria-hidden="true">×</span>
							</button>
						</div>
						<div class="modal-body">
							<input type="text" value="{{ $reply->words }}" id="update_reply_{{ $reply->id }}">
						</div>
						<div class="modal-footer">
							 
							<button type="button" class="btn btn-primary" onclick="updateReply({{ $reply->id }},{{ $reply->comment->id }})" data-dismiss="modal">
								Save changes
							</button> 
							<button type="button" class="btn btn-secondary" onclick="deleteReply({{ $reply->id }},{{ $reply->comment->id }})" data-dismiss="modal">
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
	<div id="reply_likes_{{ $reply->id }}"></div>


</div>

@endforeach