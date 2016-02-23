@extends ('backend.layouts.master')

@section ('title', "Company Management")

@section('page-header')
    <h1>
        Company Details {{ $company->title }}
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.company.header-buttons')

    <h3>Company Profile</h3>

    <div class="tab-content">

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
                    <th>Video URLs associated</th>
                    <td>
                        <table>
                            @foreach($company->videos as $video)
                                <tr>
                                    <td><a target="_blank" href="{{ $video->url }}">{{ $video->url }}</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </td>
                </tr>
            </table>
            <?php $poeple_count = $company->people->count(); ?>
            @if ($poeple_count)
                <div class="row">
                    <div class="col-md-2">People</div>
                    <div class="col-md-10">
                        @foreach($company->people as $people)
                            <div class="col-md-{{ 12/$poeple_count }}">
                                <table class="table table-striped table-hover table-bordered dashboard-table">
                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $people->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Designation</th>
                                        <td>{{ $people->designation }}</td>
                                    </tr>
                                    <tr>
                                        <th>Image</th>
                                        <td><img style="width: 25px; height: 25px;" src="{{ $people->image}}" alt="{{ $people->name}}"></td>
                                    </tr>
                                </table>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <?php $photo_count = $company->photos->count(); ?>
            @if ($photo_count)
                <div class="row">
                    <div class="col-md-2">Photos</div>
                    <div class="col-md-10">
                        @foreach($company->photos as $photo)
                            <div class="col-md-{{ 12/$photo_count }}">
                                <img style="max-width: 250px; max-height: 250px;" src="{{ $photo->image}}" alt="{{ $photo->name}}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <table class="table table-striped table-hover table-bordered dashboard-table">
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
                    <td>
                        @if($company->photos()->count())
                            <img
                                    style="height: 25px; width: 25px;"
                                    src="{{ $company->photos()->first()->image }}"
                                    alt="{{ $company->photos()->first()->filename }}"
                            >
                        @endif
                    </td>
                </tr>
                @if($company->logo)
                    <tr>
                        <th>Logo</th>
                        <td>
                            <img
                                    style="height: 25px;
                                width: 25px;"
                                    src="{{ $company->logo_image }}"
                                    alt="{{ $company->logo_image }}"
                            >
                        </td>
                    </tr>
                @endif
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
                                href="{{  route('admin.company.edit', $company->id) }}"
                                class="btn btn-primary btn-xs"
                        >
                            {{ trans('labels.edit_information') }}
                        </a>
                    </td>
                </tr>
            </table>
        </div>

    </div>
@stop
