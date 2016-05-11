@extends('frontend.layouts.masternew')

@section('search_div')

    <div class="container com-search">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <div class="back-box-straight">
                    <div class="tilted-box">
                        <div class="candidate-details">
                            <div class="candiate-pic"><img src="{{ $jobseeker_user->getPictureAttribute(136, 136) }}"></div>
                            <div class="cadid-btns">
                                {{--<a href="#" class="btn-primary">Invite</a>--}}
                                <a href="#" class="likejobseeker btn-fav"><img src="/images/red-heart.png" align="absmiddle"> <span class="like">{{ $jobseeker->likes ? $jobseeker->likes : 0 }}</span></a>
                            </div>
                            <div class="profile-name">
                                <h1>{{ $jobseeker_user->name }}</h1>
                                <p><img src="/images/loc-icongrey.png"> {{ $jobseeker_user->statename }}, {{ $jobseeker_user->countryname }}</p>
                            </div>
                            {{--<div class="cn-socials">--}}
                                {{--<img src="/images/cn-linkedin.png">--}}
                                {{--<img src="/images/cn-gplus.png">--}}
                                {{--<img src="/images/cn-twitter.png">--}}
                            {{--</div>--}}
                            @if($jobseeker_user->about_me)
                            <p class="profile-desc">
                                {{ $jobseeker_user->about_me }}
                            </p>
                            @endif
                            <h2>Preferences </h2>
                            <ul>
                                @if($jobseeker->skills()->count())
                                    <li>Skills   :
                                    @foreach($jobseeker->skills as $skill)
                                        {{ $skill->name }}@if($jobseeker->skills->last() != $skill),@endif
                                    @endforeach
                                    </li>
                                @endif
                                @if($jobseeker->categories()->count())
                                    <li>Preffered Job Categories   :
                                        @foreach($jobseeker->categories as $category)
                                            {{ $category->name }}@if($jobseeker->categories->last() != $category),@endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($jobseeker->industries()->count())
                                    <li>Preffered Industries   :
                                        @foreach($jobseeker->industries as $industry)
                                            {{ $industry->name }}@if($jobseeker->industries->last() != $industry),@endif
                                        @endforeach
                                    </li>
                                @endif
                                @if($jobseeker->size)
                                <li>Company Preference   :    {{ ucfirst($jobseeker->size) }}</li>
                                @endif
                                @if($jobseeker_user->country_id || $jobseeker_user->state_id)
                                <li>Location   :   {{ $jobseeker_user->statename }}, {{ $jobseeker_user->countryname }}</li>
                                @endif
                                @if($jobseeker_user->providers()->count())
                                    <li>Social Media Connected :
                                        @foreach($jobseeker_user->providers as $provider)
                                            {{ ucfirst($provider->provider) }}
                                        @endforeach
                                    </li>
                                @endif
                            </ul>



                            @if($jobseeker->images()->count())
                            <h2>Photo Gallery </h2>

                                <div class="photo_gallery">
                                    <div id="jssor_1"
                                         style="position: relative; margin: 0 auto; top: 0px; left: 0px; width: 960px; height: 480px; overflow: hidden; visibility: hidden;">
                                        <!-- Loading Screen -->
                                        <div data-u="loading" style="position: absolute; top: 0px; left: 0px;">
                                            <div style="filter: alpha(opacity=70); opacity: 0.7; position: absolute; display: block; top: 0px; left: 0px; width: 100%; height: 100%;"></div>
                                            <div style="position:absolute;display:block;background:url('/img/loading.gif') no-repeat center center;top:0px;left:0px;width:100%;height:100%;"></div>
                                        </div>
                                        <div data-u="slides" class="resp-sliders"
                                             style="cursor: default; position: relative; top: 0px; left: 240px; width: 720px; height: 457px; overflow: hidden;">
                                            @foreach($jobseeker->images as $image)
                                            <div data-p="150.00" style="display: none; margin: 0;">
                                                <img data-u="image" src="{{ $image->getPictureAttribute(720, 457) }}"/>
                                                <img data-u="thumb" src="{{ $image->getPictureAttribute(85, 56) }}"/>
                                            </div>
                                            @endforeach
                                            <a data-u="ad" href="http://www.jssor.com" style="display:none">jQuery Slider</a>

                                        </div>
                                        <!-- Thumbnail Navigator -->
                                        <div data-u="thumbnavigator" class="jssort01-99-66 res-thumbs"
                                             style="position:absolute;left:0px;top:0px;width:240px;height:480px;" data-autocenter="2">
                                            <!-- Thumbnail Item Skin Begin -->
                                            <div data-u="slides" style="cursor: default;">
                                                <div data-u="prototype" class="p">
                                                    <div class="w">
                                                        <div data-u="thumbnailtemplate" class="t"></div>
                                                    </div>
                                                    <div class="c"></div>
                                                </div>
                                            </div>
                                            <!-- Thumbnail Item Skin End -->
                                        </div>
                                        <!-- Arrow Navigator -->
        <span data-u="arrowleft" class="jssora05l" style="top:158px;left:248px;width:40px;height:40px;"
              data-autocenter="2"></span>
        <span data-u="arrowright" class="jssora05r" style="top:158px;right:8px;width:40px;height:40px;"
              data-autocenter="2"></span>
                                    </div>
                                </div>

                            @endif


                            @if($jobseeker->videos()->count())
                            <h2>Timeline video</h2>
                            <div class="candid-video">
                                @foreach($jobseeker->videos as $video)
                                <video
                                        id="jobseeker_video"
                                        class="video-js vjs-default-skin"
                                        controls
                                        preload="auto"
                                        data-setup='{}'
                                        style="max-width: 100%;"
                                >
                                    <source src="{{ $video->video }}" type='video/{{ $video->extension }}'>
                                </video>
                                @endforeach
                            </div>
                            @elseif($jobseeker->videoLink()->count())
                                @foreach($jobseeker->videoLink as $video)
                                    @if($video->vimeo_id!=Null)
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
                                            <iframe src='http://player.vimeo.com/video/{{$video->vimeo_id}}'
                                                    frameborder='0'
                                                    webkitAllowFullScreen
                                                    mozallowfullscreen
                                                    allowFullScreen
                                            ></iframe>
                                        </div>
                                    @else
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
                                            <iframe src="//www.youtube.com/embed/{{$video->youtube_id}}" frameborder="0" allowfullscreen></iframe>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection


