@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>
                <div class="col-12">
                    <div class="earning-wrrpr">
                        <div class="container">
                            <form method="GET" action="{{ route('accounting') }}"
                                  class="d-flex align-items-center flex-wrap gap-3">
                                <div class="row mb-5">
                                    <div class="col-3">
                                        <select name="offering_type" id="offering_type" class="form-control">
                                            <option value="all" {{ $offeringType == 'all' ? 'selected' : '' }}>All Bookings</option>
                                            <option value="offering" {{ $offeringType == 'offering' ? 'selected' : '' }}>Offering</option>
                                            <option value="event" {{ $offeringType == 'event' ? 'selected' : '' }}>Event</option>
                                            <option value="shows" {{ $offeringType == 'shows' ? 'selected' : '' }}>Shows</option>
                                        </select>
                                    </div>

                                    <div class="col-3">
                                        <input type="date" name="start_date" id="start_date"
                                               value="{{ $startDate ?? '' }}" class="form-control"
                                               placeholder="Start Date">
                                    </div>

                                    <div class="col-3">
                                        <input type="date" name="end_date" id="end_date"
                                               value="{{ $endDate ?? '' }}" class="form-control"
                                               placeholder="End Date">
                                    </div>

                                    <div class="col-3 d-flex gap-2">
                                        <a href="{{ route('accounting') }}" class="update-btn">
                                            Reset
                                        </a>
                                        <button type="submit" class="update-btn">Filter</button>
                                    </div>
                                </div>
                            </form>


                            <div class="earnings-section">
                                <h2>Gross Sales Report</h2>
                                <table>
                                    <tbody>
                                    <tr class="border-bottom">
                                        <td>Total Orders</td>
                                        <td>{{ $totalOrders }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Products Sold</td>
                                        <td>{{ $totalProductsSold }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Offerings</td>
                                        <td>{{ $totalOfferings }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Events</td>
                                        <td>{{ $totalEvents }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Shows</td>
                                        <td>{{ $totalShows }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Earnings</td>
                                        <td>{{ $userDetails->currency_symbol ?? '$' }}{{ number_format($totalEarnings, 2) }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Tax</td>
                                        <td>{{ $userDetails->currency_symbol ?? '$' }}{{ number_format($totalTax, 2) }}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="earnings-section w-100">
                                <h2>Booking Total ({{ $totalOrders }})</h2>
                                @if($bookings->isEmpty())
                                    <p style="text-align: start;">No orders found. Adjust your filters above and click
                                        update, or list new products for customers to buy.</p>
                                @else
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>Booking ID</th>
                                            <th>Customer</th>
                                            <th>Offering</th>
                                            <th>Date</th>
                                            <th>Time Slot</th>
                                            <th>Amount</th>
                                            <th>Tax</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->id }}</td>
                                                <td>{{ $booking->first_name }} {{ $booking->last_name }}</td>
                                                <td>
                                                    @if($booking->shows_id && $booking->shows)
                                                        {{ $booking->shows->name ?? 'N/A' }} (Show)
                                                    @elseif($booking->offering_id && $booking->offering)
                                                        @if($booking->offering->offering_event_type === 'event' && $booking->offering->event)
                                                            {{ $booking->offering->name }}
                                                            (Event: {{ \Carbon\Carbon::parse($booking->offering->event->date_and_time)->format('Y-m-d H:i') }}
                                                            )
                                                        @else
                                                            {{ $booking->offering->name ?? 'N/A' }} (Offering)
                                                        @endif
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                                                <td>{{ $booking->time_slot }}</td>
                                                <td>{{ $booking->currency_symbol }}{{ number_format($booking->total_amount, 2) }}</td>
                                                <td>{{ $booking->currency_symbol }}{{ number_format($booking->tax_amount, 2) }}</td>
                                                <td>{{ $booking->status }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {{ $bookings->links() }} <!-- Pagination links -->
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
