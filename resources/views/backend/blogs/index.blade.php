@extends ('backend.layouts.master')

@section ('title', "Blog Management")

@section('page-header')
    <h1>
        Blog Management
    </h1>
@endsection

@section('content')

    @include('frontend.includes.partials.blogs.header-buttons')

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Heading</th>
            <th>Type</th>
            <th>Published</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php $f=1; ?>
     {{--   @foreach ($cms as $value)
            <tr>
                <td>{{ $f++ }}</td>
                <td>{{ str_limit($value->header, $limit =80, $end = '...') }}</td>
                <td>{{ $value->type }}</td>
                <td>{!! $value->published_text !!}</td>
                <td>{!! $value->action_buttons !!}</td>
            </tr>
        @endforeach--}}
        </tbody>
    </table>
    <div class="pull-left">
      {{--  {!! count($cms) !!} CMS Total--}}
    </div>

    <div class="pull-right">
       {{-- {!! $cms->render() !!}--}}
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