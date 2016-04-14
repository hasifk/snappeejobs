@extends ('backend.layouts.master')

@section ('title', "User Activity Log Management")

@section('page-header')
    <h1>
        {{ trans('strings.backend.newsfeed_management') }}
    </h1>
@endsection

@section('content')


    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Action</th>
            <th>Title</th>
            <th>Author</th>
          
        </tr>
        </thead>
        <tbody>
        <?php $f=1; ?>
        @foreach ($user as $newsfeed)
        <?php $string=explode('-',$newsfeed->text); ?>
            <tr>
                <td>{{ $f++ }}</td>
                <td>{{ $string[0] }}</td>
                <td>{{ $string[1] }}</td>
                <td>{{ $string[2] }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="clearfix"></div>
@endsection
