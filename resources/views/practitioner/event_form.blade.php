<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalLabel">Create Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="eventForm">
                    <div class="mb-3">
                        <label class="form-label">Event Title</label>
                        <input type="text" id="eventTitle" class="form-control" placeholder="Event Title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Event Category</label>
                        <select id="eventCategory" class="form-control">
                            <option value="Booking">Booking</option>
                            <option value="Community Events">Community Events</option>
                            <option value="Meetings">Meetings</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Event Description</label>
                        <textarea id="eventDescription" class="form-control" placeholder="Event Description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Start Time</label>
                        <input type="datetime-local" id="eventStartTime" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">End Time</label>
                        <input type="datetime-local" id="eventEndTime" class="form-control" required>
                    </div>

                    <input type="hidden" id="eventDate">
                    <input type="hidden" id="eventId">


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
