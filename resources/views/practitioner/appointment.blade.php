@extends('layouts.app')
@section('content')
    <section class="practitioner-profile vh-100">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="appointment-wrrpr">
                    <h2 style="text-transform: capitalize;" class="home-title">Your Bookings</h2>
                    <div class="search-container mb-5">
                        <input type="text" class="search-input"
                               placeholder="">
                        <button class="search-button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    @foreach($appointments as $appointment)
                        @if($appointment->bookings->isNotEmpty())
                            <div class="appointment-data">
                                <div>
                                    <h6>{{ $appointment->user->name ?? 'N/A' }}</h6> {{-- Check if user exists --}}
                                    <p>{{ $appointment->name ?? 'No Name' }}</p>
                                </div>
                                <div class="d-flex align-items-center">

                                    @foreach($appointment->bookings as $booking)
                                        <p>{{ $booking->booking_date ?? 'No Date' }}</p>
                                    @endforeach

                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endsection
