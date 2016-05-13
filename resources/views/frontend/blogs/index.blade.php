@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">


                @if(!empty($categories))
                <div class="body-wrap">
                    <div>
                        <nav class="navbar navbar-default" role="navigation">
                            <div class="container-fluid">
                                <!-- Brand and toggle get grouped for better mobile display -->
                                <div class="navbar-header">
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                                        <span class="sr-only">Toggle navigation</span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                    </button>
                                </div>

                                <!-- Collect the nav links, forms, and other content for toggling -->
                                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                    <ul class="nav navbar-nav">
                                        @foreach($categories as $category)
                                        <li class="dropdown">
                                            <a href="/advice/{{$category->url_slug}}" class="dropdown-toggle" data-toggle="dropdown">{{ $category->name }}<b class="caret"></b></a>
                                            <ul class="dropdown-menu">
                                                @foreach($subcategories as $subcategory)
                                                    @if($subcategory->blog_category_id == $category->id)
                                                        <li><a href="/advice/{{$category->url_slug}}/{{$subcategory->url_slug}}">{{ $subcategory->name }}</a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <!-- /.navbar-collapse -->
                            </div>
                            <!-- /.container-fluid -->
                        </nav>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

@endsection


@section('content')

@endsection


@section('after-scripts-end')
    <script>
        $(document).ready(function(){
            $('ul.nav li.dropdown').hover(function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
            }, function() {
                $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
            });
        });
    </script>
@endsection
