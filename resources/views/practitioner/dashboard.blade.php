@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>

            <div class="ps-5">
                <div style="border-bottom: 2px solid#BA9B8B; margin-bottom: 20px;">
                    <h5 class="practitioner-profile-text">Upcoming
                        <span style="font-weight: 800;">community events</span>
                    </h5>
                </div>
            </div>

            <div class="row ps-5" id="upcomingEventsRowDiv">

                {{-- We show the data by ajax --}}
                <div class="col-sm-12 my-4 text-center">
                    loading...
                </div>
            </div>
            <div class="row ms-5" id="upcomingAppointmentsRowDiv">
                <div class="px-0" style="border-bottom: 2px solid#BA9B8B; margin-bottom: 20px;">
                    <h5 class="practitioner-profile-text mb-2">Upcoming <span
                            style="font-weight: 800;">appointments</span></h5>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="event-name-dv">
                        <h5>John Doe</h5>
                        <h6>Name of Service Booked</h6>
                        <div class="d-flex">
                            <img src="{{url('./assets/images/Clock.svg')}}" alt="">
                            <p class="ms-2">09:00 AM</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="event-name-dv">
                        <h5>Client Name</h5>
                        <h6>Type</h6>
                        <div class="d-flex">
                            <img src="{{url('./assets/images/Clock.svg')}}" alt="">
                            <p class="ms-2">09:00 AM</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="event-name-dv">
                        <h5>Client Name</h5>
                        <h6>Online</h6>
                        <div class="d-flex">
                            <img src="{{url('./assets/images/Clock.svg')}}" alt="">
                            <p class="ms-2">09:00 AM</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="event-name-dv">
                        <h5>Client/Event Name</h5>
                        <h6>Online</h6>
                        <div class="d-flex">
                            <img src="{{url('./assets/images/Clock.svg')}}" alt="">
                            <p class="ms-2">09:00 AM</p>
                        </div>
                    </div>
                </div>
                <h5 class="practitioner-profile-text mb-2">This month for you</span></h5>
                <div class="calendar">
                    <div id="calendar"></div>
                    <div id="eventModal" class="modal" style="display: none;">
                        <div class="modal-content">
                            <span class="close" id="closeModal">&times;</span>
                            <h2>Create Event</h2>
                            <form id="createEventForm">
                                <label for="eventTitle">Event Title:</label>
                                <input type="text" id="eventTitle" required>

                                <label for="eventDescription">Description:</label>
                                <textarea id="eventDescription"></textarea>

                                <label for="eventStartTime">Start Time:</label>
                                <input type="datetime-local" id="eventStartTime" required>

                                <label for="eventEndTime">End Time:</label>
                                <input type="datetime-local" id="eventEndTime" required>

                                <button type="submit">Save Event</button>
                            </form>
                        </div>
                    </div>
                </div>

                <div id="noteModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h3>Add Note</h3>
                        <p id="selectedDate"></p>
                        <label for="time">Select Time:</label>
                        <input type="time" id="time" required>
                        <label for="note">Note:</label>
                        <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>
                        <button id="saveNote">Save Note</button>
                    </div>
                </div>
                <h5 class="practitioner-profile-text mb-2">Browse other practitioners</span></h5>
                <div class="search-container mb-5">
                    <input type="text" class="search-input" name="endorsements" id="endorsements">
                    <button class="search-button" id="endorsementBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
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
    </section>

    <script>
        $(document).on('click', '#endorsementBtn', function (e) {
            e.preventDefault();
            let search = $('#endorsements').val();

            let imagePath = `{{env('media_path')}}`;
            let localPath = `{{env('local_path')}}`;
            let locationArr = @json($defaultLocations);
            console.log(locationArr);
            $.ajax({
                url: '/search/practitioner',
                type: 'get',
                data: {search},
                success: function (response) {
                    let endorsementHtml = '';

                    if (!response.practitioners || response.practitioners.length === 0) {
                        endorsementHtml = '<p class="text-center">No practitioners found.</p>';
                    } else {
                        for (let i = 0; i < response.practitioners.length; i += 3) {
                            endorsementHtml += '<div class="row mt-2">';

                            for (let j = i; j < i + 3 && j < response.practitioners.length; j++) {
                                let practitioner = response.practitioners[j];

                                let locationNames = '';

                                if (practitioner.location && practitioner.location.length > 0) {
                                    locationNames = JSON.parse(practitioner.location).map(function (locationId) {
                                        return locationArr[locationId] || 'location';
                                    }).slice(0, 2).join(', ');
                                    ;
                                } else {
                                    locationNames = 'no found';
                                }

                                let images = practitioner.user_detail?.images ? JSON.parse(practitioner.user_detail.images) : null;

                                let imageUrl = images?.profile_image
                                    ? `${imagePath}/practitioners/${practitioner.user_detail.id}/profile/${images.profile_image}`
                                    : `${localPath}/images/no_image.png`;
                                endorsementHtml += `
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <div class="browser-other-dv">
                                    <div class="d-flex justify-content-center">
                                       <img src="${imageUrl}" alt="person" class="img-fit img-fluid">
                                    </div>
                                    <h5>${practitioner.name}</h5>
                              <h6>${practitioner.bio && practitioner.bio.length > 0 ? practitioner.bio : ''}</h6>


                                    <div class="d-flex justify-content-between">

                                        <button class="endrose" id="endrose" data-user-id="${practitioner.id}">Endorse</button>


                                        <div class="miles"><i class="fa-solid fa-location-dot me-2"></i>${locationNames}</div>
                                    </div>
                                </div>
                            </div>
                        `;
                            }

                            endorsementHtml += '</div>';  // Close row
                        }
                    }

                    // Inject the generated HTML into the endorsement row container
                    $('#endorsementRow').html(endorsementHtml);
                }
            });
        });


        $(document).on('click', '#endrose', function (e) {
            e.preventDefault();

            // Get the user ID from the button's data attribute
            let userId = $(this).data('user-id');

            // Make the AJAX request
            $.ajax({
                url: `/setEndorsement/${userId}`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response)
                    alert('Endorsement added successfully!');
                },
                error: function (xhr, status, error) {
                    // On failure, log the error and alert the user
                    console.error('Error:', xhr.responseText);
                    alert('Failed to add endorsement!');
                }
            });
        });

    </script>
@endsection
