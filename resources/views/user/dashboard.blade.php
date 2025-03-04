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
                    <input type="text" class="search-input">
                    <button class="search-button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="browser-other-dv">
                        <div class="d-flex justify-content-center">
                            <img class="mt-5 mb-3" src="{{ url('/assets/images/question-mark.svg') }}" alt="">
                        </div>
                        <h5>John Doe</h5>
                        <h6>Alternative and Holistic <br/>Health Practitioner</h6>
                        <div class="d-flex justify-content-between">
                            <div class="endrose">Endrose</div>
                            <div class="miles"><i class="fa-solid fa-location-dot me-2"></i>0.3 km</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="browser-other-dv">
                        <div class="d-flex justify-content-center">
                            <img class="mt-5 mb-3" src="{{ url('/assets/images/question-mark.svg') }}" alt="">
                        </div>
                        <h5>John Doe</h5>
                        <h6>Alternative and Holistic <br/>Health Practitioner</h6>
                        <div class="d-flex justify-content-between">
                            <div class="endrose">Endrose</div>
                            <div class="miles"><i class="fa-solid fa-location-dot me-2"></i>0.3 km</div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="browser-other-dv">
                        <div class="d-flex justify-content-center">
                            <img class="mt-5 mb-3" src="{{ url('/assets/images/question-mark.svg') }}" alt="">
                        </div>
                        <h5>John Doe</h5>
                        <h6>Alternative and Holistic <br/>Health Practitioner</h6>
                        <div class="d-flex justify-content-between">
                            <div class="endrose">Endrose</div>
                            <div class="miles"><i class="fa-solid fa-location-dot me-2"></i>0.3 km</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

