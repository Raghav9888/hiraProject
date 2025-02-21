@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')

                <h5 class="practitioner-profile-text mb-2 mt-5">Booking Calendar</h5>

                <div class="card">
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Modal for Adding & Editing Notes --}}
    <div id="noteModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 id="modalTitle">Add Note</h3>
            <p id="selectedDate"></p>
            <label for="time">Select Time:</label>
            <input type="time" id="time" required>
            <label for="note">Note:</label>
            <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>
            <button id="saveNote">Save Note</button>
            <button id="deleteEvent" class="btn btn-danger" style="display: none;">Delete Event</button>
        </div>
    </div>

    {{-- Styles --}}
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 8px;
            width: 300px;
            text-align: center;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .close {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }

    </style>

    {{-- JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var noteModal = document.getElementById('noteModal');
            var closeModal = document.querySelector('.close');
            var saveNoteBtn = document.getElementById('saveNote');
            var deleteEventBtn = document.getElementById('deleteEvent');
            var selectedEvent = null;

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                editable: true,
                dayMaxEvents: true,
                navLinks: true,
                selectable: true,
                selectMirror: true,

                // Add Event
                select: function (arg) {
                    selectedEvent = null;
                    document.getElementById('modalTitle').textContent = "Add Note";
                    document.getElementById('selectedDate').textContent = arg.startStr;
                    document.getElementById('time').value = ''; // Reset time input
                    document.getElementById('note').value = ''; // Reset note input
                    saveNoteBtn.textContent = "Save Note";
                    deleteEventBtn.style.display = 'none';
                    noteModal.style.display = 'flex';

                    // Save event
                    saveNoteBtn.onclick = function () {
                        let time = document.getElementById('time').value;
                        let note = document.getElementById('note').value;

                        if (time && note.trim() !== '') {
                            let event = {
                                title: note,
                                start: arg.startStr + 'T' + time,
                                allDay: false
                            };
                            calendar.addEvent(event);
                            noteModal.style.display = 'none';
                        } else {
                            alert('Please enter a valid note and time.');
                        }
                    };
                },

                eventClick: function (arg) {
                    selectedEvent = arg.event;
                    document.getElementById('modalTitle').textContent = "Edit Event";
                    document.getElementById('selectedDate').textContent = arg.event.start.toISOString().split('T')[0];
                    document.getElementById('time').value = arg.event.start.toISOString().substring(11, 16);
                    document.getElementById('note').value = arg.event.title;
                    saveNoteBtn.textContent = "Update Event";
                    deleteEventBtn.style.display = 'block';
                    noteModal.style.display = 'flex';

                    // Update event
                    saveNoteBtn.onclick = function () {
                        let updatedTime = document.getElementById('time').value;
                        let updatedNote = document.getElementById('note').value;

                        if (updatedTime.trim() !== '' && updatedNote.trim() !== '') {
                            selectedEvent.setProp('title', updatedNote);
                            selectedEvent.setStart(selectedEvent.start.toISOString().split('T')[0] + 'T' + updatedTime);
                            noteModal.style.display = 'none';
                        } else {
                            alert('Please enter a valid note and time.');
                        }
                    };

                    deleteEventBtn.onclick = function () {
                        if (confirm('Are you sure you want to delete this event?')) {
                            selectedEvent.remove();
                            noteModal.style.display = 'none';
                        }
                    };
                },

                events: 'https://fullcalendar.io/api/demo-feeds/events.json?overload-day'
            });

            calendar.render();

            closeModal.addEventListener('click', function () {
                noteModal.style.display = 'none';
            });

            window.addEventListener('click', function (event) {
                if (event.target === noteModal) {
                    noteModal.style.display = 'none';
                }
            });
        });
    </script>

@endsection
