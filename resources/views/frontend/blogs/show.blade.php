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
                        {!! $blog->getImageAttribute() !!}

                    </div>


                    <div class="clearfix"></div>




                    <div class="col-lg-8 about-job">
                           {{ $blog->content }}
                    </div>






    </div>
</section>
    @endif
 @endsection
@section('after-scripts-end')

@endsection

