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
                                            <div class="widget-user-image text-center">
                                                @if(Auth::user()->foto)
                                                    <img class="img-circle" height="200" src="{{getImageThumb(Auth::user()->foto)}}" alt="User Avatar">
                                                @else
                                                    <img class="img-circle" height="200" src="{{asset('statis/user_logo.png')}}" alt="User Avatar">
                                                @endif
                                            </div>
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
                                            @if(cekRoleAkses('store'))
                                                <tr>
                                                    <td>Deskripsi Event Planner</td>
                                                    <td><strong> {{Auth::user()->store_description}} </strong></td>
                                                </tr>
                                            @endif
                                        </table>
                                        <br>
                                        @if(cekRoleAkses('store'))
                                            <a href="{{ url('/main') }}" class="btn btn-primary rounded me-2">Dashboard Event Planner &nbsp;<i
                                                    class="ml-4 fas fa-home" style="color: white !important;"></i> </a>
                                        @endif
                                        <a href="{{ route('auth-logout') }}" class="btn btn-primary rounded me-2">Logout &nbsp;<i
                                                class="ml-4 fas fa-power-off" style="color: white !important;"></i> </a>
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
                                            @if(cekRoleAkses('store'))
                                                <tr>
                                                    <td style="width: fit-content;">Event</td>
                                                    <td class="text-center"> &emsp; <strong> {{$count_event}} </strong> </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: fit-content;">Berita</td>
                                                    <td class="text-center"> &emsp; <strong> 0 </strong> </td>
                                                </tr>
                                            @else
                                                <tr>
                                                    <td style="width: fit-content;">Tiket dimiliki</td>
                                                    <td class="text-center"> &emsp; <strong> </strong></td>
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
