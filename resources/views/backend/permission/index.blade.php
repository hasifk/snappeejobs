@extends ('backend.layouts.master')

@section ('title', 'Admin Company Profile')

@section ('breadcrumbs')
<li><a href="{!!route('backend.dashboard')!!}"><i class="fa fa-dashboard"></i> {{ trans('menus.dashboard') }}</a></li>
<li class="active">{!! link_to_route('admin.employer.company.showprofile', 'Company Profile' ) !!}</li>
@endsection

@section('content')

<h3>Permission Lists</h3>
<?php $f=1; ?>
<div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="profile">
        <table class="table table-striped table-hover table-bordered dashboard-table">
            <tr> 
                <th>Allowable Permission</th>
                <td>
                    <table class="table table-condensed">
                        @foreach($permissions as $permission)
                         @if($f==1)
                        <tr>
                           @endif 
                            <td>{{ $permission->display_name }}</td>
                            @if($f==2)
                        </tr>
                        @endif
                        <?php if($f==2) $f=1; else $f++; ?>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>
    </div>
</div>
@endsection
