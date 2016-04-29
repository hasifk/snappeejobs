
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/"><img src="/images/snap-logo-small.png" /></a>
        </div>
        <div id="navbar" class="notifications-header navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="{{ Active::pattern(['/home', '/']) }}">{!! link_to('/', 'HOME') !!}</li>
                @if ( !access()->hasRole('User'))
                    <li class="{{ Active::pattern(['/employers']) }}">{!! link_to('/employers', 'EMPLOYERS') !!}</li>
                @endif
                <li class="{{ Active::pattern(['/companies']) }}">{!! link_to('/companies', 'COMPANIES') !!}</li>
                <li class="{{ Active::pattern(['/jobs']) }}">{!! link_to('/jobs', 'JOBS' ) !!}</li>
                <li class="{{ Active::pattern(['/jobseekers']) }}">{!! link_to('/jobseekers', 'JOBSEEKERS' ) !!}</li>
            </ul>


            <ul @if (auth()->guest()) style="margin-top: 9px;" @endif class="nav navbar-nav navbar-right">

                @if (auth()->user())

                <li v-cloak v-if="rejected_applications.length" class="messages-menu">
                    <a v-on:click="mark_rejected_applications_read" href="#" id="rejected_app_menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-exclamation"></i>
                        <span v-cloak class="label label-success">@{{ rejected_applications.length }}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="rejected_app_menu">
                        <li class="msgheader">You have @{{ rejected_applications.length }} job interests rejected</li>
                        <li v-for="rejected_application in rejected_applications | orderBy 'created_at' rejected_applications_order">
                            <a class="unread_message_item" href="#">
                                @{{{ rejected_application.image }}}
                                <!-- Message title and timestamp -->
                                <p>
                                    @{{ rejected_application.message }}
                                    <br>
                                    <small><i class="fa fa-clock-o"></i> @{{ rejected_application.was_created }}</small>
                                </p>
                                <div class="clearfix"></div>
                            </a>
                        </li>
                    </ul>
                </li>
                <li v-cloak v-if="unread_messages.length" class="messages-menu">
                    <a href="#" id="unread_app_menu" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-envelope-o"></i>
                        <span v-cloak class="label label-success">@{{ unread_messages.length }}</span>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="rejected_app_menu">
                        <li class="msgheader">@{{ unread_messages.length }} new message(s)</li>
                        <li v-for="unread_message in unread_messages | orderBy 'created_at' unread_messages_order">
                            <a class="unread_message_item" href="/message/@{{ unread_message.thread_id }}">
                                @{{{ unread_message.image }}}
                                <!-- Message title and timestamp -->
                                <p>
                                    @{{{ unread_message.last_message }}}
                                    <br>
                                    <small><i class="fa fa-clock-o"></i> @{{ unread_message.was_created }}</small>
                                </p>
                                <div class="clearfix"></div>
                            </a>
                        </li>
                        <li class="footer"><a href="{{ route('frontend.messages') }}">View all messages</a></li>
                    </ul>
                </li>

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                        <img src="{!! access()->user()->getPictureAttribute(39, 39) !!}" class="user-image img-circle" alt="User Image"/>
                        Hey {{ explode(' ', Auth::user()->name)[0] }}
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

                @if (Auth::guest())
                    <li>{!! link_to('auth/login', trans('navs.login')) !!}</li>
                    <li>{!! link_to('auth/register', trans('navs.register')) !!}</li>
                @else


                @endif

            </ul>


        </div><!--/.nav-collapse -->
    </div><!--/.container-fluid -->
</nav>

