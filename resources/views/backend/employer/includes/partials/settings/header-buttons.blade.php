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
            @permission('employer-settings')
            <li>
                <a href="{{route('admin.employer.settings.plan')}}">
                    Subscription Plan
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.settings.usage')}}">
                    View Usage
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.settings.makepaid')}}">
                    Make Paid Company
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.settings.cancel')}}">
                    Cancel
                </a>
            </li>
            @endauth
        </ul>
    </div>
</div>

<div class="clearfix"></div>
