@extends('layouts.app')

@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column position-relative py-5">
                <img class="hira-collective" src="{{url('/assets/images/header_logo.png')}}" alt="hira-collective">
            </div>
            <div class="home-search-wrrpr">
                <p> Search for what you seek</p>
                <form
                @php
                    $routeParams = [];
                    if (request()->route('categoryType')) {
                        $routeParams['categoryType'] = request()->route('categoryType');
                    }
                @endphp

                <form action="{{ route('searchPractitioner', $routeParams) }}" method="GET" id="searchform">
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
                        <a href="{{ route('searchPractitioner', ['categoryType' => $snakeCaseText]) }}">

                            <div class="explore-img-dv {{ $name}}">
                                <p>{{$category->name}}</p>
                            </div>

                        </a>
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
                                $mediaPath = config('app.media_path', 'uploads');
                                $localPath = config('app.local_path', 'assets');

                                $imageUrl = $offering->featured_image
                                    ? asset("$mediaPath/practitioners/{$offering->user->id}/offering/{$offering->featured_image}")
                                    : asset("$localPath/images/no_image.png");

                            @endphp
                            <div class="card swiper-slide" style="max-height: 200px;min-height: 200px; cursor:pointer;"
                                 onclick="window.location.href='{{route('practitioner_detail', $offering->user->id)}}'">

                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-5">
                                            <img src="{{$imageUrl}}" alt="calm"
                                                 style="max-height: 150px; max-width: 200px">
                                        </div>
                                        <div class="col-md-7">
                                            <h5>{{$offering?->name}}</h5>
                                            <h6>{{ implode(' ', array_slice(explode(' ', strip_tags($offering->short_description)), 0, 10)) . '...' }}</h6>
                                            <div class="d-flex justify-content-end align-items-center">
                                                <img src="{{url('./assets/images/Clock.svg')}}" alt="" class="me-2"
                                                     style="width: 20px">
                                                <span>{{ \Carbon\Carbon::parse($date)->format('F j, Y') }}</span>

                                            </div>

                                        </div>
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

                                    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4">
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
                                                                @break
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
                            <h6>Support at Every Step</h6>
                            <p class="pt-3">We don’t disappear after you book. From helping you choose a practitioner to
                                following up
                                after your session, our real human support team is here for you.
                                Care is not just a session - it’s a relationship.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/personalized-wellness.svg')}}" alt="">
                            </div>
                            <h6>More Than a Platform - A Movement</h6>
                            <p>You’re not just booking a session. You’re joining a collective.
                                By using Hira, you’re supporting a women-led, purpose-built platform centering healing,
                                justice, and cultural respect.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/spiritual-growth.svg')}}" alt="">
                            </div>
                            <h6>Vetted, Trusted Practitioners</h6>
                            <p class="pt-3">
                                Only 17% of applicants are accepted. We’ve done the work so you don’t have to.
                                Every practitioner on The Hira Collective is carefully vetted for ethical care, cultural
                                integrity, and real experience.
                            </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/our_vision.jpg')}}" alt="our-vision" class="rounded-4"
                                 style="max-height: 340px">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv">
                            <h2>OUR VISION</h2>
                            <p>To radically reimagine what wellness can be - rooted in integrity, guided by care, and
                                accessible to all.
                                The Hira Collective exists to transform how we seek and receive healing. We believe
                                wellness is not a luxury, trend,
                                or transaction - it’s a birthright. That’s why we’ve built a platform centered around
                                trust, transparency, and community care.
                            </p>
                            <button onclick="window.location.href='{{ route('our_vision') }}'"
                                    class="btn btn-secondary mt-5">
                                Read More
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv about-dv">
                            <h2>OUR STORY</h2>
                            <p style="text-align: end;">The Hira Collective is a curated wellness platform designed to
                                help you find care you can trust—rooted in integrity,
                                community connection, and ethical practice. We know that searching for the right support
                                can feel overwhelming.
                                Too often, wellness spaces feel transactional, performative, or disconnected from your
                                lived experience.
                            </p>
                            <button class="btn btn-secondary mt-5"
                                    onclick="window.location.href='{{ route('our_story') }}'">Read More
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/about_us.jpg')}}" alt="about-us" class="rounded-4"
                                 style="max-height: 340px">
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
                        @foreach($communities as $community)
                            <div class="swiper-slide">
                                @if($community->image)
                                    @php
                                        $mediaPath = config('app.media_path', 'uploads');
                                        $localPath = config('app.local_path', 'assets');

                                        $imageUrl = $community->image
                                            ? asset("$mediaPath/admin/community/{$community->image}")
                                            : asset("$localPath/images/no_image.png");
                                    @endphp
                                    <img src="{{ $imageUrl }}" alt="community Image" width="100">
                                @else
                                    <img src="{{url('assets/images/quotes.svg')}}" alt="quotes">
                                    <img class="shadow-quotes" src="{{ url('/assets/images/shadow-quotes.svg') }}"
                                         alt="quotes">
                                @endif
                                {!! $community->description !!}

                                <h4>{{$community->title}}</h4>
{{--                                <p class="mb-0">Yoga Student</p>--}}
                            </div>
                        @endforeach
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
                                Search by need, modality, or intention and begin your personalized healing journey
                                today.
                            </p>
                            <button onclick="window.location.href='{{route('searchPractitioner')}}'" class="mt-4">Find a
                                Practitioner
                            </button>
                            <img src="{{url('assets/images/footer-butterfly.svg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="find-apply-dv">
                            <h2>Grow your Holistic Practice <br>
                                with Hira !</h2>
                            <p>
                                Expand your reach, connect with aligned clients, and grow your practice within a
                                supportive community.
                            </p>
                            <button data-bs-target="#registerModal" data-bs-toggle="modal" class="mt-4">Apply as a
                                Practitioner</button>

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
                {{--                <a href="{{route('blog')}}" class="home-blog-btn">View All</a>--}}
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Coming soon...</h3>
                </div>
                {{--                @forEach($blogs as $blog)--}}
                {{--                    @php--}}
                {{--                        $mediaPath = config('app.media_path', 'uploads');--}}
                {{--                        $localPath = config('app.local_path', 'assets');--}}

                {{--                        $imageUrl = $blog->image--}}
                {{--                            ? asset("$mediaPath/admin/blog/{$blog->image}")--}}
                {{--                            : asset("$localPath/images/no_image.png");--}}
                {{--                    @endphp--}}
                {{--                    <div class="col-sm-12 col-md-6 col-lg-4 mb-4">--}}
                {{--                        <div class="featured-dv">--}}
                {{--                            <img src="{{ $imageUrl }}" alt="person" class="img-fit">--}}
                {{--                            <img src="{{$imageUrl}}" alt="calm" height="160" width="160" class="rounded-4">--}}
                {{--                            <div class="home-blog-label">--}}
                {{--                                <h5>{{$blog->category->name}}</h5>--}}
                {{--                            </div>--}}
                {{--                            <h4>{{$blog->name}}</h4>--}}
                {{--                            <div class="text-end">--}}
                {{--                                <a href="{{route('blogDetail', $blog->slug)}}" class="place-order btn btn-green text-end ">Learn More <i class="fa-solid fa-arrow-right "></i></a>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                @endforeach--}}
            </div>
        </div>
    </section>
    <!-- blog artical section end -->

    <!-- FAQ start -->
    <section class="faq-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-5">
                <h1 class="home-title">Frequently Asked Questions</h1>
                {{--                <button class="home-blog-btn">More FAQs</button>--}}
            </div>
            <div class="accordion w-100 max-w-2xl" id="accordionExample">
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Why was Hira created?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            The Hira Collective is a curated platform where seekers can discover and book sessions or
                            events with trusted wellness practitioners - across a wide range of healing modalities.
                            We’re not just a directory. We’re a values-driven ecosystem rooted in ethical care, cultural
                            integrity, and community connection. Every practitioner on Hira has been carefully vetted,
                            and our platform is designed to make finding the right support feel easeful, grounded, and
                            trustworthy.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            What makes Hira different from other wellness platforms?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <ul>
                                <li>Curation Over Quantity: We accept fewer than 20% of practitioner applicants. Every
                                    person on the platform is vetted for ethics, experience, and alignment with our
                                    values.
                                </li>
                                <li>Ongoing Human Support: You’re not left to figure it out alone. Our community team is
                                    here to guide, support, and walk with you.
                                </li>
                                <li>Collective Accountability: If something doesn’t feel right, we’re here to listen and
                                    act — with care and responsibility.
                                </li>
                                <li>Ethical Infrastructure: Hira is built with intention, by a small team committed to
                                    justice, equity, and holistic wellness. Every part of our process reflects that.
                                </li>
                                <li>You’re Part of a Movement: Booking on Hira isn’t just about one session. It’s about
                                    being part of a reimagined wellness future — one rooted in integrity, access, and
                                    care.
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            What kind of practitioners are on The Hira Collective?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            The Hira Collective is home to a diverse range of holistic wellness and mystic arts
                            practitioners — including energy healers, life coaches, intuitive guides, birth and womb
                            workers, somatic practitioners, spiritual counselors, bodyworkers, yoga and meditation
                            teachers, sound healers, and more.
                            You’ll also find practitioners trained in talk-based support like wellness coaching,
                            trauma-informed care, and nervous system regulation. Many bring lived experience, ancestral
                            wisdom, and culturally rooted practices to their work.
                            We do not include licensed medical professionals such as doctors, naturopaths,
                            chiropractors, or dietitians.
                            Hira is not a replacement for medical or psychiatric care — it is a space for complementary
                            healing, self-discovery, and spiritual wellness.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Who is Hira for?
                        </button>
                    </h2>
                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Hira is for everyone</b>
                            Hira is for anyone seeking care - care that is intentional, rooted, and trustworthy.
                            Whether you’re navigating anxiety, grief, burnout, or just seeking deeper connection to self
                            and spirit, Hira is here for you.
                            It’s also for those who’ve felt overlooked, underserved, or unsafe in traditional wellness
                            spaces.
                            We serve all people and we’re committed to making wellness more accessible, honest, and
                            human.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            Do I need to create an account to book?
                        </button>
                    </h2>
                    <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Yes -</b> creating an account helps you manage your bookings, track your sessions,
                            receive reminders, and save your favorite practitioners.
                            It takes less than a minute, and it helps us support you more personally throughout your
                            journey.
                            And there’s more: when you create an account, you’re automatically enrolled in our upcoming
                            Diamond Rewards program.
                            You’ll earn points for every booking — which can be redeemed for future sessions, offerings,
                            or special community perks. ✨
                            Care deserves to be celebrated — and we’re honored to grow with you, one step at a time.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingSix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            How do I find the right practitioner for me?
                        </button>
                    </h2>
                    <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            You can start by searching by symptom, modality, or intention. From there, explore the
                            offerings that resonate with you. Each listing includes practitioner bios, session details,
                            and pricing to help guide your decision.
                            Still unsure? You can always email us or book a support call. We’ll help you find the right
                            fit — with care, not algorithms.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingSeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                            How do I stay in the loop about events, new practitioners, or updates?
                        </button>
                    </h2>
                    <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>You can stay connected by:</b>
                            <ul>
                                <li>
                                    Subscribing to our newsletter for updates, events, and soulful offerings - biweekly
                                    we share a care package!
                                </li>
                                <li>
                                    Following us on Instagram where we share daily inspiration and collective care
                                </li>
                                <li>
                                    Exploring our blog and YouTube channel for wisdom, practices, and practitioner
                                    spotlights
                                </li>
                            </ul>
                            You’re part of something beautiful now — and we’d love to keep you close.

                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEight" aria-expanded="false" aria-controls="collapseEight">
                            How are practitioners selected?
                        </button>
                    </h2>
                    <div id="collapseEight" class="accordion-collapse collapse" aria-labelledby="headingEight"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            Less than 17% of applicants have been accepted. Each practitioner goes through a detailed
                            vetting process to ensure they meet our standards of care, ethics, and lived integrity.
                            This includes, a pre-screening, an interview, another screening process, references checks
                            and practice check
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingEight">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNine" aria-expanded="false" aria-controls="collapseNine">
                            Can I trust the quality of care here?
                        </button>
                    </h2>
                    <div id="collapseNine" class="accordion-collapse collapse" aria-labelledby="headingNine"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Yes -</b> and not just because we’ve done the vetting, but because we stay with you
                            throughout the journey.<br><br>
                            Every practitioner on The Hira Collective has been carefully selected through a multi-step
                            process that looks beyond credentials. We assess alignment with ethical care, cultural
                            integrity, lived values, and the ability to hold space with depth and compassion. Fewer than
                            20% of applicants are accepted.
                            <br><br>
                            But the care doesn’t stop there. What makes Hira different is that we don’t disappear after
                            you book. If something feels unclear, if you have questions before or after your session, or
                            if something doesn’t feel right — you have a real team to reach out to.
                            Our community and tech support teams are here to walk with you. We’re not just a directory —
                            we’re a collective. And that means you’re never alone in the process.
                            You can always book a call with our Community Director, or contact us at <a
                                href="mailto:community@thehiracollective.com">community@thehiracollective.com.</a> We’re
                            here to support you with care and accountability, every step of the way.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTen" aria-expanded="false" aria-controls="collapseTen">
                            How do I book a session or event?
                        </button>
                    </h2>
                    <div id="collapseTen" class="accordion-collapse collapse" aria-labelledby="headingTen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Booking on The Hira Collective is simple</b> - and designed to help you find exactly what
                            you need with ease and intention.
                            <ol>
                                <li>
                                    <strong>Start your search:</strong>
                                    Use the search bar or filters to explore by:
                                    <ul>
                                        <li><strong>Symptom:</strong> (e.g. anxiety, grief, fatigue)</li>
                                        <li><strong>Modality:</strong> (e.g. acupuncture, reiki, breathwork)</li>
                                        <li><strong>Intention:</strong> (e.g. reconnecting with self, stress release,
                                            clarity)
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <strong>Explore your matches:</strong>
                                    You’ll see a list of sessions, events, or practitioners based on your search. Click
                                    to read more about each offering, including details, length, pricing, and
                                    practitioner background.
                                </li>

                                <li>
                                    <strong>Choose your offering:</strong>
                                    Once you’ve found the right session, event, or practitioner, select your preferred
                                    time and follow the prompts to book.
                                </li>

                                <li>
                                    <strong>Confirm your booking:</strong>
                                    You’ll receive a confirmation email with all the session details, including a
                                    calendar invite and video call link (if applicable). If your practitioner has added
                                    notes or intake forms, they’ll be included too.
                                </li>

                                <li>
                                    <strong>Need support?</strong>
                                    If you’re unsure who to book with or where to start, we’re here to help. You can
                                    email us or book a free support call with our Community Director to get personalized
                                    guidance.
                                </li>
                            </ol>

                            <p style="text-align: center;">
                                <b> You don’t need to have it all figured out —</b> just a willingness to begin. We’re
                                here to walk with you.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingEleven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEleven" aria-expanded="false" aria-controls="collapseEleven">
                            What if I don’t know who to book with?
                        </button>
                    </h2>
                    <div id="collapseEleven" class="accordion-collapse collapse" aria-labelledby="headingEleven"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>You’re not alone —</b> many people aren’t sure where to start, and that’s completely
                            okay.
                            <p>“Who do I book with? Which service or modality can actually help me?”</p>
                            <p>That’s exactly why we’re here.</p>
                            <p>Our Community Director is available to support you. Whether you’re navigating a specific
                                concern, exploring different healing paths, or simply feeling unsure — we’ll help you
                                find the right fit.</p>
                            <p>You can <a href="mailto:support@thehiracollective.com">email us</a> with your questions
                                or book a free support call for personalized guidance. We’ll walk you through your
                                options with care, and help you feel confident in your choice.</p>
                            <p><b>At Hira, you’re never left to figure it out on your own — we’re here, with you.</b>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwelve">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwelve" aria-expanded="false" aria-controls="collapseTwelve">
                            How do I reschedule or cancel a booking?
                        </button>
                    </h2>
                    <div id="collapseTwelve" class="accordion-collapse collapse" aria-labelledby="headingTwelve"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Life happens —</b> and we’ve created a policy that honors your time, our practitioners’
                            time, and the integrity of this collective space.
                            <p>You can reschedule your booking up to 24 hours in advance, up to two times. Just follow
                                the link in your confirmation email to manage your booking.</p>
                            <p>If you need to cancel, please know that a cancellation fee applies regardless of when
                                it’s canceled. This is to honor the energy, preparation, and time practitioners devote
                                to your session or event — and to help cover the operational costs we incur to maintain
                                the platform, pay our team fairly, and uphold the ethical standards that guide Hira.</p>
                            <p>Our platform isn’t automated or transactional — it’s relational. Behind every booking is
                                a real human, and we’re here to support you.</p>
                            <p>If you’re unsure how to proceed or need help managing your booking, feel free to <a
                                    href="mailto:support@thehiracollective.com">email us</a> or book a support call.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingThirteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThirteen" aria-expanded="false"
                                aria-controls="collapseThirteen">
                            Why is there a cancellation fee?
                        </button>
                    </h2>
                    <div id="collapseThirteen" class="accordion-collapse collapse" aria-labelledby="headingThirteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>This fee supports the time, energy, and preparation practitioners devote to your care</b>
                            and helps us sustain Hira’s operations, including fair pay and ethical infrastructure. We’re
                            not a volume-driven platform — we’re a care-centered collective.
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingFourteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFourteen" aria-expanded="false"
                                aria-controls="collapseFourteen">
                            Can I book for someone else?
                        </button>
                    </h2>
                    <div id="collapseFourteen" class="accordion-collapse collapse" aria-labelledby="headingFourteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <b>Yes — you can absolutely book a session or event for a loved one.</b>
                            <p>Just be sure to enter their full name and email address accurately during the booking
                                process so they receive the confirmation details, session link, and any important
                                practitioner notes directly.</p>
                            <p>If you’re gifting a session or helping someone access care, and you’d like additional
                                support, feel free to <a href="mailto:support@thehiracollective.com">email us</a> or
                                book a quick call. We’re happy to walk you through it.</p>
                            <p>At Hira, care is communal — and we love when it’s shared.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingFifteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFifteen" aria-expanded="false" aria-controls="collapseFifteen">
                            I’m having trouble logging in or booking. What should I do?
                        </button>
                    </h2>
                    <div id="collapseFifteen" class="accordion-collapse collapse" aria-labelledby="headingFifteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>If you’re experiencing any issues with logging in or booking, <b>contact our Technical
                                    Director</b> at <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>
                                or reach out via WhatsApp to Mohit.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingSixteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSixteen" aria-expanded="false" aria-controls="collapseSixteen">
                            Can I get a refund?
                        </button>
                    </h2>
                    <div id="collapseSixteen" class="accordion-collapse collapse" aria-labelledby="headingSixteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>We do not offer automatic refunds,</b> as each practitioner holds space and prepares
                                for your session or event well in advance. A cancellation fee applies to all bookings,
                                as outlined in our policy.</p>
                            <p>That said, we understand that certain circumstances may require additional care. If
                                something unexpected happened or you feel your experience needs review, please reach out
                                to us directly at <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>.
                            </p>
                            <p>We handle each situation with compassion and integrity — always centering respect for
                                both the seeker and the practitioner.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingSeventeen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseSeventeen" aria-expanded="false"
                                aria-controls="collapseSeventeen">
                            My payment didn’t go through. What should I do?
                        </button>
                    </h2>
                    <div id="collapseSeventeen" class="accordion-collapse collapse" aria-labelledby="headingSeventeen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>Reach out to our Technical Director, Mohit, right away!</b></p>
                            <p>WhatsApp him or email him at <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>,
                                and we’ll look into it for you immediately.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingEighteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseEighteen" aria-expanded="false"
                                aria-controls="collapseEighteen">
                            Do I need to prepare anything before my session or event?
                        </button>
                    </h2>
                    <div id="collapseEighteen" class="accordion-collapse collapse" aria-labelledby="headingEighteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>If your practitioner has shared any notes, instructions, or an intake form, you’ll find
                                them in your confirmation email.</p>
                            <p>If nothing is listed, there’s nothing you need to do in advance—simply come as you are.
                                Every offering is designed to meet you exactly where you are, without pressure or
                                performance.</p>
                            <p>If you’re ever unsure, you can always reach out to us or your practitioner for clarity.
                                <b>You’re supported, always.</b></p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingNineteen">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseNineteen" aria-expanded="false"
                                aria-controls="collapseNineteen">
                            Are sessions virtual or in-person?
                        </button>
                    </h2>
                    <div id="collapseNineteen" class="accordion-collapse collapse" aria-labelledby="headingNineteen"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>All practitioners offer virtual sessions, but many also offer in-person options.</b>
                            </p>
                            <p>Each listing will clearly state whether the session or event is virtual, in-person, or
                                hybrid. You’ll also receive the relevant details in your confirmation email after
                                booking.</p>
                            <p>If you’re ever unsure or need clarification before booking, feel free to reach out to us
                                at <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>—we’re
                                happy to help.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwenty">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwenty" aria-expanded="false" aria-controls="collapseTwenty">
                            Do you offer gift cards or group bookings?
                        </button>
                    </h2>
                    <div id="collapseTwenty" class="accordion-collapse collapse" aria-labelledby="headingTwenty"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>Not yet — but they’re on the way.</b></p>
                            <p>We’re working on adding both gift cards and group booking options so you can share
                                healing experiences with loved ones or communities.</p>
                            <p>Stay connected through our newsletter or Instagram for updates—you’ll be the first to
                                know when they launch.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentyOne">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyOne" aria-expanded="false"
                                aria-controls="collapseTwentyOne">
                            How do I become a practitioner on The Hira Collective?
                        </button>
                    </h2>
                    <div id="collapseTwentyOne" class="accordion-collapse collapse" aria-labelledby="headingTwentyOne"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>We’re honored you’re interested in joining the Collective.</b></p>
                            <p>You can start by filling out our practitioner application form. We carefully review each
                                application to ensure alignment with Hira’s values—including ethical care, cultural
                                integrity, community-rootedness, and a heart-centered approach to healing.</p>
                            <p>We prioritize quality, depth, and collective care. If selected, you’ll be invited to
                                complete an onboarding process, including setting up your offerings and participating in
                                community orientation.</p>
                            <p>If you have questions about applying, email us at <a
                                    href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentyTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyTwo" aria-expanded="false"
                                aria-controls="collapseTwentyTwo">
                            How do I pay for a session?
                        </button>
                    </h2>
                    <div id="collapseTwentyTwo" class="accordion-collapse collapse" aria-labelledby="headingTwentyTwo"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p>All payments are processed securely through our platform at the time of booking, using
                                <b>Stripe</b>—a trusted global payment processor.</p>
                            <p><b>You can pay using:</b></p>
                            <ul>
                                <li>Visa, Mastercard, American Express, and other major credit cards</li>
                                <li>Debit cards (with a Visa or Mastercard logo)</li>
                                <li>Apple Pay and Google Pay (on supported devices)</li>
                                <li>International cards (in most countries)</li>
                                <li>Other local payment options, depending on your region</li>
                            </ul>
                            <p>You’ll receive an email confirmation and receipt after your payment is complete.</p>
                            <p>If you run into any issues with your payment or aren’t sure if your preferred method is
                                accepted, contact our tech team at <a
                                    href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>—we’re
                                here to help.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentyThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyThree" aria-expanded="false"
                                aria-controls="collapseTwentyThree">
                            Is The Hira Collective available worldwide?
                        </button>
                    </h2>
                    <div id="collapseTwentyThree" class="accordion-collapse collapse"
                         aria-labelledby="headingTwentyThree"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>Yes - our platform is accessible from anywhere in the world.</b></p>
                            <p>All practitioners offer sessions virtually, allowing you to book sessions or attend
                                events no matter where you’re located. For in-person sessions, location details are
                                clearly listed on the booking page.</p>
                            <p>If you’re ever unsure whether a specific offering is available to you, feel free to reach
                                out to <a
                                    href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>—we’re
                                happy to guide you.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentyFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyFour" aria-expanded="false"
                                aria-controls="collapseTwentyFour">
                            How do I contact support?
                        </button>
                    </h2>
                    <div id="collapseTwentyFour" class="accordion-collapse collapse" aria-labelledby="headingTwentyFour"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>We believe in real people, not bots.</b></p>
                            <p><b>For booking support, platform guidance, or help choosing a practitioner, contact
                                    Rashida, our Community Director:</b></p>
                            <ul>
                                <li><i class="fa-regular fa-envelope"></i> <a
                                        href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>
                                </li>
                                <li><i class="fa-solid fa-phone"></i> <a href="#">Book a support call</a></li>
                            </ul>
                            <p>For tech issues (login, payments, bugs), contact Mohit, our Technical Director:</p>
                            <ul>
                                <li><i class="fa-regular fa-envelope"></i> <a
                                        href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>
                                </li>
                                <li><i class="fa-brands fa-whatsapp"></i> <a href="#">Message on WhatsApp</a></li>
                            </ul>
                            <p>We’re here to support you every step of the way.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentyFive">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentyFive" aria-expanded="false"
                                aria-controls="collapseTwentyFive">
                            How does The Hira Collective work?
                        </button>
                    </h2>
                    <div id="collapseTwentyFive" class="accordion-collapse collapse" aria-labelledby="headingTwentyFive"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>The Hira Collective is a heart-centered platform</b> designed to make finding
                                trustworthy, culturally rooted, and ethically aligned wellness practitioners easier and
                                more meaningful.</p>
                            <p><b>Here’s how it works:</b></p>
                            <ol>
                                <li>Search for offerings by symptom, modality, or intention.</li>
                                <li>Explore practitioner profiles or events that resonate with your needs.</li>
                                <li>Book directly through our platform — you’ll receive confirmation and support
                                    materials.
                                </li>
                                <li>Connect with your practitioner or attend your session/event with full presence.</li>
                                <li>Return whenever you’re ready — healing is a journey, not a one-time experience.</li>
                            </ol>
                            <p>What makes Hira different is the curation, community care, and support that surrounds
                                each offering. You’re not navigating this alone — we walk with you.</p>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentySix">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentySix" aria-expanded="false"
                                aria-controls="collapseTwentySix">
                            Why book on Hira and not directly through a practitioner?
                        </button>
                    </h2>
                    <div id="collapseTwentySix" class="accordion-collapse collapse" aria-labelledby="headingTwentySix"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>When you book through The Hira Collective,</b> you’re not just scheduling a session -
                                you’re entering into a curated, supported, and intentional ecosystem of care.</p>
                            <p><b>Here’s what booking through Hira offers that direct bookings often don’t:</b></p>
                            <ol>
                                <li><b>Trusted, Vetted Practitioners</b><br>
                                    Every practitioner on Hira undergoes a rigorous vetting process. We accept fewer
                                    than 20% of applicants, ensuring they align with our ethical and cultural values.
                                </li>
                                <li><b>Ongoing Support for You</b><br>
                                    You’re never alone in your journey. Our team helps you choose the right practitioner
                                    and supports you before and after your session.
                                </li>
                                <li><b>Secure, Centralized Booking & Payments</b><br>
                                    Your payments are processed safely through Stripe, and all booking details are
                                    stored in one place, with a support team ready to assist.
                                </li>
                                <li><b>Collective Accountability</b><br>
                                    If something feels off in your experience, Hira steps in to advocate for your
                                    well-being and ensure ethical care.
                                </li>
                                <li><b>You’re Supporting a Movement</b><br>
                                    Hira is a community-driven initiative, not a tech giant. Your booking sustains our
                                    platform, supports fair pay, and fuels a wellness ecosystem rooted in justice.
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
                <div class="accordion-item hidden">
                    <h2 class="accordion-header" id="headingTwentySeven">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwentySeven" aria-expanded="false"
                                aria-controls="collapseTwentySeven">
                            Why is it important to rebook through The Hira Collective?
                        </button>
                    </h2>
                    <div id="collapseTwentySeven" class="accordion-collapse collapse"
                         aria-labelledby="headingTwentySeven"
                         data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <p><b>Rebooking through Hira</b> isn’t just a technicality — it’s a powerful act of support
                                that keeps this ecosystem alive.</p>
                            <p><b>When you rebook through the platform, you help sustain:</b></p>
                            <ul>
                                <li>The curation and vetting of practitioners</li>
                                <li>The ongoing community support you receive</li>
                                <li>The ethical infrastructure we’ve built behind the scenes</li>
                                <li>The marketing and visibility that helps connect people to healing</li>
                            </ul>
                            <p>Unlike traditional marketplaces, we’re not driven by volume or profit - we’re driven by
                                care, quality, and collective responsibility.</p>
                            <p>Rebooking through Hira ensures that our team — made up primarily of women who are
                                purposefully marginalized by the system, many of whom are mothers — is paid fairly and
                                can continue to operate with integrity.</p>
                            <p><b>So when you find a practitioner or offering you love — come back through Hira. It
                                    truly makes all the difference.</b></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-center mt-4">
                <button id="loadMoreBtn" class="home-blog-btn text-end">Show More</button>
            </div>
        </div>
    </section>

    <!-- FAQ end -->


    <style>
        .hidden {
            display: none;
        }
    </style>
@endsection
@push('custom_scripts')
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let hiddenFAQs = document.querySelectorAll(".accordion-item.hidden");
            let loadMoreBtn = document.getElementById("loadMoreBtn");
            let itemsToShow = 10;
            let currentIndex = 0;

            function showMoreFAQs() {
                let nextIndex = currentIndex + itemsToShow;
                for (let i = currentIndex; i < nextIndex && i < hiddenFAQs.length; i++) {
                    hiddenFAQs[i].classList.remove("hidden");
                }
                currentIndex = nextIndex;

                if (currentIndex >= hiddenFAQs.length) {
                    loadMoreBtn.style.display = "none";
                }
            }

            loadMoreBtn.addEventListener("click", showMoreFAQs);
            showMoreFAQs(); // Show initial 10 FAQs
        });
    </script>

@endpush
