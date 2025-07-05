@extends('admin.layouts.app')

@section('content')

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
                                            '4' => 'Delete User Bookings',
                                            '3' => 'Practitioner Client Bookings',
                                            '2' => 'New User Bookings',
                                            default => 'Practitioner Bookings',
                                        };
                                    }
                                    ?>
                                </h4>
                                @if(count($bookings) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> Name</th>
                                                @if($userType == '3')
                                                    <th>Practitioners</th>
                                                @else
                                                    <th>Users</th>
                                                @endif
                                                <th>
                                                    Offering Type
                                                </th>
                                                <th> Date</th>
                                                <th> Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($bookings as $booking)
                                                <tr>
                                                    <td>
                                                        {{ $loop->iteration }}
                                                    </td>
                                                    @if($userType == '3')
                                                        {{-- This is for practitioner users --}}
                                                        <td>
                                                            {{ $booking->user->name ?? 'N/A' }}
                                                        </td>
                                                        <td>
                                                            {{ $booking->shows->user->name ?? 'N/A' }}
                                                        </td>
                                                    @else
                                                        {{-- This is for practitioner --}}
                                                        @if(isset($booking->offering_id) && $booking->offering_id)
                                                            <td>
                                                                {{ $booking->offering->user->name ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ $booking->user->name ?? 'N/A' }}
                                                            </td>

                                                        @else
                                                            <td>
                                                                {{ $booking->shows->user->name ?? 'N/A' }}
                                                            </td>
                                                            <td>
                                                                {{ $booking->user->name ?? 'N/A' }}
                                                            </td>

                                                        @endif
                                                    @endif
                                                    <td>
                                                            <?php
                                                                $offeringType = isset($booking->shows_id) && $booking->shows_id ? 'show':$booking->offering->offering_event_type ?? 'N/A';

                                                            echo match ($offeringType) {
                                                                'show' => '<span class="badge text-bg-warning rounded">Shows</span>',
                                                                'event' => '<span class="badge text-bg-success rounded">Events</span>',
                                                                default => '<span class="badge text-bg-primary rounded">Offerings</span>',
                                                            };
                                                            ?>

                                                    </td>
                                                    <td>
                                                        {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') : 'N/A' }}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-dark" type="button" data-bs-toggle="dropdown"
                                                               aria-expanded="false">
                                                                <span class="mdi mdi-dots-vertical"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{route('admin.booking.detail', ['bookingId' => $booking->id,'userType' => $userType])}} "
                                                                    >Booking detail</a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>

                                                </tr>

                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-primary" role="alert">
                                        <p>No booking found</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
