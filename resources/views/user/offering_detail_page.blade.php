<div class="container my-3">
    <div
        class="alert alert-green alert-dismissible fade show d-flex justify-content-between align-items-center f-5"
        role="alert">
        <h2 class="h5 mb-0">Check Available Slots and Confirm Booking</h2>
        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
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
            <div class="text-green fw-bold"><span id="symbol">$</span>
            <span id="offeringPrice">0</span></div>
        </div>
        <button class="btn btn-green rounded-pill {{isset($isReschedule) && $isReschedule ? 'proceed_to_reschedule' : 'proceed_to_checkout' }}">PROCEED TO CHECK OUT</button>
    </div>
</div>
