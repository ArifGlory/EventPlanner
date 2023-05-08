@extends('mylayouts.layout_front_sb')
@section('title', $product->product_name)
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> {{$product->product_name}} </h1>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <div class="card">
                                <div class="col-lg-12">
                                    @include('mycomponents.alert_front')
                                </div>
                                <figure class="card-img-top overlay overlay-1 hover-scale">
                                    <a href="{{ getImageOri($product->product_image)  }}"><img src="{{ getImageOri($product->product_image)  }}" alt="" /></a>
                                </figure>
                                <div class="card-body">
                                    <div class="post-header">
                                        <div class="post-category text-line">
                                            <a href="#" class="hover" rel="category">{{$product->subcategory_name}}</a>
                                        </div>
                                        <!-- /.post-category -->
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="#">{{$product->product_name}}</a></h2>
                                        <br>
                                        <del>Rp. {{ format_angka_indo($product->product_old_price) }} </del>
                                        <h4><strong> Rp. {{ format_angka_indo($product->product_price) }} </strong></h4>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        <p>
                                            @php
                                                echo nl2br($product->product_description)
                                            @endphp
                                        </p>
                                        <br>
                                        <a href="{{url('/produk-link/'.encodeId($product->product_id))}}" class="btn btn-primary rounded me-2">Dapatkan produk &nbsp;&nbsp;<i
                                                class="ml-4 fas fa-shopping-cart" style="color: white !important;"></i> </a>
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <div class="card-footer">
                                    <ul class="post-meta d-flex mb-0">
                                        <li class="post-date"> <strong> Berlaku sampai <span>{{ rubah_tanggal_indo($product->product_discount_end_date)  }}</span> </strong> </li>
                                        <li class="post-author"><a href="#"><i class="uil uil-user"></i><span>By {{$product->store_name}}</span></a></li>
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
                        <h4 class="widget-title mb-3">Yuk cek produk lainnya</h4>
                        <ul class="image-list">
                            @foreach($other_product as $val)
                                <li>
                                    <figure class="rounded">
                                        <a href="{{url('/detail-produk/'.encodeId($val->product_id))}}">
                                            <img src="{{ getImageOri($val->product_image)  }}" alt="" />
                                        </a>
                                    </figure>
                                    <div class="post-content">
                                        <h6 class="mb-2"> <a class="link-dark" href="{{url('/detail-produk/'.encodeId($val->product_id))}}">{{$val->product_name}}</a> </h6>
                                        <ul class="post-meta">
                                            <li class="post-comments"><a href="#"><i class="uil uil-store"></i>{{$val->store_name}}</a></li>
                                        </ul>
                                        <!-- /.post-meta -->
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <!-- /.image-list -->
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title mb-3">Kategori Lainnya</h4>
                        <ul class="unordered-list bullet-primary text-reset">
                            @foreach($some_category as $val)
                                <li><a href="#"> {{$val->subcategory_name}} </a></li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /.widget -->
                    <div class="widget">
                        <h4 class="widget-title mb-3">Tags</h4>
                        <ul class="list-unstyled tag-list">
                            @for($i=0; $i < count($tags); $i++)
                                <li><a href="#" class="btn btn-soft-ash btn-sm rounded-pill"> {{$tags[$i]}} </a></li>
                            @endfor
                        </ul>
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
