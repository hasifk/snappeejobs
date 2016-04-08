@extends ('backend.layouts.master')

@section ('title', "Task Details")

@section('page-header')
    <h1>
        Task Details - {{ $task->title }}
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('admin.projects.index')!!}"><i class="fa fa-dashboard"></i> All Projects</a></li>
    <li>{!! link_to_route('admin.projects.show', $task->projectname, $task->project_id) !!}</li>
    <li class="active">{!! link_to_route('admin.projects.showtask', $task->title, $task->id) !!}</li>
@stop

@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <tbody>
        <tr>
            <td>Title</td>
            <td>{{ $task->title }}</td>
        </tr>
        <tr>
            <td>Members</td>
            <td>{{ $task->allmembers }}</td>
        </tr>
        <tr>
            <td>Edit</td>
            <td><a href="{{ route('admin.projects.edittask', $task->id) }}">Edit</a></td>
        </tr>
        </tbody>
    </table>

    <div class="clearfix"></div>
@stop