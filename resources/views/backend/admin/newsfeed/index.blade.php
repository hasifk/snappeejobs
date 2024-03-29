@extends ('backend.layouts.master')

@section ('title', "News Feeds Management")

@section('page-header')
<h1>
    {{ trans('strings.backend.newsfeed_management') }}
</h1>
@endsection

@section('content')

@include('backend.admin.includes.partials.newsfeeds.header-buttons')

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>No</th>
            <th>News</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php $f = 1; ?>
    @foreach ($newsfeeds as $newsfeed)
        <?php $newsfed=strip_tags($newsfeed->news); ?>
        <tr>
            <td>{{ $f++ }}</td>
            <td><?php
                if(strlen($newsfed)>100)
                    echo substr($newsfed,0,100)."...";
                else
                    echo $newsfed;
                ?></td>
            <td>{!! $newsfeed->action_buttons !!}</td>
        </tr>
    @endforeach
    </tbody>
</table>
<div class="pull-left">
    {!! count($newsfeeds) !!} News Feeds Total
</div>

<div class="pull-right">
    {!! $newsfeeds->render(); !!}
</div>
<div class="clearfix"></div>
@endsection

@section('after-scripts-end')
<script>
    $(document).ready(function () {
        $('.newsfeed_delete').on('click', function () {
            if (confirm("Are you sure want to delete")) {
                return true;
            }
            return false;
        });
    });
</script>
@endsection
