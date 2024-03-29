@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">
            @if (Session::has('success'))
                <div class="alert alert-success">{{ Session::get('success') }}</div>
            @endif
                @if (Session::has('failure'))
                    <div class="alert alert-danger">{{ Session::get('failure') }}</div>
                @endif
            <div class="panel panel-default">
                <div class="panel-heading">Upload your video  @if(!empty($key)) {{$key}} @endif</div>
                <div class="panel-body">
                   @if(!empty($video))
                    @if( $video && $video->video)
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
                    @endif
                    @endif

                       @if(!empty($videolink))
                           @if($videolink->vimeo_id!=Null)
                               <iframe  style="max-width: 100%;" src="https://player.vimeo.com/video/{{$videolink->vimeo_id}}?title=0&byline=0&portrait=0"  frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                           @else
                               <iframe  style="max-width: 100%;"  src="//www.youtube.com/embed/{{$videolink->youtube_id}}" frameborder="0" allowfullscreen=""></iframe>
                           @endif
                       @endif

                    <h5>Upload Videos</h5>

                    <form
                                enctype="multipart/form-data"
                                method="post"
                                action="{{ route('frontend.profile.upload_videos') }}"
                                id="upload-videos"
                        >

                        </form>




                        <h5>{{ trans('strings.front_end.youtube_vimeo') }}</h5>

                        {!! Form::open(array('url' =>  route('frontend.profile.store_video_links'),'class' => 'form-inline')) !!}
                        {{ csrf_field() }}
                        <div class="form-group">
                        <input type="text" name="videolink" class="form-control" value="{{old('videolink')}}" placeholder="https://www.youtube.com"/>
                       </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        {!! Form::close() !!}

                </div><!--panel body-->

            </div><!-- panel -->

        </div><!-- col-md-10 -->

    </div><!-- row -->
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
