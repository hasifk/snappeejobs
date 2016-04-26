<!doctype html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="_token" content="{{ csrf_token() }}" />
    <title>@yield('title', app_name())</title>
    <meta name="description" content="@yield('meta_description', 'SNAP - The best way to find a job')">
    <meta name="author" content="@yield('author', 'Silverbloom Technologies')">
    @yield('meta')

    @yield('before-styles-end')
    {!! HTML::style(elixir('css/frontend.css')) !!}
    @yield('after-styles-end')

</head>
<body>

    @if(auth()->user())
        <header class="top-nav">
            <nav class="navbar navbar-default">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"><img src="images/snap-logo-small.png" /></a>
                    </div>
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            <li class="active"><a href="#">HOME</a></li>
                            <li><a href="#">EXPLORE</a></li>
                            <li><a href="#">COMPANIES</a></li>
                            <li><a href="#">GET ADVICE</a></li>
                            <li><a href="#">FOR EMPLOYERS</a></li>
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                    <img src="images/user-icon.png" />
                                    Hey Akhil <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="/dashboard">Profile</a></li>
                                    <li><a href="/profile/favourites">Favourites</a></li>
                                    <li><a href="/jobseeker/appliedjobs">Applied Jobs</a></li>
                                    <li><a href="/auth/logout">Logout</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div><!--/.container-fluid -->
            </nav>
        </header>

        <div class="container user-home">
            <div class="browse col-md-10">
                <p><span class="username">Hey Akhil,</span> Let's make today great. Check out some new jobs</p>
            </div>
        </div>
        <section class="home-loggedin">
            <div class="bodycontent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 companies">
                            <h1>Newest Companies</h1>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/thumbtack.jpg" /></div>
                                    <h2>Thumbtack</h2>
                                    <h5>Software Engineer, Integrations</h5>
                                    <p>Media  |  Small Size  |   York City Metro Area</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/comcast.jpg" /></div>
                                    <h2>Comcast</h2>
                                    <h5>Intermediate/Senior Web Graphic Designer</h5>
                                    <p>Socialgood  |  Small Size  |   Washington DC</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/orange.jpg" /></div>
                                    <h2>Orange</h2>
                                    <h5>Intermediate/Senior Web Graphic Designer </h5>
                                    <p>Consumer |  Large Size  |   San Francisco</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/orange.jpg" /></div>
                                    <h2>Jive</h2>
                                    <h5>Territory Sales Manager - Benelux</h5>
                                    <p>Senior Level  |   Bangalore, India  |   Development</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/annelouis.jpg" /></div>
                                    <h2>Thumbtack</h2>
                                    <h5>Software Engineer</h5>
                                    <p>Socialgood  |  Small Size  |   Washington DC</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/thumbtack.jpg" /></div>
                                    <h2>Euclid Analytics</h2>
                                    <h5>Data Scientist</h5>
                                    <p>Consumer |  Large Size  |   San Francisco</p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section>
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 companies text-right">
                        <a href="#" class="view-jobs-btn">View all jobs</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="new-comp">
            <div class="bodycontent">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 col-md-offset-1 col-sm-12 companies">
                            <h1>Newest Companies</h1>
                            <div class="row">
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/thumbtack.jpg" /></div>
                                    <h2>Thumbtack</h2>
                                    <h5>Software Engineer, Integrations</h5>
                                    <p>Media  |  Small Size  |   York City Metro Area</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/comcast.jpg" /></div>
                                    <h2>Comcast</h2>
                                    <h5>Intermediate/Senior Web Graphic Designer</h5>
                                    <p>Socialgood  |  Small Size  |   Washington DC</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/orange.jpg" /></div>
                                    <h2>Orange</h2>
                                    <h5>Intermediate/Senior Web Graphic Designer </h5>
                                    <p>Consumer |  Large Size  |   San Francisco</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/orange.jpg" /></div>
                                    <h2>Jive</h2>
                                    <h5>Territory Sales Manager - Benelux</h5>
                                    <p>Senior Level  |   Bangalore, India  |   Development</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/annelouis.jpg" /></div>
                                    <h2>Thumbtack</h2>
                                    <h5>Software Engineer</h5>
                                    <p>Socialgood  |  Small Size  |   Washington DC</p>
                                </div>
                                <div class="col-sm-6 col-md-4 thumbs">
                                    <div><img src="images/companies/thumbtack.jpg" /></div>
                                    <h2>Euclid Analytics</h2>
                                    <h5>Data Scientist</h5>
                                    <p>Consumer |  Large Size  |   San Francisco</p>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
        <section>
            <hr />
            <div class="container">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1 companies text-right">
                        <a href="#" class="view-jobs-btn">View all Companies</a>
                    </div>
                </div>
            </div>
        </section>
        <section class="user-home">
            <div class="cl-logos featured ftr-logos">
                <div class="container">
                    <span>As featured in</span>
                    <img src="images/tnw.png" />
                    <img src="images/lg-entpr.png" />
                    <img src="images/lg-giga.png" />
                    <img src="images/lg-fast.png" />
                    <img src="images/lg-wired.png" />
                </div>

            </div>
        </section>

        <section class="hm-contact">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 cnt-phone"><img src="images/ic-hone.png" /> Tool Free <span>number</span>  555 444 777</div>
                    <div class="col-md-4 cnt-phone cnt-support"><img src="images/ic-hone.png" /> Support  547548 ( 954 )</div>
                    <div class="col-md-4 cnt-email"><img src="images/ic-email.png" /> Support  547548 ( 954 )</div>
                </div>
            </div>
        </section>

        <footer class="footer-cnt">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 footer-secs">
                        <h3>Information</h3>
                        <ul>
                            <li><a href="{{ route('information.aboutus') }}">About Us</a></li>
                            <li><a href="{{ route('information.terms') }}">Terms & Conditions</a></li>
                            <li><a href="{{ route('information.privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('information.career') }}">Careers with Us</a></li>
                            <li><a href="{{ route('information.contact') }}">Contact Us</a></li>
                            <li><a href="{{ route('information.faq') }}">FAQs</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 footer-secs">
                        <h3>Jobseekers</h3>
                        <ul>
                            <li><a href="#">Register Now</a></li>
                            <li><a href="#">Search Jobs</a></li>
                            <li><a href="#">Login</a></li>
                            <li><a href="#">Create Job Alert</a></li>
                            <li><a href="#">Report a Problem</a></li>
                            <li><a href="#">Security Advice</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 footer-secs">
                        <h3>Browse Jobs</h3>
                        <ul>
                            <li><a href="#">Browse All Jobs</a></li>
                            <li><a href="#">Premium MBA Jobs</a></li>
                            <li><a href="#">Premium Engineering Jobs</a></li>
                            <li><a href="#">Govt. Jobs</a></li>
                            <li><a href="#">International Jobs</a></li>
                            <li><a href="#">Jobs by Company</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-6 footer-secs">
                        <h3>Employers</h3>
                        <ul>
                            <li><a href="#">Post Jobs</a></li>
                            <li><a href="#">Access Database</a></li>
                            <li><a href="#">Manage Responses</a></li>
                            <li><a href="#">Buy Online</a></li>
                            <li><a href="#">Report a Problem</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-12 footer-secs socialWrap">
                        <h3>Follow us</h3>
                        <ul>
                            <li class="socials"><a href="#"><img src="images/facebook.png" />Facebook</a></li>
                            <li class="socials"><a href="#"><img src="images/twitter.png" />Twitter</a></li>
                            <li class="socials"><a href="#"><img src="images/gplus.png" />Google+</a></li>
                            <li class="socials"><a href="#"><img src="images/linkedin.png" />LinkedIn</a></li>
                        </ul>
                    </div>
                </div>

            </div>

        </footer>
        <div class="copyright">
            <div class="container">© 2016 Snappeejobs LLC. All rights reserved</div>
        </div>

    @else

    <!-- Home page Content -->
    <div class="container-fluid">
        <div class="row">
            <header>
                <div class="home-banner">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-5 top-head">
                                <a href="/employers">For Employers</a>
                                <a href="/auth/login"> Sign In</a>
                                <a href="/auth/register" class="signup-btn">Sign Up</a>
                            </div>
                        </div>
                        <div class="home-logo text-center"><img src="images/snap-logo.png" /></div>
                        <h1>The best way to find a job</h1>
                        <div class="row">
                            <div class="col-sm-12">
                                <form class="form-inline text-center">
                                    <div class="form-group">
                                        <label class="sr-only" for="">Your name</label>
                                        <input type="email" class="form-control input-lg" id="" placeholder="Your name">
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="">Your email</label>
                                        <input type="email" class="form-control input-lg" id="" placeholder="Your email">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg">Sign up</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </header>
        </div>
        <div class="popcap text-center">
            <a href="#">How  Snappeejobs Help Me?</a>
        </div>
        <section class="container pr-logos">
            <div class="row">
                <div class="col-md-6 cl-partners col-md-offset-3 text-center">
                    No bad apples here. We only work with the best companies to ensure you end up in an incredible place.
                </div>
            </div>
            <div class="row">
                <div class="cl-logos">
                    <img src="images/lg-amazon.png" />
                    <img src="images/lg-uber.png" />
                    <img src="images/lg-microsoft.png" />
                    <img src="images/lg-google.png" />
                    <img src="images/lg-yahoo.png" />
                    <img src="images/lg-flipkart.png" />
                    <img src="images/lg-cadburry.png" />
                    <img src="images/lg-boss.png" />
                    <img src="images/lg-fujifilm.png" />
                    <img src="images/lg-fedex.png" />
                    <img src="images/lg-vaio.png" />
                    <img src="images/lg-comcast.png" />
                </div>
            </div>
        </section>
        <section>
            <div class="row">
                <div class="boxWrap">
                    <div class="boxImage applicant"></div>
                    <div class="boxContent">
                        <h2>Snappeejobs<br />Better Jobs for Everyone</h2>
                        <p class="clearfix">We connect millions of aspiring job seekers
                            to world's best employers</p>
                        <div class="clearfix MB-30"></div>
                        <a href="/auth/register" class="signup-btn">Sign Up</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="boxWrap">
                    <div class="boxContent emplr">
                        <h2>For Employers</h2>
                        <p class="clearfix">Are you an employer looking to attract the best talent? Showcase the<br />
                            heart and soul of your company and find the candidates<br />
                            that you are searching for !
                            to world's best employers</p>
                        <div class="clearfix MB-30"></div>
                        <a href="/employers" class="signup-btn">learn more <img src="images/btn-arrow.png" align="center" /></a>
                    </div>
                    <div class="boxImage employer"></div>
                </div>
            </div>
        </section>

        <section class="customer-reviews">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2 text-center">
                        <h2>Customer Reviews</h2>
                        <p>Aside from actually finding my job on The Muse, it helped me figure out what to wear to my first Chartbeat interview. All the advice just made the whole process less stressful.
                        </p>
                    </div>
                    <div class="clearfix"></div>
                    <div class="customers">
                        <div class="">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="col-xs-4 c-list"><img src="images/customer1.png" /></div>
                                <div class="col-xs-4 c-list current">
                                    <img src="images/customer2.png" />
                                    <span><img src="images/qoute.png" /></span>
                                    <h3>Kate Coghlan</h3>
                                    <p>Art Director, Brick Media</p>
                                </div>
                                <div class="col-xs-4 c-list"><img src="images/customer3.png" /></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="row">
                <div class="boxWrap">
                    <div class="boxImage deal"></div>
                    <div class="boxContent">
                        <h2>Everything About Your Career<br /> at One Place Now</h2>
                        <p class="clearfix">Start Your Job Search With 250,000+ Jobs from  <br />All Over the Web</p>
                        <div class="clearfix MB-30"></div>
                        <a href="#" class="signup-btn">Sign Up</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="boxWrap">
                    <div class="boxContent hire">
                        <h2>Discover your next great hire</h2>
                        <p class="clearfix">Are you an employer looking to attract the best talent? Showcase the heart and soul of your company and find the candidates that you are searching for !</p>
                        <div class="clearfix MB-30"></div>
                        <a href="#" class="signup-btn">Employer side  <img src="images/btn-arrow.png" align="center" /></a>
                        <div class="clearfix"></div>
                    </div>
                    <div class="boxImage employees"></div>
                </div>
            </div>
        </section>

        <section class="container featurd">
            <div class="cl-logos featured">
                As featured in
                <img src="images/tnw.png" />
                <img src="images/lg-entpr.png" />
                <img src="images/lg-giga.png" />
                <img src="images/lg-fast.png" />
                <img src="images/lg-wired.png" />
            </div>
        </section>
        <section class="hm-contact row">
            <div class="container">
                <div class="row text-center">
                    <div class="col-md-4 cnt-phone"><img src="images/ic-hone.png" /> Tool Free <span>number</span>  555 444 777</div>
                    <div class="col-md-4 cnt-phone cnt-support"><img src="images/ic-hone.png" /> Support  547548 ( 954 )</div>
                    <div class="col-md-4 cnt-email"><img src="images/ic-email.png" /> Support  547548 ( 954 )</div>
                </div>
            </div>
        </section>

        @include('frontend.includes.footer')

    </div>
    <!-- Home page Content -->

    @endif

    @yield('before-scripts-end')

    {!! HTML::script(elixir('js/frontend.js')) !!}

    <script>

        @if(auth()->user())

        var socket = io('http://{{ env('SOCKETIO_SERVER_IP', '127.0.0.1') }}:{{ env('SOCKETIO_SERVER_PORT', 8000) }}');

        var SnappeeJobsHeader = new Vue({
            el: '.notifications-header',

            data: {
                unread_messages: [],
                rejected_applications: [],
                unread_messages_order: -1,
                rejected_applications_order: -1
            },

            ready: function(){

                var that = this;

                $.post('{{ route('frontend.notification.unreadchats') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                    if ( data.length ) {
                        that.unread_messages = data;
                    }
                });

                $.post('{{ route('frontend.notification.rejected_applications') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){
                    if ( data.length ) {
                        that.rejected_applications = data;
                    }
                });

                // Listening to the socket
                socket.on('user.{{ auth()->user()->id }}:employerchat-received', function(data){
                    that.unread_messages.push(data.message_details)
                });

            },

            methods: {
                mark_rejected_applications_read: function(){
                    $.post('{{ route('frontend.notification.rejected_applications_mark_read') }}', { _token : $('meta[name="_token"]').attr('content') }, function(data){

                    });
                }
            }
        });

        @endif

    </script>

    @yield('after-scripts-end')

    @include('sweet::alert')
</body>
</html>