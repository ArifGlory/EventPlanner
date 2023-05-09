@extends('mylayouts.layout_auth')
@section('title', 'Daftar Aplikasi')
@push('css')
@endpush
<!--begin::Content-->
@section('content')
    <!-- Register -->
    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-center align-self-center">
                <img alt="" src="{{asset('statis/event_planner_logo.png')}}"
                     srcset="{{asset('statis/event_planner_logo.png')}}">
            </div>
            <br>
            <p class="mb-4 text-center">Register akun {{getSetting('app_name')}}</p>
            <div class="col-md-12">
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h6>{{$errors->first()}}</h6>
                    </div>
                @endif
            </div>

            <form id="" class="mb-3"
                  action="{{ route('register') }}" autocomplete="off"
                  method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Mendaftar Sebagai</label>
                    <select name="role" class="form-control">
                        <option value="user">Pengguna</option>
                        <option value="store">Event Planner</option>
                    </select>
                    @error('role')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <br>
                    {{--<input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                           name="email" required placeholder="Enter your email" autofocus>--}}
                    <div class="input-group mb-3">
                        <input name="email" required type="text" id="email" class="form-control" placeholder="Email anda" aria-label="email anda" aria-describedby="basic-addon2">
                    </div>

                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Nama</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                           name="name" required placeholder="Enter your name" autofocus>
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone"
                           name="phone" required placeholder="Enter your phone" autofocus>
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
                </div>
                {{--<div class="mb-3 form-password-toggle">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Confirm Password</label>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="c_password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="c_password"/>
                        <div class="input-group-prepend"
                             onclick="hintPass('c_password')">
                               <span class="input-group-text"
                                     id="icon_password"><i
                                       class="fas fa-eye-slash"></i></span>
                        </div>
                        @error('c_password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>--}}
                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
                </div>
            </form>


        </div>
    </div>
    <!-- /LOGIN -->
@endsection
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $("#btnCekEmail").on("click",function (){
                $.ajax({
                    beforeSend: function () {
                        $("#btnCekEmail").prop('disabled', true);
                        Swal.showLoading();
                    },
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: '{{ route('register.cek-email') }}',
                    data: {
                        email: $("#email").val(),
                    },
                    success(res) {
                        //console.log(res);
                        Swal.close();
                        if (res.status === true) {
                            swal.fire("Berhasil !", res.pesan, "success");
                            $("#name").val(res.data.name);
                            $("#phone").val(res.data.phone);
                        } else {
                            swal.fire("Email Tidak terdaftar", res.pesan, "warning");
                        }

                        $("#btnCekEmail").prop('disabled', false);
                    },
                    error: function (err) {
                        // console.log(err)
                        Swal.close();
                        swal.fire("Gagal!", res.pesan, "error");
                        $("#btnCekEmail").prop('disabled', false);
                    }
                });
            });
        });

    </script>
@endpush
