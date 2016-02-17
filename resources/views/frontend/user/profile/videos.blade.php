@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Upload your video</div>
                <div class="panel-body">

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

                    <h5>Upload Videos</h5>

                    <form
                                enctype="multipart/form-data"
                                method="post"
                                action="{{ route('frontend.profile.upload_videos') }}"
                                id="upload-videos"
                        >

                        </form>

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
