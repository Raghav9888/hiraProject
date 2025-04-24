@extends('layouts.app')

@section('content')
    <div class="contact-us-wrrpr" style="display: flex; align-items: center; justify-content: center;">
        <div class="login-wrrpr register-data">
            <div class="login-body">
                <div class="d-flex justify-content-center mb-4">
                    <img src="{{ url('./assets/images/header_logo.png') }}" alt="" width="300px">
                </div>
                <div class="contact-us-right-dv">
                    <h3 style="margin-bottom: 40px;">Login (For Practitioners)</h3>
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
                        <a href="javascript:void(0)" data-bs-target="#exampleModal" data-bs-toggle="modal"
                           class="login-link">Register Now</a>
                        <a href="{{ route('password.request') }}" class="login-link">Forgot Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
