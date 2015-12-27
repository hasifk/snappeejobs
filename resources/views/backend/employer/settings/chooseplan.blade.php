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
            <h2>Employer Choose Plan</h2>
            <p>Payment</p>
        </div>

        <div role="tabpanel" class="tab-pane active" id="profile">
            <table class="table table-striped table-hover table-bordered dashboard-table">
                <tr>
                    <th>Plan Name</th>
                    <td>{{ $plan['name'] }}</td>
                </tr>
                <tr>
                    <th>Description</th>
                    <td>{{ $plan['description'] }}</td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td> &pound; {{ ($plan['price']/100) }}</td>
                </tr>
                <tr>
                    <th>Addons</th>
                    <td>
                        <ul>
                            @foreach($plan['addons'] as $addon)
                            <li> <b>{{ $addon['label'] }}</b> : {{ $addon['count'] }} </li>
                            @endforeach
                        </ul>
                    </td>
                </tr>
                <tr>
                    <th>
                        Pay with your Credit Card
                    </th>
                    <td>
                        {!! Form::open(['route' => ['admin.employer.settings.selectplan', request()->segment(5) ], 'method' => 'POST']) !!}
                            {!! csrf_field() !!}

                            <script src="https://checkout.stripe.com/checkout.js" class="stripe-button" data-key="{{ config('services.stripe.secret') }}"
                                    data-amount="10000"
                                    data-email="{{ auth()->user()->email }}"
                                    data-name="SnappeeJobs"
                                    data-description="100&pound;"
                                    data-image="/tile.png"
                                    data-label="Pay With your Credit Card"
                                    data-currency="GBP"
                                    data-locale="gb">
                            </script>
                        </form>
                    </td>
                </tr>
            </table>
        </div><!--tab panel profile-->

    </section>

    <div class="clearfix"></div>
@stop