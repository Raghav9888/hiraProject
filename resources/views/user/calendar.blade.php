{{--@extends('layouts.app')--}}
{{--@section('content')--}}
{{--    <section class="practitioner-profile">--}}
{{--        <div class="container">--}}
{{--            @include('layouts.partitioner_sidebar')--}}
{{--            <div class="row">--}}
{{--                @include('layouts.partitioner_nav')--}}
{{--                <h5 class="practitioner-profile-text mb-2 mt-5">Booking Calendar</span></h5>--}}
{{--                <div class="calendar">--}}
{{--                    <div class="controls">--}}
{{--                        <select id="monthSelect">--}}
{{--                            <option value="0">January</option>--}}
{{--                            <option value="1">February</option>--}}
{{--                            <option value="2">March</option>--}}
{{--                            <option value="3">April</option>--}}
{{--                            <option value="4">May</option>--}}
{{--                            <option value="5">June</option>--}}
{{--                            <option value="6">July</option>--}}
{{--                            <option value="7">August</option>--}}
{{--                            <option value="8">September</option>--}}
{{--                            <option value="9">October</option>--}}
{{--                            <option value="10">November</option>--}}
{{--                            <option value="11">December</option>--}}
{{--                        </select>--}}
{{--                        <button id="resetCalendar">Reset Calendar</button>--}}
{{--                    </div>--}}
{{--                    <div class="calendar-grid">--}}
{{--                    </div>--}}
{{--                </div>--}}

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
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}


{{--<h2>Google Calendar Events</h2>--}}
{{--<div id="calendar"></div>--}}

{{--<script>--}}
{{--    document.addEventListener('DOMContentLoaded', function () {--}}
{{--        var calendarEl = document.getElementById('calendar');--}}

{{--        var calendar = new FullCalendar.Calendar(calendarEl, {--}}
{{--            initialView: 'dayGridMonth',--}}
{{--            events: function(fetchInfo, successCallback, failureCallback) {--}}
{{--                axios.get('{{ route("calendarEvents") }}')--}}
{{--                    .then(response => {--}}
{{--                        let events = response.data.map(event => ({--}}
{{--                            title: event.title,--}}
{{--                            start: event.start,--}}
{{--                            end: event.end--}}
{{--                        }));--}}
{{--                        successCallback(events);--}}
{{--                    })--}}
{{--                    .catch(error => {--}}
{{--                        console.error('Error fetching events:', error);--}}
{{--                        failureCallback(error);--}}
{{--                    });--}}
{{--            }--}}
{{--        });--}}

{{--        calendar.render();--}}
{{--    });--}}
{{--</script>--}}
{{--@endsection--}}
@extends('layouts.app')

@section('content')
    <div id="calendar"></div>

    <script>
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                events: @json(`${events}`),
                eventRender: function(event, element) {
                    element.attr('title', event.title); // Optional: Tooltip on hover
                },
                editable: true, // Allow dragging and dropping of events
                droppable: true, // Allow event drop
                displayEventTime: true, // Display event time on the calendar
            });
        });
    </script>
@endsection


