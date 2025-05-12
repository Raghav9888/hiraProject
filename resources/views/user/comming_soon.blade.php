@extends('layouts.app')

@section('content')
    <style>
        .coming-soon-wrapper {
            min-height: 70vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(to right, #f7f7f7, #eef3f8);
            padding: 40px 15px;
        }
        .coming-soon-card {
            background: #ffffff;
            border-radius: 16px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            max-width: 600px;
            width: 100%;
        }
        .coming-soon-icon {
            font-size: 60px;
            color: #74b9ff;
            margin-bottom: 20px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>

    <div class="coming-soon-wrapper">
        <div class="coming-soon-card">
            <div class="coming-soon-icon">
                <i class="fas fa-tools"></i>
            </div>
            <h2 class="fw-bold text-secondary">Dashboard Coming Soon</h2>
            <p class="text-muted mt-3">
                We're working hard to build something amazing for your dashboard experience. Stay tuned!
            </p>
            <a href="{{ route('home') }}" class="btn btn-green mt-4 px-4 rounded-pill">Back to Home</a>
        </div>
    </div>
@endsection
