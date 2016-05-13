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
                        {!! $blog->getImagethumbAttribute(750, 350) !!}

                    </div>


                    <div class="clearfix"></div>




                    <div class="col-lg-8 about-job">
                           {!! $blog->content !!}
                    </div>

                    <a href="{{ route('blogs.next', $blog->id) }}" class="btn-primary MB-60">NEXT BLOG</a>





    </div>
</section>
    @endif
 @endsection
@section('after-scripts-end')

@endsection

