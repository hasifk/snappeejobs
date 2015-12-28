@extends ('backend.layouts.master')

@section('after-styles-end')
    {!! HTML::style('css/backend/plugin/plan/plan.css') !!}
@endsection

@section ('title', trans('menus.user_management'))

@section('page-header')
    <h1>
        Employer Settings
        <small>Plan</small>
    </h1>
@endsection

@section ('breadcrumbs')
    <li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
    <li class="active">{!! link_to_route('admin.employer.settings.dashboard', 'Settings' ) !!}</li>
@stop

@section('content')
    @include('backend.employer.includes.partials.settings.header-buttons')

    <section class="section">
        <div class="section-headlines text-center">
            <h2>Employer Pricing Plan</h2>
            <p>Please select any of the plans below</p>
        </div>

        <div class="row-fluid">
            <div class="pricing-table row-fluid text-center">

                @foreach( config('subscription.employer_plans') as $key => $plan )
                    <div class="span4">
                        <div class="plan">
                            <div class="plan-name">
                                <h2>{{ $plan['name'] }}</h2>
                                <p class="muted">{{ $plan['description'] }}</p>
                            </div>
                            <div class="plan-price">
                                <b>${{ $plan['price']/100 }} </b> / month
                            </div>
                            <div class="plan-details">
                                @foreach( $plan['addons'] as $addon )
                                <div>
                                    <b>{{ $addon['count'] }}</b> {{ $addon['label'] }}
                                </div>
                                @endforeach
                            </div>
                            <div class="plan-action">
                                @if( auth()->user()->onPlan($plan['id']) )
                                    <a href="#" class="btn btn-success dropdown-toggle">Current Plan</a>
                                @else
                                    <a
                                            href="{!!route('admin.employer.settings.choose-plan', $key)!!}"
                                            class="btn btn-primary dropdown-toggle">
                                        Choose Plan
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <p class="muted text-center">Note: You can change or cancel your plan at anytime in your account settings.</p>
        </div>
    </section>

    <div class="clearfix"></div>
@stop