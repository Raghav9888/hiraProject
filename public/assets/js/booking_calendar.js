console.log('booking');

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();
let activeDate = formatDate(currentDate);
let availableSlotsData = {};

function formatDate(date) {
    return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
}


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
    let duration = event.target.getAttribute('data-duration');
    let bufferTime = event.target.getAttribute('data-buffer-time');

    console.log(priceData, currency, currencySymbol)

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
    let durationTimeInput = document.getElementById('duration_time');
    let bufferTimeInput = document.getElementById('buffer_time');

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
        durationTimeInput.value = duration;
        bufferTimeInput.value = bufferTime;
    } else {
        console.error("Element with name 'offering_id' not found");
    }

    if (offeringEventType === 'event') {
        $.ajax({
            url: '/getEvent',
            type: 'POST',
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

        // Disable old days according to current date
        if (new Date(dateString).setHours(0, 0, 0, 0) < currentDate.setHours(0, 0, 0, 0)) {
            dayCell.classList.add('inactive');
            dayCell.setAttribute('title', 'This date is in the past');
        }

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
                // Otherwise, check individually enabled days
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
            console.error("Error parsing store availability JSON:", error, storeAvailabilityRaw);
            return [];
        }


    }
    console.log('availability is here ', availability)
    return dayMapping[availability] || [];
}


function showAvailableSlots(date) {
    const slotsContainer = document.getElementById('availableSlots');
    const availability = document.getElementById('availability')?.value || 'own_specific_date';
    const dateLabel = document.getElementById('selectedDate');
    const storeAvailabilityRaw = document.getElementById('store-availability')?.value;

    // Format and show selected date
    dateLabel.innerText = new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    });

    let availableSlots = [];

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

        let allSlots = [];

        if (storeAvailability.every_day?.enabled === "1") {
            const fromTime = storeAvailability.every_day?.from;
            const toTime = storeAvailability.every_day?.to;
            if (fromTime && toTime) {
                allSlots = generateTimeSlots(fromTime, toTime, date);
            }
        } else {
            Object.keys(storeAvailability).forEach(dayKey => {
                const normalizedDay = dayKey.replace("every_", "").toLowerCase();
                const targetDate = new Date(date);
                const dayName = targetDate.toLocaleDateString('en-US', {weekday: 'long'}).toLowerCase();

                if (normalizedDay === dayName && storeAvailability[dayKey]?.enabled === "1") {
                    const fromTime = storeAvailability[dayKey]?.from;
                    const toTime = storeAvailability[dayKey]?.to;
                    if (fromTime && toTime) {
                        allSlots = allSlots.concat(generateTimeSlots(fromTime, toTime, date));
                    }
                }
            });
        }

        availableSlots = [...new Set(allSlots)];
    } else {
        // All-day case
        availableSlots = generateTimeSlots(null, null, date, true);
    }

    availableSlots = filterBookedSlots(date, availableSlots);

    renderSlots(date, availableSlots);
}

function parseDuration(str) {
    if (!str) {
        console.error("Duration string is undefined or empty");
        return {hours: 0, minutes: 0};
    }

    const hoursMatch = str.match(/(\d+)\s*hour/);
    const minutesMatch = str.match(/(\d+)\s*minute/);

    const hours = hoursMatch ? parseInt(hoursMatch[1]) : 0;
    const minutes = minutesMatch ? parseInt(minutesMatch[1]) : 0;

    return {hours, minutes};
}


