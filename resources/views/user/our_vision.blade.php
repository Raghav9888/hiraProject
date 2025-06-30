@extends('layouts.app')
@section('content')
    <style>
        .hero { background: #eef6f2; text-align: center; padding: 3rem 1rem; }

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

    <section class="py-5">

        <div class="container my-5">
            <div class="hero">
                <h1>Our Vision</h1>
                <p>
                    To radically reimagine what wellness can be - rooted in integrity, guided by care, and accessible to all.</p>
            </div>
            <div class="bg-light border-start border-success border-5 p-3 my-4">
                <em>Our vision is a world where:</em>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <ul class="list-dot">
                        <li class="mb-3"><strong>Practitioners</strong> are deeply aligned and ethically held</li>
                        <li><strong>Healing</strong> is culturally respectful, accessible, and sustainable</li>
                    </ul>
                </div>
                <div class="col-md-6">
                    <ul class="list-dot">
                        <li><strong>People</strong> can find the right support without overwhelm or guesswork</li>
                    </ul>
                </div>
            </div>

            <p class="mt-4">
                We are here to disrupt extractive wellness models and replace them with something real — something sacred.
            </p>
            <p class="mb-4">
                A collective where care is curated, support is ongoing, and your journey is honored every step of the way.
            </p>

            <div class="bg-success bg-opacity-10 p-4 rounded">
                <p class="fw-bold text-center mb-0">
                    This is more than a platform. It’s a movement toward collective healing — and you’re part of it.
                </p>
            </div>
        </div>
    </section>
@endsection
