@extends('layouts.app')
@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column position-relative py-5">
                <img class="hira-collective" src="{{url('/assets/images/home_logo.png')}}" alt="hira-collective">
            </div>
            <div class="home-search-wrrpr">
                <p> Search for what you seek</p>
                <form
                    action="{{ route('searchPractitioner', ['categoryType' => request()->route('categoryType') ?? 'all']) }}"
                    method="GET" id="searchform">
                    <div class="search-dv-body">
                        <div class="search-container align-items-center">
                            <input type="text" class="search-input" id="search" name="search"
                                   placeholder="Search by modality, ailment, symptom or practitioner">
                            <button type="submit" class="search-button">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="dropdown">
                            <select class="form-select" id="practitionerType" name="practitionerType"
                                    style="border-radius: 30px !important;padding:11px 37px 12px 20px;text-align: start;color: #838383;">
                                <option value="">Select type</option>
                                <option value="in-person">In person Offering</option>
                                <option value="virtual">Virtual Practitioners Only</option>
                                <option value="both">Both in personal and virtual</option>
                            </select>
                        </div>
                        <div class="search-container location-input align-items-center">
                            <select class="form-select" id="location" name="location"
                                    style="border-radius: 30px !important;padding:11px 37px 12px 20px;text-align: start;color: #838383;">
                                <option value="">Select location</option>
                                @foreach($defaultLocations as $defaultLocationId => $defaultLocation)
                                    <option value="{{ $defaultLocationId }}">{{ $defaultLocation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="home-search-btn" id="searchFilter">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row my-4">
                <div class="col-md-8">
                    <h1 class="home-title">Practitioners</h1>
                </div>
            </div>
            @if($practitioners->isNotEmpty())
                @foreach($practitioners->chunk(4) as $chunk)
                    <div class="row">
                        @foreach($chunk as $user)

                            @php
                                $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
                                $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
                                $imageUrl = $image
                                    ? asset(env('media_path') . '/practitioners/' . $user->userDetail->id . '/profile/' . $image)
                                    : asset(env('local_path') . '/images/no_image.png');

                              $userLocations = isset($user->location) && $user->location ? json_decode($user->location, true) : [];

                            @endphp

                            <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                                <div class="featured-dv">
                                    <a href="{{ route('practitioner_detail', $user->id) }}">
                                        <img src="{{ $imageUrl }}" class="img-fit" alt="person">

                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4>{{ $user->name }}</h4>
                                            <i class="fa-regular fa-heart"></i>
                                        </div>

                                        <h5>

                                            @if(!empty($userLocations))
                                                @foreach($defaultLocations as $defaultLocationId => $defaultLocation)
                                                    @if(in_array($defaultLocationId, $userLocations))
                                                        <i class="fa-solid fa-location-dot"></i>
                                                        {{ $defaultLocation }} ,
                                                    @endif

                                                @endforeach
                                            @endif
                                        </h5>
                                        <p>{{$user->userDetail->company ?? 'Alternative and Holistic Health Practitioner'}}</p>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                @for ($i = 0; $i < 5; $i++)
                                                    <i class="fa-regular fa-gem"></i>
                                                @endfor
                                            </div>
                                            <h6>5.0 Ratings</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach

                <!-- Load More Button (Only if there are practitioners) -->
                <div class="d-flex justify-content-center mt-2">
                    <button class="category-load-more loadPractitioner" data-count="1">Load More</button>
                </div>
            @else
                <p class="text-center">No practitioners found.</p>
            @endif
        </div>
    </section>

    <div class="container">
        <div class="upcoming-event-container position-relative">
            <h4>Upcoming Events</h4>
            <div class="upcoming-event-inner upcoming-events-slider">
                <div class="swiper-wrapper row">
                    @if(count($offerings) > 0)
                            @foreach($offerings as $date => $offering)

                                @php
                                    $mediaPath = config('app.media_path', 'uploads');
                                    $localPath = config('app.local_path', 'assets');

                                    $imageUrl = $offering->featured_image
                                        ? asset("$mediaPath/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                        : asset("$localPath/images/no_image.png");

                                @endphp
                                <div class="col-md-4">

                                    <div class="card swiper-slide"
                                         style="max-height: 250px;min-height: 250px; cursor:pointer;"
                                         onclick="window.location.href='{{route('practitioner_detail', $offering->user->id)}}'">

                                        <div class="card-body">

                                            <div class="row">
                                                <div class="col-md-5">
                                                    <img src="{{$imageUrl}}" alt="calm"
                                                         style="max-height: 150px; max-width: 200px">
                                                </div>
                                                <div class="col-md-7">
                                                    <h5>{{$offering?->name}}</h5>
                                                    <h6>{{ implode(' ', array_slice(explode(' ', strip_tags($offering->short_description)), 0, 20)) . '...' }}</h6>
                                                    <div class="d-flex justify-content-end align-items-center">
                                                        <img src="{{url('./assets/images/Clock.svg')}}" alt=""
                                                             class="me-2"
                                                             style="width: 20px">
                                                        <span>{{$date}}</span>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12">
                                <h5>No result</h5>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <div class="swiper-button-prev-event"><i class="fa-solid fa-arrow-left-long"></i></div>
            <div class="swiper-button-next-event"><i class="fa-solid fa-arrow-right-long"></i></div>

        </div>
    </div>

    <script>
        var swiper = new Swiper(".mySwiper", {
            spaceBetween: 30,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 40,
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 50,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

    </script>
    <script>
        var swiper = new Swiper(".upcoming-events-slider", {
            spaceBetween: 30,
            slidesPerGroup: 1, // Moves 2 slides at a time
            loop: true, // Enables infinite looping
            autoplay: {
                delay: 3000, // Auto slide every 3 seconds
                disableOnInteraction: false, // Keep autoplay running after interaction
            },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 2.5,
                    spaceBetween: 30,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next-event",
                prevEl: ".swiper-button-prev-event",
            },
        });
        var swiper = new Swiper(".related-article-slider", {
            spaceBetween: 30,
            slidesPerGroup: 1, // Moves 2 slides at a time
            loop: true, // Enables infinite looping
            // autoplay: {
            //     delay: 3000, // Auto slide every 3 seconds
            //     disableOnInteraction: false, // Keep autoplay running after interaction
            // },
            breakpoints: {
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 30,
                },
                1024: {
                    slidesPerView: 2.5,
                    spaceBetween: 30,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });
    </script>
@endsection