function generateTimeSlots(from = null, to = null, date = null, allDay = false) {
    const practitionerTimeZone = document.getElementById('practitioner_timezone')?.value || 'UTC';
    const { DateTime, Duration, Interval } = luxon;

    let durationTime = document.getElementById('duration_time')?.value || '15 minutes';
    let bufferTime = document.getElementById('buffer_time')?.value || '0 minutes';

    const duration = Duration.fromObject(parseDuration(durationTime));
    const buffer = Duration.fromObject(parseDuration(bufferTime));

    if (!date) return [];

    let startTime, endTime;

    if (allDay) {
        startTime = DateTime.fromISO(`${date}T00:00:00`, { zone: practitionerTimeZone });
        endTime = startTime.plus({ hours: 24 });
    } else {
        if (!from || !to) return [];

        startTime = DateTime.fromISO(`${date}T${from}`, { zone: practitionerTimeZone });
        endTime = DateTime.fromISO(`${date}T${to}`, { zone: practitionerTimeZone });

        if (endTime <= startTime) {
            endTime = endTime.plus({ days: 1 });
        }
    }

    // ✅ Blocked Intervals = Booking + Only First Buffer
    const bookedSlots = JSON.parse(document.getElementById('already_booked_slots').value || '[]');
    const blockedIntervals = [];

    bookedSlots.forEach(slot => {
        if (slot.date === date) {
            const zone = slot.timezone || 'UTC';
            const bookingStart = DateTime.fromFormat(slot.start_time, 'hh:mm a', { zone });
            const bookingEnd = bookingStart.plus(duration);
            const blockedEnd = bookingEnd.plus(buffer); // only add buffer ONCE per booking
            blockedIntervals.push(Interval.fromDateTimes(bookingStart, blockedEnd));
        }
    });

    let slots = [];
    let current = startTime;

    while (current.plus(duration) <= endTime) {
        const slotInterval = Interval.fromDateTimes(current, current.plus(duration));
        const overlaps = blockedIntervals.some(b => b.overlaps(slotInterval));

        if (!overlaps) {
            slots.push(current.toFormat('hh:mm a'));
        }

        current = current.plus(duration); // 👉 Only increment with duration always
    }

    console.log("🎯 Final Generated Slots:", slots);
    return slots;
}

function filterBookedSlots(date, availableSlots) {
    const { DateTime, Duration } = luxon;

    const bookedSlots = JSON.parse(document.getElementById('already_booked_slots').value || '[]');
    const bufferTime = document.getElementById('buffer_time')?.value || '0 minutes';
    const bufferParts = parseDuration(bufferTime);
    const buffer = Duration.fromObject(bufferParts);

    const practitionerTimeZone = document.getElementById('practitioner_timezone')?.value || 'UTC';

    const blockedIntervals = [];

    // Prepare all blocked intervals
    bookedSlots.forEach(slot => {
        if (slot.date === date) {
            const zone = slot.timezone || 'UTC';
            let start = DateTime.fromFormat(`${date} ${slot.start_time}`, 'yyyy-MM-dd hh:mm a', { zone });
            let end = DateTime.fromFormat(`${date} ${slot.end_time}`, 'yyyy-MM-dd hh:mm a', { zone });

            // Fix overnight bookings
            if (end <= start) {
                end = end.plus({ days: 1 });
            }

            // Push booking interval
            blockedIntervals.push({
                start: start.setZone(practitionerTimeZone),
                end: end.setZone(practitionerTimeZone)
            });

            // Push buffer interval
            const bufferEnd = end.plus(buffer);
            blockedIntervals.push({
                start: end.setZone(practitionerTimeZone),
                end: bufferEnd.setZone(practitionerTimeZone)
            });
        }
    });

    console.log("⛔ Blocked Intervals on", date, blockedIntervals.map(b => ({
        start: b.start.toFormat('hh:mm a'),
        end: b.end.toFormat('hh:mm a')
    })));

    // Filter available slots that do not overlap with blocked intervals
    const filteredSlots = availableSlots.filter(timeStr => {
        const slotStart = DateTime.fromFormat(`${date} ${timeStr}`, 'yyyy-MM-dd hh:mm a', {
            zone: practitionerTimeZone
        });
        const slotEnd = slotStart.plus({ minutes: 15 });

        return !blockedIntervals.some(b => {
            return slotStart < b.end && slotEnd > b.start;
        });
    });

    console.log("✅ Filtered Slots:", filteredSlots);
    return filteredSlots;
}





