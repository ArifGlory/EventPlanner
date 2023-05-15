@extends('mylayouts.layout_front_sb')
@section('title', $berita->name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$berita->berita_title}} </h1>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($berita->berita_image)  }}"><img src="{{ getImageOri($berita->berita_image)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$berita->berita_title}}</a></h2>

                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        {!! $berita->berita_content !!}
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
                                    <ul class="post-meta d-flex mb-0">
                                        <li class="post-date"> <strong> Dipost pada <span>{{ rubah_tanggal_indo($berita->created_at)  }}</span> </strong> </li>
                                        <li class="post-date"> <strong> Kategori <span>{{ $berita->category_name  }}</span> </strong> </li>
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
                        <h4 class="widget-title mb-3">Yuk cek berita lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_berita as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/berita/detail/'.encodeId($val->berita_id))}}">
                                            <img src="{{ getImageOri($val->berita_image)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/berita/detail/'.encodeId($val->berita_id))}}">{{$val->berita_name}}</a> </h6>
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
        });
    </script>
@endpush
