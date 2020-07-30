<div class="col-md-3 asidenav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a class="nav-link" href="/profile/{{ auth()->id() }}">{{ auth()->user()->name }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/profile/{{ auth()->id() }}">My Profile</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/articles/create">Create New</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/articles/myarticles">My Articles</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="/articles/saves">My Saves</a>
				</li>
				<li class="nav-item">
					<a href="{{ route('logout') }}" onclick="
					event.preventDefault();
					$('#logout-form').submit();" class="nav-link">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
				</li>

			</ul>
			<ul>
				<li>
					<a href="/articles/automobile">Automobile</a>
				</li>
				<li>
					<a href="/articles/crime">Crime</a>
				</li>
				<li>
					<a href="/articles/foodie">Foodie</a>
				</li>
				<li>
					<a href="/articles/health">Health</a>
				</li>
				<li>
					<a href="/articles/movies">Movie</a>
				</li>
				<li>
					<a href="/articles/music">Music</a>
				</li>
				<li>
					<a href="/articles/politics">Politics</a>
				</li>
				<li>
					<a href="/articles/science">Science</a>
				</li>
				<li>
					<a href="/articles/sports">Sports</a>
				</li>
				<li>
					<a href="/articles/technology">Technology</a>
				</li>

			</ul>
</div>
