@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container">
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>
                <div class="col-12">
                    <h2 class="mb-4">Practitioner Add Show</h2>
                    <div class="add-offering-dv">
                        <form action="{{ route('practitionerShowStore') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <select id="duration" name="duration" class="form-select" required>
                                    <option value="">Select duration</option>
                                    <option value="15 minutes">15 minutes</option>
                                    <option value="20 minutes">20 minutes</option>
                                    <option value="30 minutes">30 minutes</option>
                                    <option value="45 minutes">45 minutes</option>
                                    <option value="50 minutes">50 minutes</option>
                                    <option value="1 hour">1 hour</option>
                                    <option value="1:15 hour">1:15 hour</option>
                                    <option value="1:30 hour">1:30 hour</option>
                                    <option value="1:45 hour">1:45 hour</option>
                                    <option value="1:50 hour">1:50 hour</option>
                                    <option value="2 hour">2 hours</option>
                                    <option value="3 hour">3 hour</option>
                                    <option value="4 hour">4 hour</option>
                                    <option value="1 Month">1 Month</option>
                                    <option value="2 Month">2 Months</option>
                                    <option value="3 Month">3 Months</option>
                                    <option value="4 Month">4 Months</option>
                                </select>
                                @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="text"  name="price" class="form-control" id="price" required>
                                @error('price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tax" class="form-label">Tax</label>
                                <input type="text" name="tax" class="form-control" id="tax">
                                @error('tax')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-green">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
