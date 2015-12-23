    <div style="margin-bottom:10px;">
        <div class="btn-group">
          <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              Staffs
              <span class="caret"></span>
          </button>
          <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{route('admin.employer.staffs.index')}}">
                    All Staffs
                </a>
            </li>

            @permission('create-employer-staff')
                <li>
                    <a href="{{route('admin.employer.staffs.create')}}">
                        Create Staff
                    </a>
                </li>
            @endauth

            <li class="divider"></li>
            <li>
                <a href="{{route('admin.employer.staffs.deactivated')}}">
                    Deactivated Staffs
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.staffs.banned')}}">
                    Banned Staffs
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.staffs.deleted')}}">
                    Deleted Staffs
                </a>
            </li>
          </ul>
        </div>
    </div>

    <div class="clearfix"></div>