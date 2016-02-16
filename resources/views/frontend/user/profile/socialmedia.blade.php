@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Social Media</div>

                <div class="panel-body">

                    <table class="table">
                        {{--<tr>--}}
                            {{--<td>Linkedin</td>--}}
                            {{--<td>--}}
                                {{--@if ( auth()->user()->providers->count() && in_array('linkedin', auth()->user()->providers()->lists('provider')->toArray()) )--}}
                                    {{--Connected to Linkedin--}}
                                {{--@else--}}
                                    {{--<a href="{{ route('auth.linkedin') }}">Connect to Linkedin</a>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        <tr>
                            <td>Facebook</td>
                            <td>
                                @if ( auth()->user()->providers->count() && in_array('facebook', auth()->user()->providers()->lists('provider')->toArray()) )
                                    Connected to Facebook
                                @else
                                    <a href="{{ route('auth.facebook') }}">Connect to Facebook</a>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Google</td>
                            <td>
                                @if ( auth()->user()->providers->count() && in_array('google', auth()->user()->providers()->lists('provider')->toArray()) )
                                    Connected to Google
                                @else
                                    <a href="{{ route('auth.google') }}">Connect to Google</a>
                                @endif
                            </td>
                        </tr>
                    </table>

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
@endsection

