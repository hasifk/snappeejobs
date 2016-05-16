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

