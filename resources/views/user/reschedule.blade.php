@extends('layouts.user_internal_base')

@section('userContent')
    <style>
        #reschedule {
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .info-icon {
            color: #424E3E;
            font-size: 1.3rem;
            vertical-align: middle;
        }

        h3 {
            font-weight: 700;
            letter-spacing: 1.2px;
        }

        p strong {
            color: #424E3E;
        }
    </style>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card bg-white p-4" id="reschedule">
                    <div class="text-center mb-4">
                        <h3>Reschedule Booking #{{ $booking->id }}</h3>
                        <small class="text-muted">We’ve got you covered!</small>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <p class="mb-4 fs-5 text-center">
                        Original Booking Date:<br>
                        <strong>{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</strong> |
                        <strong>{{ $booking->time_slot ?? 'All Day' }}</strong>
                    </p>

                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert" style="border-radius: 0.75rem;">
                        <i class="fa-solid fa-info-circle info-icon me-3"></i>
                        <div>
                            Rescheduling is allowed only if done <strong>at least 48 hours</strong> before the booked date & time.
                        </div>
                    </div>

                    @php
                        $offering = $booking->offering;
                        $event = $offering->event ?? null;
                        $userDetail = $booking->user->userDetail;

                        $rawPrice = $offering->offering_event_type === 'event'
                            ? ($event->client_price ?? 0)
                            : ($offering->client_price ?? 0);

                        $cadPrice = round(floatval(str_replace(',', '', $rawPrice)));
                    @endphp

                    <div class="text-center mb-4">
                        <button type="button"
                                class="home-blog-btn offering_process"
                                data-bs-toggle="modal"
                                data-bs-target="#exampleModal"
                                onclick="openPopup(event)"
                                data-user-id="{{ $booking->user->id }}"
                                data-duration="{{ $offering->offering_event_type === 'event' ? ($event->event_duration ?? '15 minutes') : ($offering->booking_duration ?? '15 minutes') }}"
                                data-buffer-time="{{ $offering->offering_event_type === 'event' ? '15 minutes' : ($offering->buffer_time ?? '15 minutes') }}"
                                data-offering-id="{{ $offering->id }}"
                                data-offering-event-type="{{ $offering->offering_event_type }}"
                                data-event-start="{{ $offering->offering_event_type === 'event' ? ($event->date_and_time ?? '') : '' }}"
                                data-availability="{{ $offering->availability_type ?? '' }}"
                                data-specific-day-start="{{ $offering->from_date }}"
                                data-specific-day-end="{{ $offering->to_date }}"
                                data-price="{{ $cadPrice }}"
                                data-currency-symbol="CA$"
                                data-currency="cad"
                                data-timezone="{{$timezone}}"
                                data-cad-price="{{ $cadPrice }}"
                                data-store-availability='{{$storeAvailable}}'>
                            Book Now
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" name="offering_id" id="offering_id">
    <input type="hidden" name="user_id" id="user_id">

    <input type="hidden" name="offering_event_type" id="offering_event_type">
    <input type="hidden" name="offering_event_start_date_time" id="offering_event_start_date_time">
    <input type="hidden" name="availability" id="availability">

    <input type="hidden" name="offering_price" id="offering_price">

    <input type="hidden" name="booking_date" id="booking_date">
    <input type="hidden" name="booking_time" id="booking_time">
    <input type="hidden" name="practitioner_timezone" id="practitioner_timezone">

    <input type="hidden" name="store-availability" id="store-availability">
    <input type="hidden" name="offering-specific-days" id="offering-specific-days">
    <input type="hidden" name="already_booked_slots" id="already_booked_slots">
    <input type="hidden" name="currency" id="currency">
    <input type="hidden" name="currency_symbol" id="currency_symbol">

    <input type="hidden" name="duration_time" id="duration_time">
    <input type="hidden" name="buffer_time" id="buffer_time">

    @php $isReschedule = true; @endphp

        <!-- Reschedule Modal -->
    <div class="modal fade xl" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="booking-container d-none">
                        @include('user.offering_detail_page')
                    </div>
                    <div class="event-container d-none">
                        @include('user.event_detail_popup')
                    </div>
                    <div class="billing-container"></div>
                    <div class="checkout-container"></div>
                    <div class="login-container" style="display: none;">
                        @include('user.login-popup')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="application/javascript">
        let bookingId = '{{ $booking->id }}';
        $(document).ready(function () {
            $(document).on('click', '.proceed_to_reschedule', function () {

                const bookingDate = $('#booking_date').val();
                const bookingTime = $('#booking_time').val();
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                if (!bookingDate || !bookingTime) {
                    alert('Please select both date and time');
                    return;
                }

                $.ajax({
                    url: `/booking/${bookingId}/handleReschedule`,
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    data: {
                        new_date: bookingDate,
                        new_slot: bookingTime,
                    },
                    success: function (response) {
                        if (response.redirect_url) {
                            window.location.href = response.redirect_url;
                        } else {
                            alert('Reschedule handled but no redirect.');
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'Something went wrong.');
                    }
                });
            });
        });
    </script>
@endsection
