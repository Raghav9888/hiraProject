@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>
            <div class="row ps-5">
                <h3 class="no-request-text mb-4 ps-3">Edit Offering</h3>
                <p style="text-align: start;">Remember, when creating services, you must create separate
                    services for
                    virtual and in-person. This will allow ease for YOU and your potential clients. Feel
                    free to “copy
                    and paste” descriptions from each service offering.</p>
                <div class="add-offering-dv">
                    <form method="POST" action="{{ route('update_offering') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$offering->id}}">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="fw-bold">Offering Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="" value="{{ $offering->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Short Description</label>
                            <textarea class="form-control" name="short_description"
                                      placeholder="please add a full description here"
                                      id="floatingTextarea">{{ $offering->short_description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Description</label>
                            <textarea class="form-control" name="long_description"
                                      placeholder="please add a full description here"
                                      id="floatingTextarea">{{ $offering->long_description}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="fw-bold">Type of offering</label>
                            <select id="type" name="offering_type" class="form-select">
                                <option value="">Select Offering Type</option>
                                <option
                                    value="virtual" {{ $offering->offering_type  == 'virtual' ? 'selected' : ''}}>
                                    Virtual Offering
                                </option>
                                <option
                                    value="in-person" {{ $offering->offering_type  == 'in-person' ? 'selected' : ''}}>
                                    In person Offering
                                </option>
                            </select>
                        </div>
                        <div class="mb-3 {{  $offering->offering_type  == 'in-person' ? '': 'd-none'}}" id="location">
                            <label for="exampleInputEmail1" class="fw-bold">Location</label>
                            <select name="location" class="form-control">
                                @foreach($locations as $location)
                                    <option
                                        value="{{$location->id}}"{{ $offering->location === $location->id  ? 'selected' : '' }}>
                                        {{$location->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="fw-bold">Categories</label>
                            <span>- Specifies the
                                type of
                                service/offering you're providing (e.g. massage is the category and a
                                specific treatment
                                would be Ayuvedic massage and hot stone massage)
                                Practitioner Offerings
                            </span>

                            <select name="categories[]" multiple="multiple" class="form-control category-select2">

                                @foreach($categories as $term)
                                    <option
                                        value="{{$term->id}}" {{ (isset($offering->categories) && in_array($term->id, json_decode($offering->categories))) ? 'selected' : '' }}>{{$term->name}}</option>
                                @endforeach
                            </select>

                        </div>
                        <div class="row">
                            <label for="type" class="fw-bold">Tags</label>
                            <p style="text-align: start;">
                                These are keywords used to help identify more specific versions of something.
                                For example, a good tag for a massage could be "Deep Tissue".
                            </p>
                            <div class="col-md-6">
                                @php
                                    $selectedTags = json_decode($offering->tags ?? '[]', true);
                                @endphp

                                <div class="form-group select2-div">
                                    <select name="tags[]" id="tags" multiple="multiple" class="form-select location-select2">
                                        @foreach($practitionerTag as $tag)
                                            <option value="{{$tag->id}}"
                                                {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                                                {{$tag->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <button class="update-btn mb-2 addterm" data-type="tags">Add
                                    New Term
                                </button>
                            </div>
                        </div>
                        <div id="tags-container">

                        </div>
                        <div class="mb-3">
                            <label class="pt-4 featured-image-tag fw-bold">Featured Image</label>
                            <input type="file" id="fileInput" name="featured_image" class="hidden" accept="image/*"
                                   onchange="previewImage(event)" style="display: none;">
                            @if(isset($offering->featured_image))
                                @php
                                    $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/offering/'  . $offering->featured_image);
                                @endphp
                                <label class="image-preview" id="imagePreview"
                                       style="background-image: url('{{$imageUrl}}'); background-size: cover; background-position: center center;">
                                    <i class="fas fa-trash text-danger fs-3"
                                       data-image="{{ $offering->featured_image }}"
                                       data-user-id="{{ $userDetails->id }}"
                                       data-profile-image="true"
                                       onclick="removeImage(this);" style="cursor: pointer;"></i>
                                </label>
                            @else
                                <label onclick="document.getElementById('fileInput').click();"
                                       class="image-preview" id="imagePreview"
                                       style="border-radius: 50%;">
                                    <span>+</span>
                                </label>
                            @endif
                            <p style="text-align: start;" class="text">Set featured image</p>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="offering-tab"
                                                data-bs-toggle="tab" data-bs-target="#offering" type="button" role="tab"
                                                aria-controls="offering-tab-pane" aria-selected="true">Offering
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="events-tab" data-bs-toggle="tab"
                                                data-bs-target="#events" type="button" role="tab"
                                                aria-controls="events-tab-pane" aria-selected="false">Events
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="package-offering-tab" data-bs-toggle="tab"
                                                data-bs-target="#package_offering" type="button" role="tab"
                                                aria-controls="package-offering-tab-pane" aria-selected="false">Package
                                            offering
                                        </button>
                                    </li>

                                </ul>
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="offering" role="tabpanel"
                                         aria-labelledby="offering-tab" tabindex="0">
                                        <div class="my-4">
                                            <label for="booking-duration" class="fw-bold">Duration of offering</label>
                                            <select id="booking-duration" name="booking_duration" class="form-select">
                                                <option value="">Select</option>
                                                <option
                                                    value="15 minutes" {{ $offering->booking_duration  == '15 minutes' ? 'selected' : ''}}>
                                                    15 minutes
                                                </option>
                                                <option
                                                    value="30 minutes" {{ $offering->booking_duration  == '30 minutes' ? 'selected' : ''}}>
                                                    30 minutes
                                                </option>
                                                <option
                                                    value="45 minutes" {{ $offering->booking_duration  == '45 minutes' ? 'selected' : ''}}>
                                                    45 minutes
                                                </option>
                                                <option
                                                    value="1 hour" {{ $offering->booking_duration  == '1 hour' ? 'selected' : ''}}>
                                                    1 hour
                                                </option>
                                                <option
                                                    value="1:15 hour" {{ $offering->booking_duration  == '1:15 hour' ? 'selected' : ''}}>
                                                    1:15 hour
                                                </option>
                                                <option
                                                    value="1:30 hour" {{ $offering->booking_duration  == '1:30 hour' ? 'selected' : ''}}>
                                                    1:30 hour
                                                </option>
                                                <option
                                                    value="1:45 hour" {{ $offering->booking_duration  == '1:45 hour' ? 'selected' : ''}}>
                                                    1:45 hour
                                                </option>
                                                <option
                                                    value="2 hour" {{ $offering->booking_duration  == '2 hour' ? 'selected' : ''}}>
                                                    2 hour
                                                </option>
                                            </select>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="service-hours" class="fw-bold mb-4">Service hours</label>
                                                <div class="d-flex" style="gap: 20px;">

                                                    <div>
                                                        <label for="service-hours" class="fw-bold">From</label>
                                                        <input type="datetime-local" class="form-control"
                                                               name="from_date"
                                                               value="{{ $offering->from_date ? $offering->from_date : '' }}">
                                                    </div>
                                                    <div>
                                                        <label for="service-hours" class="fw-bold">To</label>
                                                        <input type="datetime-local" class="form-control"
                                                               name="to_date"
                                                               value="{{ $offering->to_date ? $offering->to_date : '' }}">
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-check offering-check">
                                                    <input type="checkbox" class="form-check-input" id="availability"
                                                           name="availability" {{$offering->availability ? 'checked': ''}}>
                                                    <label class="form-check-label mb-3 fw-bold"
                                                           for="availability">Availability</label><br>
                                                    <select id="type" class="form-select" name="availability_type">
                                                        <option value="">Select Availability</option>
                                                        <option
                                                            value="monday" {{$offering->availability_type == 'monday'? 'selected': ''}}>
                                                            Monday
                                                        </option>
                                                        <option
                                                            value="tuesday" {{$offering->availability_type == 'tuesday'? 'selected': ''}}>
                                                            Tuesday
                                                        </option>
                                                        <option
                                                            value="wednesday" {{$offering->availability_type == 'wednesday'? 'selected': ''}}>
                                                            Wednesday
                                                        </option>
                                                        <option
                                                            value="thursday" {{$offering->availability_type == 'thursday'? 'selected': ''}}>
                                                            Thursday
                                                        </option>
                                                        <option
                                                            value="friday" {{$offering->availability_type == 'friday'? 'selected': ''}}>
                                                            Friday
                                                        </option>
                                                        <option
                                                            value="all_week_days" {{$offering->availability_type == 'all_week_days'? 'selected': ''}}>
                                                            All week days
                                                        </option>
                                                        <option
                                                            value="weekends_only" {{$offering->availability_type == 'weekends_only'? 'selected': ''}}>
                                                            Weekends only
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Client price</label>
                                                <input type="text" class="form-control" placeholder=""
                                                       name="client_price" value="{{$offering->client_price}}">
                                            </div>
                                            <div class=" col mb-4">
                                                <label for="tax" class="fw-bold">what % of tax</label>
                                                <input type="text" class="form-control" placeholder="" name="tax_amount"
                                                       value="{{$offering->tax_amount}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Scheduling window</label>
                                                <select id="type" class="form-select" name="scheduling_window">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="15 minutes" {{ $offering->scheduling_window  == '15 minutes' ? 'selected' : ''}}>
                                                        15 minutes
                                                    </option>
                                                    <option
                                                        value="30 minutes" {{ $offering->scheduling_window  == '30 minutes' ? 'selected' : ''}}>
                                                        30 minutes
                                                    </option>
                                                    <option
                                                        value="45 minutes" {{ $offering->scheduling_window  == '45 minutes' ? 'selected' : ''}}>
                                                        45 minutes
                                                    </option>
                                                    <option
                                                        value="1 hour" {{ $offering->scheduling_window  == '1 hour' ? 'selected' : ''}}>
                                                        1 hour
                                                    </option>
                                                    <option
                                                        value="1:15 hour" {{ $offering->scheduling_window  == '1:15 hour' ? 'selected' : ''}}>
                                                        1:15 hour
                                                    </option>
                                                    <option
                                                        value="1:30 hour" {{ $offering->scheduling_window  == '1:30 hour' ? 'selected' : ''}}>
                                                        1:30 hour
                                                    </option>
                                                    <option
                                                        value="1:45 hour" {{ $offering->scheduling_window  == '1:45 hour' ? 'selected' : ''}}>
                                                        1:45 hour
                                                    </option>
                                                    <option
                                                        value="2 hour" {{ $offering->scheduling_window  == '2 hour' ? 'selected' : ''}}>
                                                        2 hour
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Buffer time between
                                                    appointment</label>
                                                <input type="datetime-local" class="form-control" placeholder=""
                                                       name="buffer_time" value="{{$offering->buffer_time}}">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Email template</label>
                                                <textarea class="form-control"
                                                          name="email_template">{{$offering->email_template}}</textarea>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Intake form</label>
                                                <input type="text" class="form-control" name="intake_form"
                                                       placeholder="enter your link" value="{{$offering->intake_form}}">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       data-type="hide" data-id="cancellation_time"
                                                       name="is_cancelled" {{$offering->is_cancelled ? 'checked' : ''}}>
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Cancellation</label>
                                            </div>
                                            <div class="col-md-6 mb-4 {{$offering->is_cancelled ? '' :'d-none'}}"
                                                 id="cancellation_time">
                                                <label class="fw-bold">Cancellation time</label>
                                                <input type="datetime-local" name="cancellation_time_slot"
                                                       class="form-control"
                                                       value="{{$offering->cancellation_time_slot}}">
                                            </div>
                                        </div>
                                        <div class="form-check offering-check">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                   name="is_confirmation" {{$offering->is_confirmation ? 'checked' : ''}}>
                                            <label class="form-check-label mb-3 fw-bold"
                                                   for="can-be-cancelled">Requires Confirmation</label>
                                        </div>
                                        <div class="d-flex" style="gap: 20px;">
                                            <button class="update-btn">Save</button>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab"
                                         tabindex="0">
                                        <h5>Coming soon</h5>
                                    </div>
                                    <div class="tab-pane fade" id="package_offering" role="tabpanel"
                                         aria-labelledby="package-offering-tab" tabindex="0">
                                        <h5>Coming soon</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

