<!DOCTYPE html>
<!-- beautify ignore:start -->
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{getSetting('app_description')}}">
    <meta name="keywords" content="{{getSetting('app_keyword')}}">
    <meta name="author" content="{{getSetting('app_author')}}">
    <title>{{ getSetting('app_name')  }} - @yield('title')</title>
    @include('mycomponents.maincss')

    @stack('css')
</head>
<body class="hold-transition">
<div class="wrapper">
    <div class="content-wrapper" style="margin-left: 0px!important;">
        @yield('content')
    </div>
</div>

@include('mycomponents.mainjs')
@include('mycomponents.lottieplayer')
@stack('scripts')
</body>
</html>
