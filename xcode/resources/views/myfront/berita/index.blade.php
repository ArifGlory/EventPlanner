@extends('mylayouts.layout_front_sb')
@section('title', 'Berita')
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
                    <h1 class="display-1 mb-5 mx-md-n5 mx-lg-0">Berita</h1>
                    <p class="lead fs-lg mb-7">{{getSetting('app_description')}}</p>
                </div>
                <!-- /column -->
                <div class="col-lg-7" data-cue="slideInDown">
                    <lottie-player
                        src="{{asset('statis/illustrations/news.json')}}"
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
            <h3> Berita </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pencarian berita</label>
                        <form action="{{ url()->current()  }}" method="GET">
                            <input class="form-control" name="search" placeholder="masukkan kata kunci..">
                        </form>
                    </div>
                </div>
            </div>
            <div class="row gx-lg-8 gx-xl-12 gy-10 gy-lg-0 mt-4">
                @if(count($berita) > 0)
                    @foreach($berita as $val)
                        <div class="project item col-md-4 col-xl-4 mission">
                            <figure class="lift rounded mb-6"><a href="{{url('/berita/detail/'.encodeId($val->berita_id))}}">
                                    <img src="{{ getImageOri($val->berita_image)  }}" alt="" /></a></figure>
                            <div class="project-details d-flex justify-content-center flex-column">
                                <div class="post-header">
                                    <a href="{{url('/berita/detail/'.encodeId($val->berita_id))}}">
                                        <h2 class="post-title h3"> {{$val->berita_title}} </h2>
                                    </a>
                                    <a href="#">
                                        {!! \Illuminate\Support\Str::limit($val->berita_content, 50, $end='...') !!}
                                    </a>
                                </div>
                                <!-- /.post-header -->
                            </div>
                            <!-- /.project-details -->
                        </div>
                    @endforeach
                    <div class="mt-4"></div>
                    {{$berita->links()}}
                @else
                    <h3>Mohon maaf berita dengan nama {{$keyword}} tidak ditemukan</h3>
                    <a href="{{ url(('/berita'))  }}"> <i class="uil uil-backward"></i> Kembali </a>
                @endif
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
