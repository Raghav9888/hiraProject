console.log('calendar.js');
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dayMaxEvents: true,
        events: function(info, successCallback, failureCallback) {
            $.ajax({
                url: '/calendar/events',
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.error) {
                        window.location.href = response.redirect_url;
                    } else {
                        successCallback(response.events);
                    }
                },
            })
        },

        select: function (info) {
            console.log(info);
            const formatDateTime = (dateStr, allDay) => {
                return allDay ? `${dateStr}T00:00` : new Date(dateStr).toISOString().slice(0, 16);
            };

            document.getElementById('eventStartTime').value = formatDateTime(info.startStr, info.allDay);
            document.getElementById('eventEndTime').value = formatDateTime(info.endStr, info.allDay);

            document.getElementById('eventModal').style.display = 'block';
        },
        eventDrop: function (info) {
            // updateEvent(info.event);
        },
        eventClick: function (info) {
            if (confirm('Do you want to delete this event?')) {
                info.event.remove();
            }
        }
    });

    calendar.render();

    // Close modal functionality
    document.getElementById('closeModal').onclick = function () {
        document.getElementById('eventModal').style.display = 'none';
    };

    // Handle form submission
    document.getElementById('createEventForm').addEventListener('submit', function (event) {
        event.preventDefault();

        const eventData = {
            title: document.getElementById('eventTitle').value,
            description: document.getElementById('eventDescription').value,
            start_time: new Date(document.getElementById('eventStartTime').value).toISOString(),
            end_time: new Date(document.getElementById('eventEndTime').value).toISOString(),
        };

        sendToServer(eventData, calendar);
        document.getElementById('createEventForm').reset(); // Reset form fields
        document.getElementById('eventModal').style.display = 'none';
    });
});



function sendToServer(eventData, calendar) {
    $.ajax({
        url: '/calendar/create-events',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(eventData),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            calendar.addEvent(eventData);
            calendar.refetchEvents();
            alert('Event created successfully');
        },
        error: function (xhr) {
            alert('Error: ' + xhr.responseJSON.message);
        }
    });
}

$(document).ready(function () {
    if ($('#upcomingEventsRowDiv').length > 0) {
        upComingEvents();
    }
});

function upComingEvents() {
    $.ajax({
        url: '/calendar/up-coming-events',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#upcomingEventsRowDiv').empty(); // Clear the div before appending new content

            // Check if response is empty or events array is empty
            if (!response || !response.events || response.events.length === 0) {
                $('#upcomingEventsRowDiv').append(`
                    <div class="col-sm-12 my-4 text-center">
                       No results found
                    </div>
                `);
                return;
            }

            if (typeof response.events === 'object') {
                Object.values(response.events).forEach(event => {
                    if (!event.start || !event.end) return;

                    let eventStart = new Date(event.start);
                    let formattedStartTime = eventStart.toLocaleTimeString([], {
                        hour: '2-digit', minute: '2-digit', hour12: true
                    });

                    let eventDiv = `
                        <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                            <div class="event-name-dv">
                                <h5>${event.title ?? 'No Title'}</h5>
                                <h6>${event.description ?? 'Online/In-Person'}</h6>
                                <div class="d-flex">
                                    <img src="${window.location.origin}/assets/images/Clock.svg" alt="">
                                    <p class="ms-2">Start: ${formattedStartTime}</p>
                                </div>
                            </div>
                        </div>`;

                    $('#upcomingEventsRowDiv').append(eventDiv);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching events:", error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('booking_calendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        selectable: true,
        fixedWeekCount: true,
        dateClick: function (info) {
            if(info.dateStr < new Date().toISOString().slice(0, 10)){
                alert('You cannot book for past dates');
                return;
            }

            var selectedDate = info.dateStr;
            fetchTimeSlots(selectedDate);
        }
    });
    calendar.render();
});



fetchTimeSlots = (selectedDate) => {
    id = $('.product_id').val();

    $.ajax({
        url: `/calendar/time-slots/${selectedDate}/${id}`,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            console.log(response);
            $('.booking_date').val(selectedDate);

            let options = '<option value="">Select a Time Slot</option>';
            response.availableSlots.forEach(slot => {
                options += `<option value="${slot}">${slot}</option>`;
            });

            let selectHtml = `
                <label for="time_slot">Choose a Time Slot:</label>
                <select id="time_slot" name="booking_time" class="form-control">
                    ${options}
                </select>
            `;

            $('#showTimeSlot').html(selectHtml);
        },
        error: function (xhr) {
            console.log(xhr);
        }
    });
};


$(document).ready(function () {
    $(document).on('click', '[data-type="hide"]', function () {

        let id = $(this).data('id');
       $(`#${id}`).toggleClass('d-none');
    });
});





