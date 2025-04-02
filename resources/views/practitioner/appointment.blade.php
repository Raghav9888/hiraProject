@extends('layouts.app')
@section('content')
    <section class="practitioner-profile vh-100">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-lg-5">
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
                    @if(count($appointments) > 0)
                        @foreach($appointments as $appointment)

                            @if($appointment->status != 'pending')
                                <div class="appointment-data">
                                    <div>
                                        <h6>{{( $appointment?->first_name .' '. $appointment?->last_name) ?? 'N/A' }}</h6>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <p> {{ $appointment?->booking_date .' '. $appointment?->time_slot}}</p>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    @else
                        <div class="appointment-data">
                            <div>
                                <h6>No Appointments</h6>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
