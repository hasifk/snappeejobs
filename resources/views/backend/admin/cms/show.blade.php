@extends ('backend.layouts.master')

@section ('title', "CMS Management")

@section('page-header')
<h1>
   CMS Management
</h1>
@endsection

@section('content')

@include('backend.admin.includes.partials.cms.header-buttons')

<table class="table table-striped table-bordered table-hover">

    <tbody>

        <tr>
            <th>Heading</th><td>{{ $cms->header }}</td>
        </tr>
        <tr>
            <th>Type</th><td>{{ $cms->type }}</td>
        </tr>
        <tr>
            <th>Published</th><td><?php if($cms->published==1) echo "Published"; else echo "Note Published"; ?></td>
        </tr>
        <tr>
            <th>Content</th><td>{!! $cms->content !!}</td>
        </tr>

        <tr>
            <th>Image</th>
            <th>{!! $cms->getImageAttribute('297','218') !!}</th>
            
        </tr>

        <tr>
            <th></th>
            <th>
                <a href="{{route('backend.admin.cms.edit',$cms->id)}}" class="btn btn-primary btn-xs">
                    Edit {{ $cms->type }}
                </a>
            </th>
        </tr>
        
    </tbody>
</table>
<div class="clearfix"></div>
@endsection
