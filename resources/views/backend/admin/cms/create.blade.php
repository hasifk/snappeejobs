@extends ('backend.layouts.master')

@section ('title', 'Create CMS')

@section('page-header')
<h1>
    Create CMS - Articles/Blogs
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
                    
                    <!-- form start -->
                    <form method="POST" action="{{ route('backend.admin.cmssave') }}" accept-charset="UTF-8" role="form" enctype='multipart/form-data' >
                         {{ csrf_field() }}
                        <div class="box-body">
                            
                            <div class="form-group col-xs-12">
                                
                                <div class="row">
                                    
                                <label for="exampleInputPassword1">Heading</label>
                                
                                <input type="text" name="heading" class="form-control" placeholder="Heading">
                                
                                </div>
                                
                            </div>
                            
                            <div class="form-group col-xs-6">
                                
                                <div class="row">
                                    
                                <label for="exampleInputPassword1">Image</label>
                                
                                <input type="file" name="img" class="form-control">
                                
                                </div>
                                
                            </div>
                            
                            <div class="form-group col-xs-6">
                                
                                <label for="exampleInputPassword1">Select Type</label>
                                
                                <select name="type" class="form-control">
                                    
                                    <option value="Article">Article</option>
                                    
                                    <option value="Blog">Blog</option>
                                    
                                </select>
                                
                            </div>
                            
                            <div class="form-group">
                                
                                <label for="exampleInputPassword1">Content</label>
                                <textarea class="form-control textarea" name="content" cols="30" rows="5"></textarea>
                                
                            </div>
                            
                        </div>
                         
                         <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                         
                    </form>
                </div><!-- /.box -->
            </div>
        </div>
    </div>
</section>
@endsection
