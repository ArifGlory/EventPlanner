<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{getSetting('app_description')}}">
    <meta name="keywords" content="{{getSetting('app_keyword')}}">
    <meta name="author" content="{{getSetting('app_author')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ getSetting('app_name')  }} - @yield('title')</title>
    @include('mycomponents.maincssfront')

    @stack('css')
</head>
<body>
<!-- Site wrapper -->
<div class="content-wrapper">
    <!-- Navbar -->
    @include('mylayouts.header_front')

    @yield('content')

</div>

<!-- footer -->
<footer class="bg-light">
    <div class="container py-13 py-md-15">
        <div class="row gy-6 gy-lg-0">
            <div class="col-md-4 col-lg-5">
                <div class="widget">
                    <img alt="" class="mb-4" src="{{asset('statis/event_planner_logo.png')}}"
                         srcset="{{asset('statis/event_planner_logo.png')}}">

                    <p class="mb-4">© {{date('Y')}} {{getSetting('app_author')}}. <br class="d-none d-lg-block"/>All
                        rights reserved.</p>
                    <nav class="nav social">
                        <a href="{{getSetting('app_twitter')}}" target="_blank"><i class="uil uil-twitter"></i></a>
                        <a href="{{getSetting('app_facebook')}}" target="_blank"><i class="uil uil-facebook-f"></i></a>
                        <a href="{{getSetting('app_instagram')}}" target="_blank"><i class="uil uil-instagram"></i></a>
                        <a href="{{getSetting('app_youtube')}}" target="_blank"><i class="uil uil-youtube"></i></a>
                    </nav>
                    <!-- /.social -->
                </div>
                <!-- /.widget -->
            </div>
            <!-- /column -->
            <div class="col-md-8 col-lg-5">

                <!-- /.widget -->
            </div>
            <!-- /column -->
            <div class="col-md-4 col-lg-2">
                <div class="widget">
                    <h4 class="widget-title  mb-3">Kontak</h4>
                    <address class="pe-xl-15 pe-xxl-17">{{getSetting('app_address')}}
                    </address>
                    <a href="mailto:{{getSetting('app_email')}}"
                       class="link-body">{{getSetting('app_email')}}</a><br/> {{getSetting('app_telephone')}}
                </div>
                <!-- /.widget -->
            </div>
        </div>
        <!--/.row -->
    </div>
    <!-- /.container -->
</footer>
<div class="progress-wrap">
    <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
        <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"/>
    </svg>
</div>
<!--/footer-->
@include('mycomponents.mainjsfront')
@stack('scripts')
</body>
</html>
