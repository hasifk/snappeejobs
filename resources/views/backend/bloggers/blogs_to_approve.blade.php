@extends ('backend.layouts.master')

@section ('title', 'Approve Blogs')

@section('page-header')
    <h1>
        Approve Blogs
        <small>Bloggers Dashboard</small>
    </h1>
@endsection

@section('content')



    <div class="col-md-6">
        <h4>Approve Blogs</h4>
    </div>


    <div class="clearfix"></div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Approval Status</th>
        </tr>
        </thead>
        <tbody>
        @if(!empty($blogs))
        @foreach($blogs as $blog)

            <tr>
                <td>{!! $blog->id !!}</td>
                <td><a href="{{ route('blogs.view', $blog->id) }}">{{ $blog->title }}</a></td>
                <td>{!!$blog->approved_button!!}</td>

            </tr>



        @endforeach
        @else
            None
        @endif

        </tbody>
    </table>

    <div class="col-md-12 center-block">
        {!! $blogs->render() !!}
    </div>

    <div class="clearfix"></div>

@endsection



