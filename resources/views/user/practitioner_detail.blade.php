@extends('layouts.app')

@section('content')
    <div class="practitioner-detail-wrrpr">
        <div class="container">
            <div class="practitioner-search-dv">
                <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
                    <a href="{{ route('home') }}" class="blog-view-more"><i
                            class="fa-solid fa-chevron-left me-2"></i>Back</a>
                    <div class="search-container location-input">
                        <input type="text" class="search-input" placeholder="Search Articles, Blogs and Videos">
                        <button class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                        <button class="blog-search-btn">Search</button>
                    </div>
                </div>
            </div>
            <div class="practitioner-detail-dv">
                <div class="row">
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <div class="d-flex justify-content-between flex-wrap">
                            <h4>{{$user->name}}</h4>
                            <div style="display: flex; gap: 10px;">
                                <i class="fa-regular fa-heart"></i>
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                        </div>
                        <h5>Alternative and Holistic Health Practitioner</h5>
                        <p class="mb-4">{{$userDetails->bio}}</p>
                        <div class="practitioner-location-dv">
                            <button><i class="fa-solid fa-location-dot me-2"></i>Los Angeles, US</button>
                            <ul class="m-0">
                                <li>Virtual Offerings Available</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <img style="width: 100%;" class="mb-4" src="{{ url('/assets/images/darrel.png') }}"
                             alt="darrel">
                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                            <div>
                                <i class="fa-regular fa-gem"></i>
                                <i class="fa-regular fa-gem"></i>
                                <i class="fa-regular fa-gem"></i>
                                <i class="fa-regular fa-gem"></i>
                                <i class="fa-regular fa-gem"></i>
                            </div>
                            <h6 style="color: #9F8B72; margin: 0;">5.0 Ratings</h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper mySwiper mb-5">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="{{url('assets/images/yoga-persons.png')}}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{ url('assets/images/girl-with-bowl.png') }}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{url('assets/images/yoga-persons.png')}}" alt="">
                    </div>
                    <div class="swiper-slide">
                        <img src="{{url('assets/images/girl-with-bowl.png')}}" alt="">
                    </div>
                </div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    Offerings
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="d-flex align-items-center mb-3" style="gap: 20px;">
                                        <p class="m-0">Select Currency</p>
                                        <div class="dropdown Currency-select">
                                            <button onclick="toggleDropdown()" class="dropdown-button">
                                                <span>USD</span>
                                                <i class="fas fa-chevron-down ms-3"></i>
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
                                    @foreach($offerings as $offering)
                                        <div class="accordian-body-data">
                                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                                <h4 class="mb-2">{{$offering->name}}</h4>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="offer-prize me-2 m-0">$1,444.00</h6>
                                                    {{--                                                <a href="{{ route('offerDetail',$offering->id)}}" class="home-blog-btn">BOOK NOW</a>--}}
                                                </div>
                                            </div>
                                            <ul class="practitioner-accordian-lists">
                                                <li>7 Hours</li>
                                                <li>7 Sessions</li>
                                            </ul>
                                            <p class="m-0 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit,
                                                sed
                                                do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim
                                                ad
                                                minim veniam quis nostrud exercitation.Lorem ipsum dolor sit amet,
                                                consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                et
                                                dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                exercitation.</p>
                                            <button id="view-more-btn" class="blog-view-more mb-2"
                                                    style="color:#9F8B72;">More Info<i
                                                    class="fas fa-chevron-down ms-2"></i></button>

                                            <div id="lorem-text" class="lorem-text">
                                                <div class="toggle-data-dv">
                                                    <div class="toggle-dv-desc">
                                                        <img src="{{url('assets/images/bowl-girl.png')}}" alt="">
                                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                                            do
                                                            eiusmod tempor incididunt ut labore et dolore magna aliqua.
                                                            Ut
                                                            enim ad minim veniam quis nostrud exercitation. Lorem ipsum
                                                            dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                            tempor incididunt. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing
                                                            elit, sed do eiusmod tempor incididunt ut labore et dolore
                                                            magna
                                                            aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation.</p>
                                                    </div>
                                                    <div class="toggle-dv-review">
                                                        <div class="d-flex mb-2" style="gap: 20px;">
                                                            <button>Description</button>
                                                            <button
                                                                style="background-color: transparent;color: #9F8B72;">
                                                                Reviews
                                                            </button>
                                                        </div>
                                                        <ul>
                                                            <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do eiusmod tempor incididunt ut
                                                                labore
                                                                et dolore magna aliqua. Ut enim ad minim veniam quis
                                                                nostrud
                                                                exercitation. Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do eiusmod tempor incididunt. dolor
                                                                sit
                                                                amet Ut enim ad minim veniam quis nostrud exercitation.
                                                            </li>
                                                            <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do eiusmod tempor incididunt ut
                                                                labore
                                                                et dolore magna aliqua. Ut enim ad minim veniam quis
                                                                nostrud
                                                                exercitation. Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do Ut enim ad minim eiusmod tempor
                                                                incididunt. Ut enim ad minim veniam quis nostrud
                                                                exercitation.
                                                            </li>
                                                            <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do eiusmod tempor incididunt ut
                                                                labore
                                                                et dolore magna aliqua. Ut enim ad minim veniam quis
                                                                nostrud
                                                                exercitation. Lorem ipsum dolor sit amet, consectetur
                                                                adipiscing elit, sed do eiusmod sed do eiusmod tempor
                                                                incididunt tempor incididunt. Ut enim ad minim veniam
                                                                quis
                                                                nostrud exercitation.
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <button id="view-less-btn" class="blog-view-more"
                                                    style="color:#9F8B72; display: none;">
                                                Less Info<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                        </div>
                                    @endforeach
                                    <div class="accordian-body-data">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                                            <h4 class="mb-2">Alchemical Rebirth Journey</h4>
                                            <div class="d-flex align-items-center">
                                                <h6 class="offer-prize me-2 m-0">$1,444.00</h6>
                                                <button class="home-blog-btn">BOOK NOW</button>
                                            </div>
                                        </div>
                                        <ul class="practitioner-accordian-lists">
                                            <li>7 Hours</li>
                                            <li>7 Sessions</li>
                                        </ul>
                                        <p class="m-0 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim veniam quis nostrud exercitation.Lorem ipsum dolor sit amet,
                                            consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                            dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation.</p>
                                        <button id="view-more-btn" class="blog-view-more mb-2"
                                                style="color:#9F8B72;">More Info<i
                                                class="fas fa-chevron-down ms-2"></i></button>

                                        <div id="lorem-text" class="lorem-text">
                                            <div class="toggle-data-dv">
                                                <div class="toggle-dv-desc">
                                                    <img src="{{url('assets/images/bowl-girl.png')}}" alt="">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                        enim ad minim veniam quis nostrud exercitation. Lorem ipsum
                                                        dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                        tempor incididunt. Ut enim ad minim veniam quis nostrud
                                                        exercitation. Lorem ipsum dolor sit amet, consectetur adipiscing
                                                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                                        aliqua. Ut enim ad minim veniam quis nostrud exercitation.</p>
                                                </div>
                                                <div class="toggle-dv-review">
                                                    <div class="d-flex mb-2" style="gap: 20px;">
                                                        <button>Description</button>
                                                        <button
                                                            style="background-color: transparent;color: #9F8B72;">Reviews</button>
                                                    </div>
                                                    <ul>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt. dolor sit
                                                            amet Ut enim ad minim veniam quis nostrud exercitation.</li>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do Ut enim ad minim eiusmod tempor
                                                            incididunt. Ut enim ad minim veniam quis nostrud
                                                            exercitation.</li>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod sed do eiusmod tempor
                                                            incididunt tempor incididunt. Ut enim ad minim veniam quis
                                                            nostrud exercitation.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <button id="view-less-btn" class="blog-view-more"
                                                style="color:#9F8B72; display: none;">View
                                            Less<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                    </div>
                                    <div class="accordian-body-data">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                                            <h4 class="mb-2">Alchemical Rebirth Journey</h4>
                                            <div class="d-flex align-items-center">
                                                <h6 class="offer-prize me-2 m-0">$1,444.00</h6>
                                                <button class="home-blog-btn">BOOK NOW</button>
                                            </div>
                                        </div>
                                        <ul class="practitioner-accordian-lists">
                                            <li>7 Hours</li>
                                            <li>7 Sessions</li>
                                        </ul>
                                        <p class="m-0 mb-1">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                                            do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad
                                            minim veniam quis nostrud exercitation.Lorem ipsum dolor sit amet,
                                            consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et
                                            dolore magna aliqua. Ut enim ad minim veniam quis nostrud exercitation.</p>
                                        <button id="view-more-btn" class="blog-view-more mb-2"
                                                style="color:#9F8B72;">More Info<i
                                                class="fas fa-chevron-down ms-2"></i></button>

                                        <div id="lorem-text" class="lorem-text">
                                            <div class="toggle-data-dv">
                                                <div class="toggle-dv-desc">
                                                    <img src="{{url('assets/images/bowl-girl.png')}}" alt="">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
                                                        enim ad minim veniam quis nostrud exercitation. Lorem ipsum
                                                        dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                                                        tempor incididunt. Ut enim ad minim veniam quis nostrud
                                                        exercitation. Lorem ipsum dolor sit amet, consectetur adipiscing
                                                        elit, sed do eiusmod tempor incididunt ut labore et dolore magna
                                                        aliqua. Ut enim ad minim veniam quis nostrud exercitation.</p>
                                                </div>
                                                <div class="toggle-dv-review">
                                                    <div class="d-flex mb-2" style="gap: 20px;">
                                                        <button>Description</button>
                                                        <button
                                                            style="background-color: transparent;color: #9F8B72;">Reviews</button>
                                                    </div>
                                                    <ul>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt. dolor sit
                                                            amet Ut enim ad minim veniam quis nostrud exercitation.</li>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do Ut enim ad minim eiusmod tempor
                                                            incididunt. Ut enim ad minim veniam quis nostrud
                                                            exercitation.</li>
                                                        <li class="m-0">Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod tempor incididunt ut labore
                                                            et dolore magna aliqua. Ut enim ad minim veniam quis nostrud
                                                            exercitation. Lorem ipsum dolor sit amet, consectetur
                                                            adipiscing elit, sed do eiusmod sed do eiusmod tempor
                                                            incididunt tempor incididunt. Ut enim ad minim veniam quis
                                                            nostrud exercitation.</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>

                                        <button id="view-less-btn" class="blog-view-more"
                                                style="color:#9F8B72; display: none;">View
                                            Less<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    I Help With
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv">
                                        <ul>
                                            <li>Nervous System Reset</li>
                                            <li>Chronic Pain Support</li>
                                            <li>Concussion Recovery</li>
                                            <li>Trauma Recovery</li>
                                            <li>PTSD</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    How I Help
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv">
                                        <ul>
                                            <li>Quantum Healing</li>
                                            <li>CranioSacral Therapy</li>
                                            <li>CranioSacral Therapy</li>
                                            <li>Nutritional Support</li>
                                            <li>Quantum Healing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    Certifications
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv certificate-dv">
                                        <ul>
                                            <li>Quantum Healing</li>
                                            <li>CranioSacral Therapy</li>
                                            <li>CranioSacral Therapy</li>
                                            <li>Nutritional Support</li>
                                            <li>Quantum Healing</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingSix">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                                    Reviews
                                </button>
                            </h2>
                            <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body review-dv-data">
                                    <div class="d-flex justify-content-between flex-wrap mb-3">
                                        <div>
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="font-weight-bold">5.0</h6>
                                                <div class="mx-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <h6 class="review-count-text">26 Reviews</h5>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="font-weight-bold">4.0</h6>
                                                <div class="mx-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 70%;" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <h6 class="review-count-text">23 Reviews</h5>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="font-weight-bold">3.0</h6>
                                                <div class="mx-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <h6 class="review-count-text">15 Reviews</h5>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <h6 class="font-weight-bold">2.0</h6>
                                                <div class="mx-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <h6 class="review-count-text">6 Reviews</sh5>
                                            </div>
                                            <div class="d-flex align-items-center mb-3">
                                                <span class="font-weight-bold">1.0</span>
                                                <div class="mx-2">
                                                    <div class="progress">
                                                        <div class="progress-bar" role="progressbar" style="width: 10%;" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <h6 class="review-count-text">4 Reviews</sh5>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <div class="d-flex justify-content-end mb-2" style="gap: 5px;">
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                                <i class="fa-regular fa-gem"></i>
                                            </div>
                                            <h2>4.9/5.0</h2>
                                            <p>74 Total Reviews</p>
                                        </div>
                                    </div>
                                    <div class="sort-by">
                                        <p>Sort By</p>
                                        <div class="dropdown">
                                            <button onclick="toggleDropdown()" class="dropdown-button">
                                                <span>ALL CATEGORIES</span>
                                                <i class="fas fa-chevron-down"></i>
                                            </button>
                                            <div id="dropdownMenuData" class="dropdown-menu">
                                                <ul>
                                                    <li><a href="#">Category 1</a></li>
                                                    <li><a href="#">Category 2</a></li>
                                                    <li><a href="#">Category 3</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="person-review-dv">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center mt-3">
                                            <div class="reviewer mb-3">
                                                <div class="reviewer-img-text">MJ</div>
                                                <div class="reviewer-info">
                                                    <div class="name">Micheal Johnson</div>
                                                    <div class="stars">
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>5.0/5.0</h3>
                                        </div>
                                        <div class="review-text mb-3">
                                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                                        </div>
                                    </div>
                                    <div class="person-review-dv">
                                        <div class="d-flex justify-content-between flex-wrap align-items-center mt-3">
                                            <div class="reviewer mb-3">
                                                <div class="reviewer-img-text">MJ</div>
                                                <div class="reviewer-info">
                                                    <div class="name">Micheal Johnson</div>
                                                    <div class="stars">
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                        <i class="fa-regular fa-gem"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <h3>5.0/5.0</h3>
                                        </div>
                                        <div class="review-text mb-3">
                                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button class="home-blog-btn">Load More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="practitioner-detail-right-dv">
                        <div class="practitioner-detail-right-dv-lists mb-5">
                            <h5 class="active"><i class="fa-solid fa-circle me-3"></i>Offerings</h5>
                            <h5><i class="fa-solid fa-circle me-3"></i>Ailments</h5>
                            <h5><i class="fa-solid fa-circle me-3"></i>Treatments</h5>
                            <h5><i class="fa-solid fa-circle me-3"></i>Certifications</h5>
                            <h5><i class="fa-solid fa-circle me-3"></i>Reviews</h5>
                            <h5><i class="fa-solid fa-circle me-3"></i>More About Me</h5>
                        </div>
                        <h4>Sessions, Insights & More</h4>
                        <video class="video" src=""></video>
                        <video class="video" src=""></video>
                        <video class="video" src=""></video>
                    </div>
                </div>
            </div>
        </div>
        <div class="endorsment-dv">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <img src="{{url('assets/images/person.png')}}" alt="person">
                            <label for="">0.4 Km Away</label>
                            <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                                <h4>Brigitta Ziemba</h4>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <h5><i class="fa-solid fa-location-dot"></i>Los Angeles, US</h5>
                            <p>Alternative and Holistic Health Practitioner</p>
                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                <div>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                </div>
                                <h6>5.0 Ratings</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <img src="{{url('assets/images/person.png')}}" alt="person">
                            <label for="">0.4 Km Away</label>
                            <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                                <h4>Brigitta Ziemba</h4>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <h5><i class="fa-solid fa-location-dot"></i>Los Angeles, US</h5>
                            <p>Alternative and Holistic Health Practitioner</p>
                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                <div>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                </div>
                                <h6>5.0 Ratings</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <img src="{{url('assets/images/person.png')}}" alt="person">
                            <label for="">0.4 Km Away</label>
                            <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                                <h4>Brigitta Ziemba</h4>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <h5><i class="fa-solid fa-location-dot"></i>Los Angeles, US</h5>
                            <p>Alternative and Holistic Health Practitioner</p>
                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                <div>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                </div>
                                <h6>5.0 Ratings</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <img src="{{url('assets/images/person.png')}}" alt="person">
                            <label for="">0.4 Km Away</label>
                            <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                                <h4>Brigitta Ziemba</h4>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <h5><i class="fa-solid fa-location-dot"></i>Los Angeles, US</h5>
                            <p>Alternative and Holistic Health Practitioner</p>
                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                <div>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                    <i class="fa-regular fa-gem"></i>
                                </div>
                                <h6>5.0 Ratings</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
