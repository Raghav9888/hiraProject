@php use App\Models\Offering;use Carbon\Carbon; @endphp
@extends('layouts.user_internal_base')

@section('userContent')
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="card p-4">
        <h5 class="mb-4">📅 Bookings</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="thead-light">
                <tr>
                    <th class="text-center">Practitioner</th>
                    <th class="text-center">Offering</th>
                    <th class="text-center">Offering Type</th>
                    <th class="text-center">Date</th>
                    <th class="text-center">Time Slot</th>
                    <th class="text-center">Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($bookings as $booking)
                    @php
                        $bookingDateTime = Carbon::parse($booking->booking_date . ' ' . $booking->time_slot);
                        $offering = Offering::find($booking->offering_id);

                        $beforeCanceledValue = 0;
                        $beforeCanceled = null;

                        if ($offering->offering_event_type === 'offering' && $offering->is_cancelled) {
                            $beforeCanceled = $offering->cancellation_time_slot;
                        } elseif ($offering->offering_event_type === 'event' && optional($offering->event)->is_cancelled) {
                            $beforeCanceled = $offering->event->cancellation_time_slot;
                        }

                        if ($beforeCanceled) {
                            preg_match('/\d+/', $beforeCanceled, $matches);
                            $beforeCanceledValue = isset($matches[0]) ? (int) $matches[0] : 0;
                        }

                        $cutoff = $bookingDateTime->copy()->subMinutes($beforeCanceledValue);
                        $now = Carbon::now();

                        $canRescheduleOrCancel = $beforeCanceled && $now->greaterThanOrEqualTo($cutoff);
                    @endphp


                    <tr>
                        <td class="text-center">{{ $booking->offering->user->first_name ?? '' }} {{ $booking->offering->user->last_name ?? '' }}</td>
                        <td class="text-center">{{ $booking->offering->name ?? '-' }}</td>
                        <td class="text-center">{{ $booking->offering->offering_event_type }}</td>
                        <td class="text-center">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</td>
                        <td class="text-center">{{ $booking->time_slot ?? 'All Day' }}</td>
                        <td class="text-center">{{ $booking->currency_symbol .' ' .$booking->price }}</td>
                        <td class="text-center">
                                <span
                                    class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <a class="text-green" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                           href="{{ route('viewBooking', $booking->id) }}">View</a></li>
                                    @if($canRescheduleOrCancel)
                                        <li><a class="dropdown-item"
                                               href="{{ route('bookings.rescheduleForm', $booking->id) }}">Re-schedule</a>
                                        </li>
                                    @endif

                                    @if($booking?->event_id)
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('bookingCancel', ['bookingId' => $booking->id, 'eventId' => $booking->event_id]) }}"
                                               onclick="return confirm('Are you sure you want to cancel this booking?');"
                                            >Cancel</a>
                                        </li>
                                    @endif

                                    {{-- Add more actions as needed --}}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No bookings found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
