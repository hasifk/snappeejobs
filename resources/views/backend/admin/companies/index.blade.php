@extends ('backend.layouts.master')

@section ('title', "Company Management")

@section('page-header')
    <h1>
        Company Management
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.company.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Company</th>
            <th>Country</th>
            <th>State</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($companies as $company)
            <tr>
                <td>{{ $company->title }}</td>
                <td>{{ $company->country->name }}</td>
                <td>{!! $company->state->name !!}</td>
                <td>{!! $company->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {{ $companies->total() }} job(s) total
    </div>

    <div class="pull-right">
        {!! $companies->render() !!}
    </div>

    <div class="clearfix"></div>
@stop
