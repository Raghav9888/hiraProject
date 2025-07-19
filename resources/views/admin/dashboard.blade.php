@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.nav')
    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <!-- Top Cards -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/fluency/48/user-group-man-man.png" alt="Total Users">
                                <div class="dashboard-title">Total Users</div>
                                <div class="dashboard-value fs-4 fw-bold">{{ $totalUsers }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/fluency/48/conference-call.png" alt="Practitioners">
                                <div class="dashboard-title">Total Practitioners</div>
                                <div class="dashboard-value fs-4 fw-bold">{{ $totalPractionters }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/?size=100&id=119660&format=png&color=000000"
                                     alt="Bookings">
                                <div class="dashboard-title">Total Bookings</div>
                                <div class="dashboard-value fs-4 fw-bold">{{ $totalBookings }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/?size=100&id=bRSK58zBO6UO&format=png&color=000000"
                                     alt="Earnings">
                                <div class="dashboard-title">Total Earnings</div>
                                <div class="dashboard-value fs-4 fw-bold">${{ number_format($totalPayment, 2) }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/?size=100&id=JhPEC7MuLxCC&format=png&color=000000"
                                     alt="Offerings">
                                <div class="dashboard-title">Total Offerings</div>
                                <div class="dashboard-value fs-4 fw-bold">{{ $totalOfferings }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 col-md-4 col-sm-6">
                        <div class="card dashboard-card text-center h-100">
                            <div class="card-body">
                                <img src="https://img.icons8.com/?size=100&id=26066&format=png&color=000000"
                                     alt="Events">
                                <div class="dashboard-title">Total Events</div>
                                <div class="dashboard-value fs-4 fw-bold">{{ $totalEvents }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Chart -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Booking Analytics</h4>
                                <div class="chart-container" style="height: 400px;">
                                    <canvas id="bookingChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings Table -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Booking Records</h4>
                                <div class="table-responsive">
                                    <table class="table table-hover" id="bookings-table">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>User Name</th>
                                            <th>Practitioner Name</th>
                                            <th>Offering</th>
                                            <th>Booking Date</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($bookings as $booking)
                                            <tr>
                                                <td>{{ $booking->id }}</td>
                                                <td>{{ $booking->user ? $booking->user->name : 'N/A' }}</td>
                                                <td>{{  $booking->offering?->user?->name ?: 'N/A' }}</td>
                                                <td>{{ $booking->offering ? $booking->offering->name : 'N/A' }}</td>
                                                <td>{{ $booking->booking_date }}</td>
                                                <td>${{ number_format($booking->total_amount, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">No bookings available</td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="custom_pagination mt-3">
                                            {!! $bookings->links() !!}
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
@push('custom_scripts')
    <script>
        // Chart Data
        const chartLabels = @json($chartData['labels']);
        const bookingsCount = @json($chartData['bookingsCount']);
        const bookingsAmount = @json($chartData['bookingsAmount']);

        // Initialize Chart
        document.addEventListener('DOMContentLoaded', function () {
            const bookingCtx = document.getElementById('bookingChart').getContext('2d');
            new Chart(bookingCtx, {
                type: 'line',
                data: {
                    labels: chartLabels,
                    datasets: [
                        {
                            label: 'Bookings Count',
                            data: bookingsCount,
                            backgroundColor: 'rgba(63, 124, 172, 0.1)',
                            borderColor: '#3F7CAC',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y-count'
                        },
                        {
                            label: 'Bookings Amount ($)',
                            data: bookingsAmount,
                            backgroundColor: 'rgba(92, 148, 110, 0.1)',
                            borderColor: '#5C946E',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true,
                            yAxisID: 'y-amount'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {position: 'top'},
                        tooltip: {
                            callbacks: {
                                label: function (context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.datasetIndex === 0) {
                                        label += context.parsed.y;
                                    } else {
                                        label += '$' + context.parsed.y.toFixed(2);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        'y-count': {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: {
                                display: true,
                                text: 'Bookings Count'
                            },
                            beginAtZero: true
                        },
                        'y-amount': {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: {
                                display: true,
                                text: 'Amount ($)'
                            },
                            beginAtZero: true,
                            grid: {
                                drawOnChartArea: false
                            }
                        },
                        x: {
                            ticks: {
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
