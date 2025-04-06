@extends('layouts.app')

@section('content')
    <div class="contact-us-wrrpr" style="height: 100vh;display: flex; align-items: center; justify-content: center;">
        <div class="login-wrrpr register-data">
            <div class="login-body">
                <div class="d-flex justify-content-center mb-4">
                    <img src="{{ url('./assets/images/header_logo.png') }}" alt="" width="300px">
                </div>
                <div class="contact-us-right-dv">
                    <h3 style="margin-bottom: 40px;">Forgot Password</h3>
                    @if (session('status'))
                        <p class="text-white">{{ session('status') }}</p>
                    @endif
                    <form method="POST" action="{{ route('send.resetLink') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="w-100 login-button">
                                {{ __('Send Reset Link') }}
                            </button>
                        </div>
                    </form>
                    <div class="links justify-content-end mt-4">
                        <p>Already have an account? <a style="text-decoration: underline;" href="{{route('login')}}"
                                                       class="login-link">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
