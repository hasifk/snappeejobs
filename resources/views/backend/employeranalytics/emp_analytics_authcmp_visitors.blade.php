@extends('backend.layouts.master')

@section('page-header')
    <h1>
        SnappeeJobs
        <small>{{ trans('strings.backend.dashboard_title') }}</small>
    </h1>
@endsection

@section('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{{ trans('strings.here') }}</li>
@endsection

@section('content')




        @roles(['Employer', 'Employer Staff'])



        @if(count($company_auth_visitors)>0 )



        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Company Visitors</h3>
            </div><!-- /.box-header -->
            <div class="box-body">
                <table class="table table-bordered">
                    <tr>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Latitude</th>
                        <th style="width: 40px">Longitude</th>
                    </tr>

                    @if(count($company_auth_visitors)>0)
                        @foreach($company_auth_visitors as $cmp)
                            <tr>
                                <td> <a href="{{ route('jobseeker.show' , [ $cmp->user_id ] ) }}">{{ $cmp->name }}</a></td>
                                <td>{{$cmp->country}}</td>
                                <td>
                                    {{$cmp->latitude}}
                                </td>
                                <td>{{$cmp->longitude}}</td>
                            </tr>
                        @endforeach

                            <div class="col-md-12 center-block">
                                {!! $company_auth_visitors->render() !!}
                            </div>
                         @endif

</table>
</div><!-- /.box-body -->

</div><!-- /.box -->
@endif
@endauth




@endsection

