@extends('mylayouts.layout_front_sb')
@section('title', $reward->reward_name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$reward->reward_name}} </h1>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($reward->reward_image)  }}"><img src="{{ getImageOri($reward->reward_image)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$reward->reward_name}}</a></h2>
                                        <br>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                       {!! $reward->reward_description !!}
                                        <br>
                                        <a href="#" class="btn btn-primary rounded me-2">Dapatkan reward &nbsp;&nbsp;<i
                                                class="ml-4 fas fa-shopping-cart" style="color: white !important;"></i> </a>
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
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
                        <h4 class="widget-title mb-3">Yuk cek reward lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_reward as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/detail-reward/'.encodeId($val->reward_id))}}">
                                            <img src="{{ getImageOri($val->reward_image)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/detail-reward/'.encodeId($val->reward_id))}}">{{$val->reward_name}}</a> </h6>
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
