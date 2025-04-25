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
    @php
        $mediaPath = config('app.media_path', 'uploads');
        $localPath = config('app.local_path', 'assets');
    @endphp
    <div class="practitioner-detail-wrrpr">
        <div class="container">
            <div class="practitioner-search-dv">
                <div class="d-flex justify-content-between flex-wrap align-items-center mb-4">
                    <a href="{{ route('home') }}" class="blog-view-more"><i
                            class="fa-solid fa-chevron-left me-2"></i>Back</a>
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


                                    @php
                                        $shareUrl = urlencode(route('practitioner_detail', $user->id));
                                    @endphp

                                    <ul class="dropdown-menu">
                                        <!-- Copy Direct Link -->
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0)"
                                               onclick="copyLink(event)"
                                               data-link="{{ route('practitioner_detail', $user->id) }}">
                                                <i class="fa-solid fa-copy"></i> Copy Link
                                            </a>
                                        </li>

                                        <!-- Instagram (No direct share, opens homepage) -->
                                        <li>
                                            <a class="dropdown-item" href="https://www.instagram.com/" target="_blank">
                                                <i class="fa-brands fa-instagram"></i> Instagram
                                            </a>
                                        </li>

                                        <!-- WhatsApp Share -->
                                        <li>
                                            <a class="dropdown-item"
                                               href="https://wa.me/?text={{ $shareUrl }}"
                                               target="_blank">
                                                <i class="fa-brands fa-whatsapp"></i> WhatsApp
                                            </a>
                                        </li>

                                        <!-- Facebook Share -->
                                        <li>
                                            <a class="dropdown-item"
                                               href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                               target="_blank">
                                                <i class="fa-brands fa-facebook"></i> Facebook
                                            </a>
                                        </li>

                                        <!-- Twitter (X) Share -->
                                        <li>
                                            <a class="dropdown-item"
                                               href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text=Check this out!"
                                               target="_blank">
                                                <i class="fa-brands fa-x-twitter"></i> X-twitter
                                            </a>
                                        </li>
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
                            $imageUrl = isset($image) ? asset($mediaPath . '/practitioners/' . $userDetail->id . '/profile/' . $image) :asset($localPath.'/images/no_image.png');
                        @endphp
                        <img class="mb-4 img-fit rounded-5" src="{{ $imageUrl }}" alt="darrel">
                        <div class="d-flex justify-content-between flex-wrap align-items-center">
                            <div>
                                @for($i= 1; $i<= $averageProfileRating; $i++)
                                    <i class="fa-regular fa-gem"></i>
                                @endfor
                            </div>
                            <h6 style="color: #9F8B72; margin: 0;">{{ ($averageProfileRating != 0.0 ? $averageProfileRating:'No') .' '. 'Ratings' }} </h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper mySwiper mb-5" style="max-height: 250px">
                <div class="{{count($mediaImages) > 0 ? 'swiper-wrapper' : 'images'}}">
                    @if(count($mediaImages) > 0)
                        @foreach ($mediaImages as $image)
                            @php

                                $imageUrl = $image
                                    ? asset("$mediaPath/practitioners/$userDetail->id/media/$image")
                                    : asset("$localPath/images/no_image.png");
                            @endphp
                            <div class="swiper-slide">
                                <img src="{{ $imageUrl }}" alt="media image" class="img-fit">
                            </div>
                        @endforeach

                    @else
                        <p>No images available</p>
                    @endif
                </div>
                <!-- <div class="swiper-pagination"></div> -->
            </div>

            <div class="d-flex align-items-center mb-3" style="gap: 20px;">
                <p class="m-0">Select Currency</p>
                <div class="dropdown Currency-select">
                    <div class="dropdown">
                        <select class="form-select" aria-label="Default select example"
                                id="currencySelect"
                                style="border-radius: 30px !important;padding: 10px 36px 10px 10px;text-align: start;">
                            <option value="cad">CAD</option>
                            <option value="usd">USD</option>
                        </select>
                    </div>
                </div>
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
                                    @foreach($offerings as $offering)
                                        @if($offering?->offering_event_type == 'offering')
                                            <div class="accordian-body-data">
                                                <div
                                                    class="d-flex justify-content-between flex-wrap align-items-center">
                                                    <h6 class="mb-2"
                                                        style="font-size: 15px;font-weight: 800">{{$offering->name}}</h6>
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $rawPrice = $offering->offering_event_type == 'event'
                                                                ? $offering->event?->client_price ?? 0
                                                                : ($offering?->client_price ?? 0);

                                                            // Clean the price: remove commas, convert to float
                                                            $cadPrice = round(floatval(str_replace(',', '', $rawPrice)));

                                                        @endphp

                                                        <h6 class="offer-prize me-2 m-0">
                                                            CA$ {{ $cadPrice }}
                                                        </h6>

                                                        <button type="button" class="home-blog-btn offering_process"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal"
                                                                onclick="openPopup(event)"
                                                                data-user-id="{{$user->id}}"
                                                                data-duration="{{$offering->offering_event_type =='event' ? ($offering->event?->event_duration ?? '15 minutes') : ($offering?->booking_duration ?? '15 minutes')}}"
                                                                data-buffer-time="{{$offering->offering_event_type =='event'  ? '15 minutes' : ($offering?->buffer_time ?? '15 minutes')}}"
                                                                data-offering-id="{{$offering->id}}"
                                                                data-offering-event-type="{{$offering->offering_event_type}}"
                                                                data-event-start="{{$offering->offering_event_type =='event' ? $offering->event?->date_and_time  ?? '': ''}}"
                                                                data-availability="{{$offering?->availability_type ?? ''}}"
                                                                data-specific-day-start="{{$offering->from_date}}"
                                                                data-specific-day-end="{{$offering->to_date}}"
                                                                data-price="{{$cadPrice}}"
                                                                data-currency-symbol="CA$"
                                                                data-currency="cad"
                                                                data-timezone="{{$userDetail->timezone}}"
                                                                data-cad-price="{{$cadPrice}}"
                                                                data-store-availability="{{$storeAvailable}}">BOOK NOW
                                                        </button>

                                                        {{--                                                    <a href="{{ route('practitionerOfferingDetail',$offering->id)}}" class="home-blog-btn">BOOK NOW</a>--}}
                                                    </div>
                                                </div>
                                                <ul class="practitioner-accordian-lists">
                                                    <li>{{ $offering->offering_event_type == 'event' ? $offering->event?->event_duration ?? 0:$offering->booking_duration}}</li>
                                                </ul>

                                                <button id="view-more-btn" class="blog-view-more mb-2"
                                                        style="color:#9F8B72;">More Info<i
                                                        class="fas fa-chevron-down ms-2"></i></button>

                                                <div id="lorem-text" class="lorem-text">
                                                    <div class="toggle-data-dv">
                                                        <div class="toggle-dv-desc">
                                                            @php
                                                                $imageUrl = (isset($offering->featured_image) and $offering->featured_image) ? asset($mediaPath . '/practitioners/' . $userDetail->id . '/offering/'  . $offering->featured_image) :
                                                            asset($localPath . '/images/no_image.png');
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
                                                                            data-bs-target="#reviews-tab-pane"
                                                                            type="button"
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
                                                        @if($offering?->event?->sports > 0 && $offering?->offering_event_type == 'event')
                                                            <div class="toggle-dv-review mt-3">
                                                                <div class="d-flex mb-2" style="gap: 20px;">
                                                                    <button>Events</button>
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

                                                        @endif
                                                    </div>
                                                </div>

                                                <button id="view-less-btn" class="blog-view-more"
                                                        style="color:#9F8B72; display: none;">
                                                    Less Info<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                            </div>
                                        @endif
                                    @endforeach


                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#Events" aria-expanded="true" aria-controls="collapseOne">
                                    Events
                                </button>
                            </h2>
                            <div id="Events" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    @foreach($offerings as $offering)
                                        @if($offering?->event?->sports > 0 && $offering?->offering_event_type == 'event')
                                            <div class="accordian-body-data">
                                                <div
                                                    class="d-flex justify-content-between flex-wrap align-items-center">
                                                    <h6 class="mb-2"
                                                        style="font-size: 15px;font-weight: 800">{{$offering->name}}</h6>
                                                    <div class="d-flex align-items-center">
                                                        @php
                                                            $rawPrice = $offering->offering_event_type == 'event'
                                                                ? $offering->event?->client_price ?? 0
                                                                : ($offering?->client_price ?? 0);

                                                            // Clean the price: remove commas, convert to float
                                                            $cadPrice = round(floatval(str_replace(',', '', $rawPrice)));

                                                        @endphp

                                                        <h6 class="offer-prize me-2 m-0">
                                                            CA$ {{ $cadPrice }}
                                                        </h6>

                                                        <button type="button" class="home-blog-btn offering_process"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#exampleModal"
                                                                onclick="openPopup(event)"
                                                                data-user-id="{{$user->id}}"
                                                                data-duration="{{$offering->offering_event_type =='event' ? ($offering->event?->event_duration ?? '15 minutes') : ($offering?->booking_duration ?? '15 minutes')}}"
                                                                data-buffer-time="{{$offering->offering_event_type =='event'  ? '15 minutes' : ($offering?->buffer_time ?? '15 minutes')}}"
                                                                data-offering-id="{{$offering->id}}"
                                                                data-offering-event-type="{{$offering->offering_event_type}}"
                                                                data-event-start="{{$offering->offering_event_type =='event' ? $offering->event?->date_and_time  ?? '': ''}}"
                                                                data-availability="{{$offering?->availability_type ?? ''}}"
                                                                data-specific-day-start="{{$offering->from_date}}"
                                                                data-specific-day-end="{{$offering->to_date}}"
                                                                data-price="{{$cadPrice}}"
                                                                data-currency-symbol="CA$"
                                                                data-currency="cad"
                                                                data-timezone="{{$userDetail->timezone}}"
                                                                data-cad-price="{{$cadPrice}}"
                                                                data-store-availability="{{$storeAvailable}}">BOOK NOW
                                                        </button>

                                                        {{--                                                    <a href="{{ route('practitionerOfferingDetail',$offering->id)}}" class="home-blog-btn">BOOK NOW</a>--}}
                                                    </div>
                                                </div>
                                                <ul class="practitioner-accordian-lists">
                                                    <li>{{ $offering->offering_event_type == 'event' ? $offering->event?->event_duration ?? 0:$offering->booking_duration}}</li>
                                                </ul>

                                                <button id="view-more-btn" class="blog-view-more mb-2"
                                                        style="color:#9F8B72;">More Info<i
                                                        class="fas fa-chevron-down ms-2"></i></button>

                                                <div id="lorem-text" class="lorem-text">
                                                    <div class="toggle-data-dv">
                                                        <div class="toggle-dv-review my-3">
                                                            <div class="d-flex mb-2" style="gap: 20px;">
                                                                <button>Events</button>
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
                                                                            data-bs-target="#reviews-tab-pane"
                                                                            type="button"
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
                                                    </div>
                                                </div>

                                                <button id="view-less-btn" class="blog-view-more"
                                                        style="color:#9F8B72; display: none;">
                                                    Less Info<i class="fa-solid fa-chevron-up ms-2"></i></button>

                                            </div>
                                        @endif
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
                                        <div class="row">
                                            @foreach($IHelpWith as $term)
                                                <li class="col-md-6 d-flex align-items-start text-green">
                                                    <i class="fa-solid fa-caret-right mt-1 me-2"></i>
                                                    <span>{{ $term }}</span>
                                                </li>
                                            @endforeach
                                        </div>

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
                                        <div class="row">
                                            @foreach($HowIHelp as $term)
                                                <li class="col-md-6 d-flex align-items-start text-green">
                                                    <i class="fa-solid fa-caret-right mt-1 me-2"></i>
                                                    <span>{{ $term }}</span>
                                                </li>
                                            @endforeach
                                        </div>

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
                                                <li class="col-md-6 d-flex align-items-start text-green">
                                                    <i class="fa-solid fa-caret-right mt-1 me-2"></i>
                                                    <span>{{ $Certification }}</span>
                                                </li>
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
                                                <div class="d-lg-flex align-items-center mb-3">
                                                    <h6 class="font-weight-bold py-2">{{ $star }}.0</h6>
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
                                                    <h6 class="review-count-text py-2">{{ $ratings[$star] }}
                                                        Reviews</h6>
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
                                data-bs-target="#collapseOne"><i class="fa-solid fa-circle me-3"></i>Offering</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#Events"><i class="fa-solid fa-circle me-3"></i>Event</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo"><i class="fa-solid fa-circle me-3"></i>
                                I Help With</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree"><i class="fa-solid fa-circle me-3"></i> How I Help</h5>
                            <h5 class="py-2" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseFour"><i class="fa-solid fa-circle me-3"></i> Certifications
                            </h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="endorsment-dv">
            <div class="container">
                @if(count($endorsedUsers) > 0)
                    <div class="row">
                        <h4>Endorsements</h4>
                        <div class="row" id="endorsementRow">
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
                        </div>
                    </div>
                @endif

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
    <input type="hidden" name="practitioner_timezone" id="practitioner_timezone">

    <input type="hidden" name="store-availability" id="store-availability">
    <input type="hidden" name="offering-specific-days" id="offering-specific-days">
    <input type="hidden" name="already_booked_slots" id="already_booked_slots">
    <input type="hidden" name="currency" id="currency">
    <input type="hidden" name="currency_symbol" id="currency_symbol">

    <input type="hidden" name="duration_time" id="duration_time">
    <input type="hidden" name="buffer_time" id="buffer_time">



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
        function copyLink(event) {
            event.preventDefault();
            const link = event.currentTarget.getAttribute('data-link');

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(link)
                    .then(() => alert("Link copied!"))
                    .catch(err => alert("Failed to copy: " + err));
            } else {
                // Fallback method
                const tempInput = document.createElement("input");
                tempInput.value = link;
                document.body.appendChild(tempInput);
                tempInput.select();
                try {
                    document.execCommand("copy");
                    // alert("Link copied using fallback!");
                } catch (err) {
                    alert("Fallback failed: " + err);
                }
                document.body.removeChild(tempInput);
            }
        }


    </script>

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

@endsection