@section('after-scripts-end')

    @if($jobseeker->images()->count())

        <script type="text/javascript" src="/build/js/jssor.slider.mini.js"></script>
        <script>
            jQuery(document).ready(function ($) {

                var jssor_1_SlideshowTransitions = [
                    {$Duration:1200,$Zoom:1,$Easing:{$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad},$Opacity:2},
                    {$Duration:1000,$Zoom:11,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,$Zoom:1,$Rotate:1,$During:{$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
                    {$Duration:1000,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
                    {$Duration:1200,x:0.5,$Cols:2,$Zoom:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:4,$Cols:2,$Zoom:11,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear},$Opacity:2},
                    {$Duration:1200,x:0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
                    {$Duration:1000,x:-4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
                    {$Duration:1200,x:-0.6,$Zoom:1,$Rotate:1,$During:{$Left:[0.2,0.8],$Zoom:[0.2,0.8],$Rotate:[0.2,0.8]},$Easing:{$Left:$Jease$.$Swing,$Zoom:$Jease$.$Swing,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$Swing},$Opacity:2,$Round:{$Rotate:0.5}},
                    {$Duration:1000,x:4,$Zoom:11,$Rotate:1,$SlideOut:true,$Easing:{$Left:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.8}},
                    {$Duration:1200,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
                    {$Duration:1000,x:0.5,y:0.3,$Cols:2,$Zoom:1,$Rotate:1,$SlideOut:true,$Assembly:2049,$ChessMode:{$Column:15},$Easing:{$Left:$Jease$.$InExpo,$Top:$Jease$.$InExpo,$Zoom:$Jease$.$InExpo,$Opacity:$Jease$.$Linear,$Rotate:$Jease$.$InExpo},$Opacity:2,$Round:{$Rotate:0.7}},
                    {$Duration:1200,x:-4,y:2,$Rows:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Row:28},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.7}},
                    {$Duration:1200,x:1,y:2,$Cols:2,$Zoom:11,$Rotate:1,$Assembly:2049,$ChessMode:{$Column:19},$Easing:{$Left:$Jease$.$InCubic,$Top:$Jease$.$InCubic,$Zoom:$Jease$.$InCubic,$Opacity:$Jease$.$OutQuad,$Rotate:$Jease$.$InCubic},$Opacity:2,$Round:{$Rotate:0.8}}
                ];

                var jssor_1_options = {
                    $AutoPlay: true,
                    $SlideshowOptions: {
                        $Class: $JssorSlideshowRunner$,
                        $Transitions: jssor_1_SlideshowTransitions,
                        $TransitionsOrder: 1
                    },
                    $ArrowNavigatorOptions: {
                        $Class: $JssorArrowNavigator$
                    },
                    $ThumbnailNavigatorOptions: {
                        $Class: $JssorThumbnailNavigator$,
                        $Rows: 2,
                        $Cols: 6,
                        $SpacingX: 14,
                        $SpacingY: 12,
                        $Orientation: 2,
                        $Align: 156,
                        $AutoCenter: 1
                    }
                };

                var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

                //responsive code begin
                //you can remove responsive code if you don't want the slider scales while window resizing
                function ScaleSlider() {
                    var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                    if (refSize) {
                        refSize = Math.min(refSize, 960);
                        refSize = Math.max(refSize, 300);
                        jssor_1_slider.$ScaleWidth(refSize);
                    }
                    else {
                        window.setTimeout(ScaleSlider, 30);
                    }
                }
                ScaleSlider();
                $(window).bind("load", ScaleSlider);
                $(window).bind("resize", ScaleSlider);
                $(window).bind("orientationchange", ScaleSlider);
                //responsive code end
            });
        </script>
    @endif

    <script>

        $(document).ready(function(){

            $('.likejobseeker').on('click', function () {

                $.ajax({
                    url : '{{ route('jobseeker.like') }}',
                    method  : 'post',
                    data : {
                        jobSeekerId: {{ $jobseeker->id }},
                        '_token' : $('meta[name=_token]').attr("content")
                    },
                    success:function(data){
                        data = $.parseJSON(data);
                        $('.likejobseeker .like').html(data.likes);
                    }
                });

            });

        });

    </script>

@endsection