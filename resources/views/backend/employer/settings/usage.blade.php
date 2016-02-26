@extends ('backend.layouts.master')

@section ('title', trans('menus.user_management'))

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

    <h3>Plan Usage</h3>

    <h5>Plan Usage</h5>
    <table class="table">
        <tr>
            <td>Type</td>
            <td>Used</td>
            <td>Limit</td>
            <td>Buy</td>
        </tr>
        <tr>
            <td>Job Postings</td>
            <td>{{ $plan_usage->job_postings }}</td>
            <td>{{ $plan_usage->job_postings > $plan_details['addons']['job_postings']['count'] ? $plan_usage->job_postings : $plan_details['addons']['job_postings']['count'] }}</td>
            <td>
                <a href="{{ route('admin.employer.settings.buyaddon', 'job_postings') }}">Buy more</a>
            </td>
        </tr>
        <tr>
            <td>Staff Members</td>
            <td>{{ $plan_usage->staff_members }}</td>
            <td>{{ $plan_usage->staff_members > $plan_details['addons']['staff_members']['count'] ? $plan_usage->staff_members : $plan_details['addons']['staff_members']['count'] }}</td>
            <td>
                <a href="{{ route('admin.employer.settings.buyaddon', 'staff_members') }}">Buy more</a>
            </td>
        </tr>
        <tr>
            <td>Chats Accepted</td>
            <td>{{ $plan_usage->chats_accepted }}</td>
            <td>{{ $plan_usage->chats_accepted > $plan_details['addons']['chats_accepted']['count'] ? $plan_usage->chats_accepted : $plan_details['addons']['chats_accepted']['count'] }}</td>
            <td>
                <a href="{{ route('admin.employer.settings.buyaddon', 'chats_accepted') }}">Buy more</a>
            </td>
        </tr>
    </table>

    <hr>

    <h5>Addon Packs</h5>

    <table class="table">
        @foreach($addonpacks as $addonpackname => $addonpack)
        <tr>
            <td>
                {{ $addonpack['label'] }} :
                Jobs : {{ $addonpack['job_postings'] }},
                Staff Members : {{ $addonpack['staff_members'] }}
                Chats Accepted : {{ $addonpack['chats_accepted'] }}
            </td>
            <td>
                <a href="{{ route('admin.employer.settings.buyaddonpack', $addonpackname) }}">Buy</a>
            </td>
        </tr>
        @endforeach
    </table>

    <div class="clearfix"></div>
@stop
