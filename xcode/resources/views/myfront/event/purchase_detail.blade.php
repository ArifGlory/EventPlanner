@extends('mylayouts.layout_front_sb')
@section('title', "Detail pembelian tiket")
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h2> Pembelian Tiket {{$event->event_name}} </h2>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <div class="card-body">
                                    <div class="post-content">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <img class="img-thumbnail" src="{{ getImageOri($event->event_poster)  }}" alt="" />
                                            </div>
                                            <div class="col-md-8">
                                                <h6>{{$event->event_name}}</h6>
                                                <p> <strong>{{$transaksi->jumlah}} </strong> buah tiket
                                                <br>
                                                    Total Pembayaran <strong>Rp. {{format_angka_indo($transaksi->total_bayar)}}</strong>
                                                </p>
                                                @if($transaksi->status == 0)
                                                    <span class="badge rounded-pill bg-warning text-dark">Menunggu Konfirmasi Pembayaran</span>
                                                @elseif($transaksi->status == 1)
                                                    <span class="badge rounded-pill bg-success text-white"> Pembayaran Diverifikasi </span>
                                                @elseif($transaksi->status == 2)
                                                    <span class="badge rounded-pill bg-danger text-white"> Pembayaran Ditolak </span>
                                                @endif
                                                <div class="mt-3 mb-3"></div>
                                                @if($transaksi->bukti_bayar == null)
                                                    <br>
                                                    <h6>Upload Bukti Pembayaran</h6>
                                                    <form action="{{ url('/purchase/upload/payment')  }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="col-md-5">
                                                            <input type="hidden" name="transaksi_event_id" value="{{encodeId($transaksi->transaksi_event_id)}}">
                                                            <input name="bukti_bayar" type="file" class="form-control w-100">
                                                        </div>
                                                        <div class="pull-right mt-2">
                                                            <button type="submit" class="btn btn-primary rounded w-100">Kirim</button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <span class="badge rounded-pill bg-primary text-white"> Bukti bayar telah dikirim </span>
                                                @endif
                                            </div>
                                        </div>
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
                        </article>
                    </div>
                </div>
                <!-- /column -->
                <div class="col-lg-4">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="card-body">
                                    <div class="post-content">
                                        <h4>Cara pembayaran</h4>
                                        <h5>Transfer Bank</h5>
                                        <p>1. Silahkan melakukan pembayaran sejumlah <strong> Rp. {{format_angka_indo($transaksi->total_bayar)}} </strong>
                                            ke rekening berikut

                                        </p>
                                        <label>Nama Bank</label>
                                        <h6>{{$event->event_bank_rekening}}</h6>
                                        <label>No. Rekening</label>
                                        <h6>{{$event->event_rekening}}</h6>
                                        <p>
                                            2. Setelah pembayaran dilakukan, upload bukti bayar pada menu riwayat transaksi anda
                                            <br>
                                            3. Setelah pembayaran diverifikasi, tiket anda akan aktif
                                        </p>

                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
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
        $( document ).ready(function() {
            console.log( "ready!" );
        });
    </script>
@endpush
