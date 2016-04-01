@extends ('backend.layouts.master')

@section ('title', "Projects Management")

@section('page-header')
    <h1>
        Projects Management
    </h1>
@endsection

@section('content')

    @include('backend.projects.includes.partials.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Title</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

            @foreach($projects as $project)
                <tr>
                    <td>{{ $project->title }}</td>
                    <td>{!! $project->action_buttons !!}</td>
                </tr>
                
            @endforeach

        </tbody>
    </table>

    <div class="clearfix"></div>
@stop