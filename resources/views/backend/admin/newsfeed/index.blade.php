@extends ('backend.layouts.master')

@section ('title', "Company Management")

@section('page-header')
    <h1>
        Company Management
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.newsfeeds.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>News</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $f=1; ?>
        @foreach ($newsfeeds as $newsfeed)
            <tr>
                <td>{{ $f++ }}</td>
                <td>{{ $newsfeed->news }}</td>
                <td>{!! $newsfeed->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="clearfix"></div>
@endsection
