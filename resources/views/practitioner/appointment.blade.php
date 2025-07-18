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

                        <div class="earning-wrrpr my-5 py-5">
                            {{-- Appointments --}}
                            @if(count($appointments) > 0)
                                @foreach($appointments as $appointment)
                                    @if($appointment->status != 'pending')
                                        <div class="appointment-data p-3 mb-3 border rounded bg-light">
                                            <h6 class="mb-1">{{ $appointment?->first_name . ' ' . $appointment?->last_name ?? 'N/A' }}</h6>
                                            <small class="text-muted px-2">
                                                {{ $appointment?->booking_date . ' ' . $appointment?->time_slot }}
                                            </small>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <h6 class="no-request-text text-center min-vh-100">No Appointments</h6>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
