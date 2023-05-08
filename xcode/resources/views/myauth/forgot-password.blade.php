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
            <h4 class="mb-2">Forgot Password</h4>
            <p class="mb-4">Enter your email and we'll send you instructions to reset your password</p>

            <form id="form" class="mb-3"
                  action="{{ route('password.email') }}" autocomplete="off"
                  method="POST">
                @csrf
                <div class="mb-3">
                    <label for="username" class="form-label">Email</label>
                    <input type="text" class="form-control @error('email') is-invalid @enderror" id="email"
                           name="email" required placeholder="Enter your Email" autofocus>
                    @error('email')
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
