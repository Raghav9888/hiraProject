@extends('layouts.user_internal_base')

@section('userContent')
    <div class="card shadow p-4 rounded-4">
        <h3 class="mb-4 text-primary fw-bold">
            <i class="fas fa-file-alt me-2"></i>Booking Summary
        </h3>

        {{-- Practitioner & Offering --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h6 class="fw-semibold text-secondary mb-1">
                        <i class="fas fa-user-md me-1"></i>Practitioner
                    </h6>
                    <p class="mb-0">{{ $booking->offering->user->first_name ?? '' }} {{ $booking->offering->user->last_name ?? '' }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-light rounded-3">
                    <h6 class="fw-semibold text-secondary mb-1">
                        <i class="fas fa-briefcase me-1"></i>Offering
                    </h6>
                    <p class="mb-0">{{ $booking->offering->name ?? '-' }}</p>
                </div>
            </div>
        </div>

        {{-- Booking Time Info --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-3 border-start border-4 border-primary bg-white rounded-3">
                    <h6 class="fw-semibold mb-1">
                        <i class="fas fa-calendar-alt me-1"></i>Booking Date
                    </h6>
                    <p class="mb-0">{{ \Carbon\Carbon::parse($booking->booking_date)->format('F j, Y') }}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 border-start border-4 border-primary bg-white rounded-3">
                    <h6 class="fw-semibold mb-1">
                        <i class="fas fa-clock me-1"></i>Time Slot
                    </h6>
                    <p class="mb-0">{{ $booking->time_slot ?? 'All Day' }}</p>
                </div>
            </div>
        </div>

        {{-- Status & Amount --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border-start border-4 {{ $booking->status === 'completed' ? 'border-success' : ($booking->status === 'pending' ? 'border-warning' : 'border-secondary') }}">
                    <h6 class="fw-semibold mb-1">
                        <i class="fas fa-credit-card me-1"></i>Status
                    </h6>
                    <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($booking->status) }}
                </span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 bg-white rounded-3 border-start border-4 border-info">
                    <h6 class="fw-semibold mb-1">
                        <i class="fas fa-dollar-sign me-1"></i>Total Amount
                    </h6>
                    <p class="mb-0">{{ $booking->currency_symbol }}{{ number_format($booking->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        {{-- Notes --}}
        <div class="mb-4">
            <div class="p-4 bg-light rounded-3">
                <h6 class="fw-semibold mb-2">
                    <i class="fas fa-sticky-note me-1"></i>Notes
                </h6>
                <p class="mb-0">{{ $booking->notes ?? 'No additional notes provided.' }}</p>
            </div>
        </div>

        {{-- Billing & Shipping --}}
        <div class="row g-4 mb-4">
            <div class="col-md-6">
                <div class="p-4 bg-white border-start border-4 border-secondary rounded-3 h-100">
                    <h6 class="fw-semibold mb-2">
                        <i class="fas fa-receipt me-1"></i>Billing Info
                    </h6>
                    <p class="mb-0">
                        {{ $booking->first_name }} {{ $booking->last_name }}<br>
                        {{ $booking->billing_address }}<br>
                        {{ $booking->billing_city }}, {{ $booking->billing_state }} {{ $booking->billing_postcode }}<br>
                        {{ $booking->billing_country }}<br>
                        <strong>Phone:</strong> {{ $booking->billing_phone }}<br>
                        <strong>Email:</strong> {{ $booking->billing_email }}
                    </p>
                </div>
            </div>
{{--            <div class="col-md-6">--}}
{{--                <div class="p-4 bg-white border-start border-4 border-secondary rounded-3 h-100">--}}
{{--                    <h6 class="fw-semibold mb-2">--}}
{{--                        <i class="fas fa-shipping-fast me-1"></i>Shipping Info--}}
{{--                    </h6>--}}
{{--                    <p class="mb-0">--}}
{{--                        {{ $booking->shipping_name }}<br>--}}
{{--                        {{ $booking->shipping_address }}<br>--}}
{{--                        {{ $booking->shipping_city }}, {{ $booking->shipping_postcode }}<br>--}}
{{--                        {{ $booking->shipping_country }}<br>--}}
{{--                        <strong>Phone:</strong> {{ $booking->shipping_phone }}<br>--}}
{{--                        <strong>Email:</strong> {{ $booking->shipping_email }}--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>
@endsection
