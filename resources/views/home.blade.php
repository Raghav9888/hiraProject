@extends('layouts.app')

@section('content')
    <section class="home-main-section">
        <div class="container">
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img class="hira-collective" src="{{url('/assets/images/hira-collective.svg')}}" alt="hira-collective">
                <h5 class="roots-title text-center mb-4">Honouring Roots, Nurturing Growth.</h5>
            </div>
            <div class="home-search-wrrpr">
                <p> Search for what you seek</p>
                <div class="search-dv-body">
                    <div class="search-container align-items-center">
                        <input type="text" class="search-input" id="search"
                               placeholder="search by modality, ailment, symptom or practitioner">
                        <div class="search-button">
                            <i class="fas fa-search"></i>
                        </div>
                    </div>
                    <div class="dropdown">
                        <select class="form-select" id="category" aria-label="Default select example"
                                style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">
                            <option selected>Virtual Practitioners Only</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="search-container location-input align-items-center">
                        <input type="text" class="search-input" placeholder="Select your preferred Location"
                               id="location">
                        <button class="search-button">
                            <i class="fa-solid fa-location-dot"></i>
                        </button>
                    </div>
                    <button class="home-search-btn" id="searchFilter">Search</button>
                </div>
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


            <div class="row">
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv rekki">
                        <p>Reiki</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv yoga">
                        <p>Yoga</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv nutrition">
                        <p>Nutritional </br>Support</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv energy">
                        <p>Energy </br>Healing</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv yoga">
                        <p>Yoga</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv energy">
                        <p>Energy </br>Healing</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv rekki">
                        <p>Reiki</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-3 mb-4">
                    <div class="explore-img-dv nutrition">
                        <p>Nutritional</br>
                            Support</p>
                    </div>
                </div>
                {{--                <div class="d-flex justify-content-center mt-2">--}}
                {{--                    <button class="category-load-more">Load More</button>--}}
                {{--                </div>--}}
            </div>
        </div>
    </section>
    <!-- explore categories section end -->

    <!-- featured section start -->
    <section class="featured-section">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <h1 class="home-title">Featured Practitioners </h1>
                <div class="d-flex align-items-center" style="gap: 20px;">
                    <p class="selected-category">Select by Categories</p>
                    <div class="dropdown">
                        <button onclick="toggleDropdown()" class="dropdown-button">
                            <span>ALL CATEGORIES</span>
                            <i class="fas fa-chevron-down"></i>
                        </button>
                        <div id="dropdownMenu" class="dropdown-menu">
                            <ul>
                                <li><a href="#">Category 1</a></li>
                                <li><a href="#">Category 2</a></li>
                                <li><a href="#">Category 3</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="practitionersList">
                @foreach($users as $user)

                    @php
                        $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
                        $image = $images['profile_image'] ?? null;
                        $imageUrl = $image  ? asset(env('media_path') . '/practitioners/' . $user->userDetail->id . '/profile/' . $image) : asset('assets/images/no_image.png');
                    @endphp

                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <a href="{{route('practitioner_detail', $user->id)}}">
                                <img src="{{ $imageUrl }}" alt="person">
                                {{--                                <label for="">0.4 Km Away</label>--}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4>{{  $user->name }}</h4>
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <h5>
                                    @if($locations)
                                        @php
                                            $locations = json_decode($user->location, true);
                                        @endphp

                                        @foreach($locations as $location)
                                            <i class="fa-solid fa-location-dot"></i>  {{ $location .',' }}
                                        @endforeach
                                    @endif
                                </h5>
                                <p>Alternative and Holistic Health Practitioner</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                    </div>
                                    <h6>5.0 Ratings</h6>
                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{--        <div class="d-flex justify-content-center mt-2">--}}
        {{--            <button class="category-load-more">Load More</button>--}}
        {{--        </div>--}}
    </section>
    <!-- featured section end -->
    <!-- choose us section start -->
    <section>
        <div class="container">
            <div class="why-us-wrrpr">
                <h1 class="home-title mb-4">why choose us?</h1>
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/trusted-practitioners.svg')}}" alt="">
                            </div>
                            <h6>Trusted Practitioners</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/personalized-wellness.svg')}}" alt="">
                            </div>
                            <h6>Personalized Wellness</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-4 mb-5">
                        <div class="choose-us-dv">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/spiritual-growth.svg')}}" alt="">
                            </div>
                            <h6>Spiritual Growth</h6>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor. </p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/our-vision.png')}}" alt="our-vision">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv">
                            <h2>Our Vision</h2>
                            <p>Our vision is to create a world where holistic well-being is accessible to everyone. We
                                aim to empower individuals by connecting them with experienced practitioners who bring
                                balance and transformation into their lives. Through The Hira Collective, we envision a
                                thriving community where wellness is not just a practice but a way of life.</p>
                            <button>Read More</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-and-about-dv about-dv">
                            <h2>About US</h2>
                            <p style="text-align: end;">The Hira Collective is a platform designed to connect customers
                                with trusted wellness practitioners. Whether you seek guidance in Yoga, Reiki, Energy
                                Healing, or other holistic practices, we provide a space where experts can share their
                                knowledge, and customers can easily find the right practitioner for their needs. Rooted
                                in authenticity and community, we strive to make wellness accessible, simple, and
                                personalized for everyone.</p>
                            <button>Read More</button>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="vision-about-img-dv">
                            <img src="{{url('/assets/images/choose-about.png')}}" alt="about-us">
                        </div>
                    </div>
                </div>
                <div class="position-relative">
                    <h1 class="home-title mb-4 mt-5">What our community says</h1>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
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
                            <h2>Find Your Path to</br>
                                Wellness</h2>
                            <p>Explore expert-led Yoga, Reiki, and Energy Healing and more sessions. Connect with
                                certified practitioners and start your journey today</p>
                            <button>Find a Practitioner</button>
                            <img src="{{url('assets/images/footer-butterfly.svg')}}" alt="">
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6">
                        <div class="find-apply-dv">
                            <h2>Grow Your Practice</br>
                                with Us!</h2>
                            <p>List your services and connect with customers seeking wellness and healing. Expand your
                                reach and build your client base effortlessly.</p>
                            <button>Apply as a Practitioner</button>
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
                <button class="home-blog-btn">View All</button>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="home-blog-dv">
                        <img src="{{url('/assets/images/blog-yoga.png')}}" alt="yoga">
                        <div class="home-blog-label">
                            <h5>Yoga</h5>
                        </div>
                        <h4>Lorem ipsum dolor it amet elit, sed do temporut labore et dolore magna aliqua. </h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. </p>
                        <button>Learn More<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="home-blog-dv">
                        <img src="{{url('/assets/images/blog-rekki.png')}}" alt="rekki">
                        <div class="home-blog-label">
                            <h5>Reiki</h5>
                        </div>
                        <h4>Lorem ipsum dolor it amet elit, sed do temporut labore et dolore magna aliqua. </h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. </p>
                        <button>Learn More<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4 mb-4">
                    <div class="home-blog-dv">
                        <img src="{{url('/assets/images/blog-energy.png')}}" alt="energy-hearing">
                        <div class="home-blog-label">
                            <h5>Energy Healing</h5>
                        </div>
                        <h4>Lorem ipsum dolor it amet elit, sed do temporut labore et dolore magna aliqua. </h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et dolore magna aliqua. </p>
                        <button>Learn More<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                </div>
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
            $('#searchFilter').on('click', function (e) {
                e.preventDefault();

                // Get the values from the search inputs
                let search = $('#search').val();
                let category = $('#category').val();
                let location = $('#location').val();

                // Perform the AJAX request
                $.ajax({
                    url: '/search/practitioner',  // Make sure the URL is correct
                    type: 'get',
                    data: {
                        search: search,
                        category: category,
                        location: location
                    },
                    success: function (response) {
                        // Check if there are practitioners
                        if (response.practitioners.length > 0) {
                            let practitionersHTML = '';

                            // Loop through the practitioners and build the HTML dynamically
                            response.practitioners.forEach(function (user) {
                                let images = user.user_detail ? JSON.parse(user.user_detail.images) : null;
                                let image = images ? images.profile_image : null;
                                let imageUrl = image ? '/storage/practitioners/' + user.user_detail.id + '/profile/' + image : '/assets/images/no_image.png';

                                practitionersHTML += `
                            <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                                <div class="featured-dv">
                                    <a href="/practitioner/${user.id}">
                                        <img src="${imageUrl}" alt="person">
<!--                                        <label for="">0.4 Km Away</label>-->
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h4>${user.name}</h4>
                                            <i class="fa-regular fa-heart"></i>
                                        </div>
                                        <h5><i class="fa-solid fa-location-dot"></i>Los Angeles, US</h5>
                                        <p>Alternative and Holistic Health Practitioner</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                            </div>
                                            <h6>5.0 Ratings</h6>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        `;
                            });

                            // Replace the old content with the new one
                            $('#practitionersList').html(practitionersHTML);
                        } else {
                            // No results found
                            $('#practitionersList').html('<p>No practitioners found.</p>');
                        }
                    }
                });
            });
        });

    </script>
@endsection
