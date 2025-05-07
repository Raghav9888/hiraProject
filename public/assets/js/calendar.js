console.log('calendar.js');

function sendToServer(eventData) {

    let url = eventData.event_id ? '/calendar/update-event' : '/calendar/create-event'
    $.ajax({
        url: url,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(eventData),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {

            fetchEvents()
            alert('Event created successfully');
        },
        error: function (xhr) {
            alert('Error: ' + xhr.responseJSON.message);
        }
    });
}

$(document).ready(function () {
    if ($('#upcomingEventsRowDiv').length > 0) {
        upComingAppointments();
    }
});

function upComingAppointments() {
    $.ajax({
        url: '/calendar/up-coming-appointments',
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
            $('#upcomingAppointmentsDiv').empty();

            if (!response || !response.events || response.events.length === 0) {
                $('#upcomingAppointmentsDiv').append(`
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

                                <div class="d-flex">
                                    <img src="${window.location.origin}/assets/images/Clock.svg" alt="">
                                    <p class="ms-2">Start: ${formattedStartTime}</p>
                                </div>
                            </div>
                        </div>`;

                    $('#upcomingAppointmentsDiv').append(eventDiv);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error fetching events:", error);
        }
    });
}

$(document).ready(function () {
    $(document).on('click', '[data-type="hide"]', function () {

        let id = $(this).data('id');
        $(`#${id}`).toggleClass('d-none');
    });
});


if ($('#customCalendar').length > 0) {
    $('#customCalendar').removeClass('d-none');
    $('.spinner-border').addClass('d-none');
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDate = currentDate.getDate();

    let events = [];

    // Helper function to get color based on event type
    function getEventColor(category) {
        console.log(category)
        switch (category) {
            case 'Booking':
                return '#BA9B8B';
            case 'Community Events':
                return '#D8977A';
            case 'Meetings':
                return '#AED8B9';
            default:
                return '#E9DCCF';
        }
    }

    function fetchEvents() {
        $.ajax({
            url: '/calendar/events',
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response)
                if (response.error) {
                    window.location.href = response.redirect_url;
                } else {
                    events = response ?? [];
                    generateCalendar(currentMonth, currentYear);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error fetching events:", status, error);
            }
        });
    }

    function updateMonthLabel() {
        document.getElementById("monthLabel").innerText =
            `${new Date(currentYear, currentMonth).toLocaleString('default', {month: 'long'})} ${currentYear}`;
    }

    function generateYearDropdown() {
        const existingDropdown = document.getElementById("yearDropdown");
        if (existingDropdown) {
            existingDropdown.remove();
            return;
        }

        const yearDropdown = document.createElement("div");
        yearDropdown.classList.add("year-dropdown");
        yearDropdown.id = "yearDropdown";

        for (let i = currentYear - 10; i <= currentYear + 10; i++) {
            const yearOption = document.createElement("div");
            yearOption.classList.add("year-option");
            yearOption.innerText = i;
            yearOption.addEventListener("click", () => {
                currentYear = i;
                document.getElementById("yearDropdown").remove();
                updateMonthLabel();
                generateCalendar(currentMonth, currentYear);
            });
            yearDropdown.appendChild(yearOption);
        }

        document.getElementById("monthLabel").parentElement.appendChild(yearDropdown);
    }

    function getEventCreateForm(eventDate) {
        document.getElementById("eventDate").value = eventDate;
        document.getElementById("eventModalLabel").innerText = `Create Event for ${eventDate}`;

        // Show Bootstrap modal
        let eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
        eventModal.show();
    }

    function openEventModal(event) {
        console.log(event);


        document.getElementById("eventId").value = event.id || "";
        document.getElementById("eventTitle").value = event.title || "";
        document.getElementById("eventCategory").value = event.category || "";
        document.getElementById("eventDescription").value = event.description || "";

        // Format start & end time correctly for datetime-local input
        document.getElementById("eventStartTime").value = event.start ? event.start.substring(0, 16) : "";
        document.getElementById("eventEndTime").value = event.end ? event.end.substring(0, 16) : "";

        document.getElementById("eventDate").value = event.start ? event.start.split('T')[0] : "";

        document.getElementById("eventModalLabel").innerText = `Edit Event: ${event.title}`;

        let eventModal = new bootstrap.Modal(document.getElementById("eventModal"));
        eventModal.show();
    }



    if (document.getElementById("eventForm").length > 0) {
        document.getElementById("eventForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const eventData = {
                event_id: document.getElementById("eventId").value,
                title: document.getElementById("eventTitle").value,
                category: document.getElementById("eventCategory").value,
                description: document.getElementById("eventDescription").value,
                start: document.getElementById("eventStartTime").value,
                end: document.getElementById("eventEndTime").value,
                date: document.getElementById("eventDate").value
            };

            console.log("Event Data:", eventData);

            sendToServer(eventData);

            // Close modal
            let eventModal = bootstrap.Modal.getInstance(document.getElementById("eventModal"));
            eventModal.hide();
        });
    }

    function generateCalendar(month, year) {
        const calendarGrid = document.getElementById("calendarGrid");
        calendarGrid.innerHTML = "";

        const firstDay = new Date(year, month, 1).getDay();
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement("div");
            emptyCell.classList.add("calendar-cell", "empty");
            calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement("div");
            dayCell.classList.add("calendar-cell");
            dayCell.innerText = day;

            if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
                dayCell.classList.add("today");
            }

            if (day === selectedDate && month === currentMonth && year === currentYear) {
                dayCell.classList.add("active");
            }

            const eventDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;
            const dayEvents = events.filter(event => {
                if (!event.start) return false;
                let eventStartDate = event.start ? event.start.split('T')[0] : null;
                let eventEndDate = event.end ? event.end.split('T')[0] : eventStartDate;
                return eventStartDate && eventStartDate <= eventDate && eventEndDate >= eventDate;
            });

            if (dayEvents.length > 0) {
                let renderedEvents = new Set(); // Track already rendered events

                dayEvents.forEach(event => {
                    let eventStartDate = event.start.split('T')[0];
                    let eventEndDate = event.end ? event.end.split('T')[0] : eventStartDate;
                    let eventStart = new Date(eventStartDate);
                    let eventEnd = new Date(eventEndDate);
                    let eventDays = (eventEnd - eventStart) / (1000 * 60 * 60 * 24) + 1; // Duration in days

                    let eventLabel = document.createElement("div");

                    eventLabel.style.backgroundColor = getEventColor(event.category);
                    eventLabel.addEventListener("click", function (e) {
                        e.stopPropagation();
                        openEventModal(event);
                    });
                    if (eventStartDate !== eventEndDate && eventStartDate === eventDate && !renderedEvents.has(event.title)) {
                        eventLabel.classList.add("event-bar");
                        eventLabel.innerText = event.title;

                        // Calculate width based on number of days
                        let calendarCellWidth = document.querySelector(".calendar-cell").offsetWidth;
                        eventLabel.style.width = (calendarCellWidth * eventDays) + "px";
                        eventLabel.style.position = "absolute";
                        eventLabel.style.left = "0";
                        eventLabel.style.zIndex = "1";
                        eventLabel.style.top = "0";
                        eventLabel.style.right = "0";

                        renderedEvents.add(event.title);
                    } else if (eventStartDate === eventEndDate || eventStartDate === eventDate) {
                        eventLabel.classList.add("event-bar");
                        eventLabel.innerText = event.title;
                    } else {
                        eventLabel.classList.add("event-radio");
                        eventLabel.innerHTML = `<input type='radio' name='event-${eventDate}'/> ${event.title}`;
                    }

                    // Append only on the first occurrence of the event on that day
                    if (eventStartDate === eventDate) {
                        dayCell.appendChild(eventLabel);
                    }
                });
            }

            dayCell.addEventListener("click", function () {
                document.querySelectorAll(".calendar-cell.active").forEach(cell => cell.classList.remove("active"));
                dayCell.classList.add("active");
                selectedDate = day;
                getEventCreateForm(eventDate);
            });

            calendarGrid.appendChild(dayCell);
        }
    }

    document.getElementById("monthLabel").addEventListener("click", generateYearDropdown);

    document.getElementById("prevMonth").addEventListener("click", function () {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        selectedDate = null;
        updateMonthLabel();
        generateCalendar(currentMonth, currentYear);
    });

    document.getElementById("nextMonth").addEventListener("click", function () {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        selectedDate = null;
        updateMonthLabel();
        generateCalendar(currentMonth, currentYear);
    });

    updateMonthLabel();
    fetchEvents();
}

