@extends('frontend.layouts.master')

@section('content')
	<div class="row">

		<div class="col-md-10 col-md-offset-1">

			<div class="panel panel-default">
				<div class="panel-heading">{{ trans('navs.dashboard') }}</div>

				<div class="panel-body">
					<div role="tabpanel">

                      <!-- Nav tabs -->
                      <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">{{ trans('navs.my_information') }}</a></li>
                      </ul>

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
                                @if($user->jobseeker_details)
                                <tr>
                                    <th>Profile Completeness</th>
                                    <td>
                                        <div id="canvas-holder" style="margin-left:50px; height: 50px; width: 100px;">
                                            <canvas id="chart-area" />
                                        </div>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <th>{{ trans('validation.attributes.actions') }}</th>
                                    <td>
                                        <a href="{!!route('frontend.profile.edit')!!}" class="btn btn-primary btn-xs">
                                            {{ trans('labels.edit_information') }}
                                            @if( $user->jobseeker_details && ( (!auth()->user()->avatar_filename) || (!auth()->user()->about_me) || (!auth()->user()->country_id) || (!auth()->user()->state_id) ) )
                                            <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                            @endif
                                        </a>
                                        <a href="{!!url('auth/password/change')!!}" class="btn btn-warning btn-xs">{{ trans('navs.change_password') }}</a>
                                        @if ( access()->hasRole('User'))
                                            <a href="{!!route('frontend.resume.edit')!!}" class="btn btn-info btn-xs">
                                                Update Resume
                                                @if( $user->jobseeker_details && !$user->jobseeker_details->has_resume)
                                                    <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                                @endif
                                            </a>
                                            <a href="{!!route('frontend.preferences.edit')!!}" class="btn btn-info btn-xs">
                                                Change Preferences
                                                @if( $user->jobseeker_details && !$user->jobseeker_details->preferences_saved)
                                                    <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                                @endif
                                            </a>
                                            <a href="{!!route('frontend.profile.videos')!!}" class="btn btn-info btn-xs">
                                                Upload Videos
                                                @if( $user->jobseeker_details && ( ! \DB::table('job_seeker_video_profiles')->where('user_id', $user->jobseeker_details->id)->count() ) )
                                                    <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                                @endif
                                            </a>
                                            <a href="{!!route('frontend.profile.images')!!}" class="btn btn-info btn-xs">
                                                Upload Images
                                                @if( $user->jobseeker_details && ( ! \DB::table('job_seeker_images')->where('user_id', $user->jobseeker_details->id)->count() ) )
                                                    <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                                @endif
                                            </a>
                                            <a href="{!!route('frontend.profile.socialmedia')!!}" class="btn btn-info btn-xs">
                                                Connect Social Media
                                                @if( ! \DB::table('user_providers')->where('user_id', $user->id)->count() )
                                                    <span style="margin: 0; padding: 0;" class="alert alert-danger badge">!</span>
                                                @endif
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div><!--tab panel profile-->

                      </div><!--tab content-->

                    </div><!--tab panel-->

				</div><!--panel body-->

			</div><!-- panel -->

		</div><!-- col-md-10 -->

	</div><!-- row -->
@endsection

@section('after-scripts-end')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>

    <script>

        var doughnutData = [
            {
                value: {{ $user->jobseeker_details && $user->jobseeker_details->profile_completeness ? $user->jobseeker_details->profile_completeness : '' }},
                color: "#3cb371",
                highlight: "#3cb371",
                label: 'Complete'
            },
            {
                value: {{ 9 - ( $user->jobseeker_details ? $user->jobseeker_details->profile_completeness : 0 ) }},
                color:"#CD5C5C",
                highlight: "#CD5C5C",
                label: 'Not Complete'
            }
        ];
        window.onload = function(){
            var ctx = document.getElementById("chart-area").getContext("2d");
            window.myDoughnut = new Chart(ctx).Doughnut(doughnutData, {responsive : true, tooltipFontSize: 10});
        };
    </script>


@endsection

