<div style="margin-bottom:10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            Menu
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu">
            {{--<li>--}}
                {{--<a href="{{route('admin.employer.mail.dashboard')}}">--}}
                    {{--Mail Dashboard--}}
                {{--</a>--}}
            {{--</li>--}}
            @permission('mail-send-private-message')
            <li>
                <a href="{{route('admin.employer.mail.create')}}">
                    New Message
                </a>
            </li>
            @endauth
            <li>
                <a href="{{route('admin.employer.mail.inbox')}}">
                    Inbox
                </a>
            </li>
            <li>
                <a href="{{route('admin.employer.mail.sent')}}">
                    Sent
                </a>
            </li>
        </ul>
    </div>
</div>

<div class="clearfix"></div>