@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="booking-calender-container">
                    <div class="col-md-9">
                        <h2 class="practitioner-profile-text mb-2 ">Booking Calendar</h2>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- Modal for Event Creation -->
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
@endsection
