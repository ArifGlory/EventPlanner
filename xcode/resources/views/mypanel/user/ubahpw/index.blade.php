@extends('mylayouts.layout_panel')
<?php
$titlePage = 'ubah password';
?>
@section('title', ucwords($titlePage))
@push('css')

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
                        <p class="mb-3">lengkapi form berikut jikalau anda ingin merubah password.</p>
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
                                <form id="form" method="post"
                                      enctype="multipart/form-data"
                                      action="{{url('main/update-password')}}">
                                    {{csrf_field()}}
                                    {{ method_field('PUT') }}
                                    <div class="card-header">
                                        <h5 class="card-title">Form Ubah Password</h5>
                                    </div>

                                    <div class="card-body">
                                        @include('mycomponents.alert')
                                        <div class="row">
                                            <div class="mb-3 col-lg-6">
                                                <label class="form-label" for="old_password">Password saat ini</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" id="old_password"
                                                           class="form-control @error('old_password') is-invalid @enderror"
                                                           name="old_password"/>
                                                    <div class="input-group-prepend"
                                                         onclick="hintPass('old_password')">
                                                           <span
                                                           class="input-group-text"
                                                           id="icon_old_password"><i
                                                               class="fas fa-eye-slash"></i></span>
                                                    </div>
                                                    @error('old_password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-lg-6">
                                                <label class="form-label" for="password">Password Baru</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" id="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           name="password"/>
                                                    <div class="input-group-prepend"
                                                         onclick="hintPass('password')">
                                                        <span class="input-group-text"
                                                              id="icon_password"><i
                                                                class="fas fa-eye-slash"></i></span>
                                                    </div>
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3 col-lg-6">
                                                <label class="form-label" for="password_confirmation">Konfirmasi
                                                    Password
                                                    baru</label>
                                                <div class="input-group mb-3">
                                                    <input type="password" id="password_confirmation"
                                                           class="form-control @error('password_confirmation') is-invalid @enderror"
                                                           name="password_confirmation"/>
                                                    <div class="input-group-prepend"
                                                         onclick="hintPass('password_confirmation')">
                                                        <span class="input-group-text"
                                                              id="icon_password_confirmation"><i
                                                                class="fas fa-eye-slash"></i></span>
                                                    </div>
                                                    @error('password_confirmation')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="mb-3 col-lg-12">
                                                <div class="d-flex justify-content-end">
                                                    @component('mycomponents.btnsubmit')
                                                        @slot('variabel')
                                                            Simpan Perubahan
                                                        @endslot
                                                    @endcomponent
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <p class="fw-semibold mt-2">Password yang disarankan:</p>
                                                <ul class="ps-3 mb-0">
                                                    <li class="mb-1">
                                                        Minimal 8 karakter atau lebih
                                                    </li>
                                                    <li class="mb-1">setidaknya memiliki 1 huruf kecil</li>
                                                    <li>setidaknya memiliki 1 angka dan simbol</li>
                                                </ul>
                                            </div>
                                            <div class="col-lg-6">
                                                <lottie-player
                                                    src="{{asset('assets/illustrations/63004-profile-password-unlock.json')}}"
                                                    background="transparent" speed="1"
                                                    style="width: 100%; height: 150px;" loop
                                                    autoplay></lottie-player>
                                            </div>
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
    <script type="text/javascript">

    </script>
@endpush
