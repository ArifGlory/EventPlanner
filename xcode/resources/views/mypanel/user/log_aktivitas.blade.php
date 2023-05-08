@extends('mylayouts.layout_panel')
<?php
$titlePage = 'Profil Akun';
?>
@section('title', ucwords($titlePage))
@push('css')
    <link rel="stylesheet" href="{{asset('backtemplate/vendor/css/pages/page-profile.css')}}"/>
@endpush
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-1 mb-2">
            <a class="text-muted" href="{{url('main/pengguna')}}">Pengguna</a> /
            {{ucwords($titlePage)}}
        </h4>

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
                        <h5 class="card-action-title mb-0"><i class="fa fa-list-ul me-2"></i>Catatan Aktivitas</h5>
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
@endsection
@push('scripts')
    @include('mypanel.user.aktivitas.script')
@endpush
