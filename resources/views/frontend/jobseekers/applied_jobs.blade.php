@extends('frontend.layouts.master')

@section('content')

    <div class="col-md-10 col-md-offset-1">

        <div class="job-view panel panel-primary">

            @if(!empty($applied))

                        <ul class="list-group">
                            @foreach($applied as $key=>$value)

                                <li class="list-group-item">

                                    <h6>{{$value->title}}</h6>


                                    <h6>{{$value->title}}</h6>
                                    <h6>{{$value->created_at}}</h6>
                                </li>
                            @endforeach
                        </ul>

            @endif

        </div>

    </div>

@endsection

