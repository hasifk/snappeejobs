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

        @if ($company)
        <div role="tabpanel" class="tab-pane active" id="profile">
            <table class="table table-striped table-hover table-bordered dashboard-table">
                <tr>
                    <th>Title</th>
                    <td>{{ $company->title }}</td>
                </tr>
                <tr>
                    <th>Size</th>
                    <td>{{ $company->size }}</td>
                </tr>
                <tr>
                    <th>Industry associated</th>
                    <td>
                        <table>
                            @foreach($company->industries as $industry)
                            <tr>
                                <td>{{ $industry->name }}</td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Social Media Profiles associated</th>
                    <td>
                        <table>
                            @foreach($company->socialmedia as $social)
                            <tr>
                                <td><a target="_blank" href="{{ $social->url }}">{{ $social->url }}</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $company->description }}</td>
                </tr>
                <tr>
                    <th>What it does</th>
                    <td>{{ $company->what_it_does }}</td>
                </tr>
                <tr>
                    <th>Office Life</th>
                    <td>{{ $company->office_life }}</td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $company->country_name }}</td>
                </tr>
                <tr>
                    <th>State</th>
                    <td>{{ $company->state_name }}</td>
                </tr>
                <tr>
                    <th>Default Photo</th>
                    <td>{{ $company->default_photo }}</td>
                </tr>
                <tr>
                    <th>Logo</th>
                    <td>{{ $company->logo_image }}</td>
                </tr>
                <tr>
                    <th>Likes</th>
                    <td>{{ $company->likes }}</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.created_at') }}</th>
                    <td>{{ $company->created_at }} ({{ $company->created_at->diffForHumans() }})</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.last_updated') }}</th>
                    <td>{{ $company->updated_at }} ({{ $company->updated_at->diffForHumans() }})</td>
                </tr>
                <tr>
                    <th>{{ trans('validation.attributes.actions') }}</th>
                    <td>
                        <a
                            href="{{  route('admin.employer.company.editprofile') }}"
                            class="btn btn-primary btn-xs"
                        >
                            {{ trans('labels.edit_information') }}
                        </a>
                    </td>
                </tr>
            </table>
        </div>
        @else
            There is no company information associated with this account, please fill in.
            <a
                    href="{{  route('admin.employer.company.editprofile') }}"
                    class="btn btn-primary btn-xs"
            >
                Add Company Info
            </a>
        @endif

    </div>

    <div class="clearfix"></div>
@stop