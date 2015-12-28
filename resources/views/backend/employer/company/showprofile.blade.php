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
@stop

@section('content')
    @include('backend.employer.includes.partials.company.header-buttons')

    <h3>Company Profile</h3>

    <div class="tab-content">

        <div role="tabpanel" class="tab-pane active" id="profile">
            <table class="table table-striped table-hover table-bordered dashboard-table">
                <tr>
                    <th>{{ trans('validation.attributes.name') }}</th>
                    <td>{!! $user->name !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.email') }}</th>
                    <td>{!! $user->email !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.profile_image') }}</th>
                    <td>
                        <img style="height: 20px; width: 20px;" src="{!! $user->getAvatarImage(25) !!}" alt="{{ $user->name }}">
                    </td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.about_me') }}</th>
                    <td>{!! $user->about_me !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.country') }}</th>
                    <td>{!! $user->country_name !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.state') }}</th>
                    <td>{!! $user->state_name !!}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.created_at') }}</th>
                    <td>{!! $user->created_at !!} ({!! $user->created_at->diffForHumans() !!})</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.last_updated') }}</th>
                    <td>{!! $user->updated_at !!} ({!! $user->updated_at->diffForHumans() !!})</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.actions') }}</th>
                    <td>
                        <a href="{!!route('frontend.profile.edit')!!}" class="btn btn-primary btn-xs">{{ trans('labels.edit_information') }}</a>
                        <a href="{!!url('auth/password/change')!!}" class="btn btn-warning btn-xs">{{ trans('navs.change_password') }}</a>
                    </td>
                </tr>
            </table>
        </div><!--tab panel profile-->

    </div>

    <div class="clearfix"></div>
@stop