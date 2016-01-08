@extends ('backend.layouts.master')

@section ('title', "Inbox")

@section('page-header')
    <h1>
        Sent
        <small>Mail Sent Items</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.mail.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.mail.header-buttons')
    <div class="box-body no-padding">

        <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Last Message</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($sent as $thread)
                    <tr>
                        <td class="mailbox-name">
                            <a href="{{ route('admin.employer.mail.view', $thread->id) }}">
                                {{ $thread->name }}
                            </a>
                        </td>
                        <td class="mailbox-subject">
                            <a href="{{ route('admin.employer.mail.view', $thread->thread_id) }}">
                            {{ $thread->subject }}
                            </a>
                        </td>
                        <td class="mailbox-date">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.employer.mail.view', $thread->id) }}" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i>
                                View
                            </a>
                            <a href="{{ route('admin.employer.mail.destroy', $thread->thread_id) }}" data-method="delete" class="btn btn-xs btn-danger">
                                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="Delete"></i>
                                Delete
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <br>

            <div class="pull-left">
                {{ $sent->total() }} thread(s) total
            </div>

            <div class="pull-right">
                {!! $sent->render() !!}
            </div>

        </div>

    </div>

    <div class="clearfix"></div>
@stop