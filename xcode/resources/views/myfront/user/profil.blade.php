@extends('mylayouts.layout_front_sb')
@section('title', "Profil Pengguna")
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="">
        <div class="container py-14 py-md-16">
            <h1> Profil Akun </h1>
            <div class="col-lg-12">
                @include('mycomponents.alert_front')
            </div>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-6">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{ Auth::user()->name  }}</a></h2>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        <table class="table-responsive table-borderless">
                                            <tr>
                                                <td>Wallet Address</td>
                                                <td><strong> {{Auth::user()->wallet_address}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Email</td>
                                                <td><strong> {{Auth::user()->email}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Telepon</td>
                                                <td><strong> {{Auth::user()->phone}} </strong></td>
                                            </tr>
                                            <tr>
                                                <td>Alamat</td>
                                                <td><strong> {{Auth::user()->alamat}} </strong></td>
                                            </tr>
                                        </table>
                                        <br>
                                        @if(cekRoleAkses('store'))
                                            <a href="{{ url('/main') }}" class="btn btn-primary rounded me-2">Dashboard Store &nbsp;<i
                                                    class="ml-4 fas fa-home" style="color: white !important;"></i> </a>
                                        @endif
                                        <a href="{{ route('auth-logout') }}" class="btn btn-primary rounded me-2">Logout &nbsp;<i
                                                class="ml-4 fas fa-power-off" style="color: white !important;"></i> </a>
                                        @if(!cekRoleAkses('store'))
                                            <div class="form-group mt-3">
                                                <a href="{{ url('/user/become-store') }}" class="btn btn-primary w-100 rounded me-2">Upgrade akun menjadi pemilik Store &nbsp;<i
                                                        class="ml-4 fas fa-store" style="color: white !important;"></i> </a>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                            </div>
                            <!-- /.card -->
                        </article>
                    </div>
                </div>
                <!-- /column -->
                <div class="col-lg-6">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">Summary Kepemilikan</a></h2>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        <table class="table-responsive table-borderless">
                                            <tr>
                                                <td style="width: fit-content;">Token $XOME</td>
                                                <td class="text-center"> &emsp; <strong> {{ format_angka_indo(Auth::user()->saldo_xome) }} </strong></td>
                                            </tr>
                                            <tr>
                                                <td style="width: fit-content;">Kredit Point</td>
                                                <td class="text-center"> &emsp; <strong> {{ format_angka_indo(Auth::user()->saldo_point) }} </strong></td>
                                            </tr>
                                            @if(cekRoleAkses('user'))
                                                <tr>
                                                    <td style="width: fit-content;">Mission </td>
                                                    <td class="text-center"> &emsp; <strong> {{ $count_mission }} </strong></td>
                                                </tr>
                                            @endif
                                        </table>
                                        <br>
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                            </div>
                            <!-- /.card -->
                        </article>
                    </div>
                </div>
                <!-- /column -->

            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
@push('scripts')
    <script type="text/javascript">

    </script>
@endpush
