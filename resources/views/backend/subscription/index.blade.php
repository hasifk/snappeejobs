@extends ('backend.layouts.master')

@section ('title', trans('menus.subscription_management'))

@section('page-header')
<h1>
    {{ trans('menus.subscription_management') }}
    <small>{{ trans('menus.active_users') }}</small>
</h1>
@endsection

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('backend.subscription', trans('menus.subscription_management')) !!}</li>
@stop

@section('content')
<br>

<table class="table table-striped table-bordered table-hover">
    <thead>
    <tr>
        <th>{{ trans('subscription.id') }}</th>
        <th>{{ trans('subscription.subscriber_name') }}</th>
        <th>{{ trans('subscription.subscriber_email') }}</th>
        <th>{{ trans('subscription.subscribed_plan') }}</th>
        <th class="visible-lg">{{ trans('subscription.subscribed_at') }}</th>
        <th class="visible-lg">{{ trans('subscription.last_upgrade') }}</th>
        <th>{{ trans('subscription.subscription_status') }}</th>
        <th>{{ trans('subscription.actions') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($subscribed_employers as $key => $employer)
    <tr>
        <td>{!! $key+1 !!}</td>
        <td>{!! $employer->name !!}</td>
        <td>{!! $employer->email !!}</td>
        <td>{{ $employer->stripe_plan }}</td>
        <td class="visible-lg">{!! $employer->created_at !!}</td>
        <td class="visible-lg">{!! $employer->updated_at !!}</td>
        @if( $employer->subscription_ends_at == null)
        <td>Active</td>
        @else
        <td>Expired</td>
        @endif
        <td><a href="{!! route('backend.user.subscription',$employer->id) !!}" class="btn btn-primary btn-xs">Change Plan</a></td>
    </tr>
    @endforeach
    </tbody>
</table>

<div class="pull-left">
    {!! count($subscribed_employers) !!} {{ trans('crud.users.total') }}
</div>

<div class="pull-right">
    {!! $subscribed_employers->render() !!}
</div>

<div class="clearfix"></div>
@stop