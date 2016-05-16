@extends('frontend.layouts.masternew')



@section('content')
@if(!empty($blog))
<section style="margin-top: 50px;">
    <div class="bodycontent">
        <div class="container">
            <div class="job-view row job-details">
                <div class="col-md-10 col-md-offset-1 companies">
                    <h1>
                        {{ $blog->title }}

                    </h1>
                    <div class="boxWrap">
                        {!! $blog->image !!}
                    </div>


                    <div class="clearfix"></div>


                    <div style="padding: 10px;" class="col-lg-8 about-job">
                           <p>
                               {!! $blog->content !!}
                           </p>
                    </div>
                    
                    <br clear="all">
                    @if($blog->youtube_id)
                        <style>
                            .embed-container {
                                position: relative;
                                padding-bottom: 56.25%;
                                height: 0; overflow:
                                    hidden;
                                max-width: 100%;
                            }
                            .embed-container iframe, .embed-container object, .embed-container embed {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                            }
                        </style>
                        <div class='embed-container'>
                            <iframe src="//www.youtube.com/embed/{{$blog->youtube_id}}" frameborder="0" allowfullscreen></iframe>
                        </div>
                    @elseif($blog->vimeo_id)
                        <style>
                            .embed-container {
                                position: relative;
                                padding-bottom: 56.25%;
                                height: 0;
                                overflow: hidden;
                                max-width: 100%;
                            }
                            .embed-container iframe, .embed-container object, .embed-container embed {
                                position: absolute;
                                top: 0;
                                left: 0;
                                width: 100%;
                                height: 100%;
                            }
                        </style>
                        <div class='embed-container'>
                            <iframe src='http://player.vimeo.com/video/{{$blog->vimeo_id}}'
                                    frameborder='0'
                                    webkitAllowFullScreen
                                    mozallowfullscreen
                                    allowFullScreen
                            ></iframe>
                        </div>
                    @endif    

                    <div class="col-lg-8 about-job">
                        @if($blog->authorimage)
                        {!! $blog->authorimage !!}
                        @endif
                        <br>
                        {{ $blog->authoraboutme }}
                    </div>    
    </div>
</section>
    @endif
 @endsection
@section('after-scripts-end')

@endsection

