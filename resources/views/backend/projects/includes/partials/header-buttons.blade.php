<div style="margin-bottom:10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Menu
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{route('admin.projects.index')}}">
                    All Project
                </a>
            </li>

            @permission('employer-jobs-add')
            <li>
                <a href="{{route('admin.projects.create')}}">
                    Create Project
                </a>
            </li>
            @endauth
        </ul>
    </div>
</div>

<div class="clearfix"></div>