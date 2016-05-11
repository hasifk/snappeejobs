@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div style="min-height:300px;" class="row">

                <div style="margin-bottom: 75px;" class="upload-resume-section col-sm-10 col-sm-offset-1">

                    @if (Session::has('success'))
                        <div class="alert alert-success">{{ Session::get('success') }}</div>
                    @endif
                    @if (Session::has('failure'))
                        <div class="alert alert-danger">{{ Session::get('failure') }}</div>
                    @endif

                        @if(!empty($video))
                            @if( $video && $video->video)
                                <video
                                        id="jobseeker_video"
                                        class="video-js vjs-default-skin"
                                        controls
                                        preload="auto"
                                        data-setup='{}'
                                        style="max-width: 100%; margin-top: 50px;"
                                >
                                    <source src="{{ $video->video }}" type='video/{{ $video->extension }}'>
                                </video>
                            @endif
                        @endif

                        @if(!empty($videolink))
                            @if($videolink->vimeo_id!=Null)
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
                                    <iframe src='http://player.vimeo.com/video/{{$videolink->vimeo_id}}'
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
                                    <iframe src="//www.youtube.com/embed/{{$videolink->youtube_id}}" frameborder="0" allowfullscreen></iframe>
                                </div>
                            @endif
                        @endif

                        <h3 class="text-center">Upload Videos</h3>

                        <form
                                enctype="multipart/form-data"
                                method="post"
                                action="{{ route('frontend.profile.upload_videos') }}"
                                id="upload-videos"
                        >

                        </form>


                        <hr>

                        <h5>{{ trans('strings.front_end.youtube_vimeo') }}</h5>

                        {!! Form::open(array('url' =>  route('frontend.profile.store_video_links'),'class' => 'form-inline')) !!}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <?php
                            if(!empty($videolink)) {
                                if($videolink->vimeo_id!=Null) {
                                    $video_link = 'https://vimeo.com/'.$videolink->vimeo_id;
                                } else {
                                    $video_link = 'https://www.youtube.com/watch?v='.$videolink->youtube_id;
                                }
                            } else {
                                $video_link = '';
                            }
                            ?>
                            <input type="text" name="videolink" class="form-control" value="{{old('videolink') ? old('videolink') : $video_link}}" placeholder="https://www.youtube.com"/>
                        </div>
                        <button type="submit" class="btn btn-md">Save</button>
                        {!! Form::close() !!}

                </div>
            </div>
        </div>
@endsection

@section('after-scripts-end')

    <script>

        Dropzone.autoDiscover = false

        $("#upload-videos").addClass('dropzone').dropzone({
            url: "{{ route('frontend.profile.upload_videos') }}",
            dictDefaultMessage: 'Drag your video here or Click to upload.',
            acceptedFiles: ".mp4,.mkv,.avi",
            paramName: "file",
            maxFilesize: 5,
            accept: function (file, done) {
                done();
            },
            sending: function (file, xhr, data) {
                data.append('_token', $('meta[name="_token"]').attr('content'));
            },
            success: function (file, xhr) {
                sweetAlert("Success", "Your video is uploaded!", "success");
            }
        });

    </script>

@endsection