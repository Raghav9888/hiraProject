console.log('bookeding_calendar.js loaded');
let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let activeDate = formatDate(currentDate);


let availableSlotsData = {};

function openPopup(event) {
    event.preventDefault();
    window.loadingScreen.addPageLoading();

    let offeringId = event.target.getAttribute('data-offering-id');
    let availabilityData = event.target.getAttribute('data-availability');
    let storeAvailability = event.target.getAttribute('data-store-availability');
    let priceData = event.target.getAttribute('data-price');
    let specificDayStart = event.target.getAttribute('data-specific-day-start');
    let specificDayEnd = event.target.getAttribute('data-specific-day-end');
    let offeringEventType = event.target.getAttribute('data-offering-event-type') !== '' ? event.target.getAttribute('data-offering-event-type') : 'offering';
    let offeringEventStart = event.target.getAttribute('data-event-start');
    let userId = event.target.getAttribute('data-user-id');
    let currency = event.target.getAttribute('data-currency');
    let currencySymbol = event.target.getAttribute('data-currency-symbol');
    let timezone = event.target.getAttribute('data-timezone');

    console.log(priceData , currency , currencySymbol)

    let inputElement = document.querySelector('[name="offering_id"]');
    let availabilityInput = document.querySelector('[name="availability"]');
    let offeringPriceInput = document.querySelector('[name="offering_price"]');
    let offeringSlotsInput = document.querySelector('[name="store-availability"]');
    let priceDiv = offeringEventType === 'event' ? document.getElementById('eventPrice') : document.getElementById('offeringPrice');
    let offeringSpecificDaysInput = document.querySelector('[name="offering-specific-days"]');
    let offeringEventInput = document.querySelector('[name="offering_event_type"]');
    let offeringEventStartDateTime = document.querySelector('[name="offering_event_start_date_time"]');
    let popupElement = document.getElementById('popup');
    let userIdInput = document.getElementById('user_id');
    let currencyInput = document.getElementById('currency');
    let currencySymbolInput = document.getElementById('currency_symbol');
    let timezoneInput = document.getElementById('practitioner_timezone');

    if (inputElement) {
        inputElement.value = offeringId;
        inputElement.classList.add('activeInput');
        availabilityInput.value = availabilityData;
        offeringSlotsInput.value = storeAvailability;
        offeringEventInput.value = offeringEventType;
        offeringPriceInput.value = priceData;
        priceDiv.textContent = priceData;
        offeringEventStartDateTime.value = offeringEventStart;
        offeringSpecificDaysInput.setAttribute('data-specific-day-start', specificDayStart);
        offeringSpecificDaysInput.setAttribute('data-specific-day-end', specificDayEnd);
        offeringSpecificDaysInput.value = specificDayStart + ' - ' + specificDayEnd;
        userIdInput.value = userId;
        currencyInput.value = currency;
        currencySymbolInput.value = currencySymbol;
        timezoneInput.value = timezone;
    } else {
        console.error("Element with name 'offering_id' not found");
    }

    if (offeringEventType === 'event') {
        $.ajax({
            url: '/getEvent',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                offeringId: offeringId,
                userId: `${userId}`,
                price: `${priceData}`,
                currency: `${currencySymbol}`,
            },
            beforeSend: function () {
                window.loadingScreen.addPageLoading();
            },
            success: function (response) {
                if (response.success) {
                    // Populate the event data in the modal
                    document.querySelector('.event-container').innerHTML = response.html;
                    document.querySelector('.event-container').classList.remove('d-none');
                    document.querySelector('.event-container').style.display = 'block';
                    document.querySelector('.booking-container').classList.add('d-none');
                } else {
                    console.log('error')
                }

            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            },

            complete: function () {
                window.loadingScreen.removeLoading();
            }


        })

    } else {
        document.querySelector('.event-container').classList.add('d-none');
        document.querySelector('.booking-container').classList.remove('d-none');

        $.ajax({
            type: 'post',
            url: `/getBookedSlots/${userId}`,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                window.loadingScreen.addPageLoading();
            },
            success: function (response) {
                console.log("Fetched booked dates:", response.bookedDates);

                if (response.status === 'success' && Array.isArray(response.bookedDates)) {
                    $('#already_booked_slots').val(JSON.stringify(response.bookedDates));
                } else {
                    console.error("Invalid booked dates:", response);
                    $('#already_booked_slots').val("[]");
                }

                // ✅ Call `generateCalendar` after data is updated
                generateCalendar(currentMonth, currentYear);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
            },
            complete: function () {
                window.loadingScreen.removeLoading();
            }
        });

        generateCalendar(currentMonth, currentYear);
    }


    window.loadingScreen.removeLoading();
}


