    <nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">{{ app_name() }}</a>
			</div>

			<div class="collapse navbar-collapse notifications-header" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li>{!! link_to('/', trans('navs.home')) !!}</li>
					@if ( !access()->hasRole('User'))
					<li>{!! link_to('/employers', 'Employers') !!}</li>
					@endif
					<li>{!! link_to('/companies', 'Companies') !!}</li>
					<li>{!! link_to('/jobs', 'Jobs' ) !!}</li>
					<li>{!! link_to('/jobseekers', 'JobSeekers' ) !!}</li>
				</ul>

				<ul class="nav navbar-nav navbar-right">

					@if (Auth::guest())
						<li>{!! link_to('auth/login', trans('navs.login')) !!}</li>
						<li>{!! link_to('auth/register', trans('navs.register')) !!}</li>
					@else

						<li v-cloak v-if="rejected_applications.length" class="dropdown messages-menu">
							<a v-on:click="mark_rejected_applications_read" href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-exclamation"></i>
								<span v-cloak class="label label-success">@{{ rejected_applications.length }}</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have @{{ rejected_applications.length }} job interests rejected</li>
								<li>
									<ul class="menu">
										<li v-for="rejected_application in rejected_applications | orderBy 'created_at' rejected_applications_order">
											<a href="#">
												<div class="pull-left">
													<!-- User Image -->
													<img src="@{{ rejected_application.image }}" class="img-circle" alt="User Image"/>
												</div>
												<!-- Message title and timestamp -->
												<p>
													@{{ rejected_application.message }}
													<br>
													<small><i class="fa fa-clock-o"></i> @{{ rejected_application.was_created }}</small>
												</p>
											</a>
										</li>
									</ul>
								</li>
							</ul>
						</li>

						<li v-cloak v-if="unread_messages.length" class="dropdown messages-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="fa fa-envelope-o"></i>
								<span v-cloak class="label label-success">@{{ unread_messages.length }}</span>
							</a>
							<ul class="dropdown-menu">
								<li class="header">You have @{{ unread_messages.length }} message(s)</li>
								<li>
									<ul class="menu">
										<li v-for="unread_message in unread_messages | orderBy 'created_at' unread_messages_order">
											<a href="/message/@{{ unread_message.thread_id }}">
												<div class="pull-left">
													<!-- User Image -->
													<img src="@{{ unread_message.image }}" class="img-circle" alt="User Image"/>
												</div>
												<!-- Message title and timestamp -->
												<p>
													@{{ unread_message.last_message }}
													<br>
													<small><i class="fa fa-clock-o"></i> @{{ unread_message.was_created }}</small>
												</p>
											</a>
										</li>
									</ul>
								</li>
								<li class="footer"><a href="{{ route('frontend.messages') }}">View all messages</a></li>
							</ul>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
								{{ Auth::user()->name }}
								<img style="height: 25px; width: 25px;" src="{!! access()->user()->getAvatarImage(25) !!}" class="user-image" alt="User Image"/>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu" role="menu">
							    <li>{!! link_to('dashboard', trans('navs.profile')) !!}</li>
							    <li>{!! link_to(route('frontend.profile.favourites'), 'Favourites') !!}</li>
							    @permission('view-backend')
							        <li>{!! link_to_route('backend.dashboard', trans('navs.administration')) !!}</li>
							    @endauth
								@role('User')
								<li>{!! link_to_route('jobseeker.appliedjobs', trans('navs.applied_jobs')) !!}</li>
								@endauth

								<li>{!! link_to('auth/logout', trans('navs.logout')) !!}</li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
