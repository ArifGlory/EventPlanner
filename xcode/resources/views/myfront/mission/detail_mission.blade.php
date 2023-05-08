@extends('mylayouts.layout_front_sb')
@section('title', $mission->mission_name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$mission->mission_name}} </h1>
            @if($isJoined)
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Anda berhasil bergabung dalam mission ini</h4>
                </div>
            @endif
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($mission->mission_image)  }}"><img src="{{ getImageOri($mission->mission_image)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$mission->mission_name}}</a></h2>
                                        <h6>Reward Point {{format_angka_indo($reward_user)}} </h6>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        {!! $mission->mission_description !!}
                                        <br>
                                        @if($isJoined)
                                            @if($isJoined->submission_status == "accepted")
                                                <div class="alert alert-success" role="alert">
                                                    <h4 class="alert-heading">Mission telah sukses</h4>
                                                    <p>Anda telah menyelesaikan mission ini, silahkan cek point anda pada menu profil</p>
                                                </div>
                                            @elseif($isJoined->submission_status == "waiting")
                                                <div class="alert alert-success" role="alert">
                                                    <h4 class="alert-heading">Anda telah tergabung dalam mission ini</h4>
                                                    <p>Silahkan ikuti petunjuk pengerjaan mission, kemudian kirimkan bukti pengerjaan anda melalui tombol dibawah ini</p>
                                                    <hr class="m-0">
                                                    <p class="m-0">Setelah bukti pengerjaan dikirimkan, kami akan mereview dan verifikasi pekerjaan anda.
                                                        Setelah mission diverifikasi maka point anda akan bertambah
                                                    </p>
                                                </div>
                                                <a href="{{url('/mission/submission/'.encodeId($mission->mission_id))}}" class="btn btn-success rounded me-2">Kirim Bukti Pengerjaan &nbsp;&nbsp;<i
                                                        class="ml-4 fas fa-file-image" style="color: white !important;"></i> </a>
                                            @else
                                                <div class="alert alert-success" role="alert">
                                                    <h4 class="alert-heading">Anda telah tergabung dalam mission ini</h4>
                                                    <p>Silahkan ikuti petunjuk pengerjaan mission, kemudian kirimkan bukti pengerjaan anda melalui tombol dibawah ini</p>
                                                    <hr class="m-0">
                                                    <p class="m-0">Setelah bukti pengerjaan dikirimkan, kami akan mereview dan verifikasi pekerjaan anda.
                                                        Setelah mission diverifikasi maka point anda akan bertambah
                                                    </p>
                                                </div>
                                                <a href="{{url('/mission/submission/'.encodeId($mission->mission_id))}}" class="btn btn-success rounded me-2">Kirim Bukti Pengerjaan &nbsp;&nbsp;<i
                                                        class="ml-4 fas fa-file-image" style="color: white !important;"></i> </a>
                                            @endif
                                        @else
                                            <a href="{{url('/mission/join/'.encodeId($mission->mission_id))}}" class="btn btn-primary rounded me-2">Ikuti Mission &nbsp;&nbsp;<i
                                                    class="ml-4 fas fa-check-circle" style="color: white !important;"></i> </a>
                                        @endif

                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
                                    <ul class="post-meta d-flex mb-0">
                                        <li class="post-date"> <strong> Berlaku sampai <span>{{ rubah_tanggal_indo($mission->mission_end_date)  }}</span> </strong> </li>
                                    </ul>
                                    <!-- /.post-meta -->
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </article>
                    </div>
                </div>
                <!-- /column -->
                <aside class="col-lg-4 sidebar mt-8 mt-lg-6">
                    <div class="widget">
                        <h4 class="widget-title mb-3">Yuk cek mission lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_mission as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/mission/detail/'.encodeId($val->mission_id))}}">
                                            <img src="{{ getImageOri($val->mission_image)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/mission/detail/'.encodeId($val->mission_id))}}">{{$val->mission_name}}</a> </h6>
                                        <!-- /.post-meta -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <!-- /.image-list -->
                    </div>
                </aside>
                <!-- /column .sidebar -->
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
