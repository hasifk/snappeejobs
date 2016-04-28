@extends('frontend.layouts.masternew')

@section('content')

    <div class="bodycontent">

        <div class="container cnt-body">

            <div style="min-height:300px;" class="row">

                <div style="margin-bottom: 50px;" class="upload-resume-section col-sm-10 col-sm-offset-1">

                    <h1  v-cloak class="text-center" v-show="showHeading" transition="expand">@{{ modalHeading }}</h1>

                    @if( $job_seeker && $job_seeker->has_resume )

                        <p v-cloak>
                            Your resume : <a target="_blank" href="{{ $resume_link }}">@{{ resumeFileName }}</a>
                        </p>

                    @endif

                    <form enctype="multipart/form-data" method="post" action="{{ route('frontend.profile.resume') }}" id="upload-resume"></form>

                </div>

            </div>

        </div>

@endsection

@section('after-scripts-end')
    <script>

        $(document).ready(function () {

            Dropzone.autoDiscover = false

            var uploadResumeSection = new Vue({
                el: '.upload-resume-section',

                data: {
                    modalHeading: 'Update Resume',
                    showHeading: true,
                    resumeFileName: '{{ $job_seeker && $job_seeker->has_resume ? $job_seeker->resume_filename.'.'.$job_seeker->resume_extension : '' }}'
                }
            });

            $("#upload-resume").addClass('dropzone').dropzone({
                url: "{{ route('frontend.profile.resume') }}",
                paramName: "file",
                maxFilesize: 5,
                dictDefaultMessage: 'Drop your resume here to update',
                accept: function (file, done) {
                    console.log(file);
                    if (
                            ( file.type == 'application/msword' ) ||
                            ( file.type == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' ) ||
                            ( file.type == 'application/pdf' ) ||
                            ( file.type == 'application/kswps' )
                    ) {
                        done();
                    } else {
                        alert('Please upload doc/docx/pdf files')
                    }
                },
                sending: function (file, xhr, data) {
                    data.append('_token', $('meta[name="_token"]').attr('content'));
                },
                success: function (file, xhr) {
                    uploadResumeSection.resumeFileName = file.name;
                    uploadResumeSection.showHeading = false;
                    setTimeout(function () {
                        uploadResumeSection.modalHeading = 'Your resume has been updated.';
                        uploadResumeSection.showHeading = true;
                    }, 500);
                }
            });

        });

    </script>
@endsection