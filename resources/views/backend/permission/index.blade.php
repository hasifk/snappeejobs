@extends ('backend.layouts.master')

@section ('title', 'Admin Company Profile')

@section('page-header')
<h1>
    Employer Company Profile
    <small>View Company Profile</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.employer.company.showprofile', 'Company Profile' ) !!}</li>
@endsection

@section('content')

@include('backend.employer.includes.partials.company.header-buttons')

<h3>Company Profile</h3>

<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="profile">
        <table class="table table-striped table-hover table-bordered dashboard-table">
            <tr>
                <td>Allowable Permission</td>
                <td>
                    <table>
                        @foreach($permissions as $permission)
                        <tr>
                            <td>{{ $permission->display_name }}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
