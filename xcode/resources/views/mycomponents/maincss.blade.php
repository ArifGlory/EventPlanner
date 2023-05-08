<!--favicon-->
@if(getSetting('app_favicon'))
    <link rel="icon" type="image/x-icon" href="{{asset('files/'.getSetting('app_favicon'))}}">
@else
    <link type="image/png" sizes="32x32" rel="icon" href="{{asset('statis/favicon/default.png')}}">
@endif

<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet"
      href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Icons -->
<link rel="stylesheet" href="{{asset('backtemplate/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('backtemplate/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('backtemplate/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('backtemplate/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{asset('backtemplate/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('backtemplate/css/adminlte.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/magnific-popup/magnific-popup.min.css')}}">
<!-- Page -->
