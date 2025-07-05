@extends('admin.layouts.app')

@section('content')
    <style>
        .card h5 {
            border-bottom: 1px solid #e0e0e0;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-weight: 600;
        }

        .card p {
            margin-bottom: 8px;
        }

        .list-group-item {
            font-size: 14px;
        }
    </style>

    @include('admin.layouts.nav')

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php
                                    if (isset($userType) && $userType) {
                                        echo match ($userType) {
                                            '4' => 'Delete User Booking details',
                                            '3' => 'Practitioner Client Booking details',
                                            '2' => 'New User Booking details',
                                            default => 'Practitioner Booking details',
                                        };
                                    }
                                    ?>
                                </h4>
                                <div class="row">
                                    {{--                                  create booking detail layout here--}}
                                    {{-- Booking Summary --}}
                                    <div class="col-md-12 mb-4">
                                        <div class="card border rounded p-3">
                                            <h5 class="mb-3">Booking Summary</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p><strong>Booking ID:</strong> {{ $booking->id }}</p>
                                                    <p><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                                                    <p><strong>Booking
                                                            Date:</strong> {{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}
                                                    </p>
                                                    <p><strong>Time Slot:</strong> {{ $booking->time_slot }}
                                                        ({{ $booking->user_timezone }})</p>
                                                    <p>
                                                        <strong>Confirmed:</strong> {{ $booking->is_confirmed ? 'Yes' : 'No' }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p>
                                                        <strong>Offering:</strong> {{ $booking->offering->title ?? 'N/A' }}
                                                    </p>
                                                    <p><strong>Show:</strong> {{ $booking->shows->title ?? 'N/A' }}</p>
                                                    <p><strong>Event ID:</strong> {{ $booking->event_id ?? 'N/A' }}</p>
                                                    <p>
                                                        <strong>Price:</strong> {{ $booking->currency_symbol }}{{ $booking->price }}
                                                    </p>
                                                    <p>
                                                        <strong>Total:</strong> {{ $booking->currency_symbol }}{{ $booking->total_amount }}
                                                    </p>
                                                    <p>
                                                        <strong>Payment status:</strong>

                                                        <?php
                                                        echo match ($booking->status) {
                                                            'paid' => '<span class="badge text-bg-success rounded">Paid</span>',
                                                            'confirmed' => '<span class="badge text-bg-danger rounded">User not found</span>',
                                                            default => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                        };
                                                        ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    {{-- Customer Info --}}
                                    <div class="col-md-12 mb-4">
                                        <div class="card border rounded p-3">
                                            <h5 class="mb-3">Customer Information</h5>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>
                                                        <strong>Name:</strong> {{ $booking->first_name }} {{ $booking->last_name }}
                                                    </p>
                                                    <p><strong>Email:</strong> {{ $booking->billing_email }}</p>
                                                    <p><strong>Phone:</strong> {{ $booking->billing_phone }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>User ID:</strong> {{ isset($booking?->user_id)  && $booking?->user_id ? $booking?->user_id : 'N/A' }}</p>
                                                    <p><strong>User Type:</strong>
                                                        <?php
                                                        echo match (isset($booking?->user_id)  && $booking?->user_id ? $booking->user->role : 5) {
                                                            0 => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                            1 => '<span class="badge text-bg-success rounded">Practitioner</span>',
                                                            5 => '<span class="badge text-bg-danger rounded">User not found</span>',
                                                            default => '<span class="badge text-bg-primary rounded">User</span>',
                                                        };
                                                        ?>
                                                    </p>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Practitioner Info --}}
                                    <div class="col-md-12 mb-4">
                                        <div class="card border rounded p-3">
                                            <h5 class="mb-3">Practitioner Information</h5>
                                            <?php
                                                $practitioner = isset($booking->shows_id) && $booking->shows_id ? $booking->shows->user : $booking->offering->user;
                                                ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>
                                                        <strong>Name:</strong> {{ $practitioner->name }}
                                                    </p>
                                                    <p><strong>Email:</strong> {{ $practitioner->email }}</p>
                                                    <p><strong>Phone:</strong> {{ $practitioner->userDetail->phone ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <p><strong>User ID:</strong> {{ $practitioner->id }}</p>
                                                    <p><strong>User Type:</strong>
                                                        <?php
                                                        echo match ($practitioner->role) {
                                                            0 => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                            1 => '<span class="badge text-bg-success rounded">Practitioner</span>',
                                                            2 => '<span class="badge text-bg-success rounded">Admin</span>',
                                                            default => '<span class="badge text-bg-primary rounded">User</span>',
                                                        };
                                                        ?>
                                                    </p>
                                                    @if(isset($booking->shows_id) && $booking->shows_id )
                                                        <p><strong>Show:</strong> {{ $booking->shows->name ?? 'N/A' }}</p>
                                                    @else
                                                        <p><strong>Offering:</strong> {{ $booking->offering->name ?? 'N/A' }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Billing Info --}}
                                    <div class="col-md-12 mb-4">
                                        <div class="card border rounded p-3">
                                            <h5 class="mb-3">Billing Address</h5>
                                            <p>
                                                <strong>Company:</strong> {{ $booking->billing_company }}<br>
                                                <strong>Address:</strong> {{ $booking->billing_address }} {{ $booking->billing_address2 }}
                                                <br>
                                                {{ $booking->billing_city }}, {{ $booking->billing_state }}<br>
                                                {{ $booking->billing_country }} - {{ $booking->billing_postcode }}
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Shipping Info --}}
                                    {{--                                    <div class="col-md-12 mb-4">--}}
                                    {{--                                        <div class="card border rounded p-3">--}}
                                    {{--                                            <h5 class="mb-3">Shipping Address</h5>--}}
                                    {{--                                            <p>--}}
                                    {{--                                                <strong>Name:</strong> {{ $booking->shipping_name }}<br>--}}
                                    {{--                                                <strong>Address:</strong> {{ $booking->shipping_address }}<br>--}}
                                    {{--                                                {{ $booking->shipping_city }}, {{ $booking->shipping_country }} - {{ $booking->shipping_postcode }}<br>--}}
                                    {{--                                                <strong>Phone:</strong> {{ $booking->shipping_phone }}<br>--}}
                                    {{--                                                <strong>Email:</strong> {{ $booking->shipping_email }}--}}
                                    {{--                                            </p>--}}
                                    {{--                                        </div>--}}
                                    {{--                                    </div>--}}

                                    {{-- Notes and Extra --}}
                                    <div class="col-md-12 mb-4">
                                        <div class="card border rounded p-3">
                                            <h5 class="mb-3">Additional Notes</h5>
                                            <p>{{ $booking->notes ?? 'No additional notes.' }}</p>

                                            <h5 class="mt-4 mb-3">Other Info</h5>
                                            <ul class="list-group">
                                                <li class="list-group-item"><strong>Tax
                                                        Amount:</strong> {{ $booking->currency_symbol }}{{ $booking->tax_amount }}
                                                </li>
                                                <li class="list-group-item"><strong>Refunded to
                                                        Wallet:</strong> {{ $booking->refunded_to_wallet ? 'Yes' : 'No' }}
                                                </li>
                                                <li class="list-group-item"><strong>Reschedule
                                                        Status:</strong> {{ $booking->reschedule_status ?? 'N/A' }}</li>
                                                @if ($booking->rescheduled_at)
                                                    <li class="list-group-item"><strong>Rescheduled
                                                            At:</strong> {{ \Carbon\Carbon::parse($booking->rescheduled_at)->format('d M Y H:i') }}
                                                    </li>
                                                @endif
                                                @if ($booking->reschedule_hour)
                                                    <li class="list-group-item"><strong>Reschedule
                                                            Duration:</strong> {{ $booking->reschedule_hour }} hour(s)
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