function formatDate(date) {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
}


function getAllowedDays() {
    let availability = document.getElementById('availability')?.value || 'own_specific_date';
    let storeAvailabilityRaw = document.getElementById('store-availability')?.value;

    let dayMapping = {
        "every_monday": [1], "every_tuesday": [2], "every_wednesday": [3],
        "every_thursday": [4], "every_friday": [5], "weekend_every_saturday_sunday": [0, 6],
        "every_day": [0, 1, 2, 3, 4, 5, 6], "own_specific_date": [0, 1, 2, 3, 4, 5, 6]
    };

    if (availability === 'own_specific_date') {
        let specificDaysInput = document.querySelector('[name="offering-specific-days"]');
        if (!specificDaysInput) return [];

        let specificDays = specificDaysInput.value.split(' - ');
        let specificDayStart = new Date(specificDays[0]);
        let specificDayEnd = new Date(specificDays[1]);

        // Calculate the total number of days
        let totalDays = Math.ceil((specificDayEnd - specificDayStart) / (1000 * 60 * 60 * 24)) + 1;

        // Generate an array of allowed dates
        let allowedDates = Array.from({length: totalDays}, (_, index) => {
            let date = new Date(specificDayStart);
            date.setDate(date.getDate() + index);
            return date.toISOString().split('T')[0]; // Format as YYYY-MM-DD
        });

        console.log("Allowed Dates for Own Specific Date:", allowedDates);
        return allowedDates;
    }


    if (availability === 'following_store_hours') {

        try {
            console.log("Raw Store Availability JSON:", storeAvailabilityRaw);

            let storeAvailability = JSON.parse(storeAvailabilityRaw);
            console.log("Parsed Store Availability:", storeAvailability);

            let allowedDays = [];

            if (storeAvailability.every_day?.enabled === "1") {
                // "every_day" is enabled, so allow all days (0 = Sunday, 6 = Saturday)
                allowedDays = [0, 1, 2, 3, 4, 5, 6];
            } else {
                allowedDays = Object.keys(storeAvailability)
                    .filter(day => storeAvailability[day]?.enabled === "1")
                    .map(day => {
                        let normalizedDay = day.replace("every_", "").toLowerCase();
                        return ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"]
                            .indexOf(normalizedDay);
                    })
                    .filter(dayIndex => dayIndex !== -1);

            }
            console.log("Allowed Days from Store Availability:", allowedDays);
            return allowedDays;
        } catch (error) {
            alert('error')
            console.error("Error parsing store availability JSON:", error, storeAvailabilityRaw);
            return [];
        }


    }
console.log('availability is here ' ,availability)
    return dayMapping[availability] || [];
}


function generateTimeSlots(from = null, to = null, date = null, allDay = false) {
    const practitionerTimeZone = document.getElementById('practitioner_timezone')?.value || 'UTC';
    const { DateTime } = luxon;
    console.log('to date', to)
    console.log('to date', date)
alert(DateTime)
    let slots = [];
    let startTime, endTime;

    if (allDay) {
        // Use Luxon DateTime for consistency
        startTime = DateTime.fromISO(`${date}T12:00:00`, { zone: practitionerTimeZone });
        endTime = DateTime.fromISO(`${date}T12:00:00`, { zone: practitionerTimeZone });
    } else {
        const baseDate = `${date || Date()}`;
        startTime = DateTime.fromISO(`${baseDate}T${from}`, { zone: practitionerTimeZone });
        endTime = DateTime.fromISO(`${baseDate}T${to}`, { zone: practitionerTimeZone });
    }

    let isNextDay = endTime <= startTime;
    if (isNextDay) {
        endTime = endTime.plus({ days: 1 });
    }

    while (startTime < endTime) {
        const localTime = startTime.toLocal();
        slots.push(localTime.toFormat("hh:mm a"));
        startTime = startTime.plus({ minutes: 60 });
    }

    slots.sort((a, b) => convertTo24Hour(a) - convertTo24Hour(b));
    return slots;
}




// Convert Date object to "HH:MM AM/PM" format
function formatTime(date) {
    return date.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', hour12: true});
}

// Convert "HH:MM AM/PM" to 24-hour format for correct sorting
function convertTo24Hour(time) {
    let [hour, minute] = time.split(/:| /);
    let period = time.includes("AM") ? "AM" : "PM";

    let date = new Date(`2025-01-01 ${hour}:${minute} ${period}`);
    return date.getHours() * 60 + date.getMinutes();
}

