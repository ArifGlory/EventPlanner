<header class="wrapper bg-soft-primary">
    <nav class="navbar navbar-expand-lg extended navbar-light navbar-bg-light caret-none">
        <div class="container flex-lg-column">
            <div class="topbar d-flex flex-row w-100 justify-content-between align-items-center">
                <div class="navbar-brand"><a href="#">

                        <img alt="" src="{{asset('statis/event_planner_logo.png')}}"
                             srcset="{{asset('statis/event_planner_logo.png')}}">

                </div>
                <div class="navbar-other ms-auto">
                    <ul class="navbar-nav flex-row align-items-center">
                        <li class="nav-item d-lg-none">
                            <button class="hamburger offcanvas-nav-btn"><span></span></button>
                        </li>
                    </ul>
                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar-other -->
            </div>
            <!-- /.d-flex -->
            <div class="navbar-collapse-wrapper bg-white d-flex flex-row align-items-center">
                <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                    <div class="offcanvas-header d-lg-none">
                        <h3 class="text-white fs-30 mb-0">{{getSetting('app_name')}}</h3>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body d-flex flex-column h-100">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}">Beranda</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(('/event'))  }}">Event</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url(('/'))  }}"> Penyelenggara </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}">Berita</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('/')}}">Peta Event</a>
                            </li>

                        </ul>
                        <!-- /.navbar-nav -->
                        <div class="offcanvas-footer d-lg-none">
                            <div>
                                <a href="mailto:{{getSetting('app_email')}}"
                                   class="link-inverse">{{getSetting('app_email')}}</a>
                                <br/> {{getSetting('app_telephone')}} <br/>
                                <div class="d-flex justify-content-center justify-content-lg-start" data-cues="slideInDown"
                                     data-group="page-title-buttons" data-delay="400">
                                    <span>
                                        @if(Auth::check())
                                            <a href="{{url('/user')}}" class="btn btn-primary rounded me-2"> {{Auth::user()->name}} &nbsp;&nbsp;<i
                                                    class="ml-4 fas fa-user-circle" style="color: white !important;"></i> </a>
                                        @else
                                            <a href="{{url('/login')}}" class="btn btn-primary rounded me-2">Login&nbsp;&nbsp; <i class="ml-4 fas fa-user-circle" style="color: white !important;"></i> </a>
                                        @endif
                                    </span>
                                </div>
                                <!-- /.social -->
                            </div>
                        </div>
                        <!-- /.offcanvas-footer -->
                    </div>
                </div>
                <!-- /.navbar-collapse -->
                <div class="navbar-other ms-auto w-100 d-none d-lg-block">
                    <nav class="nav social social-muted justify-content-end text-end">
                        <div class="d-flex justify-content-center justify-content-lg-start" data-cues="slideInDown"
                             data-group="page-title-buttons" data-delay="400">
                        <span>
                            @if(Auth::check())
                                <a href="{{url('/user')}}" class="btn btn-primary rounded me-2"> {{Auth::user()->name}} &nbsp;&nbsp;<i
                                        class="ml-4 fas fa-user-circle" style="color: white !important;"></i> </a>
                            @else
                                <a href="{{url('/login')}}" class="btn btn-primary rounded me-2"> &nbsp;&nbsp;<i
                                        class="ml-4 fas fa-user-circle" style="color: white !important;"></i> &nbsp; Login  </a>
                                {{--<button onclick="web3Login()" class="btn btn-primary rounded me-2">Connect Wallet&nbsp;&nbsp;<i
                                        class="ml-4 fas fa-wallet" style="color: white !important;"></i> </button>--}}
                            @endif
                        </span>
                        </div>
                    </nav>
                    <!-- /.social -->
                </div>
                <!-- /.navbar-other -->
            </div>
            <!-- /.navbar-collapse-wrapper -->
        </div>
        <!-- /.container -->
    </nav>
    <!-- /.navbar -->
</header>
<!-- /header -->
