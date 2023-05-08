@extends('mylayouts.layout_front_sb')
@section('title', "Kirim bukti pengerjaan")
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h1> Kirim Bukti Pengerjaan {{$mission->mission_name}} </h1>
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
                                        <h2 class="post-title mt-1 mb-0"><a class="link-dark" href="{{url('/mission/detail/'.encodeId($mission->mission_id))}}"> {{$mission->mission_name}}</a></h2>
                                        <h6 class="post-title mt-1 mb-0"><a class="link-dark" href="#">Bergabung mission pada {{ rubah_tanggal_indo($submission->created_at)  }}</a></h6>
                                    </div>
                                    <!-- /.post-header -->
                                    <div class="post-content">
                                        @if($submission->submission_image)
                                            <div class="alert alert-success" role="alert">
                                                <h4 class="alert-heading">Anda telah mengirim bukti pengerjaan pada mission ini</h4>
                                                <p class="post-title mt-1 mb-0"><a class="link-dark" href="#">dikirim pada {{ rubah_tanggal_indo($submission->updated_at)  }}</a></p>
                                            </div>
                                            <div class="card shadow-lg h-100 align-items-center">
                                                <div class="card-body align-items-center d-flex px-3 py-6 p-md-8">
                                                    <figure class="px-md-3 px-xl-0 px-xxl-3 mb-0"><img src="{{ getImageOri($submission->submission_image)  }}" alt=""></figure>
                                                </div>
                                                <!--/.card-body -->
                                            </div>
                                        @else
                                            <div class="row">
                                                <form action="{{ url('/mission/submission/store')  }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <input name="mission_id" value="{{encodeId($mission->mission_id)}}" type="hidden">
                                                        <div class="form-group">
                                                            <label> Nama Akun Anda </label>
                                                            <small>bisa juga menggunakan User ID</small>
                                                            <input id="submission_user_socmed_account"
                                                                   class="form-control @error('submission_user_socmed_account') is-invalid @enderror"
                                                                   type="text" name="submission_user_socmed_account">
                                                            @error('submission_user_socmed_account')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Screenshot Bukti Pengerjaan</label>
                                                            <input id="mission_image"
                                                                   class="form-control @error('submission_image') is-invalid @enderror"
                                                                   type="file" name="submission_image"
                                                                   accept="image/*">
                                                            @error('submission_image')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                            @enderror
                                                        </div>
                                                        <div class="form-group">
                                                            <br>
                                                            <button type="submit" class="btn btn-sm btn-primary w-100">Kirim</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        @endif
                                    </div>
                                    <!-- /.post-content -->
                                </div>
                                <!--/.card-body -->
                                <!-- /.card-footer -->
                            </div>
                            <!-- /.card -->
                        </article>
                    </div>
                </div>
                <!-- /column -->
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
