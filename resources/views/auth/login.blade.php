@extends('layouts.app')

@section('content')
    <section class="contact-us-wrrpr"
             style="height: 100vh;display: flex; align-items: center; justify-content: center;">
        <div class="login-wrrpr">
            <div class="login-body">
                <div class="d-flex justify-content-center mb-4">
                    <img src="../../../asserts/header-logo.svg" alt="">
                </div>
                <div class="contact-us-right-dv">
                    <h3 style="margin-bottom: 40px;">Login your account</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label mb-2">Username or Email Address</label>
                            <input type="text" class="form-control" name="email" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="username or email">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="exampleInputPassword1" class="form-label mb-2">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" class="form-control" id="exampleInputPassword1"
                                       placeholder="password">
                                <span class="input-group-text" id="togglePassword">
                                                <i class="fas fa-eye"></i>
                                            </span>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 form-check d-flex justify-content-end">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label mb-0 ms-2" for="exampleCheck1">Remember me</label>
                        </div>
                        <div class="d-flex justify-content-center">
                            <button class="w-100" type="submit">Login</button>
                        </div>
                    </form>
                    <div class="links mt-4">
                        <a href="{{ route('register') }}" class="login-link">Register Now</a>
                        <a href="{{ route('password.request') }}" class="login-link">Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

    <div class="row mb-3">
        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
    </div>
</div>

<div class="row mb-3">
    <div class="col-md-6 offset-md-4">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
    </label>
</div>
</div>
</div>

<div class="row mb-0">
<div class="col-md-8 offset-md-4">
<button type="submit" class="btn btn-primary">
{{ __('Login') }}
    </button>

@if (Route::has('password.request'))
        <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
        </a>

    @endif
    </div>
</div>
</form>
</div>
</div>
</div>
</div>
</div> -->
    <script>
        const togglePassword = document.getElementById("togglePassword");
        const passwordField = document.getElementById("exampleInputPassword1");

        togglePassword.addEventListener("click", function () {
            const type = passwordField.type === "password" ? "text" : "password";
            passwordField.type = type;

            this.innerHTML = type === "password" ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
@endsection
