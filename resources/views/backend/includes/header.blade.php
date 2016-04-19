          <!-- Main Header -->
          <header class="main-header notifications-header">

            <!-- Logo -->
            <a href="{!!route('home')!!}" class="logo">SnappeeJobs</a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
              <!-- Sidebar toggle button-->
              <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">{{ trans('labels.toggle_navigation') }}</span>
              </a>
              <!-- Navbar Right Menu -->
              <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                  <!-- Messages: style can be found in dropdown.less-->
                  @if ($unread_messages_count)
                  <li class="dropdown messages-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-envelope-o"></i>
                      <span class="label label-success">{{ $unread_messages_count }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">You have {{ $unread_messages_count }} message(s)</li>
                      <li>
                        <!-- inner menu: contains the messages -->
                        <ul class="menu">
                          @foreach($unread_messages as $unread_message)
                          <li><!-- start message -->
                            @role('Administrator')
                            <a href="{{ route('admin.mail.view', $unread_message->thread_id) }}">
                            @else
                                <a href="{{ route('admin.employer.mail.view', $unread_message->thread_id) }}">
                            @endauth
                              <div class="pull-left">
                                <!-- User Image -->
                                <img src="{!! \App\Models\Access\User\User::find($unread_message->id)->picture !!}" class="img-circle" alt="User Image"/>
                              </div>
                              <!-- Message title and timestamp -->
                              <h4>
                                {{ $unread_message->name }}
                                <small><i class="fa fa-clock-o"></i> {{ \Carbon\Carbon::parse($unread_message->updated_at)->diffForHumans() }}</small>
                              </h4>
                              <!-- The message -->
                              <p>{{ str_limit(strip_tags($unread_message->last_message), 25) }}</p>
                            </a>
                          </li><!-- end message -->
                          @endforeach
                        </ul><!-- /.menu -->
                      </li>
                      <li class="footer"><a href="{{ route('admin.employer.mail.inbox') }}">{{ trans('strings.see_all.messages') }}</a></li>
                    </ul>
                  </li><!-- /.messages-menu -->
                  @endif


                    <li v-cloak v-if="job_applications.length" class="dropdown messages-menu">
                      <!-- Menu toggle button -->
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-suitcase"></i>
                        <span v-cloak class="label label-success">@{{ job_applications.length }}</span>
                      </a>
                      <ul class="dropdown-menu">
                        <li class="header">You have @{{ job_applications.length }} job application(s)</li>
                        <li>
                          <!-- inner menu: contains the messages -->
                          <ul class="menu">

                              <li v-for="job_application in job_applications | orderBy 'created_at' job_applications_order"><!-- start message -->
                                <a href="/admin/employer/jobs/application/@{{ job_application.id }}">
                                  <div class="pull-left">
                                    <!-- User Image -->
                                    <img src="@{{ job_application.image }}" class="img-circle" alt="User Image"/>
                                  </div>
                                  <!-- Message title and timestamp -->
                                  <p>
                                    @{{ job_application.name }} applied for
                                    <br>
                                    <strong>@{{ job_application.title }}</strong>
                                    <br>
                                    <small><i class="fa fa-clock-o"></i> @{{ job_application.was_created }}</small>
                                  </p>
                                </a>
                              </li><!-- end message -->

                          </ul><!-- /.menu -->
                        </li>
                        <li class="footer"><a href="{{ route('admin.employer.jobs.applications') }}">View all job applications</a></li>
                      </ul>
                    </li><!-- /.messages-menu -->


                    <li v-cloak v-if="tasks_assigned.length" class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-flag"></i>
                            <span v-cloak class="label label-danger">@{{ tasks_assigned.length }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">You have @{{ tasks_assigned.length }} task(s) assigned</li>

                            <li>
                                <ul class="menu">
                                    <li v-for="task_assigned in tasks_assigned | orderBy 'created_at' job_applications_order">
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="@{{ task_assigned.image }}" class="img-circle" alt="User Image"/>
                                            </div>
                                            <p>
                                                <b>@{{ task_assigned.task_title }}</b> from <br>
                                                project <b>@{{ task_assigned.project_title }}</b>
                                                <br>
                                                <small><i class="fa fa-clock-o"></i> @{{ task_assigned.was_created }}</small>
                                            </p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                  <!-- Notifications Menu -->
                  <li style="display: none;" class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-bell-o"></i>
                      <span class="label label-warning">0</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">{{ trans_choice('strings.you_have.notifications', 0) }}</li>
                      <li>
                        <!-- Inner Menu: contains the notifications -->
                        <ul class="menu">
                          <li><!-- start notification -->
                            <a href="#">
                              <i class="fa fa-users text-aqua"></i> 5 new members joined today
                            </a>
                          </li><!-- end notification -->
                        </ul>
                      </li>
                      <li class="footer"><a href="#">{{ trans('strings.see_all.notifications') }}</a></li>
                    </ul>
                  </li>
                  <!-- Tasks Menu -->
                  <li style="display: none;" class="dropdown tasks-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <i class="fa fa-flag-o"></i>
                      <span class="label label-danger">1</span>
                    </a>
                    <ul class="dropdown-menu">
                      <li class="header">{{ trans_choice('strings.you_have.tasks', 1) }}</li>
                      <li>
                        <!-- Inner menu: contains the tasks -->
                        <ul class="menu">
                          <li><!-- Task item -->
                            <a href="#">
                              <!-- Task title and progress text -->
                              <h3>
                                Design some buttons
                                <small class="pull-right">20%</small>
                              </h3>
                              <!-- The progress bar -->
                              <div class="progress xs">
                                <!-- Change the css width attribute to simulate progress -->
                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                  <span class="sr-only">20% Complete</span>
                                </div>
                              </div>
                            </a>
                          </li><!-- end task item -->
                        </ul>
                      </li>
                      <li class="footer">
                        <a href="#">{{ trans('strings.see_all.tasks') }}</a>
                      </li>
                    </ul>
                  </li>
                  <!-- User Account Menu -->
                  <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                      <!-- The user image in the navbar-->
                      <img src="{!! access()->user()->picture !!}" class="user-image" alt="User Image"/>
                      <!-- hidden-xs hides the username on small devices so only the image appears. -->
                      <span class="hidden-xs">{{ access()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu">
                      <!-- The user image in the menu -->
                      <li class="user-header">
                        <img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />
                        <p>
                          {{ access()->user()->name }}
                          <small>{{ trans('strings.member_since') }} {{ auth()->user()->created_at }}</small>
                        </p>
                      </li>
                      <!-- Menu Body -->
                      <!-- <li class="user-body">
                        <div class="col-xs-4 text-center">
                          <a href="#">Link</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Link</a>
                        </div>
                        <div class="col-xs-4 text-center">
                          <a href="#">Link</a>
                        </div>
                      </li> -->
                      <!-- Menu Footer-->
                      <li class="user-footer">
                        <div class="pull-left">
                          <a href="/admin/profile" class="btn btn-default btn-flat">{{ trans('navs.profile') }}</a>
                        </div>
                        <div class="pull-right">
                          <a href="{!!url('auth/logout')!!}" class="btn btn-default btn-flat">{{ trans('navs.logout') }}</a>
                        </div>
                      </li>
                    </ul>
                  </li>
                </ul>
              </div>
            </nav>
          </header>
