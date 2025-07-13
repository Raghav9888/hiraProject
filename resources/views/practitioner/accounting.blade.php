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
                            <div class="row mb-5">
                                <div class="col-sm-12 col-md-9 col-lg-9">
                                    <form method="GET" action="{{ route('accounting') }}">
                                        <label class="d-block" for="start-date">Start Date</label>
                                        <div class="d-flex mb-4">
                                            <input type="date" name="start_date" value="{{ $startDate }}" required>
                                            <button type="submit" class="update-btn">Update</button>
                                        </div>
                                        <label class="d-block" for="end-date">End Date</label>
                                        <div class="d-flex">
                                            <input type="date" name="end_date" value="{{ $endDate }}" required>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="earnings-section">
                                <h2>Gross Sales Report</h2>
                                <table>
                                    <tbody>
                                    <tr class="border-bottom">
                                        <td>Total Orders</Flight>
                                        <td>{{ $totalOrders }}</td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td>Total Products Sold</td>
                                        <td>{{ $totalProductsSold }}</td>
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
                                    <p style="text-align: start;">No orders for this period. Adjust your dates above and click update, or list new products for customers to buy.</p>
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
                                                <td>{{ $booking->offering->title ?? 'N/A' }}</td>
                                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('Y-m-d') }}</td>
                                                <td>{{ $booking->time_slot }}</td>
                                                <td>{{ $booking->currency_symbol }}{{ number_format($booking->total_amount, 2) }}</td>
                                                <td>{{ $booking->currency_symbol }}{{ number_format($booking->tax_amount, 2) }}</td>
                                                <td>{{ $booking->status }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
