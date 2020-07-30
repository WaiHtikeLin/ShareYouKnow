@foreach ($notifications as $notification)
          <a class="dropdown-item" href="/articles/show/{{ $notification->data['source']['id'] }}"><p>
                    <img src="{{ $notification->data['photo'] }}" id="profile">{{ $notification->data['msg'] }}</p>
                  <p>{{ \App\ NotiControl::getTime($notification->created_at) }}</p>
           	</a>
                  <div class="text-right mb-1">
                  	<button class="btn btn-danger btn-sm noti-delete" value="{{ $notification->id }}">Delete</button>
                  </div>

@endforeach