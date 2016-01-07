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
    <div class="section-headlines">
        <h2>Upgrade Subscription Plan</h2>
        <!--<p>Payment</p>-->
    </div>
</section>

{!! Form::open(
['route' => 'admin.employer.settings.upgradeplan',
'class' => 'form-horizontal',
'role' => 'form',
'method' => 'post'
]) !!}

    <div class="form-group">
        <label for="office_life" class="col-lg-2 control-label">Upgrade Subscription</label>
        <div class="col-lg-6">
            <select name="plan_id" id="plan_id" class="form-control">
                <option value="">Please select</option>
                @foreach($plans as $plan_details)
                @if($subscription_plan['id'] == $plan_details['id'])
                <option
                    value="{{ $plan_details['id'] }}"
                    {{ $subscription_plan['id'] && $subscription_plan['id'] == $plan_details['id'] ? 'selected="selected"' : '' }}
                    {{ old('plan_id') && $plan_details['id'] == old('plan_id') ? 'selected="selected"' : '' }}
                    >
                    {{ $plan_details['name'] }} ( &#163;{{ $plan_details['price']/100 }} )
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-lg-2">
            <input type="submit" class="btn btn-success btn-xs" value="{{ trans('strings.save_button') }}" />
        </div>
    </div>
</form>

<div class="clearfix"></div>
@stop