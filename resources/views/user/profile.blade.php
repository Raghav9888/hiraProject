@extends('layouts.user_internal_base')

@section('userContent')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
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

                            <!-- Name Row -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="first_name" class="form-label fw-semibold">First Name <span class="text-danger">*</span></label>
                                    <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                           value="{{ old('first_name', $user->first_name ?? '') }}" required>
                                    @error('first_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="middle_name" class="form-label fw-semibold">Middle Name</label>
                                    <input type="text" name="middle_name" id="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                                           value="{{ old('middle_name', $user->middle_name ?? '') }}">
                                    @error('middle_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="last_name" class="form-label fw-semibold">Last Name <span class="text-danger">*</span></label>
                                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                           value="{{ old('last_name', $user->last_name ?? '') }}" required>
                                    @error('last_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Email & Phone -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="email" class="form-label fw-semibold">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email', $user->userDetail->email ?? '') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label fw-semibold">Phone</label>
                                    <input type="text" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror"
                                           value="{{ old('phone', $user->userDetail->phone ?? '') }}">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Address Line 1 & 2 -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="address_line_1" class="form-label fw-semibold">Address Line 1</label>
                                    <input type="text" name="address_line_1" id="address_line_1" class="form-control @error('address_line_1') is-invalid @enderror"
                                           value="{{ old('address_line_1', $user->userDetail->address_line_1 ?? '') }}">
                                    @error('address_line_1') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="address_line_2" class="form-label fw-semibold">Address Line 2</label>
                                    <input type="text" name="address_line_2" id="address_line_2" class="form-control @error('address_line_2') is-invalid @enderror"
                                           value="{{ old('address_line_2', $user->userDetail->address_line_2 ?? '') }}">
                                    @error('address_line_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="postcode" class="form-label fw-semibold">Postcode</label>
                                    <input type="text" name="postcode" id="postcode" class="form-control @error('postcode') is-invalid @enderror"
                                           value="{{ old('postcode', $user->userDetail->postcode ?? '') }}">
                                    @error('postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- City, State, Country -->
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="city" class="form-label fw-semibold">City</label>
                                    <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                                           value="{{ old('city', $user->userDetail->city ?? '') }}">
                                    @error('city') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="state" class="form-label fw-semibold">State</label>
                                    <input type="text" name="state" id="state" class="form-control @error('state') is-invalid @enderror"
                                           value="{{ old('state', $user->userDetail->state ?? '') }}">
                                    @error('state') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-4">
                                    <label for="country" class="form-label fw-semibold">Country</label>
                                    <input type="text" name="country" id="country" class="form-control @error('country') is-invalid @enderror"
                                           value="{{ old('country', $user->userDetail->country ?? '') }}">
                                    @error('country') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Bio -->
                            <div class="mb-3">
                                <label for="bio" class="form-label fw-semibold">Bio</label>
                                <textarea name="bio" id="bio" class="form-control @error('bio') is-invalid @enderror" rows="4">{{ old('bio', $user->userDetail->bio ?? '') }}</textarea>
                                @error('bio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-green w-100 fw-bold">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
