@extends('layouts.app')
<style>
    /* Popup overlay */
    .popup-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 99999;
        overflow-y: auto;
    }

    /* Popup content */
    .popup-content {
        background-color: #fff;
        width: 80%;
        max-width: 1000px;
        height: 100%;
        min-height: 700px;
        border-radius: 8px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Close button */
    .close-btn {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 20px;
        cursor: pointer;
    }

    /* Calendar grid styles */
    .calendar-grid {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        gap: 5px;
        text-align: center;
    }


</style>
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
                                {{--                                <i class="fa-regular fa-heart"></i>--}}
                                <div class="dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                                            style="font-size: 25px">
                                        <i class="fa-solid fa-share-nodes"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#"><i class="fa-solid fa-copy"></i> Copy Link</a>
                                        </li>
                                        <li><a class="dropdown-item" href="#"><i class="fa-brands fa-instagram"></i>
                                                Instagram</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fa-brands fa-whatsapp"></i>
                                                Whatsapp</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fa-brands fa-facebook"></i>
                                                Facebook</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fa-brands fa-x-twitter"></i>
                                                X-twitter</a></li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                        <h5>{{$userDetail->company ??'Alternative and Holistic Health Practitioner' }}</h5>
                        <p class="mb-4">{{$userDetail->bio}}</p>
                        @if($locations && $userLocations)
                            <div class="row">
                                @foreach($locations as  $location)
                                    @if(in_array($location->id,$userLocations))
                                        <div class="col-md-6">

                                            <div class="practitioner-location-dv mb-4">
                                                <button><i class="fa-solid fa-location-dot me-2"></i>{{$location->name}}
                                                </button>
                                                <ul class="m-0">
                                                    <li>Virtual Offerings Available</li>
                                                </ul>
                                            </div>
                                        </div>
                                    @endif

                                @endforeach
                            </div>

                        @endif
                    </div>
                    <div class="col-sm-12 col-md-3 col-lg-3">

                        @php
                            $imageUrl = isset($image) ? asset(env('media_path') . '/practitioners/' . $userDetail->id . '/profile/' . $image) :asset(env('local_path').'/images/no_image.png');
                        @endphp
                        <img class="mb-4 img-fluid rounded-5" src="{{ $imageUrl }}" alt="darrel">
                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                            <div>
                                @for($i= 1; $i<= $averageProfileRating; $i++)
                                    <i class="fa-regular fa-gem"></i>
                                @endfor
                            </div>
                            <h6 style="color: #9F8B72; margin: 0;">{{ ($averageProfileRating != 0.0 ? $averageProfileRating:'5.0') .' '. 'Ratings' }} </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper mySwiper mb-5">
                <div class="{{count($mediaImages) > 0 ? 'swiper-wrapper' : 'images'}}">
                    @if(count($mediaImages) > 0)
                        @foreach ($mediaImages as $image)
                            <div class="swiper-slide">
                                <img
                                    src="{{ asset(env('media_path') . '/practitioners/' . $userDetail->id . '/media/' . $image) }}"
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
                                                    <h6 class="offer-prize me-2 m-0">
                                                        ${{$offering->offering_event_type == 'event' ? $offering->event->client_price :($offering?->client_price ?? 0)}}</h6>
                                                    <button type="button" class="home-blog-btn" data-bs-toggle="modal"
                                                            data-bs-target="#exampleModal"
                                                            onclick="openPopup(event)"
                                                            data-offering-id="{{$offering->id}}"
                                                            data-offering-event-type="{{$offering->offering_event_type}}"
                                                            data-event-start="{{$offering->offering_event_type =='event' ? $offering->event->date_and_time : ''}}"
                                                            data-availability="{{$offering?->availability_type ?? ''}}"
                                                            data-specific-day-start="{{$offering->from_date}}"
                                                            data-specific-day-end="{{$offering->to_date}}"
                                                            data-price="{{$offering->offering_event_type =='event' ? $offering->event->client_price :$offering->client_price ?? 0}}"
                                                            data-store-availability="{{$storeAvailable}}">BOOK NOW
                                                    </button>

                                                    {{--                                                    <a href="{{ route('practitionerOfferingDetail',$offering->id)}}" class="home-blog-btn">BOOK NOW</a>--}}
                                                </div>
                                            </div>
                                            <ul class="practitioner-accordian-lists">
                                                <li>{{ $offering->offering_event_type == 'event' ? $offering->event->event_duration:$offering->booking_duration}}</li>
                                            </ul>

                                            <button id="view-more-btn" class="blog-view-more mb-2"
                                                    style="color:#9F8B72;">More Info<i
                                                    class="fas fa-chevron-down ms-2"></i></button>

                                            <div id="lorem-text" class="lorem-text">
                                                <div class="toggle-data-dv">
                                                    <div class="toggle-dv-desc">
                                                        @php
                                                            $imageUrl = (isset($offering->featured_image) and $offering->featured_image) ? asset(env('media_path') . '/practitioners/' . $userDetail->id . '/offering/'  . $offering->featured_image) :
                                                        asset(env('local_path') . '/images/no_image.png');
                                                        @endphp

                                                        <img src="{{$imageUrl}}" alt="">
                                                        <p class="m-0 mb-1">{{$offering->short_description}}</p>
                                                    </div>
                                                    <div class="toggle-dv-review">


                                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link active mx-2"
                                                                        id="description-tab" data-bs-toggle="tab"
                                                                        data-bs-target="#description-tab-pane"
                                                                        type="button" role="tab"
                                                                        aria-controls="description-tab-pane"
                                                                        aria-selected="true">Description
                                                                </button>
                                                            </li>
                                                            <li class="nav-item" role="presentation">
                                                                <button class="nav-link mx-2" id="reviews-tab"
                                                                        data-bs-toggle="tab"
                                                                        data-bs-target="#reviews-tab-pane" type="button"
                                                                        role="tab" aria-controls="reviews-tab-pane"
                                                                        aria-selected="false">Reviews
                                                                </button>
                                                            </li>

                                                        </ul>
                                                        <div class="tab-content" id="myTabContent">
                                                            <div class="tab-pane fade show active"
                                                                 id="description-tab-pane" role="tabpanel"
                                                                 aria-labelledby="description-tab" tabindex="0">
                                                                {{$offering->long_description}}
                                                            </div>
                                                            <div class="tab-pane fade" id="reviews-tab-pane"
                                                                 role="tabpanel" aria-labelledby="reviews-tab"
                                                                 tabindex="0">
                                                                <div class="review-dv-data">
                                                                    @foreach ($offeringFeedback as $feedback)
                                                                        <div class="person-review-dv">
                                                                            <div
                                                                                class="d-flex justify-content-between flex-wrap align-items-center mt-3">
                                                                                <div class="reviewer mb-3">
                                                                                    <div class="reviewer-img-text">
                                                                                        {{ strtoupper(substr($feedback->name, 0, 2)) }} {{-- Show initials --}}
                                                                                    </div>
                                                                                    <div class="reviewer-info">
                                                                                        <div
                                                                                            class="name">{{ $feedback->name }}</div>
                                                                                        <div class="stars">
                                                                                            @for ($i = 1; $i <= 5; $i++)
                                                                                                <i class="fa-regular fa-gem {{ $i <= $feedback->rating ? 'text-warning' : '' }}"></i>
                                                                                            @endfor
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <h3>{{ number_format($feedback->rating, 1) }}
                                                                                    /5.0</h3>

                                                                            </div>
                                                                            <div class="review-text mb-3">
                                                                                {!! $feedback->comment !!}

                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="toggle-dv-review mt-3">
                                                        <div class="d-flex mb-2" style="gap: 20px;">
                                                            <button>Events</button>
                                                            {{--                                                            <button--}}
                                                            {{--                                                                style="background-color: transparent;color: #9F8B72;">--}}
                                                            {{--                                                                Reviews--}}
                                                            {{--                                                            </button>--}}
                                                        </div>

                                                        <p>
                                                            <span
                                                                class="mr-2 mb-1 d-block">Event Duration: {{@$offering?->event?->event_duration ?? 0}}</span>
                                                            <span
                                                                class="mr-2 mb-1 d-block"> Client Price: ${{ @$offering?->event?->client_price ?? 0}}</span>
                                                            <span
                                                                class="mr-2 mb-1 d-block">Date Time: {{@$offering->event->date_and_time? date('d M, Y', strtotime($offering->event->date_and_time)): ''}}</span>
                                                            <span
                                                                class="mr-2 mb-1 d-block">Total slots: {{@$offering?->event->sports > 0 ? $offering->event->sports: 0}}</span>

                                                        </p>
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
                                        <div class="row">
                                            @foreach($Certifications as $Certification)
                                                <li class="col-md-6">{{$Certification}}</li>
                                            @endforeach
                                        </div>
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
                            <div id="collapseSix" class="accordion-collapse collapse show" aria-labelledby="headingSix"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body review-dv-data">
                                    <div class="d-flex justify-content-between flex-wrap mb-3">
                                        <div>
                                            @foreach ([5, 4, 3, 2, 1] as $star)
                                                <div class="d-flex align-items-center mb-3">
                                                    <h6 class="font-weight-bold">{{ $star }}.0</h6>
                                                    <div class="mx-2">
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar"
                                                                 style="width: {{ $ratingPercentages[$star] }}%;"
                                                                 aria-valuenow="{{ $ratingPercentages[$star] }}"
                                                                 aria-valuemin="0"
                                                                 aria-valuemax="100">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <h6 class="review-count-text">{{ $ratings[$star] }} Reviews</h6>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="text-right">
                                            <div class="d-flex justify-content-end mb-2" style="gap: 5px;">
                                                @for($i= 1; $i<= $averageProfileRating; $i++)
                                                    <i class="fa-regular fa-gem"></i>
                                                @endfor
                                            </div>
                                            <h2>{{$averageProfileRating}}/5.0</h2>
                                            <p>{{count($profileFeedback)}} Total Reviews</p>
                                        </div>
                                    </div>
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
                                    @foreach ($profileFeedback as $feedback)
                                        <div class="person-review-dv">
                                            <div
                                                class="d-flex justify-content-between flex-wrap align-items-center mt-3">
                                                <div class="reviewer mb-3">
                                                    <div class="reviewer-img-text">
                                                        {{ strtoupper(substr($feedback->name, 0, 2)) }} {{-- Show initials --}}
                                                    </div>
                                                    <div class="reviewer-info">
                                                        <div class="name">{{ $feedback->name }}</div>
                                                        <div class="stars">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i class="fa-regular fa-gem {{ $i <= $feedback->rating ? 'text-warning' : '' }}"></i>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                </div>
                                                <h3>{{ number_format($feedback->rating, 1) }}/5.0</h3>

                                            </div>
                                            <div class="review-text mb-3">
                                                {!! $feedback->comment !!}

                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="d-flex justify-content-end mt-4">
                                        {!! $profileFeedback->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        </div>

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
                                            <p>{{$endorsedUser->userDetail->company ?? 'Alternative and Holistic Health Practitioner'}}</p>
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
    <input type="hidden" name="offering_id" id="offering_id">
    <input type="hidden" name="user_id" id="user_id">

    <input type="hidden" name="offering_event_type" id="offering_event_type">
    <input type="hidden" name="offering_event_start_date_time" id="offering_event_start_date_time">
    <input type="hidden" name="availability" id="availability">

    <input type="hidden" name="offering_price" id="offering_price">

    <input type="hidden" name="booking_date" id="booking_date">
    <input type="hidden" name="booking_time" id="booking_time">

    <input type="hidden" name="store-availability" id="store-availability">
    <input type="hidden" name="offering-specific-days" id="offering-specific-days">
    <input type="hidden" name="already_booked_slots" id="already_booked_slots">



    <!-- Modal -->
    <div class="modal fade xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="booking-container d-none">
                        @include('user.offering_detail_page')
                    </div>
                    <div class="event-container d-none">
                        @include('user.event_detail_popup')
                    </div>
                    <div class="billing-container"></div>
                    <div class="checkout-container"></div>
                    <div class="login-container" style="display: none;">
                        @include('user.login-popup')
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

    <script>
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let activeDate = formatDate(currentDate);


        let availableSlotsData = {};

        function openPopup(event) {
            event.preventDefault();
            window.loadingScreen.addPageLoading();

            let offeringId = event.target.getAttribute('data-offering-id');
            let availabilityData = event.target.getAttribute('data-availability');
            let storeAvailability = event.target.getAttribute('data-store-availability');
            let priceData = event.target.getAttribute('data-price');
            let specificDayStart = event.target.getAttribute('data-specific-day-start');
            let specificDayEnd = event.target.getAttribute('data-specific-day-end');
            let offeringEventType = event.target.getAttribute('data-offering-event-type');
            let offeringEventStart = event.target.getAttribute('data-event-start');

            let inputElement = document.querySelector('[name="offering_id"]');
            let userIdInput = document.querySelector('[name="user_id"]');
            let availabilityInput = document.querySelector('[name="availability"]');
            let offeringPriceInput = document.querySelector('[name="offering_price"]');
            let offeringSlotsInput = document.querySelector('[name="store-availability"]');
            let priceDiv = offeringEventType === 'event' ? document.getElementById('eventPrice') : document.getElementById('offeringPrice');
            let offeringSpecificDaysInput = document.querySelector('[name="offering-specific-days"]');
            let offeringEventInput = document.querySelector('[name="offering_event_type"]');
            let offeringEventStartDateTime = document.querySelector('[name="offering_event_start_date_time"]');
            let popupElement = document.getElementById('popup');

            if (offeringEventType === 'event') {
                $.ajax({
                    url: '{{ route('getEvent') }}',
                    type: 'POST',
                    data: {
                        offeringId: offeringId,
                        userId: '{{ $user->id }}',
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function () {
                        window.loadingScreen.addPageLoading();
                    },
                    success: function (response) {
                        if (response.success) {
                            // Populate the event data in the modal
                            document.querySelector('.event-container').innerHTML = response.html;
                            document.querySelector('.event-container').classList.remove('d-none');
                            document.querySelector('.booking-container').classList.add('d-none');
                        } else {
                            console.log('error')
                        }

                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    },

                    complete: function () {
                        window.loadingScreen.removeLoading();
                    }


                })

            } else {
                document.querySelector('.event-container').classList.add('d-none');
                document.querySelector('.booking-container').classList.remove('d-none');

                $.ajax({
                    type: 'post',
                    url: "{{ route('getBookedSlots',$user->id) }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        window.loadingScreen.addPageLoading();
                    },
                    success: function (response) {
                        console.log("Fetched booked dates:", response.bookedDates);

                        if (response.status === 'success' && Array.isArray(response.bookedDates)) {
                            $('#already_booked_slots').val(JSON.stringify(response.bookedDates));
                        } else {
                            console.error("Invalid booked dates:", response);
                            $('#already_booked_slots').val("[]");
                        }

                        // ✅ Call `generateCalendar` after data is updated
                        generateCalendar(currentMonth, currentYear);
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX Error:", error);
                    },
                    complete: function () {
                        window.loadingScreen.removeLoading();
                    }
                });

                generateCalendar(currentMonth, currentYear);
            }


            if (inputElement) {
                inputElement.value = offeringId;
                inputElement.classList.add('activeInput');
                availabilityInput.value = availabilityData;
                offeringSlotsInput.value = storeAvailability;
                offeringEventInput.value = offeringEventType;
                offeringPriceInput.value = priceData;
                priceDiv.textContent = priceData;
                offeringEventStartDateTime.value = offeringEventStart;
                userIdInput.value = '{{ $user->id }}';
                offeringSpecificDaysInput.setAttribute('data-specific-day-start', specificDayStart);
                offeringSpecificDaysInput.setAttribute('data-specific-day-end', specificDayEnd);
                offeringSpecificDaysInput.value = specificDayStart + ' - ' + specificDayEnd;
            } else {
                console.error("Element with name 'offering_id' not found");
            }

            window.loadingScreen.removeLoading();
        }


        function formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        }


        function getAllowedDays() {
            let availability = document.getElementById('availability')?.value || 'own_specific_date';
            let storeAvailabilityRaw = document.getElementById('store-availability')?.value;

            let dayMapping = {
                "every_monday": [1], "every_tuesday": [2], "every_wednesday": [3],
                "every_thursday": [4], "every_friday": [5], "weekend_every_saturday_sunday": [0, 6],
                "every_day": [0, 1, 2, 3, 4, 5, 6], "own_specific_date": [0, 1, 2, 3, 4, 5, 6]
            };

            if (availability === 'own_specific_date') {
                let specificDaysInput = document.querySelector('[name="offering-specific-days"]');
                if (!specificDaysInput) return [];

                let specificDays = specificDaysInput.value.split(' - ');
                let specificDayStart = new Date(specificDays[0]);
                let specificDayEnd = new Date(specificDays[1]);

                // Calculate the total number of days
                let totalDays = Math.ceil((specificDayEnd - specificDayStart) / (1000 * 60 * 60 * 24)) + 1;

                // Generate an array of allowed dates
                let allowedDates = Array.from({length: totalDays}, (_, index) => {
                    let date = new Date(specificDayStart);
                    date.setDate(date.getDate() + index);
                    return date.toISOString().split('T')[0]; // Format as YYYY-MM-DD
                });

                console.log("Allowed Dates for Own Specific Date:", allowedDates);
                return allowedDates;
            }


            if (availability === 'following_store_hours') {
                if (!storeAvailabilityRaw) return [];

                try {
                    console.log("Raw Store Availability JSON:", storeAvailabilityRaw);

                    let storeAvailability = JSON.parse(storeAvailabilityRaw);
                    console.log("Parsed Store Availability:", storeAvailability);

                    let allowedDays = [];

                    if (storeAvailability.every_day?.enabled === "1") {
                        // "every_day" is enabled, so allow all days (0 = Sunday, 6 = Saturday)
                        allowedDays = [0, 1, 2, 3, 4, 5, 6];
                    } else {
                        // Otherwise, check individually enabled days
                        allowedDays = Object.keys(storeAvailability)
                            .filter(day => storeAvailability[day]?.enabled === "1")
                            .map(day => {
                                let normalizedDay = day.replace("every_", "").toLowerCase();
                                return ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"]
                                    .indexOf(normalizedDay);
                            })
                            .filter(dayIndex => dayIndex !== -1);
                    }

                    console.log("Allowed Days from Store Availability:", allowedDays);
                    return allowedDays;
                } catch (error) {
                    console.error("Error parsing store availability JSON:", error, storeAvailabilityRaw);
                    return [];
                }


            }

            return dayMapping[availability] || [];
        }


        function generateTimeSlots(from = null, to = null, date = null, allDay = false) {
            let slots = [];
            let startTime = '';
            let endTime = '';

            if (allDay) {
                startTime = new Date(`${date}T12:00`);
                endTime = new Date(`${date}T12:00`);
            } else {
                startTime = new Date(`2025-01-01T${from}`);
                endTime = new Date(`2025-01-01T${to}`);
            }
            let isNextDay = endTime <= startTime;
            if (isNextDay) {
                endTime.setDate(endTime.getDate() + 1); // Move end time to the next day
            }

            while (startTime < endTime) {
                slots.push(formatTime(startTime));
                startTime.setMinutes(startTime.getMinutes() + 60);
            }


            // Sort slots correctly from AM to PM
            slots.sort((a, b) => convertTo24Hour(a) - convertTo24Hour(b));

            return slots;
        }

        // Convert Date object to "HH:MM AM/PM" format
        function formatTime(date) {
            return date.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', hour12: true});
        }

        // Convert "HH:MM AM/PM" to 24-hour format for correct sorting
        function convertTo24Hour(time) {
            let [hour, minute] = time.split(/:| /);
            let period = time.includes("AM") ? "AM" : "PM";

            let date = new Date(`2025-01-01 ${hour}:${minute} ${period}`);
            return date.getHours() * 60 + date.getMinutes();
        }

        function generateCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const calendarGrid = document.getElementById('calendarGrid');
            const monthLabel = document.getElementById('monthLabel');
            calendarGrid.innerHTML = '';

            monthLabel.innerText = `${firstDay.toLocaleString('default', {month: 'long'})} ${year}`;
            const daysInMonth = lastDay.getDate();
            const startDay = firstDay.getDay();
            const allowedDays = getAllowedDays();

            // Retrieve already booked slots from hidden input
            let bookedSlotsElement = document.getElementById('already_booked_slots');
            let bookedDates = [];

            if (bookedSlotsElement) {
                let value = bookedSlotsElement.value.trim(); // Remove any extra spaces

                if (value) { // Ensure the value is not empty
                    try {
                        bookedDates = JSON.parse(value);
                    } catch (error) {
                        console.error("Error parsing booked slots JSON:", error, value);
                    }
                }
            }

            console.log("Parsed bookedDates:", bookedDates);


            for (let i = 0; i < startDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('inactive');
                calendarGrid.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const currentDayOfWeek = new Date(year, month, day).getDay();
                const dayCell = document.createElement('div');
                dayCell.classList.add('dates');

                if (dateString === formatDate(currentDate)) {
                    dayCell.classList.add('active');
                    activeDate = dateString;
                }

                // ✅ Check for full date match (if own_specific_date) OR check by day of week
                if (!(allowedDays.includes(dateString) || allowedDays.includes(currentDayOfWeek))) {
                    dayCell.classList.add('inactive');
                }

                // ✅ Disable already booked dates
                if (bookedDates.includes(dateString)) {
                    dayCell.classList.add('inactive');
                    dayCell.classList.add('booked'); // Optional: Add a booked class for styling
                    dayCell.setAttribute('title', 'This date is already booked');
                }

                dayCell.innerText = day;
                dayCell.setAttribute('data-date', dateString);

                dayCell.addEventListener('click', () => {
                    if (dayCell.classList.contains('inactive')) return;

                    if (activeDate) {
                        document.querySelector(`[data-date='${activeDate}']`)?.classList.remove('active');
                    }

                    activeDate = dateString;
                    dayCell.classList.add('active');
                    showAvailableSlots(activeDate);
                });

                calendarGrid.appendChild(dayCell);
                $('.calendar-grid .dates').on('click', function () {
                    const date = $(this).data('date');
                    $('#booking_date').val(date);
                })

            }
        }


        function showAvailableSlots(date) {
            const slotsContainer = document.getElementById('availableSlots');
            const dateLabel = document.getElementById('selectedDate');
            let availability = document.getElementById('availability')?.value || 'own_specific_date';
            let storeAvailabilityRaw = document.getElementById('store-availability')?.value;

            slotsContainer.innerHTML = '';
            dateLabel.innerText = date.split('-').reverse().join('/');

            let availableSlots = [];

            if (availability === 'following_store_hours') {
                if (!storeAvailabilityRaw) {
                    console.error("Store availability data is missing.");
                    return;
                }

                let storeAvailability;
                try {
                    storeAvailability = JSON.parse(storeAvailabilityRaw.replace(/&quot;/g, '"'));
                } catch (error) {
                    console.error("Error parsing store availability JSON:", error, storeAvailabilityRaw);
                    return;
                }

                let dayOfWeekIndex = new Date(date).getDay();
                let dayNames = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];

                let allSlots = [];

                if (storeAvailability.every_day?.enabled === "1") {
                    // If "every_day" is enabled, generate slots for any day
                    let fromTime = storeAvailability.every_day?.from;
                    let toTime = storeAvailability.every_day?.to;

                    if (fromTime && toTime) {
                        allSlots = generateTimeSlots(fromTime, toTime);
                    }
                } else {
                    // Otherwise, check individual days
                    Object.keys(storeAvailability).forEach(dayKey => {
                        let normalizedDay = dayKey.replace("every_", "").toLowerCase();
                        let dayIndex = dayNames.indexOf(normalizedDay);

                        if (dayIndex === dayOfWeekIndex && storeAvailability[dayKey]?.enabled === "1") {
                            let fromTime = storeAvailability[dayKey]?.from;
                            let toTime = storeAvailability[dayKey]?.to;

                            if (fromTime && toTime) {
                                allSlots = allSlots.concat(generateTimeSlots(fromTime, toTime));
                            }
                        }
                    });
                }

                availableSlots = [...new Set(allSlots)].sort((a, b) => convertTo24Hour(a) - convertTo24Hour(b));
            } else {
                // Default case (all-day availability)
                availableSlots = generateTimeSlots(null, null, date, true);
            }

            renderSlots(availableSlots);
        }


        function renderSlots(availableSlots) {
            const slotsContainer = document.getElementById('availableSlots');
            slotsContainer.innerHTML = availableSlots.length
                ? availableSlots.map(slot => `<div class="col-4"><button class="btn btn-outline-green w-100 offering-slot" data-time="${slot}">${slot}</button></div>`).join('')
                : '<p class="text-muted">No available slots</p>';

            $('.offering-slot').on('click', function () {
                $('.offering-slot').removeClass('active')
                $(this).addClass('active')
                const time = $(this).data('time');
                $('#booking_time').val(time)
            })
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });


        $(document).on('click', '.proceed_to_checkout', function () {
            console.log('click');

            const offeringId = $('#offering_id').val();
            const offeringEventType = $('#offering_event_type').val();
            const startEventDate = $('#offering_event_start_date_time').val();

            let bookingDate = '';
            let bookingTime = '';

            if (offeringEventType !== 'event') {
                bookingDate = $('#booking_date').val();
                bookingTime = $('#booking_time').val();
            } else {
                [bookingDate, bookingTime] = startEventDate.split(" ");
            }

            paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType);
        });


        function paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType) {

            if (!offeringId || !bookingDate || !bookingTime) {
                alert("Please select slot!");
                return;
            }

            $.ajax({
                type: "POST",
                url: "{{route('storeBooking')}}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    offering_id: offeringId,
                    booking_date: bookingDate,
                    booking_time: bookingTime,
                    offering_event_type: offeringEventType
                },
                success: function (response) {
                    if (!response.success) {
                        alert("Something went wrong!")
                    }
                    $('.booking-container').hide();
                    $('.event-container').hide();
                    $('.billing-container').show();
                    $('.billing-container').html(response.html);
                    // $('.popup-content').css('width', "60%")
                    // $('.popup-content').css('background-color', "transparent")
                    // $('.popup-content .container').css('padding', "30px")
                },
                error: function (error) {
                    alert("Something went wrong!");
                }
            });
        }

    </script>

@endsection
