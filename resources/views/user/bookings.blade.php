@php use Carbon\Carbon;use Illuminate\Support\Str; @endphp
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


                        $timezone = $booking->user_timezone ?? config('app.timezone', 'UTC');
                        $bookingDateTime = Carbon::parse($booking->booking_date . ' ' . $booking->time_slot, $timezone);

                        // Default: 24 hours before booking
                        $cancellationWindow = 24;

                        if (!empty($booking->reschedule_hour)) {
                            if (preg_match('/(\d+)/', $booking->reschedule_hour, $matches)) {
                                $value = (int) $matches[1];
                                if (Str::contains($booking->reschedule_hour, 'week')) {
                                    $cancellationWindow = $value * 24 * 7;
                                } elseif (Str::contains($booking->reschedule_hour, 'hour')) {
                                    $cancellationWindow = $value;
                                } else {
                                    $cancellationWindow = $value; // fallback
                                }
                            }
                        }

                        // Calculate cutoff time
                        $cutoff = $bookingDateTime->copy()->subHours($cancellationWindow);
                        $now = Carbon::now($timezone);

                        // Determine if reschedule/cancel is allowed
                        $canRescheduleOrCancel = $now->lessThan($cutoff) &&
                            $booking->cancellation != 1 &&
                            !in_array($booking->status, ['completed', 'cancelled', 'confirmed']);
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
                                    <li><a class="dropdown-item"
                                           href="{{ route('practitioner_detail', $booking->offering->user->slug) }}">Practioner
                                            Information</a></li>
                                    @if($canRescheduleOrCancel && $booking->offering->offering_event_type != 'event')
                                        <li><a class="dropdown-item"
                                               href="{{ route('bookings.rescheduleForm', $booking->id) }}">Re-schedule</a>
                                        </li>
                                    @endif

                                    @if($booking?->event_id && $canRescheduleOrCancel)
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
