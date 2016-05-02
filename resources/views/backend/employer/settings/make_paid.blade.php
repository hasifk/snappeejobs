@extends ('backend.layouts.master')

@section ('title', trans('menus.make_paid'))

@section('page-header')
    <h1>
        Employer Settings
        <small>Settings Dashboard</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.settings.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.settings.header-buttons')

    <h3>Make Your Company Paid</h3>

    <h5>Company</h5>
    <table class="table">

        <tr>
            {!! Form::open(array('url' =>  route('admin.employer.settings.savecmppaid'),'class' => 'form-horizontal' )) !!}
            {{ csrf_field() }}
            <td>{{$company_info->title}}</td>
            @if($company_info->paid_expiry > \Carbon\Carbon::now())
                <td>Expires at: {{$company_info->paid_expiry}}</td>
                <td>{!! Form::label('', 'Paid Company') !!}
                    {!!  Form::checkbox('select_company','1','true', ['class' => 'select2']) !!}</td>

            @else
            <td>{!! Form::label('', 'Select Company') !!}
                {!!  Form::checkbox('select_company','0','', ['class' => 'select2']) !!}</td>
            <td>

                {!! Form::submit('Make Paid', array('class' => 'btn btn-success btn-xs')) !!}

            </td>
            @endif
            {!! Form::close() !!}
        </tr>
    </table>
    <div class="clearfix"></div>
    <hr>
@if(!empty($job_list))
    <h5>Job List</h5>
    <table class="table">
        @foreach($job_list as $key=> $value)
        <tr>

            {!! Form::open(array('url' =>  route('admin.employer.settings.savejobpaid'),'class' => 'form-horizontal' )) !!}
            {{ csrf_field() }}
            <td>
                {{ $value->title}} :

            </td>
            @if($value->paid_expiry > \Carbon\Carbon::now())
                <td>Expires at: {{$value->paid_expiry}}</td>
                <td>{!! Form::label('', 'Paid Job') !!}
                    {!!  Form::checkbox('select_job','1','true', ['class' => 'select2']) !!}</td>

                @else
            <td>{!! Form::label('', 'Select Job') !!}
                {!!  Form::checkbox('select_job','0','', ['class' => 'select2']) !!}</td>
            <td>
                {!! Form::submit('Make Paid', array('class' => 'btn btn-success btn-xs')) !!}

            </td>
            @endif
            {!! Form::hidden('job_id', $value->id) !!}
                {!! Form::close() !!}

        </tr>
        @endforeach
    </table>
    @endif

    <div class="clearfix"></div>
@stop
