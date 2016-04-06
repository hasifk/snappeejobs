@extends ('backend.layouts.master')

@section ('title', "Projects Details")

@section('page-header')
    <h1>
        Projects Details - {{ $project->title }}
    </h1>
@endsection

@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <tbody>
            <tr>
                <td>Title</td>
                <td>{{ $project->title }}</td>
            </tr>
            <tr>
                <td>Members</td>
                <td>{{ $members }}</td>
            </tr>
            <tr>
                <td>Job Listings</td>
                <td>{{ $job_listings }}</td>
            </tr>
            @if($project_tasks)
            <tr>
                <td>Tasks</td>
                <td>
                    <ul class="list-group">
                        @foreach($project_tasks as $project_task)
                        <li class="list-group-item">
                            {{ $project_task->title }}
                            &nbsp;
                            <a href="#" class="btn btn-primary">View</a>
                            &nbsp;
                            <a href="#" class="btn btn-primary">Edit</a>
                        </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endif
            <tr>
                <td>
                    Add Tasks
                </td>
                <td>
                    <a href="{{ route('admin.projects.assign-tasks', $project->id) }}" class="btb btn-xs">
                        <i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="" data-original-title="Add"></i>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="clearfix"></div>
@stop