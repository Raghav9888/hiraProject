@extends('layouts.app')
@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column position-relative py-3 py-md-5">
                <img class="hira-collective img-fluid" src="{{url('/assets/images/home_logo.png')}}" alt="hira-collective" style="max-width: 100%; height: auto;">
            </div>
            <div class="home-search-wrrpr">
                <p class="text-center mb-3 mb-md-4">Search for what you seek</p>
                <form method="GET" id="searchform">
                    <div class="row g-2 align-items-center">
                        <div class="col-12 col-md-6 col-lg-5">
                            <div class="search-container d-flex align-items-center">
                                <input type="text" class="search-input form-control" id="search" name="search"
                                       placeholder="Search by modality, ailment, symptom or practitioner">
                                <button type="submit" class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <select class="form-select w-100" id="practitionerType" name="practitionerType"
                                    style="border-radius: 30px; padding: 11px 37px 12px 20px; text-align: start; color: #838383;">
                                <option value="">Select type</option>
                                <option value="in-person">In person Offering</option>
                                <option value="virtual">Virtual Practitioners Only</option>
                                <option value="both">Both in personal and virtual</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-3">
                            <select class="form-select w-100" id="location" name="location"
                                    style="border-radius: 30px; padding: 11px 20px; color: #838383;">
                                <option value="">Select location</option>
                                @foreach($defaultLocations as $defaultLocationId => $defaultLocation)
                                    <option value="{{ $defaultLocation }}">{{ $defaultLocation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12 col-md-6 col-lg-1">
                            <button type="submit" class="btn btn-success home-search-btn w-100" id="searchFilter">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Offerings Slider -->
    <div class="container mt-3 mt-md-5">
        <div class="upcoming-event-container position-relative">
            <h4 class="mb-3 mb-md-4">Offerings</h4>
            <div class="upcoming-event-inner upcoming-events-slider-offerings">
                <div class="swiper-wrapper">
                    @if(count($offerings) > 0)
                        @foreach($offerings as $offering)
                            @php
                                $mediaPath = config('app.media_path', 'uploads');
                                $localPath = config('app.local_path', 'assets');
                                $imageUrl = $offering->featured_image
                                    ? asset("$mediaPath/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                    : asset("$localPath/images/no_image.png");
                            @endphp
                            <div class="swiper-slide">
                                <div class="card h-100 px-2"
                                     style="cursor:pointer; max-height: 250px;min-height: 250px; "
                                     onclick="window.location.href='{{ route('practitioner_detail', $offering->user->slug) }}?#offerings'">
                                    <div class="card-body">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-5 col-md-12 col-lg-5">
                                                <img src="{{$imageUrl}}" alt="calm" class="img-fluid"
                                                     style="max-height: 120px; width: 100%; object-fit: cover;">
                                            </div>
                                            <div class="col-7 col-md-12 col-lg-7">
                                                <h5 class="mb-1">{{$offering?->name}}</h5>
                                                @if($offering?->short_description)
                                                    <p class="small mb-2"> {{ implode(' ', array_slice(explode(' ', strip_tags($offering->short_description)), 0, 10)) . '...' }}</p>
                                                @endif
                                                <div class="mb-2">
                                                    <span>$</span> <span>{{$offering->client_price ?? 0}}</span>
                                                </div>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <img src="{{url('./assets/images/Clock.svg')}}" alt=""
                                                         class="me-2"
                                                         style="width: 16px">
                                                    <span class="small">{{ \Carbon\Carbon::parse($offering->from_date)->format('M j, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12 text-center py-4">
                            <h5>No result</h5>
                        </div>
                    @endif

                </div>
                <div class="swiper-pagination-offerings d-none"></div>
            </div>
            <div class="swiper-button-prev-offerings swiper-button-prev-event"><i class="fa-solid fa-arrow-left-long"></i></div>
            <div class="swiper-button-next-offerings swiper-button-next-event"><i class="fa-solid fa-arrow-right-long"></i></div>
        </div>
    </div>

    <!-- Upcoming Events Slider -->
    <div class="container mt-3 mt-md-5">
        <div class="upcoming-event-container position-relative">
            <h4 class="mb-3 mb-md-4">Upcoming Events</h4>
            @if(count($offeringEvents) > 0)
                <div class="upcoming-event-inner upcoming-events-slider-events">
                    <div class="swiper-wrapper">
                        @foreach($offeringEvents as $date => $offering)
                            @php
                                $mediaPath = config('app.media_path', 'uploads');
                                $localPath = config('app.local_path', 'assets');
                                $imageUrl = $offering->featured_image
                                    ? asset("$mediaPath/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                    : asset("$localPath/images/no_image.png");
                            @endphp
                            <div class="swiper-slide">
                                <div class="card h-100"
                                     style="cursor:pointer;"
                                     onclick="window.location.href='{{ route('practitioner_detail', $offering->user->slug) }}?#events'">
                                    <div class="card-body">
                                        <div class="row g-2 align-items-center">
                                            <div class="col-5 col-md-12 col-lg-5">
                                                <img src="{{$imageUrl}}" alt="calm" class="img-fluid"
                                                     style="max-height: 120px; width: 100%; object-fit: cover;">
                                            </div>
                                            <div class="col-7 col-md-12 col-lg-7">
                                                <h5 class="mb-1">{{$offering?->name}}</h5>
                                                <p class="small mb-2">{{ implode(' ', array_slice(explode(' ', strip_tags($offering->short_description)), 0, 10)) . '...' }}</p>
                                                <div class="d-flex justify-content-end align-items-center">
                                                    <img src="{{url('./assets/images/Clock.svg')}}" alt=""
                                                         class="me-2"
                                                         style="width: 16px">
                                                    <span class="small">{{ \Carbon\Carbon::parse($date)->format('M j, Y') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination-events d-none mt-3"></div>
                    <div class="swiper-button-prev-events"><i class="fa-solid fa-arrow-left-long"></i></div>
                    <div class="swiper-button-next-events"><i class="fa-solid fa-arrow-right-long"></i></div>
                </div>
            @else
                <div class="col-12 text-center py-4">
                    <h5>No result</h5>
                </div>
            @endif
        </div>
    </div>
    <hr class="my-3 my-md-4">

    <section>
        <div class="container">
            <div class="row my-3 my-md-4 align-items-center">
                <div class="col-12 col-md-8 mb-3 mb-md-0">
                    <h1 class="home-title mb-0">Practitioners</h1>
                </div>
                <div class="col-12 col-md-4">
                    <select class="form-select w-100" id="category" aria-label="Default select example"
                            style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">
                        <option class="selected-category" value="">Select by Categories</option>
                        @foreach($categories as $category)
                            @php
                                $name = str_replace(' ', '_', strtolower($category->name));
                            @endphp
                            <option value="{{ $name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($practitioners->isNotEmpty())
                <div class="row g-3" id="practitionerRowDiv">
                    @include('user.practitioner_list_xml_request')
                </div>
            @else
                <div class="col-12 text-center py-4">
                    <p>No practitioners found.</p>
                </div>
            @endif
        </div>
    </section>
    <hr class="my-3 my-md-4">

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Offerings Slider
            const offeringSlides = document.querySelectorAll('.upcoming-events-slider-offerings .swiper-slide');
            const offeringLoop = offeringSlides.length >= 3;

            new Swiper(".upcoming-events-slider-offerings", {
                spaceBetween: 16,
                slidesPerGroup: 1,
                loop: offeringLoop,
                autoplay: offeringLoop ? {
                    delay: 3000,
                    disableOnInteraction: false,
                } : false,
                breakpoints: {
                    320: {
                        slidesPerView: 1.1,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 1.3,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 2.3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 2.5,
                        spaceBetween: 30,
                    }
                },
                navigation: {
                    nextEl: ".swiper-button-next-offerings",
                    prevEl: ".swiper-button-prev-offerings",
                },
                pagination: {
                    el: ".swiper-pagination-offerings",
                    clickable: true,
                },
            });

            // Upcoming Events Slider
            const eventSlides = document.querySelectorAll('.upcoming-events-slider-events .swiper-slide');
            const eventLoop = eventSlides.length >= 3;

            new Swiper(".upcoming-events-slider-events", {
                spaceBetween: 16,
                slidesPerGroup: 1,
                loop: eventLoop,
                autoplay: eventLoop ? {
                    delay: 3000,
                    disableOnInteraction: false,
                } : false,
                breakpoints: {
                    320: {
                        slidesPerView: 1.1,
                        spaceBetween: 16,
                    },
                    576: {
                        slidesPerView: 1.3,
                        spaceBetween: 16,
                    },
                    768: {
                        slidesPerView: 2,
                        spaceBetween: 20,
                    },
                    992: {
                        slidesPerView: 2.3,
                        spaceBetween: 24,
                    },
                    1200: {
                        slidesPerView: 2.5,
                        spaceBetween: 30,
                    }
                },
                navigation: {
                    nextEl: ".swiper-button-next-events",
                    prevEl: ".swiper-button-prev-events",
                },
                pagination: {
                    el: ".swiper-pagination-events",
                    clickable: true,
                },
            });
        });
    </script>
@endsection
