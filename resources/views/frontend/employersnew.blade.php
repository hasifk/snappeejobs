@extends('frontend.layouts.masternew')


@section('content')

    <section>
        <div class="empl-banner">
            <div class="text-center">
                <h1>How do the best job<br /> candidates view your company?</h1>
                <a href="#" class="btn-primary text-uppercase btn btn-lg" data-toggle="modal" data-target="#myModal">Start Hiring</a>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close close" data-dismiss="modal" aria-label="Close"><img src="images/close-btn.png" /></button>
                    <h2 class="modal-title text-center">Start Hiring Now</h2>
                    <p class="text-center">Don't worry, you're getting access to the world's best.</p>
                </div>
                <div class="modal-body">

                    <div style="display: none;" class="employer_registration_errors alert alert-danger">
                        <p>Oops, there are some errors. </p>
                        <ul>

                        </ul>
                    </div>

                    <form class="employer_register" enctype="multipart/form-data" accept-charset="UTF-8" action="/employers" method="POST" role="form">

                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Name">
                        </div>

                        <div class="form-group">
                            <label for="">Email</label>
                            <input type="text" class="form-control" name="email" placeholder="Email">
                        </div>

                        <div class="form-group">
                            <label for="">Company</label>
                            <input type="text" class="form-control" name="company" placeholder="Company">
                        </div>

                        <div class="form-group">
                            <label for="">Country</label>
                            <select name="country_id" id="country_id" class="form-control">
                                <option value="">Please select</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}">
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="">State</label>
                            <select name="state_id" id="state_id" class="form-control">
                                <option value="">Please select</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button
                                type="submit"
                                class="btn btn-primary submit_button"
                                data-loading-text='<i class="fa fa-circle-o-notch fa-spin"></i> Loading'
                        >Start Hiring</button>

                    </form>

                </div>
            </div>
        </div>
    </div>


    <section class="employers">
        <div class="container">
            <h2 class="text-center"><strong>How it Works</strong></h2>
            <div class="row how-works">
                <div class="col-sm-4">
                    <img src="images/icon-play.png" />
                    <h3><strong>Show Don't Tell</strong></h3>
                    <p>Text-based job ads can't show job seekers what makes your company incredible. Our video-based profiles can.</p>
                </div>
                <div class="col-sm-4">
                    <img src="images/icon-users.png" />
                    <h3><strong>Attract the Best</strong></h3>
                    <p>Text-based job ads can't show job seekers what makes your company incredible. Our video-based profiles can.</p>
                </div>
                <div class="col-sm-4">
                    <img src="images/icon-shakehands.png" />
                    <h3><strong>See Better Candidates</strong></h3>
                    <p>Text-based job ads can't show job seekers what makes your company incredible. Our video-based profiles can.</p>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="SNAP-offer text-center clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h2><strong>What SNAP Offers</strong></h2>
                        <img src="images/snap-logo-trans.png" />
                        <div class="empl-feature text-left row">
                            <div class="col-sm-4 trans-blue">
                                <h3><strong>A Professional Profile</strong></h3>
                                <p>We create (and you approve) a fully branded profile that aligns with and showcases your employment branding goals.</p>
                            </div>
                            <div class="col-sm-4 trans-blue">
                                <h3><strong>Promoted Content</strong></h3>
                                <p>We're content marketing experts. We'll promote your profile, open jobs, and unique culture in articles, social media, and dedicated emails.</p>
                            </div>
                            <div class="col-sm-4 trans-blue">
                                <h3><strong>Dedicated Support</strong></h3>
                                <p>We work with the top companies in the world. We know what works, helping you to improve your employer branding.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endsection

@section('after-scripts-end')
    <script>
        $(document).ready(function(){

            $('form.employer_register').on('submit', function(e){
                e.preventDefault();

                $(this).find('.submit_button').eq(0).button('loading');

                var $form_url = $(this).attr('action');
                var $form_data = $(this).serialize();

                $.post($form_url, $form_data, function(response){
                    $('form.employer_register').find('.submit_button').eq(0).button('reset');
                    if ( response.status && response.message ) {
                        $('#myModal').modal('toggle');
                        swal(response.message, 'We have sent you an email to confirm your account to proceed');
                    }
                }).error(function(err){
                    $('form.employer_register').find('.submit_button').eq(0).button('reset');
                    $('.employer_registration_errors ul').html('');
                    for(var key in err.responseJSON) {
                        var error = err.responseJSON[key];
                        error.forEach(function(element, index){
                            $('.employer_registration_errors ul').append('<li>'+error[index]+'</li>');
                            $('.employer_registration_errors').show();
                        });
                    }
                });
            });

            $('#country_id').on('change', function(){
                $.getJSON('/get-states/'+$(this).val(), function(json){
                    var listitems = '<option value="">Please select</option>';
                    $.each(json,function(key, value)
                    {
                        listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                    });
                    $('#state_id').html(listitems);
                });
            });
        });
    </script>
@endsection