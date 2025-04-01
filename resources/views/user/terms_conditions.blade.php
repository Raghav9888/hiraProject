@extends('layouts.app')

@section('content')
    <style>

        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /*max-width: 600px;*/
            width: 100%;
            text-align: left;
        }

        h2 {
            color: #333;
            text-align: center;
        }

        p {
            color: #555;
            line-height: 1.9;
        }

    </style>

    <section class="featured-section">
        <div class="container text-center">
            <div class="card">
                <div class="card-body">
                    <h2>Terms Conditions</h2>
                </div>
            </div>
        </div>
    </section>
@endsection
