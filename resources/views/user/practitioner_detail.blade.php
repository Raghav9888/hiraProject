@extends('layouts.app')

@section('content')
    <div class="practitioner-detail-wrrpr">
        <div class="container">
            <div class="practitioner-search-dv">
                <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
                    <a href="{{ route('home') }}" class="blog-view-more"><i
                            class="fa-solid fa-chevron-left me-2"></i>Back</a>
                    <div class="search-container location-input">
                        <input type="text" class="search-input" placeholder="Search other practitioners">
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
                            <div style="display: flex; gap: 10px; font-size: 25px">
                                <i class="fa-regular fa-heart"></i>
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                        </div>
                        <h5>Alternative and Holistic Health Practitioner</h5>
                        <p class="mb-4">{{$userDetails->bio}}</p>
                        @if($locations && $userLocations)
                            @foreach($locations as  $location)
                                @if(in_array($location->id,$userLocations))
                                    <div class="practitioner-location-dv mb-4">
                                        <button><i class="fa-solid fa-location-dot me-2"></i>{{$location->name}}
                                        </button>
                                        <ul class="m-0">
                                            <li>Virtual Offerings Available</li>
                                        </ul>
                                    </div>
                                @endif

                            @endforeach
                        @endif
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">

                        @php
                            $imageUrl = isset($image) ? asset(env('media_path') . '/practitioners/' . $userDetails->id . '/profile/' . $image) :asset(env('local_path').'/images/no_image.png');
                        @endphp
                        <img class="mb-4 img-fluid rounded-5" src="{{ $imageUrl }}" alt="darrel">
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
                    @if(count($mediaImages) > 0)
                        @foreach ($mediaImages as $image)
                            <div class="swiper-slide">
                                <img
                                    src="{{ asset(env('media_path') . '/practitioners/' . $userDetails->id . '/media/' . $image) }}"
                                    alt="media image">

                            </div>
                        @endforeach
                    @else
                        <p>No images available</p>
                    @endif
                </div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-9 col-lg-9">
                    <div class="accordion" id="accordionExample">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
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
                                            <div class="dropdown">
                                                <select class="form-select" aria-label="Default select example"
                                                        style="border-radius: 30px !important;padding: 10px 36px 10px 10px;text-align: start;">
                                                    <option value="cad">CAD</option>
                                                    <option value="usd">USD</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @foreach($offerings as $offering)
                                        <div class="accordian-body-data">
                                            <div class="d-flex justify-content-between flex-wrap align-items-center">
                                                <h4 class="mb-2">{{$offering->name}}</h4>
                                                <div class="d-flex align-items-center">
                                                    <h6 class="offer-prize me-2 m-0">${{$offering->client_price}}</h6>
                                                    <a href="{{ route('practitionerOfferingDetail',$offering->id)}}"
                                                       class="home-blog-btn">BOOK NOW</a>
                                                </div>
                                            </div>
                                            <ul class="practitioner-accordian-lists">
                                                <li>{{$offering->booking_duration}}</li>
                                            </ul>

                                            <button id="view-more-btn" class="blog-view-more mb-2"
                                                    style="color:#9F8B72;">More Info<i
                                                    class="fas fa-chevron-down ms-2"></i></button>

                                            <div id="lorem-text" class="lorem-text">
                                                <div class="toggle-data-dv">
                                                    <div class="toggle-dv-desc">
                                                        @php
                                                            $imageUrl = (isset($offering->featured_image) and $offering->featured_image) ? asset(env('media_path') . '/practitioners/' . $userDetails->id . '/offering/'  . $offering->featured_image) :
                                                        asset(env('local_path') . '/images/no_image.png');
                                                        @endphp

                                                        <img src="{{$imageUrl}}" alt="">
                                                        <p class="m-0 mb-1">{{$offering->short_description}}</p>
                                                    </div>
                                                    <div class="toggle-dv-review">
                                                        <div class="d-flex mb-2" style="gap: 20px;">
                                                            <button>Description</button>
                                                            {{--                                                            <button--}}
                                                            {{--                                                                style="background-color: transparent;color: #9F8B72;">--}}
                                                            {{--                                                                Reviews--}}
                                                            {{--                                                            </button>--}}
                                                        </div>
                                                        {{$offering->long_description}}
                                                    </div>
                                                </div>
                                            </div>

                                            <button id="view-less-btn" class="blog-view-more"
                                                    style="color:#9F8B72; display: none;">
                                                Less Info<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                        </div>
                                    @endforeach

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
                            <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv">
                                        <ul>
                                            @foreach($IHelpWith as $term)
                                                <li>{{$term}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                    How I Help
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse show"
                                 aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv">
                                        <ul>
                                            @foreach($HowIHelp as $term)
                                                <li>{{$term}}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFour" aria-expanded="false"
                                        aria-controls="collapseFour">
                                    Certifications
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse show"
                                 aria-labelledby="headingFour"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="help-you-dv certificate-dv">
                                        <ul>
                                            @foreach($Certifications as $Certification)
                                                <li>{{$Certification}}</li>
                                            @endforeach

                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="accordion-item">--}}
                        {{--                            <h2 class="accordion-header" id="headingSix">--}}
                        {{--                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"--}}
                        {{--                                        data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">--}}
                        {{--                                    Reviews--}}
                        {{--                                </button>--}}
                        {{--                            </h2>--}}
                        {{--                            <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix"--}}
                        {{--                                 data-bs-parent="#accordionExample">--}}
                        {{--                                <div class="accordion-body review-dv-data">--}}
                        {{--                                    <div class="d-flex justify-content-between flex-wrap mb-3">--}}
                        {{--                                        <div>--}}
                        {{--                                            <div class="d-flex align-items-center mb-3">--}}
                        {{--                                                <h6 class="font-weight-bold">5.0</h6>--}}
                        {{--                                                <div class="mx-2">--}}
                        {{--                                                    <div class="progress">--}}
                        {{--                                                        <div class="progress-bar" role="progressbar" style="width: 80%;"--}}
                        {{--                                                             aria-valuenow="80" aria-valuemin="0"--}}
                        {{--                                                             aria-valuemax="100"></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <h6 class="review-count-text">26 Reviews</h5>--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="d-flex align-items-center mb-3">--}}
                        {{--                                                <h6 class="font-weight-bold">4.0</h6>--}}
                        {{--                                                <div class="mx-2">--}}
                        {{--                                                    <div class="progress">--}}
                        {{--                                                        <div class="progress-bar" role="progressbar" style="width: 70%;"--}}
                        {{--                                                             aria-valuenow="70" aria-valuemin="0"--}}
                        {{--                                                             aria-valuemax="100"></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <h6 class="review-count-text">23 Reviews</h5>--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="d-flex align-items-center mb-3">--}}
                        {{--                                                <h6 class="font-weight-bold">3.0</h6>--}}
                        {{--                                                <div class="mx-2">--}}
                        {{--                                                    <div class="progress">--}}
                        {{--                                                        <div class="progress-bar" role="progressbar" style="width: 50%;"--}}
                        {{--                                                             aria-valuenow="50" aria-valuemin="0"--}}
                        {{--                                                             aria-valuemax="100"></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <h6 class="review-count-text">15 Reviews</h5>--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="d-flex align-items-center mb-3">--}}
                        {{--                                                <h6 class="font-weight-bold">2.0</h6>--}}
                        {{--                                                <div class="mx-2">--}}
                        {{--                                                    <div class="progress">--}}
                        {{--                                                        <div class="progress-bar" role="progressbar" style="width: 20%;"--}}
                        {{--                                                             aria-valuenow="20" aria-valuemin="0"--}}
                        {{--                                                             aria-valuemax="100"></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <h6 class="review-count-text">6 Reviews</sh5>--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="d-flex align-items-center mb-3">--}}
                        {{--                                                <span class="font-weight-bold">1.0</span>--}}
                        {{--                                                <div class="mx-2">--}}
                        {{--                                                    <div class="progress">--}}
                        {{--                                                        <div class="progress-bar" role="progressbar" style="width: 10%;"--}}
                        {{--                                                             aria-valuenow="10" aria-valuemin="0"--}}
                        {{--                                                             aria-valuemax="100"></div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                                <h6 class="review-count-text">4 Reviews</sh5>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="text-right">--}}
                        {{--                                            <div class="d-flex justify-content-end mb-2" style="gap: 5px;">--}}
                        {{--                                                <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                <i class="fa-regular fa-gem"></i>--}}
                        {{--                                            </div>--}}
                        {{--                                            <h2>4.9/5.0</h2>--}}
                        {{--                                            <p>74 Total Reviews</p>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="sort-by">--}}
                        {{--                                        <p>Sort By</p>--}}
                        {{--                                        <div class="dropdown">--}}
                        {{--                                            <button onclick="toggleDropdown()" class="dropdown-button">--}}
                        {{--                                                <span>ALL CATEGORIES</span>--}}
                        {{--                                                <i class="fas fa-chevron-down"></i>--}}
                        {{--                                            </button>--}}
                        {{--                                            <div id="dropdownMenuData" class="dropdown-menu">--}}
                        {{--                                                <ul>--}}
                        {{--                                                    <li><a href="#">Category 1</a></li>--}}
                        {{--                                                    <li><a href="#">Category 2</a></li>--}}
                        {{--                                                    <li><a href="#">Category 3</a></li>--}}
                        {{--                                                </ul>--}}
                        {{--                                            </div>--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="person-review-dv">--}}
                        {{--                                        <div class="d-flex justify-content-between flex-wrap align-items-center mt-3">--}}
                        {{--                                            <div class="reviewer mb-3">--}}
                        {{--                                                <div class="reviewer-img-text">MJ</div>--}}
                        {{--                                                <div class="reviewer-info">--}}
                        {{--                                                    <div class="name">Micheal Johnson</div>--}}
                        {{--                                                    <div class="stars">--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                            <h3>5.0/5.0</h3>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="review-text mb-3">--}}
                        {{--                                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod--}}
                        {{--                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,--}}
                        {{--                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo--}}
                        {{--                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse--}}
                        {{--                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat--}}
                        {{--                                            non proident, sunt in culpa qui officia deserunt mollit anim id est--}}
                        {{--                                            laborum."--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="person-review-dv">--}}
                        {{--                                        <div class="d-flex justify-content-between flex-wrap align-items-center mt-3">--}}
                        {{--                                            <div class="reviewer mb-3">--}}
                        {{--                                                <div class="reviewer-img-text">MJ</div>--}}
                        {{--                                                <div class="reviewer-info">--}}
                        {{--                                                    <div class="name">Micheal Johnson</div>--}}
                        {{--                                                    <div class="stars">--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                        <i class="fa-regular fa-gem"></i>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                            <h3>5.0/5.0</h3>--}}
                        {{--                                        </div>--}}
                        {{--                                        <div class="review-text mb-3">--}}
                        {{--                                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod--}}
                        {{--                                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,--}}
                        {{--                                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo--}}
                        {{--                                            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse--}}
                        {{--                                            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat--}}
                        {{--                                            non proident, sunt in culpa qui officia deserunt mollit anim id est--}}
                        {{--                                            laborum."--}}
                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="d-flex justify-content-end mt-4">--}}
                        {{--                                        <button class="home-blog-btn">Load More</button>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="col-sm-12 col-md-3 col-lg-3">
                    <div class="practitioner-detail-right-dv">
                        <div class="practitioner-detail-right-dv-lists mb-5">
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne"><i class="fa-solid fa-circle me-3"></i>Offerings</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"><i class="fa-solid fa-circle me-3"></i>Ailments</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree"><i class="fa-solid fa-circle me-3"></i>Treatments</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour"><i class="fa-solid fa-circle me-3"></i>Certifications
                            </h5>
                            {{--                            <h5 data-bs-toggle="collapse" data-bs-target="#collapseSix"><i class="fa-solid fa-circle me-3"></i>Reviews</h5>--}}
                            {{--                            <h5><i class="fa-solid fa-circle me-3"></i>More About Me</h5>--}}
                        </div>
                        {{--                        <h4>Sessions, Insights & More</h4>--}}
                        {{--                        <video class="video" src=""></video>--}}
                        {{--                        <video class="video" src=""></video>--}}
                        {{--                        <video class="video" src=""></video>--}}
                    </div>
                </div>
            </div>
        </div>
        <div class="endorsment-dv">
            <div class="container">
                <div class="row">
                    <h4>Endorsements</h4>
                    <div class="row" id="endorsementRow">
                        @if($endorsedUsers)
                            @foreach($endorsedUsers as $endorsedUser)
                                @php
                                    $images = isset($endorsedUser->userDetail->images) ? json_decode($endorsedUser->userDetail->images, true) : null;
                                    $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
                                    $imageUrl = $image  ? asset(env('media_path') . '/practitioners/' . $endorsedUser->userDetail->id . '/profile/' . $image) : asset(env('local_path').'/images/no_image.png');
                                @endphp

                                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                                    <div class="featured-dv">
                                        <a href="{{route('practitioner_detail', $endorsedUser->id)}}">
                                            <img src="{{ $imageUrl }}" alt="person" class="img-fluid">
                                            {{--                                <label for="">0.4 Km Away</label>--}}
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h4>{{  $endorsedUser->name }}</h4>
                                                <i class="fa-regular fa-heart"></i>
                                            </div>
                                            <h5>

                                                @php
                                                    $locations = isset($endorsedUser->location) && $endorsedUser->location ? json_decode($endorsedUser->location, true) : null;
                                                @endphp
                                                @if($locations)
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
                        @endif
                    </div>
                </div>
            </div>
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
                    slidesPerView: 4,
                    spaceBetween: 50,
                },
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
        });
    </script>
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
        document.querySelectorAll("#view-more-btn").forEach((btn, index) => {
            btn.addEventListener("click", function () {
                document.querySelectorAll("#lorem-text")[index].style.display = "block";
                document.querySelectorAll("#view-more-btn")[index].style.display = "none";
                document.querySelectorAll("#view-less-btn")[index].style.display = "inline-block";
            });
        });

        document.querySelectorAll("#view-less-btn").forEach((btn, index) => {
            btn.addEventListener("click", function () {
                document.querySelectorAll("#lorem-text")[index].style.display = "none";
                document.querySelectorAll("#view-more-btn")[index].style.display = "inline-block";
                document.querySelectorAll("#view-less-btn")[index].style.display = "none";
            });
        });

    </script>
    <script>
        function toggleDropdown() {
            var dropdownMenuData = document.getElementById("dropdownMenuData");
            if (dropdownMenuData.style.display === "none" || dropdownMenuData.style.display === "") {
                dropdownMenuData.style.display = "block";
            } else {
                dropdownMenuData.style.display = "none";
            }
        }
    </script>

@endsection
