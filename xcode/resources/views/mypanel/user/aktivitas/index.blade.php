@extends('mylayouts.layout_panel')
<?php
$titlePage = 'aktivitas';
?>
@section('title', ucwords($titlePage))
@push('css')
    <link rel="stylesheet" href="{{asset('backtemplate/vendor/css/pages/page-profile.css')}}"/>
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">{{ucwords($titlePage)}}
                    </h1>
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{url('dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ucwords($titlePage)}}</li>
                    </ol>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row g-1">
                <div class="col-lg-6 col-12">
                    <div class="d-flex justify-content-start">
                        <p class="mb-3">berikut data catatan aktivitas menurut waktu kejadian anda.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Navbar pills -->
                @include('mypanel.user.navbar')
                <!--/ Navbar pills -->

                    <!-- User Profile Content -->
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-lg-5">
                            <!-- About User -->
                        @include('mypanel.user.side')
                        <!--/ About User -->

                        </div>
                        <div class="col-xl-8 col-lg-7 col-lg-7">
                            <div class="card">
                                <div class="card-header align-items-center">
                                    <h5 class="card-action-title mb-0"><i class="fa fa-list-ul mr-2"></i>Catatan
                                        Aktivitas</h5>
                                </div>
                                <div class="card-body">
                                    @include('mycomponents.shimmer')
                                    <div id="render">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    @include('mypanel.user.aktivitas.script')
@endpush
