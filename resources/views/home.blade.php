@extends('layouts.app')

@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column position-relative">
                <img class="hira-collective" src="{{url('/assets/images/hira-collective.svg')}}" alt="hira-collective">
                <h5 class="roots-title text-center mb-4 position-absolute" style="bottom: 10px">Honouring Roots, Nurturing Growth</h5>
            </div>
            <div class="home-search-wrrpr">
                <p> Search for what you seek</p>
                <form action="{{ route('searchPractitioner') }}" method="GET" id="searchform">
                    @csrf

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


                {{--                <div class="searched-category">--}}
                {{--                    <p style="font-weight: 400;">Most Searched Categories</p>--}}
                {{--                    @foreach($categories as $category)--}}
                {{--                        <button>{{ $category->name }}</button>--}}
                {{--                    @endforeach--}}
                {{--                </div>--}}

            </div>
        </div>
        <img class="arrows-down" src="{{url('/assets/images/arrows-down.svg')}}" alt="">
    </section>
    <!-- home banner section end -->
    <!-- explore categories section start -->
    <section>
        <div class="container">
            <h2 class="home-title pb-2">Explore </h2>

            <div class="row mt-3">
                @foreach($categories as $category)
                    @php
                        $name = $snakeCaseText = str_replace(' ', '_', strtolower($category->name));;
                    @endphp
                    <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                        <div class="explore-img-dv {{ $name}}">
                            <p>{{$category->name}}</p>
                        </div>
                    </div>
                @endforeach
                {{--                <div class="d-flex justify-content-center mt-2">--}}
                {{--                    <button class="category-load-more">Load More</button>--}}
                {{--                </div>--}}
            </div>
        </div>
    </section>
    <!-- explore categories section end -->
    <div class="container">
        <div class="upcoming-event-container position-relative">
            <h4>Upcoming Events</h4>
            <div class="upcoming-event-inner upcoming-events-slider">
                <div class="swiper-wrapper">
                    @if(count($offerings) > 0)
                        @foreach($offerings as $date => $offering)
                            @php
                                $imageUrl = $offering->featured_image
                                    ? asset(env('media_path') . "/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                    : asset(env('local_path') . '/images/no_image.png');
                            @endphp
                            <div class="swiper-slide"
                                 style="height: 100%;width: 100%; max-height: 250px;min-height: 250px">
                                <div class="slider-img">
                                    <img src="{{$imageUrl}}" alt="calm">
                                </div>
                                <div class="card-body">
                                    <h5>{{$offering?->name}}</h5>
                                    <h6>{{$offering?->short_description}}</h6>
                                    <div class="d-flex">
                                        <img src="{{url('./assets/images/Clock.svg')}}" alt="" class="me-2"
                                             style="width: 1px">
                                        <p class="ms-2">{{$date}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
            </div>
            <div class="swiper-button-prev-event"><i class="fa-solid fa-arrow-left-long"></i></div>
            <div class="swiper-button-next-event"><i class="fa-solid fa-arrow-right-long"></i></div>
        </div>
    </div>
    <!-- featured section start -->
    <section class="featured-section">
        <div class="container">
            <div class="row my-4">
                <div class="col-md-8">
                    <h1 class="home-title">Featured Practitioners </h1>
                </div>
                <div class="col-md-4">
                    <select class="form-select" id="category" aria-label="Default select example"
                            style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">
                        <option class="selected-category" value="">Select by Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="container">
                <div class="row" id="practitionersList">
                    @if($users->isNotEmpty())
                        @foreach($users->chunk(4) as $chunk)
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
            </div>

        </div>

    </section>
    <!-- featured section end -->
    <!-- choose us section start -->
    <section>
        <div class="container">
            <div class="why-us-wrrpr">
                <h1 class="home-title mb-4">Why Choose Hira?</h1>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/trusted-practitioners.svg')}}" alt="">
                            </div>
                            <h6>
                                Support at Every Step
                            </h6>
                            <p>We don’t disappear after you book. From helping you choose a practitioner to following up after your session, our real human support team is here for you.
                                Care is not just a session - it’s a relationship.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/personalized-wellness.svg')}}" alt="">
                            </div>
                            <h6 class="pt-2">
                                More Than a Platform - A Movement
                            </h6>
                            <p>You’re not just booking a session. You’re joining a collective.
                                By using Hira, you’re supporting a women-led, purpose-built platform centering healing, justice, and cultural respect.
                                Plus, you’ll soon earn Diamond Rewards for every booking - redeemable for future sessions and community perks.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/spiritual-growth.svg')}}" alt="">
                            </div>
                            <h6>Vetted, Trusted Practitioners
                            </h6>
                            <p>
                                Only 17% of applicants are accepted. We’ve done the work so you don’t have to.
                                Every practitioner on The Hira Collective is carefully vetted for ethical care, cultural integrity, and real experience.
                                No guesswork, no greenwashing - just trustworthy wellness you can feel safe in.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/our-vision.png')}}" alt="our-vision">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv">
                            <h2>OUR VISION</h2>
                            <p>To radically reimagine what wellness can be - rooted in integrity, guided by care, and accessible to all.
                                The Hira Collective exists to transform how we seek and receive healing. We believe wellness is not a luxury, trend,
                                or transaction - it’s a birthright. That’s why we’ve built a platform centered around trust, transparency, and community care.
                            </p>
                            <button>Read More</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv about-dv">
                            <h2>ABOUT US</h2>
                            <p style="text-align: end;">The Hira Collective is a curated wellness platform designed to help you find care you can trust—rooted in integrity,
                                community connection, and ethical practice. We know that searching for the right support can feel overwhelming.
                                Too often, wellness spaces feel transactional, performative, or disconnected from your lived experience.
                                That’s why Hira was created—to offer something different.
                            </p>
                            <button>Read More</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/choose-about.png')}}" alt="about-us">
                        </div>
                    </div>
                </div>
                <div class="position-relative row align-items-center">
                    <div class="col-md-6">
                        <h1 class="home-title mb-4 mt-5">What our community says</h1>
                    </div>
                    <div class="col-md-6">
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
                <div class="swiper mySwiper mb-5">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Robert Fox</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{ url('assets/images/quotes.svg') }}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Jenny Wilson</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Guy Hawkins</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Robert Fox</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Jenny Wilson</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                        <div class="swiper-slide">
                            <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                ut labore. Lorem ipsum dolor sit amet, consect adipicing elit, sed do eiusmod tempor
                                incididunt ut labore.</p>
                            <h4>Guy Hawkins</h4>
                            <p class="mb-0">Yoga Student</p>
                            <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}" alt="quotes">
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="find-apply-dv">
                            <h2>
                                Find a Trusted Wellness Practitioner
                            </h2>
                            <p>
                                Search by need, modality, or intention and begin your personalized healing journey today.
                            </p>
                            <button>Find a Practitioner</button>
                            <img src="{{url('assets/images/footer-butterfly.svg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="find-apply-dv">
                            <h2>Grow your Holistic Practice <br>
                                with Hira !</h2>
                            <p>
                                Expand your reach, connect with aligned clients, and grow your practice within a supportive community.
                            </p>
                            <button class="mt-4">Apply as a Practitioner</button>
                            <img src="{{url('assets/images/footer-butterfly.svg')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- choose us section end -->
    <!-- blog artical section start -->
    <section class="home-blog-wrrpr">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <h1 class="home-title">Holistic Wellness Resources</h1>
                <a href="{{route('blog')}}" class="home-blog-btn">View All</a>
            </div>
            <div class="row">
                @forEach($blogs as $blog)
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                        <div class="home-blog-dv">
                            <img src="{{ asset(env('media_path') . '/admin/blog/' . $blog->image) }}" alt="yoga">
                            <div class="home-blog-label">
                                <h5>{{@$blog->category->name}}</h5>
                            </div>
                            <h4>{{$blog->name}}</h4>
                            <a href="{{route('blogDetail', $blog->slug)}}">Learn More<i
                                    class="fa-solid fa-arrow-right"></i></a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- blog artical section end -->

    <!-- FAQ start -->
    <section class="faq-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-5">
                <h1 class="home-title">Frequently Asked Questions</h1>
                <button class="home-blog-btn">More FAQs</button>
            </div>
            <div class="accordion w-100 max-w-2xl" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How can I book a session?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet,
                            consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                            aliqua.
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            How do I become a practitioner on The Hira Collective?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Is there a fee to join as a practitioner?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            How do I pay for a session?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Can I reschedule or cancel a booked session?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            Is The Hira Collective available worldwide?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            How do I contact support?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            How does The Hira Collective work?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <!-- Content for this section -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ end -->

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
        function toggleDropdown() {
            var dropdownMenu = document.getElementById("dropdownMenu");
            if (dropdownMenu.style.display === "none" || dropdownMenu.style.display === "") {
                dropdownMenu.style.display = "block";
            } else {
                dropdownMenu.style.display = "none";
            }
        }
    </script>

    <script>
        $(document).ready(function () {
            function performSearch() {
                let search = $('#search').val();
                let location = $('#location').val();
                let practitionerType = $('#practitionerType').val();

                console.log("Performing search with:", {search, location, practitionerType}); // Debugging

                getPractitioners(search, null, location, practitionerType);
            }

            // Prevent form submission and trigger AJAX on Enter key inside the search input
            $('#search').on('keypress', function (e) {
                if (e.which === 13) { // 13 = Enter key
                    e.preventDefault();
                    performSearch();
                }
            });

            // Prevent form submission and trigger AJAX when clicking the Search button
            $('#searchFilter').on('click', function (e) {
                e.preventDefault();
                performSearch();
            });

            // Prevent form submission globally on #searchform
            $('#searchform').on('submit', function (e) {
                e.preventDefault();
                performSearch();
            });

            $(document).on('click', '.loadPractitioner', function (e) {
                e.preventDefault();
                let search = $('#search').val();
                let location = $('#location').val();
                let practitionerType = $('#practitionerType').val();
                let category = $('#category').val();
                let count = ($(this).data('count') ?? 1) + 1;

                getPractitioners(search, category, location, practitionerType, count);
            });

            $('#category').on('change', function (e) {
                e.preventDefault();
                let search = $('#search').val();
                let location = $('#location').val();
                let practitionerType = $('#practitionerType').val();
                let category = $('#category').val();
                getPractitioners(search, category, location, practitionerType);
            });
        });


        function getPractitioners(search = null, category = null, location = null, practitionerType = null, count = 1) {
            const imagePath = `{{env('media_path')}}`;
            const localPath = `{{env('local_path')}}`;
            let locationArr = @json($defaultLocations);
            $.ajax({
                url: '/search/practitioner',
                type: 'get',
                data: {search, category, location, practitionerType, count},
                beforeSend: function () {
                    window.loadingScreen.addPageLoading();
                },
                success: function (response) {

                    let practitionersHTML = '';
                    let maxItems = 8;

                    if (!response.practitioners || response.practitioners.length === 0) {
                        practitionersHTML = '<p class="text-center">No practitioners found.</p>';
                    } else {
                        // Chunking into rows of 4
                        for (let i = 0; i < response.practitioners.length; i += 4) {
                            practitionersHTML += `<div class="row">`;

                            for (let j = i; j < i + 4 && j < response.practitioners.length; j++) {
                                let practitioner = response.practitioners[j];

                                // Handling location names
                                let locationNames = '';
                                if (practitioner.location && practitioner.location.length > 0) {
                                    locationNames = JSON.parse(practitioner.location).map(function (locationId) {
                                        return locationArr[locationId] || 'location';
                                    }).slice(0, 2).join(', ');
                                } else {
                                    locationNames = 'no found';
                                }

                                let images = practitioner.user_detail?.images ? JSON.parse(practitioner.user_detail.images) : null;
                                let imageUrl = images?.profile_image
                                    ? `${imagePath}/practitioners/${practitioner.user_detail.id}/profile/${images.profile_image}`
                                    : `${localPath}/images/no_image.png`;

                                practitionersHTML += `
                            <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                                <div class="featured-dv">
                                    <a href="/practitioner/detail/${practitioner.id}">
                                        <img src="${imageUrl}" alt="person" class="img-fit">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4>${practitioner.name}</h4>
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                        <h5><i class="fa-solid fa-location-dot"></i> ${locationNames}</h5>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>${'<i class="fa-regular fa-gem"></i>'.repeat(5)}</div>
                                            <h6>5.0 Ratings</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        `;
                            }

                            practitionersHTML += `</div>`; // Close row
                        }

                    }

                    // Check if the number of practitioners exceeds the maxItems and add a Load More button
                    if (response.practitioners.length >= maxItems) {
                        practitionersHTML += `
                    <div class="d-flex justify-content-center mt-2">
                        <button class="category-load-more loadPractitioner" data-count="${count}">Load More</button>
                    </div>`;
                    }
                    $('html, body').animate({
                        scrollTop: $('.featured-section').offset().top
                    }, 700);
                    // Inject the generated HTML into the practitioners list container
                    $('#practitionersList').html(practitionersHTML);
                },
                complete: function () {
                    window.loadingScreen.removeLoading();
                }
            });
        }

    </script>
@endsection
@push('custom_scripts')
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

@endpush
