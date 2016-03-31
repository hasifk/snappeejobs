          <!-- Left side column. contains the logo and sidebar -->
          <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
              <!-- Sidebar user panel (optional) -->
              <div class="user-panel">
                <div class="pull-left image">
                  <img src="{!! access()->user()->picture !!}" class="img-circle" alt="User Image" />
                </div>
                <div class="pull-left info">
                  <p>{{ access()->user()->name }}</p>
                  <!-- Status -->
                  <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
                </div>
              </div>

              <!-- search form (Optional) -->
              @role('Employer')
              {!! Form::open(array('url' =>  route('backend.employersearch'),'class' => 'sidebar-form' ,'method' => 'get')) !!}
              {{ csrf_field() }}
                <div class="input-group">
                  <input type="text" name="emp_search_key" class="form-control" placeholder="{{ trans('strings.search_placeholder') }}" value="{{ old('emp_search_key') }}"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              {!! Form::close() !!}
              @endauth
              <!-- /.search form -->

              <!-- Sidebar Menu -->
              <ul class="sidebar-menu">
                <li class="header">{{ trans('menus.general') }}</li>

                <!-- Optionally, you can add icons to the links -->
                <li class="{{ Active::pattern('admin/dashboard') }}">
                  <a href="{!!route('backend.dashboard')!!}">
                    <i class="fa fa-dashboard"></i>
                    <span>{{ trans('menus.dashboard') }}</span>
                  </a>
                </li>

                @role('Administrator')
                    @permission('view-access-management')
                      <li class="{{ Active::pattern('admin/access/*') }}">
                        <a href="{!!url('admin/access/users')!!}">
                          <i class="fa fa-users"></i>
                          <span>
                            {{ trans('menus.access_management') }}
                          </span>
                        </a>
                      </li>
                      <li class="{{ Active::pattern('admin/subscription/*') }}">
                        <a href="{!!url('admin/subscription/')!!}">
                          <i class="fa fa-credit-card"></i>
                              <span>
                                {{ trans('menus.subscription_management') }}
                              </span>
                        </a>
                      </li>
                      <li class="{{ Active::pattern('admin/companies/*') }}">
                        <a href="{!!url('admin/companies/')!!}">
                          <i class="fa fa-building"></i>
                              <span>
                                Company Management
                              </span>
                        </a>
                      </li>
                      <li class="{{ Active::pattern('admin/jobseekers/*') }}">
                        <a href="{!!url(route('backend.jobseekers'))!!}">
                          <i class="fa fa-suitcase"></i>
                              <span>
                                {{ 'Jobseekers' }}
                              </span>
                        </a>
                      </li>
                    @endauth
                @endauth

                @role('Employer')
                  <li class="{{ Active::pattern('admin/employer/staffs') }}">
                    <a href="{!!url('admin/employer/staffs')!!}">
                      <i class="fa fa-users"></i>
                      <span>
                        Staff Management
                      </span>
                    </a>
                  </li>
                @endauth

                @roles(['Employer', 'Employer Staff'])
                  @permission('company-profile-view')
                    <li class="{{ Active::pattern('admin/employer/profile-view') }}">
                      <a href="{!! route('admin.employer.company.showprofile') !!}">
                        <i class="fa fa-building"></i>
                        <span>
                          Company Profile
                        </span>
                      </a>
                    </li>
                  @endauth
                  <li class="{{ Active::pattern('admin/employer/groupchat') }}">
                    <a href="{!! route('admin.employer.groupchat') !!}">
                      <i class="fa fa-wechat"></i>
                          <span>
                            Global Chat Room
                          </span>
                    </a>
                  </li>
                @endauth

                @roles(['Employer', 'Employer Staff'])
                  @permission('employer-jobs-view')
                    <li class="{{ Active::pattern('admin/employer/jobs/*') }}">
                      <a href="{!!url('admin/employer/jobs')!!}">
                        <i class="fa fa-suitcase"></i>
                        <span>
                          Jobs
                        </span>
                      </a>
                    </li>
                  @endauth
                @endauth


                @roles(['Employer', 'Employer Staff'])
                @permission('employer-jobs-view-jobapplications')
                <li class="{{ Active::pattern('admin/employer/jobs/*') }}">
                  <a href="{!!route('admin.employer.jobs.applications')!!}">
                    <i class="fa fa-suitcase"></i>
                        <span>
                          Job Applications
                        </span>
                  </a>
                </li>
                @endauth
                @endauth

                @roles(['Employer'])
                @permission('employer-settings')
                <li class="{{ Active::pattern('admin/jobseekers/*') }}">
                  <a href="{!!url(route('backend.employerjobseekers'))!!}">
                    <i class="fa fa-suitcase"></i>
                        <span>
                          Jobseekers
                        </span>
                  </a>
                </li>
                @endauth
                @endauth

                @roles(['Employer', 'Employer Staff'])
                  @permission('mail-view-private-messages')
                    <li class="{{ Active::pattern('admin/employer/mail/dashboard') }} treeview">
                      <a href="#">
                        <i class="fa fa-envelope"></i>
                        <span>Mail</span>
                        <i class="fa fa-angle-left pull-right"></i>
                      </a>
                      <ul
                              class="treeview-menu {{ Active::pattern('admin/employer/mail/*', 'menu-open') }}"
                              style="display: none; {{ Active::pattern('admin/employer/mail/*', 'display: block;') }}">
                        <li class="{{ Active::pattern('admin/employer/mail/create') }}">
                          <a href="{!! url('admin/employer/mail/create') !!}">{{ 'Compose' }}</a>
                        </li>
                        <li class="{{ Active::pattern('admin/employer/mail/inbox') }}">
                          <a href="{!! url('admin/employer/mail/inbox') !!}">
                            {{ 'Inbox' }}
                            @if ($unread_messages_count)
                            <span class="label label-primary pull-right">{{ $unread_messages_count }}</span>
                            @endif
                          </a>
                        </li>
                        <li class="{{ Active::pattern('admin/employer/mail/sent') }}">
                          <a href="{!! url('admin/employer/mail/sent') !!}">{{ 'Sent' }}</a>
                        </li>
                      </ul>
                    </li>
                  @endauth
                @endauth

                @roles(['Employer'])
                @permission('employer-settings')
                <li class="{{ Active::pattern('admin/employer/settings/dashboard') }}">
                  <a href="{!!url('admin/employer/settings/dashboard')!!}">
                    <i class="fa fa-cog"></i>
                        <span>
                          Settings
                        </span>
                  </a>
                </li>
                @endauth
                @endauth

                @roles(['Employer','Employer Staff'])

                <li class="{{ Active::pattern('admin/employer/employeranalytics') }} treeview">
                  <a href="#">
                    <i class="fa fa-envelope"></i>
                    <span>Employer Analytics</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul
                          class="treeview-menu {{ Active::pattern('admin/employer/employeranalytics/*', 'menu-open') }}"
                          style="display: none; {{ Active::pattern('admin/employer/mail/*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/employeranalytics/interestedjobs') }}">
                      <a href="{!! url('admin/employeranalytics/interestedjobs') !!}">{{ 'Jobs Interested' }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/employeranalytics/notinterestedjobs') }}">
                      <a href="{!! url('admin/employeranalytics/notinterestedjobs') !!}">{{ 'Jobs Not Interested' }}</a>
                    </li>

                    <li class="{{ Active::pattern('admin/employeranalytics/companyvisitors') }}">
                      <a href="{!! url('admin/employeranalytics/companyvisitors') !!}">{{ 'Company Visitors' }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/employeranalytics/jobvisitors') }}">
                      <a href="{!! url('admin/employeranalytics/jobvisitors') !!}">{{ 'Job Visitors' }}</a>
                    </li>

                    <li class="{{ Active::pattern('admin/employeranalytics/uniquejobvisitors') }}">
                      <a href="{!! url('admin/employeranalytics/uniquejobvisitors') !!}">{{ 'Unique Job Visitors' }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/employeranalytics/uniquecompanyvisitors') }}">
                      <a href="{!! url('admin/employeranalytics/uniquecompanyvisitors') !!}">{{ 'Unique Company Visitors' }}</a>
                    </li>
                  </ul>
                </li>
                @endauth

                @role('Administrator')
                  @permission('message-employers')

                    <li class="{{ Active::pattern('admin/mail/*') }}">
                      <a href="{{ route('admin.mail.index') }}">
                        <i class="fa fa-envelope"></i>
                            <span>
                              Mailbox
                            </span>
                      </a>
                    </li>

                  @endauth
                @endauth


                @role('Employer')
                @permission('create-project')

                <li class="{{ Active::pattern('admin/projects/*') }}">
                  <a href="{{ route('admin.projects.index') }}">
                    <i class="fa fa-folder-open"></i>
                            <span>
                              Projects
                            </span>
                  </a>
                </li>

                @endauth
                @endauth


                <li class="{{ Active::pattern('admin/log-viewer*') }} treeview">
                  <a href="#">
                    <span>{{ trans('menus.log-viewer.main') }}</span>
                    <i class="fa fa-angle-left pull-right"></i>
                  </a>
                  <ul class="treeview-menu {{ Active::pattern('admin/log-viewer*', 'menu-open') }}" style="display: none; {{ Active::pattern('admin/log-viewer*', 'display: block;') }}">
                    <li class="{{ Active::pattern('admin/log-viewer') }}">
                      <a href="{!! url('admin/log-viewer') !!}">{{ trans('menus.log-viewer.dashboard') }}</a>
                    </li>
                    <li class="{{ Active::pattern('admin/log-viewer/logs') }}">
                      <a href="{!! url('admin/log-viewer/logs') !!}">{{ trans('menus.log-viewer.logs') }}</a>
                    </li>
                  </ul>
                </li>

              </ul><!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
          </aside>
