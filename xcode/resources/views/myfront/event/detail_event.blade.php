@extends('mylayouts.layout_front_sb')
@section('title', $event->event_name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$event->event_name}} </h1>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($event->event_poster)  }}"><img src="{{ getImageOri($event->event_poster)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$event->event_name}}</a></h2>
                                        <h6>Harga Tiket  Rp. {{format_angka_indo($event->event_harga_tiket)}} </h6>
                                        <p>Sisa tiket {{format_angka_indo($event->event_stok_tiket)}} </p>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        {!! $event->event_description !!}
                                        <br>
                                        <br>
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
                                    <ul class="post-meta d-flex mb-0">
                                        <li class="post-date"> <strong> Diselenggarakan pada <span>{{ rubah_tanggal_indo($event->event_waktu)  }}</span> </strong> </li>
                                        <li class="post-date"> <strong> Pukul <span>{{ $event_time  }}</span> </strong> </li>
                                        <li class="post-date">
                                            @if($event->event_latitude)
                                                <a target="_blank" href="https://www.google.com/maps/search/?api=1&query={{$event->event_latitude}},{{$event->event_longitude}}">
                                                    <strong> Lokasi di <span>{{ $event->event_lokasi  }}</span> </strong>
                                                </a>
                                            @else
                                                <a href="#">
                                                    <strong> Lokasi di <span>{{ $event->event_lokasi  }}</span> </strong>
                                                </a>
                                            @endif
                                        </li>
                                    </ul>
                                    <!-- /.post-meta -->
                                </div>
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="post-content">
                                        <br>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <h4>Atur jumlah tiket</h4>
                                                <div class="input-group mb-3">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-min">-</button>
                                                    <input value="1" id="jumlah-tiket" type="number" class="form-control" placeholder="Jumlah tiket" aria-describedby="button-addon2">
                                                    <button class="btn btn-outline-secondary" type="button" id="button-plus">+</button>
                                                </div>
                                            </div>
                                            <div class="pull-right">
                                                <a href="{{url('/event/buy/'.encodeId($event->event_id))}}" class="btn btn-primary rounded">
                                                    Beli Tiket </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                            </div>
                        </article>
                    </div>
                </div>
                <!-- /column -->
                <aside class="col-lg-4 sidebar mt-8 mt-lg-6">
                    <div class="widget">
                        <h4 class="widget-title mb-3">Yuk cek event lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_event as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/event/detail/'.encodeId($val->event_id))}}">
                                            <img src="{{ getImageOri($val->event_poster)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/event/detail/'.encodeId($val->event_id))}}">{{$val->event_name}}</a> </h6>
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
        $( document ).ready(function() {
            console.log( "ready!" );
            var jmlTiket = 1;
            $("#button-min").on("click",function (){
                jmlTiket = $("#jumlah-tiket").val();
                if(jmlTiket > 1){
                    jmlTiket--;
                    $("#jumlah-tiket").val(jmlTiket);
                }
            });
            $("#button-plus").on("click",function (){
                jmlTiket = $("#jumlah-tiket").val();
                if(jmlTiket <= 50){
                    jmlTiket++;
                    $("#jumlah-tiket").val(jmlTiket);
                }
            });
        });
    </script>
@endpush
