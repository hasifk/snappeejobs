@extends ('backend.layouts.master')

@section ('title', "Projects Details")

@section('page-header')
    <h1>
        Projects Details
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
        </tbody>
    </table>

    <div class="clearfix"></div>
@stop