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

                @if(count($offerings) > 0)
                    @foreach($offerings as $date => $offering)
                        @php
                            $imageUrl = $offering->featured_image
                                ? asset(env('media_path') . "/practitioners/{$userDetails->id}/offering/{$offering->featured_image}")
                                : asset(env('local_path') . '/images/no_image.png');
                        @endphp

                        <div class="col-sm-3 my-4 text-center">
                            <div class="event-name-dv">
                            <div class="row">
                                <div class="col-md-4">
                                    <img src="{{$imageUrl}}" alt="offering img" class="img-fluid">
                                </div>
                                <div class="col-md-8">

                                        <h5>{{$offering?->name}}</h5>
                                        <h6>{{$offering?->short_description}}</h6>
                                        <div class="d-flex">
                                            <img src="{{url('./assets/images/Clock.svg')}}" alt="">
                                            <p class="ms-2">{{$date}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div>No upcoming events found.</div>
                @endif
            </div>
            <div class="row ms-5 pb=5">
                <div class="col-12 px-0" style="border-bottom: 2px solid#BA9B8B; margin-bottom: 20px;">
                    <h5 class="practitioner-profile-text mb-2">Upcoming <span
                            style="font-weight: 800;">appointments</span></h5>
                </div>
                <div class="col-12" id="upcomingAppointmentsDiv">
                    {{-- We show the data by ajax --}}
                    <div class="col-sm-12 my-4 text-center">
                        loading...
                    </div>
                </div>
            </div>
            <div class="row ms-5 mt-3">
                <h5 class="practitioner-profile-text mb-2">This month for you</span></h5>
                {{--                <div class="calendar">--}}
                {{--                    <div id="calendar"></div>--}}
                {{--                    <div id="eventModal" class="modal" style="display: none;">--}}
                {{--                        <div class="modal-content">--}}
                {{--                            <span class="close" id="closeModal">&times;</span>--}}
                {{--                            <h2>Create Event</h2>--}}
                {{--                            <form id="createEventForm">--}}
                {{--                                <label for="eventTitle">Event Title:</label>--}}
                {{--                                <input type="text" id="eventTitle" required>--}}

                {{--                                <label for="eventDescription">Description:</label>--}}
                {{--                                <textarea id="eventDescription"></textarea>--}}

                {{--                                <label for="eventStartTime">Start Time:</label>--}}
                {{--                                <input type="datetime-local" id="eventStartTime" required>--}}

                {{--                                <label for="eventEndTime">End Time:</label>--}}
                {{--                                <input type="datetime-local" id="eventEndTime" required>--}}

                {{--                                <button type="submit">Save Event</button>--}}
                {{--                            </form>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <div class="row my-4">
                    <div class="col-md-12">
                        <div class="card rounded h-100">
                            <div class="card-body">
                                <div id="customCalendar" class="d-none">
                                    <div class="bg-light p-3 rounded mb-4">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <button class="btn text-green" id="prevMonth">
                                                <i class="fas fa-chevron-left"></i>
                                            </button>
                                            <span class="mx-3 text-green fw-medium"
                                                  id="monthLabel">March 2025</span>
                                            <button class="btn text-green" id="nextMonth">
                                                <i class="fas fa-chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="calendar-grid text-green fw-medium">
                                        <div>Su</div>
                                        <div>Mo</div>
                                        <div>Tu</div>
                                        <div>We</div>
                                        <div>Th</div>
                                        <div>Fr</div>
                                        <div>Sa</div>
                                    </div>
                                    <div class="calendar-grid mt-2" id="calendarGrid">
                                    </div>
                                </div>

                                <div class="text-center">
                                    <div class="spinner-border" style="width: 3rem; height: 3rem;"
                                         role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--                <div id="noteModal" class="modal">--}}
                {{--                    <div class="modal-content">--}}
                {{--                        <span class="close">&times;</span>--}}
                {{--                        <h3>Add Note</h3>--}}
                {{--                        <p id="selectedDate"></p>--}}
                {{--                        <label for="time">Select Time:</label>--}}
                {{--                        <input type="time" id="time" required>--}}
                {{--                        <label for="note">Note:</label>--}}
                {{--                        <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>--}}
                {{--                        <button id="saveNote">Save Note</button>--}}
                {{--                    </div>--}}
                {{--                </div>--}}
                <h5 class="practitioner-profile-text mb-2">Browse other practitioners</span></h5>
                <div class="search-container mb-5">
                    <input type="text" class="search-input" name="endorsements" id="endorsements">
                    <button class="search-button" id="endorsementBtn">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="row">
                    <h4>Endorsements </h4>
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
                                                    $endorsedUserLocations = isset($endorsedUser->location) && $endorsedUser->location ? json_decode($endorsedUser->location, true) : [];
                                                @endphp

                                                @if(!empty($endorsedUserLocations))
                                                    @foreach($endorsedUserLocations as $endorsedUserLocation)
                                                        @foreach($defaultLocations as $key => $defaultLocation)
                                                            @if(in_array($key, $endorsedUserLocations))
                                                                <i class="fa-solid fa-location-dot"></i> {{ $defaultLocation }}
                                                                ,
                                                            @endif
                                                        @endforeach
                                                    @endforeach
                                                @endif


                                            </h5>
                                            <p style="display: inline; text-align: center">{{$endorsedUser->userDetail->company}}</p>
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


    @include('practitioner.event_form')

    <script>
        let typingTimer;
        const doneTypingInterval = 500; // Adjust delay time as needed

        $("#endorsements").on('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                searchPractitioner();
            }, doneTypingInterval);
        });

        function searchPractitioner() {
            const search = $("#endorsements").val();

            let imagePath = `{{env('media_path')}}`;
            let localPath = `{{env('local_path')}}`;
            let locationArr = @json($defaultLocations);

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

                            endorsementHtml += '</div>'; // Close row
                        }
                    }

                    // Inject the generated HTML into the endorsement row container
                    $('#endorsementRow').html(endorsementHtml);
                }
            });
        }


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
