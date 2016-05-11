@extends ('backend.layouts.master')

@section ('title', 'Blogger Management | Create New Blogger')



@section('page-header')
    <h1>
        Blogger Management
        <small>Create New Blogger</small>
    </h1>
@endsection



@section('content')


    {!! Form::open(['route' => ['backend.storebloggers'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        <label class="col-lg-2 control-label">Select Blogger</label>
        <div class="col-lg-10">
            @if(!empty($users))
          <select name="blogger_id" id="blogger_id" class="form-control">
              @foreach($users as $user)
              <option value="{{ $user->id }}">{{$user->name}}</option>
              @endforeach
          </select>
            @endif
        </div>
    </div><!--form control-->



    <div class="well">
        <div class="pull-left">
            <a href="{{route('backend.dashboard')}}" class="btn btn-danger btn-xs">Cancel</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="Submit" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    {!! Form::close() !!}
@stop