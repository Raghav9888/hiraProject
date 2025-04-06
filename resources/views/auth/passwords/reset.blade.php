@extends('layouts.app')

@section('content')
    <div class="contact-us-wrrpr" style="height: 100vh;display: flex; align-items: center; justify-content: center;">
        <div class="login-wrrpr register-data">
            <div class="login-body">
                <div class="d-flex justify-content-center mb-4">
                    <img src="{{ url('./assets/images/header_logo.png') }}" alt="" width="300px">
                </div>
                <div class="contact-us-right-dv">
                    <h3 style="margin-bottom: 40px;">Reset Password</h3>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="mb-3">
                            <label for="email" class="col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label text-md-end">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password"  required>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password-confirm" class="col-form-label text-md-end">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control @error('password') is-invalid @enderror"
                                   name="password_confirmation"  required autocomplete="new-password">
                        </div>
                        <div class="d-flex justify-content-center mt-5">
                            <button type="submit" class="w-100 login-button">
                                {{ __('Reset Password') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
