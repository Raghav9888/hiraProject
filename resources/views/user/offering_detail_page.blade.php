
    <section class="test-my-offer">
        <div class="container bg-white">
            <div
                class="alert alert-green alert-dismissible fade show d-flex justify-content-between align-items-center f-5"
                role="alert">
                <h2 class="h5 mb-0">Check Available Slots and Confirm Booking</h2>
                <span type="button" class="btn-white" data-bs-dismiss="alert" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </span>
            </div>

            <div class="bg-light p-3 rounded mb-4">
                <div class="d-flex justify-content-center align-items-center">
                    <button class="btn text-green" id="prevMonth">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="mx-3 text-green fw-medium" id="monthLabel">March 2025</span>
                    <button class="btn text-green" id="nextMonth">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card rounded h-100">
                        <div class="card-body">
                            <div class="calendar-grid text-green fw-medium">
                                <div>Su</div>
                                <div>Mo</div>
                                <div>Tu</div>
                                <div>We</div>
                                <div>Th</div>
                                <div>Fr</div>
                                <div>Sa</div>
                            </div>
                            <div class="calendar-grid mt-2" id="calendarGrid"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card rounded h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="text-green fw-medium">Available Slots</span>
                                <span class="text-muted" id="selectedDate">March 18, 2025</span>
                            </div>
                            <div class="row g-2" id="availableSlots">
                                <!-- Available slots will be added dynamically here -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div>
                    <div class="text-muted me-2">Total Amount to Pay</div>
                    <div class="text-green fw-bold">$1,444.00</div>
                </div>


                <button class="btn btn-green rounded-pill">PROCEED TO CHECK OUT</button>
            </div>
        </div>
    </section>
    <script>
        const availableSlotsData = {
            '2025-03-18': ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM'],
            '2025-03-19': ['9:00 AM', '10:00 AM', '11:00 AM'],
            '2025-03-20': ['2:00 PM', '3:00 PM'],
            '2025-09-21': ['9:00 AM', '10:00 AM', '11:00 AM', '12:00 PM', '1:00 PM', '2:00 PM', '3:00 PM'],
        };

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth();
        let currentYear = currentDate.getFullYear();
        let activeDate = formatDate(currentDate);

        function generateCalendar(month, year) {
            const firstDay = new Date(year, month, 1);
            const lastDay = new Date(year, month + 1, 0);
            const calendarGrid = document.getElementById('calendarGrid');
            const monthLabel = document.getElementById('monthLabel');
            calendarGrid.innerHTML = '';

            monthLabel.innerText = `${firstDay.toLocaleString('default', { month: 'long' })} ${year}`;

            const daysInMonth = lastDay.getDate();
            const startDay = firstDay.getDay();

            // Add empty cells for days before the first of the month
            for (let i = 0; i < startDay; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('inactive');
                calendarGrid.appendChild(emptyCell);
            }

            // Loop through the days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const dayCell = document.createElement('div');
                dayCell.classList.add('dates');
                const dateString = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

                if (dateString === formatDate(currentDate)) {
                    dayCell.classList.add('active');
                    activeDate = dateString;
                }

                if (!availableSlotsData[dateString]) {
                    dayCell.classList.add('inactive');
                }

                dayCell.innerText = day;
                dayCell.setAttribute('data-date', dateString);

                dayCell.addEventListener('click', () => {
                    if (!availableSlotsData[dateString]) return; // Prevent selection if no slots exist

                    if (activeDate) {
                        document.querySelector(`[data-date='${activeDate}']`)?.classList.remove('active');
                    }

                    activeDate = dateString;
                    dayCell.classList.add('active');
                    showAvailableSlots(activeDate);
                });

                calendarGrid.appendChild(dayCell);
            }

            showAvailableSlots(activeDate);
        }

        function formatDate(date) {
            return `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`;
        }

        function fetchTimeSlots(selectedDate) {
            if (selectedDate.length > 0) {
                console.log('Fetching slots for:', selectedDate);

                $.ajax({
                    url: `/calendar/time-slots/${selectedDate}/${id}`,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    success: function (response) {
                        console.log(response);
                    },
                    error: function (xhr) {
                        console.log(xhr);
                    }
                });

            }
        }

        function showAvailableSlots(date) {
            const slotsContainer = document.getElementById('availableSlots');
            const dateLabel = document.getElementById('selectedDate');
            slotsContainer.innerHTML = '';
            dateLabel.innerText = date.split('-').reverse().join('/');

            let availableSlots = availableSlotsData[date] || [];

            if (availableSlots.length === 0) {
                slotsContainer.innerHTML = '<p class="text-muted">No available slots</p>';
            } else {
                availableSlots.forEach(slot => {
                    const slotButton = document.createElement('div');
                    slotButton.classList.add('col-4');
                    slotButton.innerHTML = `<button class="btn btn-outline-green w-100">${slot}</button>`;
                    slotsContainer.appendChild(slotButton);
                });
            }

            fetchTimeSlots(date);
        }

        document.getElementById('prevMonth').addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            generateCalendar(currentMonth, currentYear);
        });

        document.getElementById('nextMonth').addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            generateCalendar(currentMonth, currentYear);
        });

        generateCalendar(currentMonth, currentYear);


    </script>
