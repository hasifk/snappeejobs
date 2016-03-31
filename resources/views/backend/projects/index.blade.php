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
            <th>Level</th>
            <th>Status</th>
            <th>Published</th>
            <th>Likes</th>
            <th>Country</th>
            <th>State</th>
            <th>{{ trans('crud.actions') }}</th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <div class="clearfix"></div>
@stop