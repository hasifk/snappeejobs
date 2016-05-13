@extends ('backend.layouts.master')

@section ('title', "Blog Management")

@section('page-header')
    <h1>
        Blog Management
    </h1>
@endsection

@section('content')



    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Author</th>
            <th>Category</th>
            <th>SubCategory</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $f=1; ?>
        @foreach ($blogs as $value)
            <tr>
                <td>{{ $f++ }}</td>
                <td>{{ str_limit($value->author, $limit =80, $end = '...') }}</td>
                <td>{{ $value->blog_category_id }}</td>
                <td>{{ $value->blog_sub_cat_id }}</td>
                <td>{!! $value->action_buttons !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="pull-left">
        {!! count($blogs) !!} CMS Total
    </div>

    <div class="pull-right">
        {!! $blogs->render() !!}
    </div>
    <div class="clearfix"></div>
@endsection
@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('.cms_delete').on('click', function(){
                if(confirm("Are you sure want to delete")){
                    return true;
                }
                return false;
            });
        });
    </script>
@endsection