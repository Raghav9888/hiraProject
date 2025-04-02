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
                    <h2>Our Vision</h2>
                    <div class="p-4">
                        <p class="fw-bold text-center">To radically reimagine what wellness can be - rooted in integrity, guided by care, and accessible to all.</p>

                        <p>The Hira Collective exists to transform how we seek and receive healing. We believe wellness is not a luxury, trend, or transaction - it’s a birthright. That’s why we’ve built a platform centered around trust, transparency, and community care.</p>

                        <h5 style="text-decoration: underline; text-align:center" >Our vision is a world where:</h5>

                        <ul>
                            <li>Practitioners are deeply aligned and ethically held</li>
                            <li>People can find the right support without overwhelm or guesswork</li>
                            <li>Healing is culturally respectful, accessible, and sustainable</li>
                        </ul>

                        <p>We are here to disrupt extractive wellness models and replace them with something real — something sacred.</p>

                        <p>A collective where care is curated, support is ongoing, and your journey is honored every step of the way.</p>

                        <p class="fw-bold text-center">This is more than a platform. It’s a movement toward collective healing — and you’re part of it.</p>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
