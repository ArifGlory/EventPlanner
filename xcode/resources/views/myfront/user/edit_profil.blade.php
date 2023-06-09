@extends('mylayouts.layout_front_sb')
@section('title', "Ubah profil pengguna")
@push('css')
@endpush
@section('content')
    <section class="wrapper bg-soft-primary" id="pelakuusaha">
        <div class="container py-14 py-md-16">
            <h2> Ubah profil {{$user->name}} </h2>
            <div class="row gx-lg-8 gx-xl-12 mt-5">
                <div class="col-lg-8">
                    <div class="blog classic-view">
                        <article class="post">
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <div class="card">
                                    <div class="col-lg-12">
                                        @include('mycomponents.alert_front')
                                    </div>
                                    <div class="card-body">
                                        <div class="post-content">
                                            <div class="row">
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Email</label>
                                                    <br>
                                                    <div class="input-group mb-3">
                                                        <input value="{{$user->email}}" name="email" required
                                                               type="text" id="email" class="form-control"
                                                               placeholder="Email anda" aria-label="email anda"
                                                               aria-describedby="basic-addon2">
                                                    </div>

                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Nama</label>
                                                    <input value="{{$user->name}}" type="text"
                                                           class="form-control @error('name') is-invalid @enderror"
                                                           id="name"
                                                           name="name" required placeholder="Enter your name" autofocus>
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3">
                                                    <label for="username" class="form-label">Phone</label>
                                                    <input value="{{$user->phone}}" type="text"
                                                           class="form-control @error('phone') is-invalid @enderror"
                                                           id="phone"
                                                           name="phone" required placeholder="Enter your phone"
                                                           autofocus>
                                                    @error('phone')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 form-password-toggle">
                                                    <div class="d-flex justify-content-between">
                                                        <label class="form-label" for="password">Password</label>
                                                    </div>
                                                    <small>Kosongkan password jika tidak ingin menggantinya</small>
                                                    <div class="input-group mb-3">
                                                        <input type="password" id="password"
                                                               class="form-control @error('password') is-invalid @enderror"
                                                               name="password"/>
                                                        <div class="input-group-prepend"
                                                             onclick="hintPass('password')"></div>
                                                        @error('password')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- /.post-content -->
                                    </div>
                                    <!--/.card-body -->
                                    <div class="card-footer text-right">
                                        <button type="submit" class="btn btn-primary rounded me-2">Simpan perubahan
                                            &nbsp;<i
                                                class="ml-4 fas fa-save" style="color: white !important;"></i></button>
                                    </div>
                                    <!-- /.card-footer -->
                                </div>
                            </form>
                            <!-- /.card -->
                        </article>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </section>
    <!-- /section -->
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            console.log("ready!");
        });
    </script>
@endpush
