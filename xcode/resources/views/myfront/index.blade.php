@extends('mylayouts.layout_front_sb')
@section('title', 'Homepage')
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.3.0/css/responsive.bootstrap5.min.css">
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="#beranda">
        <div class="container pt-5 pb-5 pt-md-5 pb-md-10">
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-5 align-items-center">
                <div class="col-md-10 offset-md-1 offset-lg-0 col-lg-5 text-center text-lg-start order-2 order-lg-0"
                     data-cues="slideInDown" data-group="page-title" data-delay="400">
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">{{getSetting('app_name')}}</h1>
                    <p class="lead fs-lg mb-7">{{getSetting('app_description')}}</p>
                    <div class="d-flex justify-content-center justify-content-lg-start" data-cues="slideInDown"
                         data-group="page-title-buttons" data-delay="400">
                        <span><a href="#" class="btn btn-primary rounded me-2">Telusuri Event &nbsp;&nbsp;<i
                                    class="ml-4 fas fa-star" style="color: white !important;"></i> </a></span>
                    </div>
                </div>
                <!-- /column -->
                <div class="col-lg-7" data-cue="slideInDown">
                    <lottie-player
                        src="{{asset('statis/illustrations/voucher.json')}}"
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
    <section class="wrapper bg-light">
        <div class="container py-14 py-md-16 pb-md-17">
            <div class="row gx-lg-8 gx-xl-12 gy-10 mb-14 mb-md-5 align-items-center" id="hargakomoditas">
                <div class="col-lg-12">
                    <h3 class="display-4 mb-2 text-left">Event terbaru</h3>
                    <p class="lead fs-lg mb-6 pe-xxl-5">Yuk lihat event terbaru yang sedang trending</p>
                    <a href="{{url('/event')}}" class="btn btn-soft-primary rounded-pill">Lihat Semua</a>
                </div>
                <div class="col-lg-8">
                    <div class="swiper-container blog grid-view mb-6" data-margin="30" data-dots="true"
                         data-items-md="2" data-items-xs="1">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach($new_events as $val)
                                    <div class="swiper-slide">
                                    <article>
                                        <figure style="height: 250px;" class="overlay overlay-1 hover-scale rounded mb-5"><a href="#">
                                                <img src="{{ getImageOri($val->event_poster)  }}" alt=""/></a>
                                            <figcaption>
                                                <h5 class="from-top mb-0">Selengkapnya</h5>
                                            </figcaption>
                                        </figure>
                                        <div class="post-header">
                                            <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark"
                                                                                   href="#"> {{$val->event_name}}  </a>
                                            </h2>
                                        </div>
                                        <!-- /.post-header -->
                                        <div class="post-footer">
                                            <ul class="post-meta mb-0">
                                                <li class="post-comments"><a href="#"><i
                                                            class="uil uil-comment"></i>
                                                        {{ \Illuminate\Support\Str::limit($val->event_description, 100, $end='...') }}
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- /.post-meta -->
                                        </div>
                                        <!-- /.post-footer -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                @endforeach
                            </div>
                            <!--/.swiper-wrapper -->
                        </div>
                        <!-- /.swiper -->
                    </div>
                    <!-- /.swiper-container -->
                </div>
            </div>

        </div>
        <!-- /.container -->
    </section>
    <section class="wrapper bg-soft-primary" id="bibitmani">
        <div class="container py-14 py-md-16">
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0">
                <div class="col-lg-12 mb-3">
                    <h2 class="display-4 mb-3">Penyelenggara event</h2>
                    <p class="lead fs-lg mb-6 pe-xxl-5">Data pembuat event di Bandar Lampung</p>
                    <a href="{{url('/planner')}}" class="btn btn-soft-primary rounded-pill">Lihat Semua</a>
                </div>
                <!-- /column -->
                <div class="col-lg-8">
                    <div class="swiper-container blog grid-view mb-6" data-margin="30" data-dots="true"
                         data-items-md="2" data-items-xs="1">
                        <div class="swiper">
                            <div class="swiper-wrapper">
                                @foreach($new_planner as $val)
                                    <div class="swiper-slide">
                                    <article>
                                        <figure class="overlay overlay-1 hover-scale rounded mb-5"><a href="{{url('/planner/detail/'.encodeId($val->id))}}"> <img
                                                    src="{{ getImageOri($val->foto)  }}" alt=""/></a>
                                            <figcaption>
                                                <h5 class="from-top mb-0">Selengkapnya</h5>
                                            </figcaption>
                                        </figure>
                                        <div class="post-header">
                                            <h2 class="post-title h3 mt-1 mb-3"><a class="link-dark"
                                                                                   href="{{url('/planner/detail/'.encodeId($val->id))}}"> {{$val->name}}  </a>
                                            </h2>
                                        </div>
                                        <!-- /.post-header -->
                                        <div class="post-footer">
                                            <ul class="post-meta mb-0">
                                                <li class="post-comments"><a href="#"><i
                                                            class="uil uil-comment"></i>
                                                        {{ \Illuminate\Support\Str::limit($val->store_description, 100, $end='...') }}
                                                    </a>
                                                </li>
                                            </ul>
                                            <!-- /.post-meta -->
                                        </div>
                                        <!-- /.post-footer -->
                                    </article>
                                    <!-- /article -->
                                </div>
                                @endforeach
                            </div>
                            <!--/.swiper-wrapper -->
                        </div>
                        <!-- /.swiper -->
                    </div>
                    <!-- /.swiper-container -->
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
