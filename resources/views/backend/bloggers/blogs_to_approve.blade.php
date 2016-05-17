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
                {!! Form::open(['route' => ['backend.storeapproval'], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}
                @if($blog->approved_at!=null)
                            <td>{!! Form::checkbox('approval_status','', true, array('id' => 'approval_status'))!!}</td>
                    @else
                    <td>{!! Form::checkbox('approval_status','','',array('id' => 'approval_status')) !!}</td>
                    @endif
                {!!   Form::hidden('id', $blog->id) !!}
                {!!   Form::hidden('approval', $blog->approved_at, array('id' => 'approval')) !!}
               <td> {!! Form::submit('Update Approval Status', array('class' => 'btn btn-success btn-xs')) !!}</td>
                {!! Form::close() !!}
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

@stop


@section('after-scripts-end')
<script>
    $(document).ready(function () {
        $('#approval_status').on('change', function () {
            if($(this).is(':checked')) {
                $('#approval').val(1)
            }
            else
            {
                $('#approval').val(0);
            }
        });
    });
</script>
@endsection

