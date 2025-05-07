<div class="container my-3">
    <div class="alert alert-green alert-dismissible fade show d-flex justify-content-between align-items-center f-5" role="alert">
        <h2 class="h5 mb-0">Event Details</h2>
        <button type="button" class="btn text-white" data-bs-dismiss="modal" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="event-info card shadow-sm p-3 rounded">
        <p class="mb-2"><i class="fa-solid fa-clock text-muted me-2"></i><strong>Event Duration:</strong> {{@$offering?->event?->event_duration ?? 0}}</p>
        <p class="mb-2"><i class="fa-solid fa-dollar-sign text-muted me-2"></i><strong>Client Price:</strong> {{($currency ?? 'CA$') .' '. ($price ?? '0.00') }} </p>
        <p class="mb-2"><i class="fa-solid fa-calendar text-muted me-2"></i><strong>Date & Time:</strong> {{@$offering->event->date_and_time? date('d M, Y', strtotime($offering->event->date_and_time)): ''}}</p>
        <p class="mb-0"><i class="fa-solid fa-users text-muted me-2"></i><strong>Available Slots:</strong> {{@$offering->event->sports > 0 ? $offering->event->sports: 0}}</p>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <div class="text-muted me-2">Total Amount to Pay</div>
            <div class="text-green fw-bold">
                <span id="symbol">{{$currency ?? 'CA$'}}</span>
                <span id="eventPrice">{{$price ?? '0.00'}} </span>
            </div>
        </div>
        @if($offering?->event?->sports ?? 0 > 0)
            <button class="btn btn-green rounded-pill px-4 py-2 proceed_to_checkout">
                <i class="fa-solid fa-credit-card me-2"></i> PROCEED TO CHECK OUT
            </button>
        @endif
    </div>
</div>
