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
              <form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                  <input type="text" name="q" class="form-control" placeholder="{{ trans('strings.search_placeholder') }}"/>
                  <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                  </span>
                </div>
              </form>
              <!-- /.search form -->

              <!-- Sidebar Menu -->
              <ul class="sidebar-menu">
                <li class="header">{{ trans('menus.general') }}</li>

                <!-- Optionally, you can add icons to the links -->
                <li class="{{ Active::pattern('admin/dashboard') }}"><a href="{!!route('backend.dashboard')!!}"><span>{{ trans('menus.dashboard') }}</span></a></li>

                @role('Administrator')
                    @permission('view-access-management')
                      <li class="{{ Active::pattern('admin/access/*') }}"><a href="{!!url('admin/access/users')!!}"><span>{{ trans('menus.access_management') }}</span></a></li>
                    @endauth
                @endauth

                @role('Employer')
                  <li class="{{ Active::pattern('admin/employer/staffs') }}"><a href="{!!url('admin/employer/staffs')!!}"><span>Staff Management</span></a></li>
                @endauth

                @roles(['Employer', 'Employer Staff'])
                  @permission('company-profile-view')
                    <li class="{{ Active::pattern('admin/employer/profile-view') }}"><a href="{!! route('admin.employer.company.showprofile') !!}"><span>Company Profile</span></a></li>
                  @endauth
                @endauth

                @roles(['Employer', 'Employer Staff'])
                  @permission('employer-jobs-view')
                    <li class="{{ Active::pattern('admin/employer/jobs/*') }}"><a href="{!!url('admin/employer/jobs')!!}"><span>Jobs</span></a></li>
                  @endauth
                @endauth

                @roles(['Employer'])
                  @permission('employer-settings')
                    <li class="{{ Active::pattern('admin/employer/settings/dashboard') }}"><a href="{!!url('admin/employer/settings/dashboard')!!}"><span>Settings</span></a></li>
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
