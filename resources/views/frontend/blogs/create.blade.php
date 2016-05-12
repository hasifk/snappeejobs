@extends ('backend.layouts.master')

@section ('title', 'Create Blog')

@section('page-header')
<h1>
    Create Blogs
</h1>
@endsection

@section('content')

    @include('frontend.includes.partials.blogs.header-buttons')

<section class="content">
    <div class="row" id='notification_add'>
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <div class="box box-primary">
                    
                    <!-- form start -->
                    <form method="POST" action="{{ route('frontend.blogsave') }}" accept-charset="UTF-8" role="form" enctype='multipart/form-data' >
                         {{ csrf_field() }}
                        <div class="box-body">
                            
                            <div class="form-group col-xs-12">
                                
                                <div class="row">
                                    
                                <label>Heading</label>
                                
                                <input type="text" name="heading" class="form-control" placeholder="Heading">
                                
                                </div>
                                
                            </div>
                            
                            <div class="form-group col-xs-6">
                                
                                <div class="row">
                                    
                                <label>Image</label>
                                
                                <input type="file" name="img" class="form-control">
                                
                                </div>
                                
                            </div>
                            
                            <div class="form-group col-xs-6">
                                @if(!empty($categories))
                                <label for="exampleInputPassword1">Select Category</label>
                                
                                <select name="type" class="select2">
                                    @foreach($categories as $category1)
                                    <option value="{{$category1->id}}">{{$category1->name}}</option>
                                   @endforeach
                                    
                                </select>
                                @endif
                                
                            </div>

                            <div class="form-group col-xs-6">
                                @if(!empty($sub_categories))
                                    <label for="exampleInputPassword1">Select Sub Category</label>

                                    <select name="type" class="select2">
                                        @foreach($sub_categories as $category1)
                                            <option value="{{$category1->id}}">{{$category1->name}}</option>
                                        @endforeach

                                    </select>
                                @endif

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
