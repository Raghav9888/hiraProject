
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dayMaxEvents: true,
        events: '/calendar/events',

        select: function (info) {
            console.log(info);
            const formatDateTime = (dateStr, allDay) => {
                return allDay ? `${dateStr}T00:00` : new Date(dateStr).toISOString().slice(0, 16);
            };

            document.getElementById('eventStartTime').value = formatDateTime(info.startStr, info.allDay);
            document.getElementById('eventEndTime').value = formatDateTime(info.endStr, info.allDay);

            document.getElementById('eventModal').style.display = 'block';
        },
        eventDrop: function (info)
        {

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

        sendToServer(eventData ,calendar);
        document.getElementById('createEventForm').reset(); // Reset form fields
        document.getElementById('eventModal').style.display = 'none';
    });

});


function sendToServer(eventData,calendar) {
    $.ajax({
        url: '/calendar/create-events',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(eventData),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            calendar.addEvent(eventData);
            calendar.refetchEvents();
            alert('Event created successfully');
        },
        error: function(xhr) {
            alert('Error: ' + xhr.responseJSON.message);
        }
    });
}


