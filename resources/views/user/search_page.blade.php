@extends('layouts.app')
@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column position-relative py-5">
                <img class="hira-collective" src="{{url('/assets/images/home_logo.png')}}" alt="hira-collective">
            </div>
            <div class="home-search-wrrpr">
                <p> Search for what you seek</p>
                <form id="searchForm" method="GET">
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
                                    <option value="{{ $defaultLocation }}">{{ $defaultLocation }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="home-search-btn" id="searchFilter">Search</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="container">
        <div class="upcoming-event-container position-relative">
            <h4>Offerings</h4>
            <div class="upcoming-event-inner upcoming-events-slider">
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
                            <div class="card swiper-slide"
                                 style="max-height: 250px;min-height: 250px; cursor:pointer;"
                                 onclick="window.location.href='{{ route('practitioner_detail', $offering->user->slug) }}?#offering'">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{$imageUrl}}" alt="calm"
                                                 style="max-height: 150px; max-width: 200px">
                                        </div>
                                        <div class="col-md-7">
                                            <h5>{{$offering?->name}}</h5>
                                            @if($offering?->short_description)
                                                <h6> {{ implode(' ', array_slice(explode(' ', strip_tags($offering->short_description)), 0, 20)) . '...' }}</h6>
                                            @endif
                                            <div>
                                                <span>$</span> <span>{{$offering->client_price ?? 0}}</span>
                                            </div>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <img src="{{url('./assets/images/Clock.svg')}}" alt=""
                                                     class="me-2"
                                                     style="width: 20px">
                                                <span>{{ \Carbon\Carbon::parse($offering->from_date)->format('F j, Y') }}</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                        @endforeach
                    @else
                        <div class="row">
                            <div class="col-md-12 text-center">
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
    <div class="container">
        <div class="upcoming-event-container position-relative">
            <h4>Upcoming Events</h4>
            @if(count($offeringEvents) > 0)
                <div class="upcoming-event-inner upcoming-events-slider">

                    <div class="swiper-wrapper">

                        @foreach($offeringEvents as $date => $offering)

                            @php
                                $mediaPath = config('app.media_path', 'uploads');
                                $localPath = config('app.local_path', 'assets');

                                $imageUrl = $offering->featured_image
                                    ? asset("$mediaPath/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                    : asset("$localPath/images/no_image.png");

                            @endphp

                            <div class="card swiper-slide"
                                 style="max-height: 250px;min-height: 250px; cursor:pointer;"
                                 onclick="window.location.href='{{ route('practitioner_detail', $offering->user->slug) }}?#events'">

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
                                                <span>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>
                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </div>

                        @endforeach
                    </div>
                    <div class="swiper-button-prev-event"><i class="fa-solid fa-arrow-left-long"></i></div>
                    <div class="swiper-button-next-event"><i class="fa-solid fa-arrow-right-long"></i></div>
                </div>
            @else
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h5>No result</h5>
                    </div>
                </div>
            @endif

        </div>
    </div>
    <hr>

    <section>
        <div class="container">
            <div class="row my-4">
                <div class="col-md-8">
                    <h1 class="home-title">Practitioners</h1>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="category" aria-label="Default select example"
                            style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">
                        <option class="selected-category" value="">Select by Categories</option>
                        @foreach($categories as $category)
                            @php
                                $name = $snakeCaseText = str_replace(' ', '_', strtolower($category->name));;
                            @endphp
                            <option value="{{ $name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @if($practitioners->isNotEmpty())
                <div class="row" id="practitionerRowDiv">
                    @include('user.practitioner_list_xml_request')
                </div>
            @else
                <p class="text-center">No practitioners found.</p>
            @endif
        </div>
    </section>
<hr>
    <div class="container py-5">
        <h1 class="home-title mb-3">Recent Resources</h1>

        <div class="row">
            <div class="col-md-12 text-center">
                <h3>Coming soon...</h3>
            </div>
            {{--                    @if(!$blogs->isEmpty())--}}
            {{--                        @foreach($blogs as $blog)--}}

            {{--                            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
            {{--                                <a href="{{route('blogDetail', $blog->slug)}}" style="text-decoration: none;"--}}
            {{--                                   class="resources-body">--}}
            {{--                                    <div class="row g-0">--}}
            {{--                                        <div class="col-md-4 px-2">--}}
            {{--                                            @php--}}
            {{--                                                $mediaPath = config('app.media_path', 'uploads');--}}
            {{--                                                $localPath = config('app.local_path', 'assets');--}}

            {{--                                                $imageUrl = $blog->image--}}
            {{--                                                    ? asset("$mediaPath/admin/blog/{$blog->image}")--}}
            {{--                                                    : asset("$localPath/images/no_image.png");--}}

            {{--                                            @endphp--}}



            {{--                                            <img src="{{$imageUrl}}" alt="calm" height="160" width="160" class="rounded-4">--}}
            {{--                                        </div>--}}
            {{--                                        <div class="col-md-8">--}}
            {{--                                            <div class="card-body">--}}
            {{--                                                <h5>{{$blog->name}}</h5>--}}
            {{--                                                <button>{{@$blog->category->name}}</button>--}}
            {{--                                                <p>{{date('M d, Y', strtotime($blog->date))}}</p>--}}
            {{--                                            </div>--}}
            {{--                                        </div>--}}
            {{--                                    </div>--}}

            {{--                                </a>--}}
            {{--                            </div>--}}
            {{--                        @endforeach--}}
            {{--                    @else--}}
            {{--                        <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
            {{--                            <p class="text-center">No Blogs found..</p>--}}
            {{--                        </div>--}}
            {{--                    @endif--}}
            {{--                     <div class="d-flex justify-content-center">--}}
            {{--                        <button class="home-blog-btn">Load More</button>--}}
            {{--                    </div> --}}
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
        var swiper = new Swiper(".upcoming-events-slider", {
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

    <script>

        ;
    </script>
@endsection
