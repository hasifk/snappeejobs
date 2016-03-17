<div style="margin-bottom:10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Mail
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            <li>
                <a href="{{route('admin.mail.create')}}">
                    New Message
                </a>
            </li>
            <li>
                <a href="{{route('admin.mail.index')}}">
                    Inbox
                </a>
            </li>
            <li>
                <a href="{{route('admin.mail.sent')}}">
                    Sent
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="clearfix"></div>
