@extends('frontend.layouts.masternew')

@section('search_div')


    <div class="container com-search">

        <div class="row">

            <div class="col-md-8 col-sm-12 col-md-offset-2">

                <div>
                    <ul class="nav nav-tabs" role="tablist">
                        @if(!empty($categories))
                            @foreach($categories as $category)
                        <li role="presentation" class="@if(!request()->has($category->name)) active @endif"><a href="#browse_jobs" aria-controls="browse_jobs" role="tab" data-toggle="tab">{{$category->name}}</a></li>
                                @endforeach
                                @endif
                    </ul>
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane @if(!request()->has('search')) active @endif" id="browse_jobs">
                            &nbsp;
                        </div>
                        <div role="tabpanel" class="tab-pane @if(request()->has('search')) active @endif" id="search_jobs">


                    </div>

                </div>
                <br>
                <br>
            </div>

            @endsection

            @section('content')

                <section>



                </section>

            @endsection

            @section('after-scripts-end')
                <script>

                    var isSearchPage = function(){
                        return window.location.href.search("[?&]search=") != -1;
                    };

                    var getNextURL = function(){
                        return isSearchPage() ? '{{ request()->route()->getUri() }}' : '{{ request()->route()->getUri() }}?search=1'
                    }

                    $(document).ready(function(){
                        $('#country_id').on('change', function(){
                            $.getJSON('/admin/get-states/'+$(this).val(), function(json){
                                var listitems = '<option value="">Please select</option>';
                                $.each(json,function(key, value)
                                {
                                    listitems += '<option value=' + value.id + '>' + value.name + '</option>';
                                });
                                $('#state_id').html(listitems);
                            });
                        });

                        $(document).on( 'shown.bs.tab', 'a[data-toggle="tab"]', function (e) {
                            if (  $(e.target).attr('href') == '#browse_jobs' ) {
                                history.pushState({}, 'Snappeejobs Browse Jobs', getNextURL());
                            } else if ( $(e.target).attr('href') == '#search_jobs' ) {
                                history.pushState({}, 'Snappeejobs Search Jobs', getNextURL());
                            }
                        })

                    });
                </script>
@endsection
