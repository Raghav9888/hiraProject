@extends('layouts.app')

@section('content')

<div class="contact-us-wrrpr" style="height: 100vh;display: flex; align-items: center; justify-content: center;">
                <div class="login-wrrpr register-data">
                    <div class="login-body">
                        <div class="d-flex justify-content-center mb-4">
                        <img src="../../../asserts/header-logo.svg" alt="">
                    </div>
                    <div class="contact-us-right-dv">
                        <h3 style="margin-bottom: 40px;">SignUp your account</h3>
                        <form>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Enter your Email</label>
                                <input type="email" class="form-control" id="exampleInputPassword1"
                                    placeholder="Enter a valid email address">
                            </div>
                            <div class="d-flex justify-content-center mt-5">
                            <button class="w-100" type="submit">Submit</button>
                        </div>
                        </form>
                        <div class="links justify-content-end mt-4">
                                <p>Already have an account? <a style="text-decoration: underline;" href="login.html" class="login-link">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection