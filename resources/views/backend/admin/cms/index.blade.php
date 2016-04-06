@extends ('backend.layouts.master')

@section ('title', "Company Management")

@section('page-header')
    <h1>
        Company Management
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.cms.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Article</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $f=1; ?>
        @foreach ($cms as $value)
            <tr>
                <td>{{ $f++ }}</td>
                <td>{{ $value->header }}</td>
                <td>{!! $value->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="clearfix"></div>
@endsection
