@extends('mylayouts.layout_front_sb')
@section('title', 'Toko dan UMKM')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="#beranda">
        <div class="container pt-5 pb-5 pt-md-5 pb-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-5 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start order-2 order-lg-0"
                     data-cues="slideInDown" data-group="page-title" data-delay="600">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Toko dan UMKM</h1>
                    <p class="lead fs-lg mb-7">{{getSetting('app_description')}}</p>
                </div>
                <!-- /column -->
                <div class="col-lg-7" data-cue="slideInDown">
                    <lottie-player
                        src="{{asset('statis/illustrations/shop.json')}}"
                        background="transparent" speed="1" style="width: 100%; height: 400px;"
                        loop
                        autoplay></lottie-player>
                </div>
                <!-- /column -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->

    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pencarian Toko / UMKM</label>
                        <form action="{{ url()->current()  }}" method="GET">
                            <input class="form-control" name="search" placeholder="masukkan kata kunci..">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mt-6">
                <!-- /column -->
                <div class="blog grid grid-view">
                    <div class="row isotope gx-md-8 gy-8 mb-8">
                        @if(count($stores) > 0)
                            @foreach($stores as $val)
                                <article class="item post col-md-4">
                                    <div class="card">
                                        <div class="card-body">
                                            @php
                                                $id_stores = encodeId($val->store_id)
                                            @endphp
                                            <div class="post-header">
                                                <figure class="lift rounded mb-6"><a href="{{getImageOri($val->store_logo)}}"> <img src="{{ getImageOri($val->store_logo)  }}" alt="" /></a></figure>
                                                <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark" href="#">{{$val->store_name}}</a></h2>
                                            </div>
                                            <!-- /.post-header -->
                                            <div class="post-content">
                                                <h6> {{ $val->store_description  }}   </h6>
                                                Kontak :
                                                <h6> {{ $val->store_url  }}   </h6>

                                            </div>
                                            <!-- /.post-content -->
                                        </div>
                                        <!--/.card-body -->
                                        <!-- /.card-footer -->
                                    </div>
                                    <!-- /.card -->
                                </article>
                            @endforeach
                                {{$stores->links()}}
                        @else
                            <h3>Mohon maaf toko/umkm dengan nama {{$keyword}} tidak ditemukan</h3>
                            <a href="{{ url(('/pelaku-usaha'))  }}"> <i class="uil uil-backward"></i> Kembali </a>
                        @endif
                    </div>
                    <!-- /.row -->
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
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.3.0/js/responsive.bootstrap5.min.js"></script>

    <script type="text/javascript">

    </script>
@endpush
