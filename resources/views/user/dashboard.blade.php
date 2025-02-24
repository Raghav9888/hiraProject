@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')

            <div class="row">
                <div class="col-sm-12 col-lg-5"></div>
                @include('layouts.partitioner_nav')
                <div class="px-0 my-3 community-text col-sm-12">
                    <h5 class="practitioner-profile-text">Upcoming <span style="font-weight: 800;">community
                            events</span></h5>
                </div>
            </div>
            <div class="row" id="upcomingEventsRowDiv">
                {{-- We show the data by ajax --}}
                <div class="col-sm-12 my-4 text-center">
                    loading...
                </div>
            </div>
            <div class="row" id="upcomingAppointmentsRowDiv">
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
                    <div class="controls">
                        <select id="monthSelect">
                            <option value="0">January</option>
                            <option value="1">February</option>
                            <option value="2">March</option>
                            <option value="3">April</option>
                            <option value="4">May</option>
                            <option value="5">June</option>
                            <option value="6">July</option>
                            <option value="7">August</option>
                            <option value="8">September</option>
                            <option value="9">October</option>
                            <option value="10">November</option>
                            <option value="11">December</option>
                        </select>
                        <button id="resetCalendar">Reset Calendar</button>
                    </div>
                    <div class="calendar-grid">
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

