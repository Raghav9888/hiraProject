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
                                <i class="fa-regular fa-heart"></i>
                                <i class="fa-solid fa-share-nodes"></i>
                            </div>
                        </div>
                        <h5>{{$userDetails->company ??'Alternative and Holistic Health Practitioner' }}</h5>
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
                                                    <button  class="home-blog-btn"  onclick="openPopup(event)" data-offering-id="{{$offering->id}}" data-availability="{{$offering?->availability_type ?? ''}}">BOOK NOW</button>

{{--                                                    <a href="{{ route('practitionerOfferingDetail',$offering->id)}}" class="home-blog-btn">BOOK NOW</a>--}}
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
                                                    <div class="toggle-dv-review mt-3">
                                                        <div class="d-flex mb-2" style="gap: 20px;">
                                                            <button>Events</button>
                                                            {{--                                                            <button--}}
                                                            {{--                                                                style="background-color: transparent;color: #9F8B72;">--}}
                                                            {{--                                                                Reviews--}}
                                                            {{--                                                            </button>--}}
                                                        </div>
                                                        <p class="mb-1"><span class="mr-2">Scheduling Window: {{@$offering->scheduling_window}}</span> | Client Price: {{@$offering->client_price}}</p>
                                                        <p><span class="mr-2">Date Time: {{@$offering->event->date_and_time? date('d M, Y', strtotime($offering->event->date_and_time)): ''}}</span> | Event Duration: {{@$offering->event->event_duration}}</p>
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
    <input type="hidden" name="availability" id="availability">
    <input type="hidden" name="offering_price" id="offering_price">
    <input type="hidden" name="booking_date" id="booking_date">
    <input type="hidden" name="booking_time" id="booking_time">

    <!-- Popup Structure -->
    <div id="popup" class="popup-overlay">
        <div class="popup-content">
            {{--            <span class="close-btn" onclick="closePopup()">&times;</span>--}}
            <div class="booking-container">
                @include('user.offering_detail_page')
            </div>
            <div class="login-container" style="display: none">
            </div>
        </div>
    </div>
    <script>
        function openPopup(event) {
            event.preventDefault();

            let offeringId = event.target.getAttribute('data-offering-id');
            let availabilityData = event.target.getAttribute('data-availability');
            let priceData = event.target.getAttribute('data-price');
            let inputElement = document.querySelector('[name="offering_id"]');
            let availabilityInput = document.querySelector('[name="availability"]');
            let offeringPriceInput = document.querySelector('[name="offering_price"]');

            let popupElement = document.getElementById('popup');

            if (inputElement) {
                inputElement.value = offeringId;
                inputElement.classList.add('activeInput');
                availabilityInput.value = availabilityData;
                offeringPriceInput.value = priceData;
            } else {
                console.error("Element with ID 'offering_id' not found");
            }

            if (popupElement) {
                popupElement.style.display = 'block';
                generateCalendar(currentMonth, currentYear);
            } else {
                console.error("Element with ID 'popup' not found");
            }


        }

        function closePopup() {
            let inputElement = document.getElementById('offering_hidden_id');
            let popupElement = document.getElementById('popup');

            if (inputElement) {
                inputElement.value = '';
            }

            if (popupElement) {
                popupElement.style.display = 'none';
            }
        }


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

    <script>
        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let activeDate = formatDate(currentDate);


        const availableSlotsData = {
            '2025-03-18': ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM'],
            '2025-03-19': ['9:00 AM', '10:00 AM', '11:00 AM'],
            '2025-03-20': ['2:00 PM', '3:00 PM'],
            '2025-09-21': ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM'],
        };


        function formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        }

        function getAllowedDays() {
            let availability = document.getElementById('availability')?.value || 'own_specific_date';
            let dayMapping = {
                "every_monday": [1],
                "every_tuesday": [2],
                "every_wednesday": [3],
                "every_thursday": [4],
                "every_friday": [5],
                "weekend_every_saturday_sunday": [0, 6],
                "every_day": [0, 1, 2, 3, 4, 5, 6],
                "own_specific_date": []
            };
            return dayMapping[availability] || [];
        }

        function generateCalendar(month, year) {
            console.log(month ,year)
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const calendarGrid = document.getElementById('calendarGrid');
            const monthLabel = document.getElementById('monthLabel');
            calendarGrid.innerHTML = '';

            monthLabel.innerText = `${firstDay.toLocaleString('default', {month: 'long'})} ${year}`;
            const daysInMonth = lastDay.getDate();
            const startDay = firstDay.getDay();
            const allowedDays = getAllowedDays();

            for (let i = 0; i < startDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('inactive');
                calendarGrid.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('dates');
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
                const currentDayOfWeek = new Date(year, month, day).getDay();

                if (dateString === formatDate(currentDate)) {
                    dayCell.classList.add('active');
                    activeDate = dateString;
                }

                if (
                    (!availableSlotsData[dateString] && allowedDays.length > 0 && !allowedDays.includes(currentDayOfWeek)) &&
                    document.getElementById('availability')?.value !== 'own_specific_date'
                ) {
                    dayCell.classList.add('inactive');
                }

                dayCell.innerText = day;
                dayCell.setAttribute('data-date', dateString);

                dayCell.addEventListener('click', () => {
                    if (
                        (!availableSlotsData[dateString] && allowedDays.length > 0 && !allowedDays.includes(currentDayOfWeek)) &&
                        document.getElementById('availability')?.value !== 'own_specific_date'
                    ) {
                        return;
                    }

                    if (activeDate) {
                        document.querySelector(`[data-date='${activeDate}']`)?.classList.remove('active');
                    }

                    activeDate = dateString;
                    dayCell.classList.add('active');
                    fetchCalendarTimeSlots(activeDate);
                    showAvailableSlots(activeDate);
                });

                calendarGrid.appendChild(dayCell);
                $('.calendar-grid .dates').on('click', function(){
                    const date = $(this).data('date');
                    $('#booking_date').val(date);
                })
            }

            fetchCalendarTimeSlots(activeDate);
            showAvailableSlots(activeDate);
        }

        function fetchCalendarTimeSlots(selectedDate) {
            let inputElement = document.getElementById('offering_id');

            if (!inputElement) {
                console.error("Element with ID 'offering_id' not found");
                return;
            }

            let id = inputElement.value;
            if (!id || id === "undefined") {
                return;
            }

            let encodedDate = encodeURIComponent(selectedDate);

            $.ajax({
                url: `/calendar/time-slots/${encodedDate}/${id}`,
                type: 'GET',
                success: function (response) {
                    console.log('Success:', response);
                },
                error: function (xhr) {
                    console.error('Error:', xhr);
                }
            });
        }

        function showAvailableSlots(date) {
            const slotsContainer = document.getElementById('availableSlots');
            const dateLabel = document.getElementById('selectedDate');
            slotsContainer.innerHTML = '';
            dateLabel.innerText = date.split('-').reverse().join('/');

            let availableSlots = availableSlotsData[date] || [];

            if (availableSlots.length === 0) {
                slotsContainer.innerHTML = '<p class="text-muted">No available slots</p>';
            } else {
                availableSlots.forEach(slot => {
                    const slotButton = document.createElement('div');
                    slotButton.classList.add('col-4');
                    slotButton.innerHTML = `<button class="btn btn-outline-green w-100 offering-slot" data-time=${slot}>${slot}</button>`;
                    slotsContainer.appendChild(slotButton);
                });
                $('.offering-slot').on('click', function(){
                    $('.offering-slot').removeClass('active')
                    $(this).addClass('active')
                    const time = $(this).data('time');
                    $('#booking_time').val(time)
                })
            }
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

        $('.proceed_to_checkout').on('click', function(){
            const offeringId = $('#offering_id').val();
            const bookingDate = $('#booking_date').val();
            const bookingTime = $('#booking_time').val();
            if(!offeringId || !bookingDate || !bookingTime){
                alert("Please select slot!");
                return;
            }
            $.ajax({
                type:"POST",
                url: "{{route('storeBooking')}}",
                headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                data: {
                    offering_id: offeringId,
                    booking_date: bookingDate,
                    booking_time: bookingTime 
                },
                success:function(response){
                    if(!response.success){
                        alert("Something went wrong!")
                    }
                    console.log(response);
                    $('.booking-container').hide();
                    $('.login-container').show();
                    $('.login-container').html(response.html);
                    $('.popup-content').css('width', "60%")
                    $('.popup-content').css('background-color', "transparent")
                    $('.popup-content .container').css('padding', "30px")
                },
                error:function(error){
                    alert("Something went wrong!")
                }
            })
        })

    </script>
@endsection
