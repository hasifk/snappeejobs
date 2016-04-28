@extends ('backend.layouts.master')

@section ('title', "Job Management")

@section('page-header')
    <h1>
        Manage Job Candidates
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.staffs.index', 'Staff Management' ) !!}</li>
@stop

@section('content')


    @if(access()->can('employer-jobs-view-jobapplications'))
    <div style="margin-bottom:10px;">
        <div class="btn-group">
            <button type="button" class="btn btn-primary btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                Menu
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li>
                    <a href="{{route('admin.employer.jobs.manage.applicationstatus')}}">
                        Job Application Status Setting
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="clearfix"></div>
    @endif

    <div>
        <div id="multi">

            @foreach($job_application_statuses_company as $job_application_status_company)
            <div class="layer tile">
                <div class="tile__name">{{ $job_application_status_company->name }}</div>
                <div data-job-application-status-company="{{ $job_application_status_company->id }}" class="tile__list">
                    @foreach($job_applications as $job_application)
                        @if($job_application->job_application_status_company_id == $job_application_status_company->id)
                            <div data-user-id="{{ $job_application->user_id }}">
                                <img style="height: 50px; width: 50px;" src="{{ \App\Models\Access\User\User::find($job_application->user_id)->getPictureAttribute(25, 25) }}" alt="">
                                <p>
                                    {{ \App\Models\Access\User\User::find($job_application->user_id)->name }}
                                </p>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            @endforeach

        </div>
    </div>

    <div class="clearfix"></div>
@stop

@section('after-scripts-end')
    <script>
        [].forEach.call(document.getElementById('multi').getElementsByClassName('tile__list'), function (el){
            Sortable.create(el, {
                group: 'photo',
                animation: 150,
                onAdd: function (evt) {
                    var statusData = {
                        user_id : $(evt.item).data('user-id'),
                        from_status : $(evt.from).data('job-application-status-company'),
                        to_status : $(evt.to).data('job-application-status-company')
                    };
                    $.post( '{{ route('admin.employer.jobs.application.changestatus', $job_id) }}', statusData, function(response){
                        console.log(response.status);
                    } );
                }
            });
        });

    </script>
@endsection

@section('after-styles-end')
    <style>

        .title {
            color: #fff;
            padding: 3px 10px;
            display: inline-block;
            position: relative;
            background-color: #FF7373;
            z-index: 1000;
        }
        .title_xl {
            padding: 3px 15px;
            font-size: 40px;
        }

        .tile {
            width: 18%;
            min-width: 175px;
            color: #FF7270;
            padding: 10px 30px;
            text-align: center;
            margin-top: 15px;
            margin-right: 1%;
            background-color: #fff;
            display: inline-block;
            vertical-align: top;
        }
        .tile__name {
            padding-bottom: 10px;
            border-bottom: 1px solid #FF7373;
        }

        .tile__list {
            margin-top: 10px;
        }
        .tile__list:last-child {
            margin-right: 0;
            min-height: 80px;
        }

        .tile__list img {
            cursor: move;
            margin: 10px;
            border-radius: 100%;
        }

        #editable {}
        #editable li {
            position: relative;
        }

        #editable i {
            -webkit-transition: opacity .2s;
            transition: opacity .2s;
            opacity: 0;
            display: block;
            cursor: pointer;
            color: #c00;
            top: 10px;
            right: 40px;
            position: absolute;
            font-style: normal;
        }

        #editable li:hover i {
            opacity: 1;
        }

        #filter {}
        #filter button {
            color: #fff;
            width: 100%;
            border: none;
            outline: 0;
            opacity: .5;
            margin: 10px 0 0;
            transition: opacity .1s ease;
            cursor: pointer;
            background: #5F9EDF;
            padding: 10px 0;
            font-size: 20px;
        }
        #filter button:hover {
            opacity: 1;
        }

        #filter .block__list {
            padding-bottom: 0;
        }

        .drag-handle {
            margin-right: 10px;
            font: bold 20px Sans-Serif;
            color: #5F9EDF;
            display: inline-block;
            cursor: move;
            cursor: -webkit-grabbing;  /* overrides 'move' */
        }

        #todos input {
            padding: 5px;
            font-size: 14px;
            font-family: 'Roboto', sans-serif;
            font-weight: 300;
        }

        #nested ul li {
            background-color: rgba(0,0,0,.05);
        }
    </style>
@endsection

