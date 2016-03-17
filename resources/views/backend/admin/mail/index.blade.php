@extends ('backend.layouts.master')

@section ('title', "Company Management")

@section('page-header')
    <h1>
        SnappeeJobs Mail
    </h1>
@endsection

@section('content')

    @include('backend.admin.includes.partials.mail.header-buttons')

    {!! Form::open(['route' => 'admin.employer.mail.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post']) !!}

    <div class="form-group">
        <label for="to" class="col-lg-2 control-label">To:</label>
        <div class="col-lg-5">
            <select name="company" id="company" class="form-control">
                <option value="">Please select Company</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-lg-5">
            <select name="to" id="to" class="form-control">
                <option>Please select a company first</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label for="to" class="col-lg-2 control-label">Subject:</label>
        <div class="col-lg-10">
            <input type="text" name="subject" id="subject" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label for="message" class="col-lg-2 control-label">Message:</label>
        <div class="col-lg-10">
            <textarea name="message" id="message" cols="30" rows="10" class="form-control textarea"></textarea>
        </div>
    </div>

    <div class="well">
        <div class="pull-left">
            <a href="{{route('admin.access.users.index')}}" class="btn btn-danger btn-xs">{{ 'Discard' }}</a>
        </div>

        <div class="pull-right">
            <input type="submit" class="btn btn-success btn-xs" value="{{ 'Send Message' }}" />
        </div>
        <div class="clearfix"></div>
    </div><!--well-->

    {!! Form::close() !!}

    <div class="clearfix"></div>

@stop

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#company').on('change', function(){
                $.getJSON('/admin/mail/getusers/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#to').html(listitems);
                });
            });
        });
    </script>
@endsection