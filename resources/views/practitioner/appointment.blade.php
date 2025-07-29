@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>
                <div class="col-md-12">
                    <div class="add-offering-dv">
                        <h2 class="home-title text-capitalize mb-4">Your Bookings</h2>

                        <div class="earning-wrrpr container p-4 bg-light rounded">
                            {{-- Appointments --}}
                            @if(count($appointments) > 0)
                                {{-- Header Row --}}
                                <div class="row p-3 bg-white border rounded mb-3 fw-bold text-muted">
                                    <div class="col-3">Name</div>
                                    <div class="col-2">Status</div>
                                    <div class="col-3">Start</div>
                                    <div class="col-2">End</div>
                                    <div class="col-2">Date</div>
                                </div>

                                {{-- Appointment Rows --}}
                                @foreach($appointments as $appointment)
                                    @if($appointment->status != 'pending')
                                        @php
                                            $startTime = \Carbon\Carbon::parse($appointment->time_slot);
                                            $rawDuration = $appointment->reschedule_hour;

                                            // Make sure it's numeric; fallback to 1 hour if invalid
                                            $duration = is_numeric($rawDuration) ? (float) $rawDuration : 1;

                                            $endTime = $startTime->copy()->addMinutes($duration * 60);
                                        @endphp

                                        <div class="row p-3 mb-2 bg-white border rounded align-items-center">
                                            {{-- Name --}}
                                            <div class="col-3">
                                                <i class="bi bi-person me-2"></i>
                                                {{ $appointment->first_name . ' ' . $appointment->last_name ?? 'N/A' }}
                                            </div>

                                            {{-- Status --}}
                                            <div class="col-2">
                                            <span class="badge
                                                @if($appointment->status == 'confirmed') bg-success
                                                @elseif($appointment->status == 'cancelled') bg-danger
                                                @elseif($appointment->status == 'completed') bg-primary
                                                @else bg-secondary @endif">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                            </div>

                                            {{-- Start Time --}}
                                            <div class="col-3">
                                                <i class="bi bi-clock me-2"></i>
                                                {{ $startTime->format('h:i A') }}
                                            </div>

                                            {{-- End Time --}}
                                            <div class="col-2">
                                                <i class="bi bi-clock-fill me-2"></i>
                                                {{ $endTime->format('h:i A') }}
                                            </div>

                                            {{-- Booking Date --}}
                                            <div class="col-2">
                                                <i class="bi bi-calendar me-2"></i>
                                                {{ \Carbon\Carbon::parse($appointment->booking_date)->format('d M Y') }}
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                {{-- No Appointments --}}
                                <div class="text-center py-5">
                                    <i class="bi bi-calendar-x text-muted" style="font-size: 2rem;"></i>
                                    <h6 class="mt-2 text-muted">No Appointments Available</h6>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
