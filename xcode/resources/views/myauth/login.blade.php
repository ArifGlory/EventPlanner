@extends('mylayouts.layout_auth')
@section('title', 'Login Aplikasi')
@push('css')
@endpush
<!--begin::Content-->
@section('content')
    <!-- LOGIN -->
    <div class="card">
        <div class="card-body">
            @include('mycomponents.alert')
            <div class="d-flex justify-content-center align-self-center">
                <img alt="" src="{{asset('statis/xpoint_logo.webp')}}"
                     srcset="{{asset('statis/xpoint_logo.webp')}}">
            </div>
            <br>
            <p class="mb-4 text-center">Login Akun {{getSetting('app_name')}}</p>

            <form id="formAuthentication" class="mb-3"
                  action="{{ route('login') }}" autocomplete="off"
                  method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                           name="email" required placeholder="Enter your email" autofocus>
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3" id="divOtp">
                    <label for="username" class="form-label">Kode OTP</label>
                    <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp"
                           name="otp" required placeholder="Enter your otp from email" autofocus>
                    @error('otp')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                {{--<div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                        <a href="{{url('forgot-password')}}">
                            <small>Forgot Password?</small>
                        </a>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password"/>
                        <div class="input-group-prepend"
                             onclick="hintPass('password')">
                               <span class="input-group-text"
                                     id="icon_password"><i
                                       class="fas fa-eye-slash"></i></span>
                        </div>
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>--}}
                <div class="mb-3">
                    <button id="btnSignIn" class="btn btn-primary d-grid w-100" type="button">Sign in</button>
                </div>
                <div class="mb-3" id="divSubmit">
                    <button class="btn btn-primary d-grid w-100" type="submit">Submit</button>
                </div>
            </form>
            <div class="row">
                <div class="col-md-12">
                    <p class="mb-4 mt-2">
                    <br>
                        Untuk dapat menggunakan layanan Xpoint, anda harus terdaftar dahulu di PrivateSale Xomerce
                    </p>
                </div>
                <div class="col-md-12">
                    <a target="_blank" href="https://privatesale.xomerce.io/login" class="btn btn-primary d-grid w-100">Register</a>
                </div>
            </div>


        </div>
    </div>
    <!-- /LOGIN -->
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function (){
           console.log("ready");
           $("#divOtp").hide();
           $("#divSubmit").hide();

           $("#btnSignIn").on("click",function (){
               $.ajax({
                   beforeSend: function () {
                       $("#btnSignIn").prop('disabled', true);
                       Swal.showLoading();
                   },
                   type: 'GET',
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   url: '{{ route('login.otp-req') }}',
                   data: {
                       email: $("#email").val(),
                   },
                   success(res) {
                       //console.log(res);
                       Swal.close();
                       if (res.status === true) {
                           swal.fire("Berhasil !", res.pesan, "success");

                           $("#divOtp").show();
                           $("#divSubmit").show();
                           $("#btnSignIn").hide();
                       } else {
                           swal.fire("Email Tidak terdaftar", res.pesan, "warning");
                       }

                       $("#btnSignIn").prop('disabled', false);
                   },
                   error: function (err) {
                       // console.log(err)
                       Swal.close();
                       swal.fire("Gagal!", res.pesan, "error");
                       $("#btnSignIn").prop('disabled', false);
                   }
               });
           });
        });
    </script>
@endpush
