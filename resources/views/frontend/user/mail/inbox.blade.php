@extends('frontend.layouts.master')

@section('content')

    <div class="box-body no-padding">

        <div class="table-responsive mailbox-messages">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Last Message</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($inbox as $thread)
                    <tr>
                        <td>
                            @if (!$thread->read_at)
                                <span class="badge">New</span>
                            @endif
                        </td>
                        <td class="mailbox-name">
                            <a href="{{ route('frontend.message', $thread->thread_id) }}">
                                {{ $thread->name }}
                            </a>
                        </td>
                        <td class="mailbox-subject">
                            @if ($thread->read_at)
                                <a href="{{ route('frontend.message', $thread->thread_id) }}">
                                    {{ $thread->subject }}
                                </a>
                            @else
                                <a href="{{ route('frontend.message', $thread->thread_id) }}">
                                    <b>
                                        {{ $thread->subject }}
                                    </b>
                                </a>
                            @endif
                        </td>
                        <td class="mailbox-date">{{ \Carbon\Carbon::parse($thread->updated_at)->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('frontend.message', $thread->thread_id) }}" class="btn btn-xs btn-info">
                                <i class="fa fa-eye"></i>
                                View
                            </a>
                            <a href="{{ route('frontend.message.destroy', $thread->thread_id) }}" data-method="delete" class="btn btn-xs btn-danger">
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

@endsection
