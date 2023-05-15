@extends('mylayouts.layout_front_sb')
@section('title', $planner->name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$planner->name}} </h1>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($planner->foto)  }}"><img src="{{ getImageOri($planner->foto)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$planner->name}}</a></h2>
                                        <p>
                                            Beralamat di <strong>{{$planner->alamat != null ? $planner->alamat : "alamat belum dilengkapi"}}</strong>
                                            <br>
                                            kontak <strong>{{$planner->phone}}</strong>
                                        </p>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        {!! $planner->store_description !!}
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
                                    <ul class="post-meta d-flex mb-0">
                                        <li class="post-date"> <strong> Bergabung sejak <span>{{ rubah_tanggal_indo($planner->created_at)  }}</span> </strong> </li>
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
                        <h4 class="widget-title mb-3">Yuk cek penyelenggara lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_planner as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/planner/detail/'.encodeId($val->id))}}">
                                            <img src="{{ getImageOri($val->foto)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/planner/detail/'.encodeId($val->id))}}">{{$val->name}}</a> </h6>
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
