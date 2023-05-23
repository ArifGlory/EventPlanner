@extends('mylayouts.layout_panel')
@section('title', 'Dashboard')
@push('css')
    @include('mycomponents.cssDatatable')
@endpush
@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 font-weight-bolder">DASHBOARD {{getSetting('app_name')}}
                    </h1>
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
                    <h5 class="widget-user-desc">{{Auth::user()->email}}</h5>
                </div>
                <div class="widget-user-image">
                    @if(Auth::user()->foto)
                        <img class="img-circle" src="{{getImageThumb(Auth::user()->foto)}}" alt="User Avatar">
                    @else
                        <img class="img-circle" src="{{asset('statis/user_logo.png')}}" alt="User Avatar">
                    @endif
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header">{{ "Event Planner" }}</h5>
                                <span class="description-text">Role</span>
                            </div>
                            <!-- /.description-block -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
            <!-- /.widget-user -->
            @if(cekRoleAkses('superadmin') || cekRoleAkses('admin'))
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-fuchsia" style="background-color: #E668B3!important;">
                            <div class="inner">
                                <h3> {{$store}} </h3>
                                <p>Store</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-home"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-fuchsia" style="background-color: #E668B3!important;">
                            <div class="inner">
                                <h3> {{$produk}} </h3>
                                <p>Produk</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-ash">
                            <div class="inner">
                                <h3> {{$mission}} </h3>
                                <p>Mission</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-ash">
                            <div class="inner">
                                <h3> 0 </h3>
                                <p>Reward</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-12">
                        <div class="card mt-2">
                            <div class="card-header bg-primary">
                                <div class="row g-1">
                                    <h5>Submission menunggu untuk di proses = {{count($mission_waiting)}} </h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <table class="table table-striped table-bordered" style="width:100%" id="mission_waiting">
                                    <thead class="bgcolortable">
                                    <tr>
                                        <th style="width: 5px">No.</th>
                                        <th style="width: 100px">Nama</th>
                                        <th style="width: 100px">Akun Social Media</th>
                                        <th style="width: 100px">Bukti</th>
                                        <th style="width: 50px">Tanggal</th>
                                        <th style="width: 50px">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $no = 1;
                                        @endphp
                                        @foreach($mission_waiting as $val)
                                            <tr>
                                                <td> {{$no++}} </td>
                                                <td> {{$val->name}} </td>
                                                <td> {{$val->submission_user_socmed_account}} </td>
                                                <td class="text-center">
                                                    <a href="{{getImageOri($val->submission_image)}}" class="image-popup-no-margins">
                                                        <img class="profile-user-img img-fluid"
                                                             src="{{getImageThumb($val->submission_image)}}" alt="mission">
                                                    </a>'
                                                </td>
                                                <td> {{ tanggalIndo($val->updated_at) }} </td>
                                                <td class="text-center"> <a href="{{ url('/main/mission/detail/'.encodeId($val->mission_id)) }}"
                                                                            class="btn btn-primary btn-lg">Lihat</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>

                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(cekRoleAkses('store'))
                <div class="row">
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-ash">
                            <div class="inner">
                                <h3> {{$event}} </h3>
                                <p>Event</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-6">
                        <div class="small-box bg-fuchsia" style="background-color: #E668B3!important;">
                            <div class="inner">
                                <h3> {{$berita}} </h3>
                                <p>Berita</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-file-alt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            @endif



        </div>


    </section>
@endsection

@push('scripts')
    @include('mycomponents.jsDatatable')
    <script src="{{ asset('assets/jshideyorix/mydatatable.js')}}"></script>
    <script src="{{ asset('assets/jshideyorix/deletertable.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function () {


        });

    </script>
@endpush
