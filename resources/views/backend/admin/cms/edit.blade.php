@extends ('backend.layouts.master')

@section ('title', 'Edit CMS')

@section('page-header')
<h1>
    Edit CMS - Articles/Blogs
</h1>
@endsection

@section('content')

@include('backend.admin.includes.partials.cms.header-buttons')

<section class="content">
    <div class="row" id='notification_add'>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <!--                <div class="box-header with-border">
                                        <h3 class="box-title">Add Push Notifications</h3>
                                    </div> /.box-header -->
                    <!-- form start -->
                    <form method="POST" action="{{ route('backend.admin.cmssave') }}" accept-charset="UTF-8" role="form" enctype='multipart/form-data' >
                         {{ csrf_field() }}
                        <div class="box-body">
                            
                            <div class="form-group col-xs-12">
                                <div class="row">
                                <label for="exampleInputPassword1">Heading</label>
                                <input type="text" name="heading" class="form-control" placeholder="Heading" value="{{$cms->header}}">
                                </div>
                            </div>
                            
                            <div class="form-group col-xs-6">
                                
                                <div class="row">
                                    
                                <label for="exampleInputPassword1">Image</label>
                                
                                <input type="file" name="img" class="form-control" value="">
                                
                                </div>
                                
                            </div>
                            <?php if(!empty($cms->img)):
                            $class="col-xs-4"; 
                             ?>
                            <div class="form-group col-xs-2">
                                <img src="{!! $cms->getAvatarImage(25) !!}" width="60" height="50">
                            </div>
                           <?php
                           else:
                               $class="col-xs-6";
                           
                           endif; ?> 
                            <div class="form-group <?php echo $class;?>">
                                
                                <label for="exampleInputPassword1">Select Type</label>
                               {!! Form::select('type', array('Article' => 'Article', 'Blog' => 'Blog'),$cms->type,array('class'=>'form-control')) !!}
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <textarea class="form-control" name="content" cols="30" rows="5">{{ $cms->content }}</textarea>
                            </div>
                            
                        </div>
                         
                         <!-- /.box-body -->

                        <div class="box-footer">
                            {!! Form::hidden('id',$cms->id) !!}
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                         
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</section>
@endsection
