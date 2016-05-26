@extends ('backend.layouts.master')

@section ('title', 'Create Blog')

@section('page-header')
<h1>
    Create Blogs
</h1>
@endsection

@section('content')



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

                                <label>Title</label>

                                <input type="text" name="title" class="form-control" placeholder="Blog Title">

                                </div>

                            </div>
                            <div class="form-group col-xs-12">
                                
                                <div class="row">
                                    
                                <label>Image</label>
                                
                                <input type="file" name="file" class="form-control">
                                
                                </div>
                                
                            </div>
                            
                            <div class="form-group col-sm-5">
                                <div class="row">
                                @if(!empty($categories))
                                <label for="exampleInputPassword1">Select Category</label>
                                
                                <select name="blog_category" id="blog_category" class="select2 form-control">
                                    <option value="">Please select</option>
                                    @foreach($categories as $category1)

                                    <option value="{{$category1->id}}"
                                            {{ old('blog_category') && $category1->id == old('blog_category') ? 'selected="selected"' : '' }}>
                                        {{$category1->name}}</option>
                                   @endforeach
                                    
                                </select>
                                @endif
                                </div>
                            </div>

                            <div class="form-group col-sm-6 col-lg-offset-1 col-md-offset-1 col-sm-offset-1">
                               <div class="row">
                                @if(!empty($sub_categories))
                                    <label for="exampleInputPassword1">Select Sub Category</label>

                                    <select name="blog_sub_cat" id="blog_sub_cat" class="select2 form-control">
                                        <option value="">Please select</option>
                                        @foreach($sub_categories as $category1)
                                            <option value="{{$category1->id}}"
                                                    {{ old('blog_sub_cat') && $category1->id == old('blog_sub_cat') ? 'selected="selected"' : '' }}
                                            >{{$category1->name}}</option>
                                        @endforeach

                                    </select>
                                @endif
                               </div>
                            </div>

                            <div class="form-group">
                                
                                <label for="exampleInputPassword1">Content</label>
                                <textarea class="form-control textarea" name="content" cols="30" rows="5"></textarea>
                                
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Video Link</label>
                            <input type="text" name="videolink" class="form-control" value="{{old('videolink')}}" placeholder="https://www.youtube.com"/>
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

@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('#blog_category').on('change', function(){
                $.getJSON('/admin/blogs/getsubcats/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#blog_sub_cat').html(listitems);
                });
            });
        });
    </script>
@endsection