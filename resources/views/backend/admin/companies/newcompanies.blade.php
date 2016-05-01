@extends ('backend.layouts.master')

@section ('title', "New Companies Management")

@section('page-header')
    <h1>
        New Companies to be registered
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.company.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>Employer</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($newcompanies as $newcompany)
            <tr>
                <td>{{ $newcompany->employer_name }}</td>
                <td>{!! $newcompany->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="pull-left">
        {{ $newcompanies->total() }} job(s) total
    </div>

    <div class="pull-right">
        {!! $newcompanies->render() !!}
    </div>

    <div class="clearfix"></div>
@stop
