@php use App\Models\Show; @endphp
@extends('layouts.user_internal_base')

@section('userContent')
    <!-- Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted">Success Bookings</h6>
                <h4 class="fw-bold">{{count($successBookings)}}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted">Pending Bookings</h6>
                <h4 class="fw-bold">{{count($pendingBookings)}}</h4>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-3">
                <h6 class="text-muted">Account Status</h6>
                <h4 class="fw-bold text-success">Active</h4>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="card p-4">
        <h5 class="mb-3">📅 Recent Bookings</h5>
        <ul class="list-group list-group-flush">
            @foreach($recentBookings as $booking)
                @if(isset($booking->shows_id) && $booking->shows_id)
                    <?php
                        $show = Show::find($booking->shows_id);

                        ?>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Therapy Session with {{ $show->user->first_name  }} {{ $show->user->last_name }}</span>
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</small>
                    </li>
                @else
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Therapy Session with {{ $booking->offering->user->first_name  }} {{ $booking->offering->user->last_name }}</span>
                        <small
                            class="text-muted">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</small>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endsection