function renderSlots(date, availableSlotGroups) {
    const slotsContainer = document.getElementById('availableSlots');
    const practitionerTimeZone = document.getElementById('practitioner_timezone')?.value || 'UTC';
    const userTimeZone = Intl.DateTimeFormat().resolvedOptions().timeZone;

    const durationTime = document.getElementById('duration_time')?.value || '15 minutes';
    const bufferTime = document.getElementById('buffer_time')?.value || '0 minutes';
    const durationParts = parseDuration(durationTime);
    const bufferParts = parseDuration(bufferTime);

    slotsContainer.innerHTML = '';

    if (!availableSlotGroups || availableSlotGroups.length === 0) {
        slotsContainer.innerHTML = '<p class="text-muted">No available slots</p>';
        return;
    }

    const row = document.createElement('div');
    row.classList.add('row', 'mb-2');

    availableSlotGroups.forEach(timeStr => {
        const dateTimeStr = `${date} ${timeStr}`;
        const dt = luxon.DateTime.fromFormat(dateTimeStr, 'yyyy-MM-dd hh:mm a', {
            zone: practitionerTimeZone
        });

        if (!dt.isValid) {
            console.warn("Invalid slot format:", dateTimeStr);
            return;
        }

        let userDateTime = dt.setZone(userTimeZone);
        let displayTime = userDateTime.toFormat('hh:mm a');
        let tooltipTime = `Your Time: ${displayTime} (${userTimeZone}) | Practitioner: ${dt.toFormat('hh:mm a')} (${practitionerTimeZone}) | Duration: ${durationTime}`;

        const isoUserTime = userDateTime.toISO();

        const col = document.createElement('div');
        col.classList.add('col-4', 'my-1');
        col.innerHTML = `
            <button class="btn btn-outline-green w-100 offering-slot"
                data-user-time="${userDateTime}"
                data-time="${displayTime}"
                title="${tooltipTime}"
                data-iso-time="${isoUserTime}"
                data-user-timezone="${userTimeZone}">
                ${displayTime}
            </button>
        `;
        row.appendChild(col);
    });

    slotsContainer.appendChild(row);

    $('.offering-slot').on('click', function () {
        $('.offering-slot').removeClass('active');
        $(this).addClass('active');

        const userTime = $(this).data('user-time');
        const selectedTime = $(this).data('time');
        const selectedIsoTime = $(this).data('iso-time');
        const userTimezone = $(this).data('user-timezone');

        $('#booking_time').val(selectedTime)
            .attr('data-user-time', userTime)
            .attr('data-display-time', selectedTime)
            .attr('data-iso-time', selectedIsoTime)
            .attr('data-user-timezone', userTimezone);
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
    const bookingUserTimezone = $('#booking_time').attr('data-user-timezone') ||  Intl.DateTimeFormat().resolvedOptions().timeZone;

    console.log(currencySymbol ,bookingUserTimezone)
    let bookingDate = '';
    let bookingTime = '';

    if (offeringEventType !== 'event') {
        bookingDate = $('#booking_date').val();
        bookingTime = $('#booking_time').val();
    } else {
        [bookingDate, bookingTime] = startEventDate.split(" ");
    }
    paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType, price, currency, currencySymbol, bookingUserTimezone);
});


function paymentAjax(offeringId, bookingDate, bookingTime, offeringEventType, price, currency, currencySymbol, bookingUserTimezone) {

    if (!offeringId || !bookingDate || !bookingTime) {
        alert("Please select slot!");
        return;
    }
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    $.ajax({
        type: "POST",
        url: "/calender/Booking",
        headers: {
            'X-CSRF-TOKEN': `${csrfToken}`
        },
        data: {
            offering_id: offeringId,
            booking_date: bookingDate,
            booking_time: bookingTime,
            offering_event_type: offeringEventType,
            price: price,
            currency_symbol: currencySymbol,
            currency: currency,
            booking_user_timezone: bookingUserTimezone,
        },
        beforeSend: function () {
            console.log('Booking started...');
        },
        success: function (response) {
            if (!response.success) {
                alert("Something went wrong!");
                return;
            }
            $('.booking-container').hide();
            $('.event-container').hide();
            $('.billing-container').show().html(response.html);

            // Optional styling
            // $('.popup-content').css({
            //     width: "60%",
            //     backgroundColor: "transparent"
            // });
            // $('.popup-content .container').css('padding', "30px");
        },
        error: function (xhr) {
            console.error('Booking failed:', xhr.responseText || xhr);
        }
    });

}
