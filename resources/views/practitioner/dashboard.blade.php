@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>
                <div class="col-md-12">
                    <div class="row pb-3">
                        <div class="col-md-12 mb-3" style="border-bottom: 2px solid#715549; margin-bottom: 20px;">
                            <h5 class="practitioner-profile-text">Upcoming
                                <span style="font-weight: 800;">community events</span>
                            </h5>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="row pb-3" id="upcomingEventsRowDiv">

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
                                                        {{--                                                    <h6>{{$offering?->short_description}}</h6>--}}
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
                        </div>

                    </div>

                    <div class="row pb-3">
                        <div class="col-12 px-0" style="border-bottom: 2px solid#715549; margin-bottom: 20px;">
                            <h5 class="practitioner-profile-text mb-2">Upcoming <span
                                    style="font-weight: 800;">appointments</span></h5>
                        </div>
                        <div class="row" id="upcomingAppointmentsDiv">
                            {{-- We show the data by ajax --}}
                            <div class="col-sm-12 my-4 text-center">
                                loading...
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <h5 class="practitioner-profile-text mb-2">This month for you</span></h5>
                        <div class="row my-4">
                            <div class="col-md-12">
                                <div class="card rounded h-100">
                                    <div class="card-body">
                                        <div id="customCalendar" class="d-none">
                                            <div class="bg-light p-3 rounded mb-4">
                                                <div class="d-flex justify-content-center align-items-center">
                                                    <button class="btn text-green" id="dashboardCalenderPrevMonth">
                                                        <i class="fas fa-chevron-left"></i>
                                                    </button>
                                                    <span class="mx-3 text-green fw-medium"
                                                          id="monthLabel">March 2025</span>
                                                    <button class="btn text-green" id="dashboardCalenderNextMonth">
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

                                        <div class="col-sm-12 col-md-6 col-lg-3 mb-4 endorsement-card"
                                             data-id="{{ $endorsedUser->id }}">
                                            <div class="featured-dv">
                                                <div class="position-relative">
                                                    <button type="button"
                                                            class="text-danger position-absolute top-0 end-0 btn delete-endorsed-user"
                                                            data-id="{{ $endorsedUser->id }}"
                                                            title="Remove Endorsement">
                                                        <i class="fa-solid fa-xmark text-danger"></i>
                                                    </button>
                                                    <img src="{{ $imageUrl }}" alt="person" class="img-fluid">
                                                </div>

                                                <a href="{{route('practitioner_detail', $endorsedUser->id)}}">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h4>{{  $endorsedUser->name }}</h4>
                                                        <i class="fa-regular fa-heart"></i>
                                                    </div>
                                                    <h5>
                                                        @php
                                                            $endorsedUserLocations = isset($endorsedUser->location) && $endorsedUser->location ? json_decode($endorsedUser->location, true) : [];
                                                        @endphp

                                                        @if(!empty($endorsedUserLocations))
                                                            @foreach($defaultLocations as $key => $defaultLocation)
                                                                @if(in_array($key, $endorsedUserLocations))
                                                                    <i class="fa-solid fa-location-dot"></i> {{ $defaultLocation }}
                                                                    ,
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </h5>
                                                    <p style="text-align: center">{{ $endorsedUser->userDetail->company }}</p>
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
        </div>
    </section>


    @include('practitioner.event_form')

    <script>
        let typingTimer;
        const doneTypingInterval = 500;

        $("#endorsements").on('input', function () {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(function () {
                searchPractitioner();
            }, doneTypingInterval);
        });

        function searchPractitioner() {
            const search = $("#endorsements").val();

            let imagePath = `{{ env('media_path') }}`;
            let localPath = `{{ env('local_path') }}`;
            let locationArr = @json($defaultLocations);

            $("#endorsementRow").html('<p class="text-center">Searching...</p>');

            $.ajax({
                url: '/endorsement-practitioner',
                type: 'get',
                data: {'search': search},
                success: function (response) {
                    let endorsementHtml = '';

                    if (!response.practitioners || response.practitioners.length === 0) {
                        endorsementHtml = '<p class="text-center">No practitioners found.</p>';
                    } else {
                        for (let i = 0; i < response.practitioners.length; i += 3) {
                            endorsementHtml += '<div class="row mt-2">';

                            for (let j = i; j < i + 3 && j < response.practitioners.length; j++) {
                                let practitioner = response.practitioners[j];

                                let locationData = [];

                                try {
                                    locationData = Array.isArray(practitioner.location)
                                        ? practitioner.location
                                        : JSON.parse(practitioner.location || "[]");
                                } catch (e) {
                                    locationData = [];
                                }

                                let locationNames = locationData.map(locId => locationArr[locId] || 'location')
                                    .slice(0, 2)
                                    .join(', ');

                                let images = null;
                                try {
                                    images = practitioner.user_detail?.images
                                        ? JSON.parse(practitioner.user_detail.images)
                                        : null;
                                } catch (e) {
                                    images = null;
                                }

                                let imageUrl = images?.profile_image
                                    ? `${imagePath}/practitioners/${practitioner.user_detail?.id}/profile/${images.profile_image}`
                                    : `${localPath}/images/no_image.png`;

                                // Trim bio to 50 words
                                let bio = practitioner.bio || '';
                                let bioWords = bio.split(" ");
                                let shortBio = bioWords.slice(0, 20).join(" ");
                                if (bioWords.length > 20) shortBio += "...";

                                endorsementHtml += `
                                <div class="col-sm-12 col-md-6 col-lg-4">
                                    <div class="browser-other-dv">
                                        <div class="d-flex justify-content-center">
                                            <img src="${imageUrl}" alt="person" class="img-fit img-fluid"
                                                onerror="this.onerror=null;this.src='${localPath}/images/no_image.png';">
                                        </div>
                                        <h5>${practitioner.name}</h5>
                                        <h6>${shortBio}</h6>
                                        <div class="d-flex justify-content-between">
                                            <button class="endrose-btn" data-user-id="${practitioner.id}">Endorse</button>
                                            <div class="miles">
                                                <i class="fa-solid fa-location-dot me-2"></i>${locationNames}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            }

                            endorsementHtml += '</div>'; // Close row
                        }
                    }

                    $('#endorsementRow').html(endorsementHtml);
                }
            });
        }

        $(document).on('click', '.endrose-btn', function (e) {
            e.preventDefault();

            let userId = $(this).data('user-id');

            $.ajax({
                url: `/setEndorsement/${userId}`,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    alertify.success('Endorsement added successfully!');
                },
                error: function (xhr) {
                    console.error('Error:', xhr.responseText);
                    alertify.error('Failed to add endorsement!');
                }
            });
        });


        $(document).on('click', '.delete-endorsed-user', function () {
            const userId = $(this).data('id');
            const card = $(this).closest('.endorsement-card');

            if (!confirm('Are you sure you want to remove this endorsement?')) return;

            $.ajax({
                url: `/remove-endorsement/${userId}`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        card.remove();
                        alertify.success(response.success);
                    } else {
                        alertify.error(response.error || 'Unable to remove endorsement.');
                    }
                },
                error: function () {
                    alertify.error('An error occurred. Please try again.');
                }
            });
        });


    </script>

@endsection
