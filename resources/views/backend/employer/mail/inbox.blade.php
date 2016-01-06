@extends ('backend.layouts.master')

@section ('title', "Inbox")

@section('page-header')
    <h1>
        Inbox
        <small>Mail Dashboard</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.mail.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.mail.header-buttons')

    <div class="box-body no-padding">

        <div class="mailbox-controls">
            <!-- Check all button -->
            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-check-square-o"></i>
            </button>
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
            </div>
        </div>

        <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>Action</th>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Last Message</th>
                    <th>View</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($inbox as $thread)
                    <tr>
                        <td>
                            <div>
                                <input type="checkbox">
                            </div>
                        </td>
                        <td class="mailbox-name">
                            <a href="{{ route('admin.employer.mail.view', $thread->id) }}">
                                {{ $thread->name }}
                            </a>
                        </td>
                        <td class="mailbox-subject">
                            {{ $thread->subject }}
                        </td>
                        <td class="mailbox-date">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('admin.employer.mail.view', $thread->id) }}" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i>
                                View
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class="pull-left">
                {{ $inbox->total() }} thread(s) total
            </div>

            <div class="pull-right">
                {!! $inbox->render() !!}
            </div>


            <!-- /.table -->
        </div>
        <!-- /.mail-box-messages -->
    </div>

    <div class="clearfix"></div>
@stop