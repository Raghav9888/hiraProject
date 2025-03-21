console.log('calendar.js');
document.addEventListener('DOMContentLoaded', function () {
    let calendarEl = document.getElementById('calendar');

    if (calendarEl) {

        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            editable: true,
            selectable: true,
            dayMaxEvents: true,
            events: function (info, successCallback, failureCallback) {
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
                            successCallback(response);
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error("Error fetching events:", status, error);
                        failureCallback(error);
                    }
                });
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
    }

    if (document.getElementById('closeModal')) {

        // Close modal functionality
        document.getElementById('closeModal').onclick = function () {
            document.getElementById('eventModal').style.display = 'none';
        };
    }

    if (document.getElementById('createEventForm')) {

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
    }
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
            $('#upcomingEventsRowDiv').empty();

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
    if (calendarEl) {

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            selectable: true,
            fixedWeekCount: true,
            dateClick: function (info) {
                if (info.dateStr < new Date().toISOString().slice(0, 10)) {
                    alert('You cannot book for past dates');
                    return;
                }

                var selectedDate = info.dateStr;
                // fetchTimeSlots(selectedDate);
            }
        });
        calendar.render();
    }
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


if ($('#customCalendar').length > 0) {
    $('#customCalendar').removeClass('d-none');
    $('.spinner-border').addClass('d-none');
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let selectedDate = currentDate.getDate();

    let events = [];

    function fetchEvents() {
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
                let eventStartDate = event.start.split('T')[0];
                let eventEndDate = event.end ? event.end.split('T')[0] : eventStartDate;
                return eventStartDate <= eventDate && eventEndDate >= eventDate;
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

                    if (eventStartDate !== eventEndDate && eventStartDate === eventDate && !renderedEvents.has(event.title)) {
                        eventLabel.classList.add("event-bar");
                        eventLabel.innerText = event.title;

                        // Calculate width based on number of days
                        // Styling for multi-day events
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

                    // Append only on the first occurrence
                    if (eventStartDate === eventDate) {
                        dayCell.appendChild(eventLabel);
                    }
                });
            }


            dayCell.addEventListener("click", function () {
                document.querySelectorAll(".calendar-cell.active").forEach(cell => cell.classList.remove("active"));
                dayCell.classList.add("active");
                selectedDate = day;
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
