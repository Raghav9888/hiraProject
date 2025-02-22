

document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        editable: true,
        selectable: true,
        dayMaxEvents: true,
        events: '/calendar/events',

        select: function (info) {
            document.getElementById('eventStartTime').value = info.startStr;
            document.getElementById('eventEndTime').value = info.endStr;
            document.getElementById('eventModal').style.display = 'block';
        },

        eventClick: function (info) {
            if (confirm('Do you want to delete this event?')) {
                info.event.remove();
                // You can also add an AJAX call here to delete the event from the backend
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
        event.preventDefault(); // Prevent default form submission

        const eventData = {
            title: document.getElementById('eventTitle').value,
            description: document.getElementById('eventDescription').value,
            start: new Date(document.getElementById('eventStartTime').value).toISOString(),
            end: new Date(document.getElementById('eventEndTime').value).toISOString(),
            // Get the color from the color input
            backgroundColor: document.getElementById('eventColor').value,
            borderColor: document.getElementById('eventColor').value, // Optional: change border color
        };

        // Add event to the calendar with the specified color
        calendar.addEvent(eventData);

        // Clear the form and close the modal
        document.getElementById('createEventForm').reset(); // Reset form fields
        document.getElementById('eventModal').style.display = 'none';
    });
});
