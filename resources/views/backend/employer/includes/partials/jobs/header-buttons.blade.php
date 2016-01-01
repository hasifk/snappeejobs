    <div style="margin-bottom:10px;">
        <div class="btn-group">
          <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              Menu
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{route('admin.employer.jobs.index')}}">
                    All Jobs
                </a>
            </li>

            @permission('employer-jobs-add')
                <li>
                    <a href="{{route('admin.employer.jobs.create')}}">
                        Create Job
                    </a>
                </li>
            @endauth

            <li class="divider"></li>
            <li>
                <a href="{{route('admin.employer.jobs.deactivated')}}">
                    Deactivated Job
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.jobs.banned')}}">
                    Banned Jobs
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.jobs.deleted')}}">
                    Deleted Jobs
                </a>
            </li>
          </ul>
        </div>
    </div>

    <div class="clearfix"></div>