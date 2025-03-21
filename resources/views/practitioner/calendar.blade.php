@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="booking-calender-container">
                    <div class="row">
                        <div class="col-md-9">
                            <h2 class="practitioner-profile-text mb-2 ">Booking Calendar</h2>
                        </div>
                    </div>
                    <div class="row my-4">
                        <div class="col-md-9">
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
                        <div class="col-md-3">
                            <h1 class="practitioner-profile-text mb-2"
                                style="font-weight:700;font-size: 32px; line-height: 100%;letter-spacing: 1px;color: #424E3E;border-bottom: 3px solid #BA9B8B;">
                                Featured</h1>

                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px;height: 30px;background: #BA9B8B;border-radius: 8px;"></div>
                                <div  style="font-size: 16px;font-weight: bold;color: black; margin-left: 10px;">Booking</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px;height: 30px;background: #D8977A;;border-radius: 8px;"></div>
                                <div  style="font-size: 16px;font-weight: bold;color: black; margin-left: 10px;">Community Events</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px;height: 30px;background: #E9DCCF;border-radius: 8px;"></div>
                                <div  style="font-size: 16px;font-weight: bold;color: black; margin-left: 10px;">Personal</div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 30px;height: 30px;background: #AED8B9;border-radius: 8px;"></div>
                                <div  style="font-size: 16px;font-weight: bold;color: black; margin-left: 10px;">Meetings</div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
