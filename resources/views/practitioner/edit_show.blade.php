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
                    <h2 class="mb-4">Edit Practitioner Show</h2>
                    <div class="add-offering-dv">
                        <form action="{{ route('practitionerShowUpdate', ['id' => $show->id]) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="show_type">Show Type</label>
                                    <select name="show_type" id="show_type" class="form-control">
                                        <option value="">-- Select Show Type --</option>
                                        <option
                                            value="offering" {{ old('show_type', $show->show_type ?? '') == 'offering' ? 'selected' : '' }}>
                                            Offering
                                        </option>
                                        <option
                                            value="product" {{ old('show_type', $show->show_type ?? '') == 'product' ? 'selected' : '' }}>
                                            Product
                                        </option>
                                    </select>

                                    @error('show_type')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    id="name"
                                    value="{{ old('name', $show->name) }}"
                                    required>
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration</label>
                                <select id="duration" name="duration" class="form-select" required>
                                    <option value="">Select duration</option>
                                    @php
                                        $durations = [
                                            '15 minutes', '20 minutes', '30 minutes', '45 minutes', '50 minutes',
                                            '1 hour', '1:15 hour', '1:30 hour', '1:45 hour', '1:50 hour',
                                            '2 hour', '3 hour', '4 hour',
                                            '1 Month', '2 Month', '3 Month', '4 Month'
                                        ];
                                    @endphp
                                    @foreach ($durations as $duration)
                                        <option
                                            value="{{ $duration }}" {{ old('duration', $show->duration) === $duration ? 'selected' : '' }}>
                                            {{ $duration }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('duration')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input
                                    type="text"
                                    name="price"
                                    class="form-control"
                                    id="price"
                                    value="{{ $show->price }}"
                                    required>
                                @error('price')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

{{--                            <div class="mb-3">--}}
{{--                                <label for="tax" class="form-label">Tax</label>--}}
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    name="tax"--}}
{{--                                    class="form-control"--}}
{{--                                    id="tax"--}}
{{--                                    value="{{ old('tax', $show->tax ?? 13) }}">--}}
{{--                                @error('tax')--}}
{{--                                <div class="text-danger">{{ $message }}</div>--}}
{{--                                @enderror--}}
{{--                            </div>--}}

                            <button type="submit" class="btn btn-green">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