function generateCalendar(month, year) {
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const calendarGrid = document.getElementById('calendarGrid');
    const monthLabel = document.getElementById('monthLabel');
    calendarGrid.innerHTML = '';

    monthLabel.innerText = `${firstDay.toLocaleString('default', {month: 'long'})} ${year}`;
    const daysInMonth = lastDay.getDate();
    const startDay = firstDay.getDay();
    const allowedDays = getAllowedDays();

    // Retrieve already booked slots from hidden input
    let bookedSlotsElement = document.getElementById('already_booked_slots');
    let bookedDates = [];

    if (bookedSlotsElement) {
        let value = bookedSlotsElement.value.trim(); // Remove any extra spaces

        if (value) { // Ensure the value is not empty
            try {
                bookedDates = JSON.parse(value);
            } catch (error) {
                console.error("Error parsing booked slots JSON:", error, value);
            }
        }
    }

    console.log("Parsed bookedDates:", bookedDates);


    for (let i = 0; i < startDay; i++) {
        const emptyCell = document.createElement('div');
        emptyCell.classList.add('inactive');
        calendarGrid.appendChild(emptyCell);
    }

    // Inside your `generateCalendar` function where you loop over the `bookedDates`
    for (let day = 1; day <= daysInMonth; day++) {
        const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
        const currentDayOfWeek = new Date(year, month, day).getDay();
        const dayCell = document.createElement('div');
        dayCell.classList.add('dates');

        if (dateString === formatDate(currentDate)) {
            dayCell.classList.add('active');
            activeDate = dateString;
        }

        // Check for all-day booked dates or by day of week
        if (!(allowedDays.includes(dateString) || allowedDays.includes(currentDayOfWeek))) {
            dayCell.classList.add('inactive');
        }

        // Check if the date is booked and it's an all-day event
        let isBooked = bookedDates.some(booked => booked.date === dateString && !booked.start_time && !booked.end_time);

        if (isBooked) {
            dayCell.classList.add('inactive');
            dayCell.classList.add('booked');
            dayCell.setAttribute('title', 'This date is fully booked (All-day)');
        }

        dayCell.innerText = day;
        dayCell.setAttribute('data-date', dateString);

        dayCell.addEventListener('click', () => {
            if (dayCell.classList.contains('inactive')) return;

            if (activeDate) {
                document.querySelector(`[data-date='${activeDate}']`)?.classList.remove('active');
            }

            activeDate = dateString;
            dayCell.classList.add('active');
            showAvailableSlots(activeDate);
        });

        calendarGrid.appendChild(dayCell);
        $('.calendar-grid .dates').on('click', function () {
            const date = $(this).data('date');
            $('#booking_date').val(date);
        });
    }

}
function filterBookedSlots(date, slots) {
    let bookedDates = JSON.parse(document.getElementById('already_booked_slots').value || '[]');

    let grouped = [];
    let currentGroup = [];
console.log('slots',slots)
    slots.forEach(slot => {
        let slotMinutes = convertTo24Hour(slot);
        let isBooked = bookedDates.some(b => {
            if (b.date !== date) return false;
            let start = convertTo24Hour(b.start_time);
            let end = convertTo24Hour(b.end_time);
            return slotMinutes >= start && slotMinutes < end;
        });

        if (!isBooked) {
            currentGroup.push(slot);
        } else if (currentGroup.length > 0) {
            grouped.push([...currentGroup]);
            currentGroup = [];
        }
    });

    if (currentGroup.length > 0) {
        grouped.push([...currentGroup]);
    }

    return grouped; // Now it's an array of arrays (slot groups)
}



