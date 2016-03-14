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
    <div class="row">




        @roles(['Employer', 'Employer Staff'])
        <h3>Fav Job Analytics</h3>
        {{-- <div class="col-lg-3 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-aqua">
                 <div class="inner">
                     <h3>{{ $total_jobs_posted }}</h3>

                     <p>Total Jobs Posted</p>
                 </div>
                 <div class="icon">
                     <i class="ion-eye"></i>
                 </div>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-green">
                 <div class="inner">
                     <h3>{{ $total_job_application }}</h3>

                     <p>Job Applications Received</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-card"></i>
                 </div>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-yellow">
                 <div class="inner">
                     <h3>{{ $total_staff_members }}</h3>

                     <p>Staff Members</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-ios-people-outline"></i>
                 </div>
             </div>
         </div>
         <!-- ./col -->
         <div class="col-lg-3 col-xs-6">
             <!-- small box -->
             <div class="small-box bg-red">
                 <div class="inner">
                     <h3>{{ $new_messages }}</h3>

                     <p>New Messages</p>
                 </div>
                 <div class="icon">
                     <i class="ion ion-email-unread"></i>
                 </div>
             </div>
         </div>--}}

        @endauth

    </div>



@endsection

@section('after-scripts-end')



@endsection