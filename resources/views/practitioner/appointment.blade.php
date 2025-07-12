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

                        {{-- Search Box --}}
                        <div class="d-flex mb-5" style="gap: 20px;">
                            <div class="search-container">
                                <input type="text" class="search-input"
                                       placeholder="">
                                <button class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <button class="category-load-more">Search</button>
                        </div>

                        <div class="earning-wrrpr my-5 py-5">
                            {{-- Appointments --}}
                            @if(count($appointments) > 0)
                                @foreach($appointments as $appointment)
                                    @if($appointment->status != 'pending')
                                        <div class="appointment-data p-3 mb-3 border rounded bg-light">
                                            <h6 class="mb-1">{{ $appointment?->first_name . ' ' . $appointment?->last_name ?? 'N/A' }}</h6>
                                            <small class="text-muted">
                                                {{ $appointment?->booking_date . ' ' . $appointment?->time_slot }}
                                            </small>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="appointment-data my-5 py-5 border rounded bg-light text-center">
                                    <h6 class="no-request-text text-center">No Appointments</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
