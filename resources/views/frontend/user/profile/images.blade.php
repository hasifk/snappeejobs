@extends('frontend.layouts.master')

@section('content')
    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">
                <div class="panel-heading">Upload Images</div>

                <div class="panel-body">

                    <h5>Upload Images</h5>

                    <form
                            enctype="multipart/form-data"
                            method="post"
                            action="{{ route('frontend.profile.upload_images') }}"
                            id="upload-images"
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

        $("#upload-images").addClass('dropzone').dropzone({
            url: "{{ route('frontend.profile.upload_images') }}",
            dictDefaultMessage: 'Drag your image here or Click to upload.',
            acceptedFiles: ".jpg,.jpeg,.png,.gif",
            addRemoveLinks: true,
            paramName: "file",
            maxFilesize: 5,
            init: function() {
                var thisDropZone = this;
                var imageData = '';
                $.each(profile_images, function(key, value){
                    var mockFile = {
                        name: value.filename+'.'+value.extension,
                        size: value.size,
                        filename: value.filename,
                        path: value.path,
                        extension: value.extension
                    };
                    thisDropZone.options.addedfile.call(thisDropZone, mockFile);
                    thisDropZone.options.thumbnail.call(thisDropZone, mockFile, value.image);
                });
            },
            accept: function (file, done) {
                done();
            },
            removedfile: function(file){
                $.post('{{ route('frontend.profile.delete_images')  }}', { filename : file.filename, path: file.path, extension: file.extension }, function(response, xhr){
                    sweetAlert("Success", "Your image is removed!", "success");
                }).error(function(){
                    sweetAlert("Oops..", "Some error happened, try again...", "error");
                });
                var _ref;
                return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            },
            sending: function (file, xhr, data) {
                data.append('_token', $('meta[name="_token"]').attr('content'));
            },
            success: function (file, xhr) {
                sweetAlert("Success", "Your image is uploaded!", "success");
            }
        });

    </script>

@endsection
