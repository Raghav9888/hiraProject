@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container">
            <div class="row">
                @include('layouts.partitioner_nav')
                <p style="text-align: start;">Invalid timezoneInvalid timezoneInvalid timezoneInvalid timezoneInvalid
                    timezoneInvalid
                    timezoneInvalid timezoneInvalid timezone</p>
                <div class="earning-wrrpr mt-5">
                    <div class="container">
                        <div class="d-flex mb-3" style="gap: 20px;">
                            <a href="{{ route('calendar') }}" class="export-btn">Calendar</a>
                            <a href="{{ route('addOffering')}}" class="export-btn">Add Offering</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead class="thead-light">
                                <tr>
                                    <th scope="col">Detail</th>
                                    <th scope="col">BookedProduct</th>
                                    <th scope="col">Booked By</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Booking #9719<br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                <tr>
                                    <td>Booking #9719<br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                <tr>
                                    <td>Booking #9719</br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                <tr>
                                    <td>Booking #9719<br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                <tr>
                                    <td>Booking #9719<br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                <tr>
                                    <td>Booking #9719<br/>
                                        <a href="">EditUnconfirm</a>
                                    </td>
                                    <td>Test my offer</td>
                                    <td>John Doe</td>
                                    <td>March 1, 2025, 12:00 pm</td>
                                    <td>March 1, 2025, 2:00 pm</td>
                                    <td>Paid</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
