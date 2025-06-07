@extends('layouts.app')

@section('content')

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .top-banner {
            background: linear-gradient(to right, #e85d5d 50%, #f6c1d1 50%);
            color: #fff;
            padding: 1rem;
        }

        .left-banner-text {
            font-weight: 700;
            line-height: 1.2;
            font-size: 1.1rem;
        }

        .right-banner-date {
            color: #000;
            text-align: right;
            font-weight: bold;
            line-height: 1;
        }

        .right-banner-date span {
            font-size: 2rem;
            display: block;
        }

        .profile-card {
            background-color: #fff;
            border-radius: 1.2rem;
            margin: 1rem;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-img {
            width: 100%;
            border-radius: 1rem;
            max-width: 120px;
        }

        .offer-label {
            border: 1px solid #ccc;
            padding: 6px 80px;
            border-radius: 30px;
            font-size: 0.85rem;
            display: inline-block;
            margin-top: 1rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .book-btn {
            background-color: #223322;
            color: #fff;
            border-radius: 20px;
            font-weight: 600;
            padding: 4px 20px;
        }

        .book-btn:hover {
            background-color: #1a271a;
        }

        .offering-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding: 1rem 0;
        }

        .offering-item:first-of-type {
            border-top: none;
        }

        @media (max-width: 576px) {
            .right-banner-date span {
                font-size: 1.5rem;
            }

            .left-banner-text {
                font-size: 1rem;
            }
        }
    </style>

    <div class="container-fluid px-0">
        <!-- Top Banner -->
        <div class="top-banner d-flex justify-content-between align-items-center">
            <div class="left-banner-text">
                Women's<br>Healthy<br>Living Show
            </div>
            <div class="right-banner-date">
                June<br><span>7 & 8</span>
            </div>
        </div>

        <!-- Group Image -->
        <img src="{{ url('/assets/images/about_us.jpg') }}" class="img-fluid" alt="Group Image">
{{--        <div class="container my-2">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <div class="d-flex align-items-center mb-3" style="gap: 20px;">--}}
{{--                        <p class="m-0">Select Currency</p>--}}
{{--                        <div class="dropdown Currency-select">--}}
{{--                            <div class="dropdown">--}}
{{--                                <select class="form-select" aria-label="Default select example"--}}
{{--                                        id="currencySelect"--}}
{{--                                        style="border-radius: 30px !important;padding: 10px 36px 10px 10px;text-align: start;">--}}
{{--                                    <option value="cad">CAD</option>--}}
{{--                                    <option value="usd">USD</option>--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        @foreach($showsOffering as $practitioner)
            @php
                $user = $practitioner;
                $mediaPath = config('app.media_path', 'uploads');
                $localPath = config('app.local_path', 'assets');
                $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
                $image = $images['profile_image'] ?? null;
                $imageUrl = $image
                    ? asset($mediaPath . '/practitioners/' . $user->userDetail->id . '/profile/' . $image)
                    : asset($localPath . '/images/no_image.png');
            @endphp

            <div class="profile-card mx-auto mb-4">
                <div class="row align-items-center text-start">
                    <div class="col-4 col-sm-3 text-center">
                        <img src="{{ $imageUrl }}" alt="{{ $user->first_name }}" class="profile-img mb-2"/>
                    </div>
                    <div class="col-8 col-sm-9">
                        <h5 class="mb-0">
                            {{ $user->first_name }} <strong class="text-dark">{{ $user->last_name }}</strong>
                        </h5>
                        <p class="text-muted mb-1">{{ $user->userDetail->company ?? 'Tarot Reader & Hypnotherapist' }}</p>
                    </div>
                </div>

                <div class="offer-label mt-3">OFFERINGS</div>
                @foreach($practitioner->shows as $index => $show)
                    @php
                        $cadOfferingPrice = round(floatval(str_replace(',', '', $show->price)));
                    @endphp
                    <div class="offering-item">
                        <div class="fw-semibold">
                            {{ $show->name }} <span class="text-muted show-prize">CA$ {{ $cadOfferingPrice }}</span>
                        </div>
                        <button class="btn book-btn show_process"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                onclick="openShowPopup(event)"
                                data-show-id="{{ $show->id }}"
                                data-show-name="{{ $show->name }}"
                                data-show-price="{{ $cadOfferingPrice}}"
                                data-currency-symbol="CA$"
                                data-currency="cad"
                                data-timezone="{{$user->userDetail->timezone}}"
                                data-cad-price="{{$cadOfferingPrice}}"
                                data-practitioner-id="{{ $user->id }}"
                        >BOOK
                        </button>
                    </div>
                @endforeach
                <hr>
                <h2>Products</h2>
                @foreach($practitioner->shows_product as $product)
                    @php
                        $cadProductPrice = round(floatval(str_replace(',', '', $product->price)));
                    @endphp
                    <div class="offering-item">
                        <div class="fw-semibold">
                            {{ $product->name }} <span class="text-muted show-prize">CA$ {{ $cadProductPrice }}</span>
                        </div>
                        <button class="btn book-btn show_process"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                onclick="openShowPopup(event)"
                                data-show-id="{{ $product->id }}"
                                data-show-name="{{ $product->name }}"
                                data-show-price="{{ $cadProductPrice}}"
                                data-currency-symbol="CA$"
                                data-currency="cad"
                                data-timezone="{{$user->userDetail->timezone}}"
                                data-cad-price="{{$cadProductPrice}}"
                                data-practitioner-id="{{ $user->id }}"
                        >BOOK
                        </button>
                    </div>
                @endforeach
            </div>
        @endforeach


    </div>
    <div class="modal fade xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="billing-container"></div>
                    <div class="checkout-container"></div>
                </div>
            </div>
        </div>
    </div>

@endsection
