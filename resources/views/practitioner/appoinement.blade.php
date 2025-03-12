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
                    <div class="appointment-data">
                        <div>
                            <h6>Name</h6>
                            <p>Type of service</p>
                        </div>
                        <div class="d-flex align-items-center">

                            <p>09:00AM</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
