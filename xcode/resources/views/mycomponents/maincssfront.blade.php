<!--favicon-->
@if(getSetting('app_favicon'))
    <link rel="icon" type="image/x-icon" href="{{asset('files/'.getSetting('app_favicon'))}}">
@else
    <link type="image/png" sizes="32x32" rel="icon" href="{{asset('statis/favicon/favicon.png')}}">
@endif
<link rel="stylesheet" href="{{ asset('/frontend/css/plugins.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/style.css')}}">
<link rel="stylesheet" href="{{ asset('/frontend/css/colors/fuchsia.css')}}">
<link rel="stylesheet" href="{{asset('backtemplate/plugins/fontawesome-free/css/all.min.css')}}">
