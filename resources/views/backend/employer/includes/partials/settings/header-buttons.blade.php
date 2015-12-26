<div style="margin-bottom:10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Settings
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{route('admin.employer.settings.dashboard')}}">
                    Settings Dashboard
                </a>
            </li>
            <li class="divider"></li>
            @permission('create-employer-staff')
            <li>
                <a href="{{route('admin.employer.settings.plan')}}">
                    Plan
                </a>
            </li>
            @endauth
        </ul>
    </div>
</div>

<div class="clearfix"></div>