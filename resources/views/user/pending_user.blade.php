@extends('layouts.app')

@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="col-md-8">
            <div class="card shadow-lg rounded-4 border-0">
                <div class="card-body text-center p-5">
                    <i class="fas fa-hourglass-half text-warning display-4 mb-3"></i>
                    <h1 class="fw-bold text-dark">Hello, <span class="text-primary">{{ $user->name }}</span>!</h1>
                    <p class="lead text-muted mt-3">Your request is in progress. Our team will contact you soon.</p>
                    <p class="lead text-muted">Thank you for your patience.</p>
                    <div class="mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary px-4">Go to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