function showAvailableSlots(date) {
    const slotsContainer = document.getElementById('availableSlots');
    const dateLabel = document.getElementById('selectedDate');
    let availability = document.getElementById('availability')?.value || 'own_specific_date';
    let storeAvailabilityRaw = document.getElementById('store-availability')?.value;

    // slotsContainer.innerHTML = '<p class="text-muted">No available slots</p>';
    dateLabel.innerText = date.split('-').reverse().join('/');

    let availableSlots = [];

    // All-Day Slot Creation
    availableSlots.push({
        type: 'all-day',
        time: 'All Day',
        date: date
    });

    if (availability === 'following_store_hours') {
        if (!storeAvailabilityRaw) {
            console.error("Store availability data is missing.");
            return;
        }

        let storeAvailability;
        try {
            storeAvailability = JSON.parse(storeAvailabilityRaw.replace(/&quot;/g, '"'));
        } catch (error) {
            console.error("Error parsing store availability JSON:", error, storeAvailabilityRaw);
            return;
        }

        let dayOfWeekIndex = new Date(date).getDay();
        let dayNames = ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "saturday"];

        let allSlots = [];

        if (storeAvailability.every_day?.enabled === "1") {
            let fromTime = storeAvailability.every_day?.from;
            let toTime = storeAvailability.every_day?.to;

            if (fromTime && toTime) {
                allSlots = generateTimeSlots(fromTime, toTime,date);
            }
        } else {
            Object.keys(storeAvailability).forEach(dayKey => {
                if(dayKey === 'every_day') {
                    return
                }
                let normalizedDay = dayKey.replace("every_", "").toLowerCase();

                let dayIndex = dayNames.indexOf(normalizedDay);
                alert(dayIndex)
                console.log(normalizedDay ,dayKey ,dayIndex === dayOfWeekIndex && storeAvailability[dayKey]?.enabled === "1")
                if (dayIndex === dayOfWeekIndex && storeAvailability[dayKey]?.enabled === "1") {
                    let fromTime = storeAvailability[dayKey]?.from;
                    let toTime = storeAvailability[dayKey]?.to;

                    if (fromTime && toTime) {
                        allSlots = allSlots.concat(generateTimeSlots(fromTime, toTime ,date));
                    }
                }
            });
        }

        availableSlots = [...new Set(allSlots)].sort((a, b) => convertTo24Hour(a) - convertTo24Hour(b));
    } else {
        availableSlots = generateTimeSlots(null, null, date, true);
    }

    // ❗ Filter out booked slots
    availableSlots = filterBookedSlots(date, availableSlots);

    renderSlots(availableSlots);
}

function renderSlots(availableSlotGroups) {
    const slotsContainer = document.getElementById('availableSlots');

    if (!availableSlotGroups || availableSlotGroups.length === 0) {
        slotsContainer.innerHTML = '<p class="text-muted">No available slots</p>';
        return;
    }

    slotsContainer.innerHTML = '';

    availableSlotGroups.forEach((group, index) => {
        // Optional: Add a group label
        if (availableSlotGroups.length > 1) {
            const label = document.createElement('div');
            label.innerHTML = `<div class="text-muted mb-1">Slot Group ${index + 1}</div>`;
            slotsContainer.appendChild(label);
        }

        const row = document.createElement('div');
        row.classList.add('row', 'mb-2');

        group.forEach(slot => {
            const col = document.createElement('div');
            col.classList.add('col-4');
            col.classList.add('my-1');
            col.innerHTML = `<button class="btn btn-outline-green w-100 offering-slot" data-time="${slot}">${slot}</button>`;
            row.appendChild(col);
        });

        slotsContainer.appendChild(row);
    });

    $('.offering-slot').on('click', function () {
        $('.offering-slot').removeClass('active');
        $(this).addClass('active');
        const time = $(this).data('time');
        $('#booking_time').val(time);
    });
}


const prevBtn = document.getElementById('prevMonth');
if (prevBtn) {
    prevBtn.addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentMonth, currentYear);
    });
}

const nextBtn = document.getElementById('nextMonth');
if (nextBtn) {
    nextBtn.addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentMonth, currentYear);
    });
}


$(document).on('click', '.proceed_to_checkout', function () {
    console.log('click');

    const offeringId = $('#offering_id').val();
    const offeringEventType = $('#offering_event_type').val();
    const startEventDate = $('#offering_event_start_date_time').val();
    const price = $('#offering_price').val();
    const currency = $('#currency').val();
    const currencySymbol = $('#currency_symbol').val();

    console.log(currencySymbol)
    let bookingDate = '';
    let bookingTime = '';

    if (offeringEventType !== 'event') {
        bookingDate = $('#booking_date').val();
        bookingTime = $('#booking_time').val();
    } else {
        [bookingDate, bookingTime] = startEventDate.split(" ");
    }

    paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType, price, currency, currencySymbol);
});


function paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType, price, currency, currencySymbol) {

    if (!offeringId || !bookingDate || !bookingTime) {
        alert("Please select slot!");
        return;
    }

    $.ajax({
        type: "POST",
        url: "/storeBooking",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            offering_id: offeringId,
            booking_date: bookingDate,
            booking_time: bookingTime,
            offering_event_type: offeringEventType,
            price: price,
            currency_symbol: currencySymbol,
            currency: currency,
        },
        success: function (response) {
            if (!response.success) {
                alert("Something went wrong!")
            }
            $('.booking-container').hide();
            $('.event-container').hide();
            $('.billing-container').show();
            $('.billing-container').html(response.html);
            // $('.popup-content').css('width', "60%")
            // $('.popup-content').css('background-color', "transparent")
            // $('.popup-content .container').css('padding', "30px")
        },
        error: function (error) {
            alert("Something went wrong!");
        }
    });
}
