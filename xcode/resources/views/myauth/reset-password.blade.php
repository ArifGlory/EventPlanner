@extends('mylayouts.layout_auth')
@section('title', 'Login Aplikasi')
@push('css')
@endpush
<!--begin::Content-->
@section('content')
    <!-- LOGIN -->
    <div class="card">
        <div class="card-body">
            <!-- Logo -->
        @include('myauth.logo')
        <!-- /Logo -->
            @include('mycomponents.alert')
            <h4 class="mb-2">Reset Password 🔒</h4>
            <span class="fw-bold">{{$request->email}}</span>

            <form id="form" class="mb-3"
                  action="{{ route('password.update') }}" autocomplete="off"
                  method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                           name="email" readonly value="{{$request->email}}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                    <label class="form-label" for="password">New Password</label>
                    <div class="input-group input-group-merge has-validation">
                        <input type="password" id="password"
                               class="form-control @error('password') is-invalid @enderror" name="password"
                               placeholder="············" aria-describedby="password">
                        <span class="input-group-text cursor-pointer"><i class="fas fa-eye-slash"></i></span>
                    </div>
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3 form-password-toggle fv-plugins-icon-container">
                    <label class="form-label" for="password_confirmation">Confirm Password</label>
                    <div class="input-group input-group-merge has-validation">
                        <input type="password" id="password_confirmation"
                               class="form-control @error('password_confirmation') is-invalid @enderror"
                               name="password_confirmation"
                               placeholder="············" aria-describedby="password">
                        <span class="input-group-text cursor-pointer"><i class="fas fa-eye-slash"></i></span>
                    </div>
                    <div class="fv-plugins-message-container invalid-feedback"></div>
                    @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>


                <div class="mb-3">
                    <button class="btn btn-primary d-grid w-100">Send Reset Link</button>
                </div>


            </form>
            <div class="text-center">
                <a href="{{url('login')}}" class="d-flex align-items-center justify-content-center">
                    <i class="fa fa-chevron-left scaleX-n1-rtl bx-sm"></i>
                    Back to login
                </a>
            </div>
        </div>
    </div>
    <!-- /LOGIN -->
@endsection
@push('scripts')

@endpush
