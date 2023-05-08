@extends('mylayouts.layout_panel')
<?php
$titlePage = 'profil';
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
                        <p class="mb-3">sesuaikan form berikut dengan profil anda</p>
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
                            <div class="card card-danger shadow-lg">
                                <form id="form" method="post"
                                      enctype="multipart/form-data"
                                      action="{{url('main/update-profil')}}">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                    <div class="card-header">
                                        <h3 class="card-title">Form Profil</h3>
                                    </div>

                                    <div class="card-body">
                                        @include('mycomponents.alert')
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row g-3">

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="email">Email</label>

                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text"><i
                                                                            class="fas fa-envelope"></i></span>
                                                                </div>
                                                                <input type="email"
                                                                       class="form-control @error('email') is-invalid @enderror"
                                                                       name="email"
                                                                       value="{{ $row->email }}"/>
                                                                @error('email')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>




                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label class="form-label" for="avatar">Avatar</label>
                                                            <div class="custom-file">
                                                                <input id="avatar"
                                                                       class="custom-file-input @error('avatar') is-invalid @enderror"
                                                                       type="file" name="avatar"
                                                                       accept="image/*"
                                                                       onchange="previewImg('avatar')">
                                                                <label class="custom-file-label" for="avatar">Choose
                                                                    file</label>
                                                            </div>
                                                            @error('avatar')
                                                            <div class="invalid-feedback" style="color: red">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                    </div>

                                                    @if($row->avatar)
                                                        <div class="col-lg-12">
                                                            @component('mycomponents.checkboxValue')
                                                                @slot('variabel')
                                                                    avatar
                                                                @endslot
                                                                @slot('value')
                                                                    {{$row->avatar}}
                                                                @endslot
                                                                @slot('teks')
                                                                    hapus avatar
                                                                @endslot
                                                            @endcomponent
                                                        </div>
                                                    @endif


                                                </div>
                                            </div>

                                            <div class="col-lg-4 d-flex justify-content-center align-self-center">
                                                <lottie-player
                                                    src="{{asset('assets/illustrations/88222-id-card-profile-card.json')}}"
                                                    background="transparent" speed="1"
                                                    style="width: 200px; height: 100%;" loop
                                                    autoplay></lottie-player>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-end">
                                            @component('mycomponents.btnsubmit')
                                                @slot('variabel')
                                                    Simpan Perubahan
                                                @endslot
                                            @endcomponent
                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script src="{{asset('backtemplate/vendor/libs/jquery-sticky/jquery-sticky.js')}}"></script>
    <script>
        $(document).ready(function () {
            changeTextFile('avatar');
        });
    </script>
@endpush
