@extends('layouts.user_internal_base')

@section('userContent')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card shadow-sm">
                    <div class="card-header bg-green text-white text-center">
                        <h3 class="mb-0">Update Your Profile</h3>
                        <small class="opacity-75">Keep your information up-to-date</small>
                    </div>
                    <div class="card-body p-4">

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form method="POST" action="{{ route('updateUserProfile') }}">
                            @csrf
                            @method('PUT')

                            <!-- First Name -->
                            <div class="mb-3">
                                <label for="first_name" class="form-label fw-semibold">First Name <span
                                        class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('first_name') is-invalid @enderror"
                                    id="first_name"
                                    name="first_name"
                                    value="{{ old('first_name', $user->first_name ?? '') }}"
                                    required
                                >
                                @error('first_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Middle Name -->
                            <div class="mb-3">
                                <label for="middle_name" class="form-label fw-semibold">Middle Name</label>
                                <input
                                    type="text"
                                    class="form-control @error('middle_name') is-invalid @enderror"
                                    id="middle_name"
                                    name="middle_name"
                                    value="{{ old('middle_name', $user->middle_name ?? '') }}"
                                >
                                @error('middle_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Last Name -->
                            <div class="mb-3">
                                <label for="last_name" class="form-label fw-semibold">Last Name <span
                                        class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control @error('last_name') is-invalid @enderror"
                                    id="last_name"
                                    name="last_name"
                                    value="{{ old('last_name', $user->last_name ?? '') }}"
                                    required
                                >
                                @error('last_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- bio -->
                            <div class="mb-3">
                                <label for="bio" class="form-label fw-semibold">Bio</label>
                                <textarea
                                    class="form-control @error('bio') is-invalid @enderror"
                                    id="bio"
                                    name="bio"
                                    rows="3"
                                >{{ old('bio', $user->bio ?? '') }}</textarea>
                                @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                            </div>

                            <button type="submit" class="btn btn-green w-100 fw-bold">
                                Save Changes
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
