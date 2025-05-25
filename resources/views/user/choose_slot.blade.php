@extends('layouts.user_internal_base')

@section('userContent')
    <style>
        body {
            background: #f9fafb;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 12px 30px rgba(66, 78, 62, 0.15);
            padding: 2rem;
            max-width: 520px;
            margin: 3rem auto;
            background: white;
        }
        h2 {
            color: #424E3E;
            font-weight: 700;
            letter-spacing: 1.1px;
            text-align: center;
            margin-bottom: 2rem;
        }
        label {
            font-weight: 600;
            color: #424E3E;
        }
        .form-control {
            border: 2px solid #424E3E;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 1.1rem;
            transition: border-color 0.3s ease;
        }
        .form-control:focus {
            border-color: #6b7a58;
            box-shadow: 0 0 5px rgba(66, 78, 62, 0.5);
        }
        .btn-success {
            background-color: #424E3E;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 700;
            font-size: 1.15rem;
            border-radius: 0.6rem;
            width: 100%;
            transition: background-color 0.3s ease;
            box-shadow: 0 6px 15px rgba(66, 78, 62, 0.3);
        }
        .btn-success:hover {
            background-color: #6b7a58;
        }
        .alert-success {
            max-width: 520px;
            margin: 1rem auto 2rem;
            border-radius: 0.75rem;
            font-weight: 600;
            box-shadow: 0 8px 25px rgba(107, 122, 88, 0.25);
        }
        .text-danger {
            color: #dc3545;
            font-weight: 600;
            margin-top: 0.25rem;
        }
    </style>

    <div class="card shadow-sm">
        <h2>Choose New Slot for Booking #{{ $booking->id }}</h2>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('bookings.confirmNewSlot', $booking->id) }}" method="POST" novalidate>
            @csrf

            <div class="mb-4">
                <label for="new_date" class="form-label">Select New Date</label>
                <input type="date" id="new_date" name="new_date" required class="form-control" value="{{ old('new_date') }}" />
                @error('new_date')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="new_slot" class="form-label">Select New Time Slot</label>
                <input type="time" id="new_slot" name="new_slot" required class="form-control" value="{{ old('new_slot') }}" />
                @error('new_slot')
                <div class="text-danger small">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Confirm New Booking Slot</button>
        </form>

    </div>
@endsection
