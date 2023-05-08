@extends('mylayouts.layout_panel')
@section('title', 'Dashboard')
@push('css')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">DASHBOARD
                    </h1>
                </div>
            </div>

            <div class="row g-1">
                <div class="col-lg-12">
                    @include('mycomponents.alert')
                </div>

            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <section class="content">
        <div class="container-fluid">
            <!-- Widget: user widget style 1 -->
            <div class="card card-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header text-white"
                     style="background: url('{{asset('statis/bg.jpg')}}') center center;">
                    <h3 class="widget-user-username">{{Auth::user()->name}}</h3>
                    <h5 class="widget-user-desc">{{Auth::user()->username}}</h5>
                </div>
                <div class="widget-user-image">
                    <img class="img-circle" src="{{getImageThumb(Auth::user()->avatar)}}" alt="User Avatar">
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">
                                    {{--                                    {{ ucwords(getRoleNameForUser(Auth::user())) }}--}}
                                    ({{ implode(',', auth()->user()->member->role->pluck('nama_role')->toArray()) }})
                                </h5>
                                <span class="description-text">Role</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <div class="col-sm-6">
                            <div class="description-block">
                                <h5 class="description-header">{{Auth::user()->member->nik}}</h5>
                                <span class="description-text">NIK</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
            <div class="row">


                <div class="col-lg-4 col-6">

                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $komoditas_ternak }}</h3>
                            <p>Komoditas Ternak</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-egg"></i>
                        </div>
                    </div>
                </div>


                <div class="col-lg-4 col-6">

                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $uph }}</h3>
                            <p>Unit Pengolah Hasil</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-user-friends"></i>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-6">

                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $produk_usaha }}</h3>
                            <p>Produk Usaha UPH</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-glass-martini"></i>
                        </div>
                    </div>
                </div>


            </div>
        </div>


    </section>
@endsection

@push('scripts')
@endpush
