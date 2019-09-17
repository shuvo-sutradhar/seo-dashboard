<header class="header gradient-bg border-none">
	<div class="logo-container">
		<a href="{{ route('home') }}" class="logo">
			<img src="{{ asset('/uploads/company_logo/') }}/{{ \App\GeneralSetting::where('key', 'app.logo')->firstOrFail()->value }}" width="120" height="40" alt="Porto Admin" />
		</a>
		<div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
			<i class="fas fa-bars" aria-label="Toggle sidebar"></i>
		</div>
	</div>

	<!-- start: search & user box -->
	<div class="header-right">

		{{-- <form action="pages-search-results.html" class="search nav-form">
			<div class="input-group">
				<input type="text" class="form-control" name="q" id="q" placeholder="Search...">
				<span class="input-group-append">
					<button class="btn btn-default" type="submit"><i class="fas fa-search"></i></button>
				</span>
			</div>
		</form> --}}

		{{-- <span class="separator"></span> --}}

		<ul class="notifications" style="position: relative;display: inline-block;">
			
			<li>
				<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
					<i class="fas fa-bell"></i>
					<span class="badge">3</span>
				</a>

				<div class="dropdown-menu notification-menu">
					<div class="notification-title">
						<span class="float-right badge badge-default">3</span>
						Alerts
					</div>

					<div class="content">
						<ul>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-thumbs-down bg-danger text-light"></i>
									</div>
									<span class="title">Server is Down!</span>
									<span class="message">Just now</span>
								</a>
							</li>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-lock bg-warning text-light"></i>
									</div>
									<span class="title">User Locked</span>
									<span class="message">15 minutes ago</span>
								</a>
							</li>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-signal bg-success text-light"></i>
									</div>
									<span class="title">Connection Restaured</span>
									<span class="message">10/10/2017</span>
								</a>
							</li>
						</ul>

						<hr />

						<div class="text-right">
							<a href="#" class="view-more">View All</a>
						</div>
					</div>
				</div>
			</li>
			
			@if(auth()->user()->isAdmin())
				<li>
					<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
						<i class="fas fa-sliders-h"></i>
					</a>

					<div class="dropdown-menu notification-menu">
						<div class="notification-title">
							<span class="float-right badge badge-default">6</span>
							Settings
						</div>

						<div class="content">
							<ul>
								<li><a href="{{ route('settings.general') }}" class="clearfix"><i class="fas fa-cogs"></i> General</a></li>
								<li><a href="#" class="clearfix"><i class="fab fa-cc-stripe"></i> Payements</a></li>
								<li><a href="#" class="clearfix"><i class="far fa-envelope"></i> Email</a></li>
								<li><a href="{{ route('account.index') }}" class="clearfix"><i class="fas fa-users"></i> Team</a></li>
								<li><a href="{{ route('tag.index') }}" class="clearfix"><i class="fas fa-tags"></i> Tags</a></li>
								<li><a href="{{ route('log.index') }}" class="clearfix"><i class="fas fa-history"></i> System Logs</a></li>

							</ul>
						</div>
					</div>
				</li>
			@endif

			@if (auth()->user()->isClient())
				<li>
					<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
						<i class="fas fa-shopping-basket"></i>
						<span class="badge">{{ Cart::count() }}</span>
					</a>
					<div class="dropdown-menu notification-menu">
						<div class="notification-title">
							<span class="float-right badge badge-default">{{ Cart::count() }}</span>
							Cart items
						</div>
						@if (Cart::count() > 0)
                			@foreach(Cart::content() as $key => $item)

								<div class="content">
									<ul>
										<li>
											<a href="{{ route('services.details', $item->model->slug) }}" class="clearfix">
												<div class="image img-60 ">
													@if(!empty($item->model->thumbnail))
														<img src="{{ asset('uploads/service_pic') }}/{{ $item->model->thumbnail }}" class="rounded-circle">
													@else
														<img src="{{ asset('uploads/service_pic/default.png') }}" class="rounded-circle">
													@endif
												</div>
												<span class="title">{{ $item->name }}</span>
												<span class="message">${{ $item->price }}</span>
											</a>
										</li>
									</ul>
								</div>
								
							@endforeach
							<hr />

							<div class="text-right">
								<a href="{{ route('cart.index') }}" class="view-more">View All</a><br/>
							</div>
						@endif
					</div>	
				</li>
			@endif
			<li>
				<a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
					<i class="fab fa-facebook-messenger"></i>
					<span class="badge">0</span>
				</a>
				<div class="dropdown-menu notification-menu">
					<div class="notification-title">
						<span class="float-right badge badge-default">3</span>
						Messages
					</div>

					<div class="content">
						<ul>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-thumbs-down bg-danger text-light"></i>
									</div>
									<span class="title">Server is Down!</span>
									<span class="message">Just now</span>
								</a>
							</li>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-lock bg-warning text-light"></i>
									</div>
									<span class="title">User Locked</span>
									<span class="message">15 minutes ago</span>
								</a>
							</li>
							<li>
								<a href="#" class="clearfix">
									<div class="image">
										<i class="fas fa-signal bg-success text-light"></i>
									</div>
									<span class="title">Connection Restaured</span>
									<span class="message">10/10/2017</span>
								</a>
							</li>
						</ul>

						<hr />

						<div class="text-right">
							<a href="{{ url('/message') }}" class="view-more">View All</a>
						</div>
					</div>
				</div>
			</li>

		</ul>

		<span class="separator"></span>
	
		<div id="userbox" class="userbox">
			<a href="#" data-toggle="dropdown">

				<figure class="profile-picture">

					@if (Auth::user()->client && Auth::user()->client->profile_picture)

						<img src="{{ asset('uploads/profile_pic') }}/{{ !auth()->user()->client->profile_picture ? 'avatar.png' :  auth()->user()->client->profile_picture }}" alt="{{ ucfirst(auth()->user()->name) }}" class="rounded-circle" data-lock-picture="{{ asset('uploads/profile_pic') }}/{{ !auth()->user()->client->profile_picture ? 'avatar.png' :  auth()->user()->client->profile_picture }}" />
					@else
						<img src="{{ asset('uploads/profile_pic/avatar.png') }}" alt="{{ ucfirst(auth()->user()->name) }}" class="rounded-circle" />
					@endif

				</figure>
				<div class="profile-info" data-lock-name="{{ ucfirst(auth()->user()->name) }}" data-lock-email="{{ ucfirst(auth()->user()->email) }}">
					<span class="name">{{ ucfirst(auth()->user()->name) }}</span>
					@if (auth()->user()->isAdmin())
					
						<span class="role">Administrator</span>
					@else
						<span class="role">{{ auth()->user()->getRoleNames()->implode(' ') }}</span>
					@endif

				</div>

				<i class="fa custom-caret"></i>
			</a>

			<div class="dropdown-menu">
				<ul class="list-unstyled mb-2">
					<li class="divider"></li>
					<li>
						<a role="menuitem" tabindex="-1" href="{{ route('profile') }}"><i class="fas fa-user"></i> My Profile</a>
					</li>
					<li>
						<a role="menuitem" tabindex="-1" href="#" data-lock-screen="true"><i class="fas fa-lock"></i> Lock Screen</a>
					</li>
					<li>
						{{-- <a role="menuitem" tabindex="-1" href="pages-signin.html"><i class="fas fa-power-off"></i> Logout</a> --}}

						<a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i> Sign Out

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- end: search & user box -->
</header>