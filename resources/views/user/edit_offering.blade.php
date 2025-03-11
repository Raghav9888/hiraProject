@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>
            <div class="row ps-5">
                <h3 class="no-request-text mb-4 ps-3">Add Offering</h3>
                <div class="add-offering-dv">
                    <form method="POST" action="{{ route('update_offering') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{$offering->id}}">
                        <div class="mb-3 justify-content-center d-flex flex-column align-items-center">
                            <label class="pt-4 featured-image-tag fw-bold">Featured Image</label>
                            <input type="file" id="fileInput" name="featured_image rounded-4" class="hidden"
                                   accept="image/*"
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

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bold">Offering Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="" value="{{ $offering->name}}">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Short Description</label>
                            <textarea class="form-control" name="short_description"
                                      placeholder="Please add a short description here"
                                      id="floatingTextarea">{{ $offering->short_description}}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Description</label>
                            <textarea class="form-control" name="long_description"
                                      placeholder="Please add a full description here"
                                      id="floatingTextarea">{{ $offering->long_description}}</textarea>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="fw-bold">Type of offering</label>
                            <select id="type" name="offering_type" class="form-select">
                                <option value="">Select Offering Type</option>
                                <option value="virtual" {{ $offering->offering_type  == 'virtual' ? 'selected' : ''}}>
                                    Virtual Offering
                                </option>
                                <option
                                    value="in-person" {{ $offering->offering_type  == 'in-person' ? 'selected' : ''}}>In
                                    person Offering
                                </option>
                            </select>
                        </div>
                        <div class="mb-3 {{  $offering->offering_type  == 'in-person' ? '': 'd-none'}}" id="location">
                            <label for="exampleInputEmail1" class="fw-bold">Location</label>
                            <select name="location" class="form-control">
                                @foreach($locations as $location)
                                    <option
                                        value="{{$location->id}}" {{ $offering->location === $location->id  ? 'selected' : '' }}>
                                        {{$location->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="fw-bold">Categories</label>
                            <span>-Specifies the type of
                                service/offering you're providing (e.g. massage is the category and a
                                specific treatment
                                would be Ayuvedic massage and hot stone massage)
                                Practitioner Offerings
                            </span>
                            <select name="categories[]" multiple="multiple" class="form-control category-select2" id="">
                                @foreach($categories as $term)
                                    <option
                                        value="{{$term->id}}" {{ (isset($offering->categories) && in_array($term->id, json_decode($offering->categories))) ? 'selected' : '' }}>{{$term->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="row">
                            <label for="type" class="fw-bold">Tags</label>
                            <p style="text-align: start;">These are keywords used to help
                                identify more
                                specific
                                versions of something. For example, a good tag for a massage
                                could be
                                "Deep
                                Tissue".</p>
                            <div class="col-md-6">
                                @php
                                    $selectedTags = json_decode($offering->tags ?? '[]', true);
                                @endphp
                                <div class="form-group select2-div">
                                    <select name="tags[]" id="tags" multiple="multiple"
                                            class="form-select location-select2">
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
                                            <select id="booking-duration" name="booking_duration_offering" class="form-select">
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
                                                <select id="type" class="form-select" name="availability_type_offering">
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
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Client price</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Please add the price for your offering"
                                                       name="client_price_offering" value="{{$offering->client_price}}">
                                            </div>
                                            <div class=" col mb-4">
                                                <label for="tax" class="fw-bold">Tax</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter the applicable tax percentage for your offering"
                                                       name="tax_amount_offering" value="{{$offering->tax_amount}}">
                                                <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Scheduling window (How far in advance
                                                    they can book)</label>
                                                <select id="type" class="form-select" name="scheduling_window_offering">
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
                                                <select id="type" class="form-select" name="buffer_time_offering">
                                                    <option value="">Select</option>
                                                    <option
                                                        value="15 minutes" {{ $offering->buffer_time  == '15 minutes' ? 'selected' : ''}}>
                                                        15 minutes
                                                    </option>
                                                    <option
                                                        value="30 minutes" {{ $offering->buffer_time  == '30 minutes' ? 'selected' : ''}}>
                                                        30 minutes
                                                    </option>
                                                    <option
                                                        value="45 minutes" {{ $offering->buffer_time  == '45 minutes' ? 'selected' : ''}}>
                                                        45 minutes
                                                    </option>
                                                    <option
                                                        value="1 hour" {{ $offering->buffer_time  == '1 hour' ? 'selected' : ''}}>
                                                        1 hour
                                                    </option>
                                                    <option
                                                        value="1:15 hour" {{ $offering->buffer_time  == '1:15 hour' ? 'selected' : ''}}>
                                                        1:15 hour
                                                    </option>
                                                    <option
                                                        value="1:30 hour" {{ $offering->buffer_time  == '1:30 hour' ? 'selected' : ''}}>
                                                        1:30 hour
                                                    </option>
                                                    <option
                                                        value="1:45 hour" {{ $offering->buffer_time  == '1:45 hour' ? 'selected' : ''}}>
                                                        1:45 hour
                                                    </option>
                                                    <option
                                                        value="2 hour" {{ $offering->buffer_time  == '2 hour' ? 'selected' : ''}}>
                                                        2 hour
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col mb-4">
                                                <div class="d-flex justify-content-between">
                                                    <label for="service-hours" class="fw-bold">Email template</label>

                                                    <p>Maximum length of 500 words</p>
                                                </div>
                                                <textarea class="form-control" name="email_template_offering"
                                                          id="email_template"
                                                          placeholder="">{{$offering?->email_template}}</textarea>
                                                <p id="word-count">0 / 500 words</p>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Intake form
                                                    (Optional)</label>
                                                <input type="text" class="form-control" name="intake_form_offering"
                                                       placeholder="enter your link"
                                                       value="{{$offering?->intake_form}}">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       data-type="hide" data-id="cancellation_time"
                                                       name="is_cancelled_offering" {{$offering->is_cancelled ? 'checked' : ''}}>
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Cancellation (How far in advance can this
                                                    be cancelled)</label>
                                            </div>
                                            <div class="col-md-6 mb-4 d-none" id="cancellation_time">
                                                <label class="fw-bold">Cancellation time</label>
                                                <select id="type" class="form-select"
                                                        name="cancellation_time_slot_offering">
                                                    <option
                                                        value="15 minutes" {{ $offering->cancellation_time_slot === '15 minutes'? 'selected':'' }}>
                                                        15 minutes
                                                    </option>
                                                    <option value="30 minutes" {{ $offering->cancellation_time_slot === '30 minutes'? 'selected':'' }}>30 minutes</option>
                                                    <option value="45 minutes" {{ $offering->cancellation_time_slot === '45 minutes'? 'selected':'' }}>45 minutes</option>
                                                    <option value="1 hour" {{ $offering->cancellation_time_slot === '1 hour'? 'selected':'' }}>1 hour</option>
                                                    <option value="2 hour" {{ $offering->cancellation_time_slot === '2 hour'? 'selected':'' }}>2 hour</option>
                                                    <option value="4 hour" {{ $offering->cancellation_time_slot === '4 hour'? 'selected':'' }}>4 hour</option>
                                                    <option value="8 hour" {{ $offering->cancellation_time_slot === '8 hour'? 'selected':'' }}>8 hour</option>
                                                    <option value="12 hour" {{ $offering->cancellation_time_slot === '12 hour'? 'selected':'' }}>12 hour</option>
                                                    <option value="24 hour" {{ $offering->cancellation_time_slot === '24 hour'? 'selected':'' }}>24 hour</option>
                                                    <option value="48 hour" {{ $offering->cancellation_time_slot === '48 hour'? 'selected':'' }}>48 hour</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-check offering-check">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                   name="is_confirmation_offering" {{$offering->is_confirmation ? 'checked' : ''}}>
                                            <label class="form-check-label mb-3 fw-bold" for="can-be-cancelled">Requires
                                                Confirmation</label>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="events" role="tabpanel" aria-labelledby="events-tab"
                                         tabindex="0">

                                        <div class="my-4">
                                            <label for="specify" class="fw-bold">Specify</label>
                                            <select id="specify" name="specify" class="form-select"
                                                    data-type="change"
                                                    data-target-one="date_and_time_div"
                                                    data-match-one="one_time_event" data-match-two="recurring_event"
                                                    data-target-two="recurring_day_div">
                                                <option value="">Select the event type</option>
                                                <option
                                                    value="one_time_event" {{$offering->event?->specify === 'one_time_event' ? 'selected' : ''}}>
                                                    One time event
                                                </option>
                                                <option
                                                    value="recurring_event" {{$offering->event?->specify === 'recurring_event' ? 'selected' : ''}}>
                                                    Recurring event
                                                </option>
                                            </select>
                                        </div>

                                        <div
                                            class="mb-4 {{$offering->event?->specify === 'one_time_event' ?:'d-none'}} flex-column"
                                            id="date_and_time_div">
                                            <label for="service-hours" class="fw-bold">Date and time</label>
                                            <input type="datetime-local" class="form-control" placeholder=""
                                                   name="date_and_time" value="{{$offering->event?->date_and_time}}">
                                        </div>

                                        <div
                                            class="mb-4 {{$offering->event?->specify === 'recurring_event' ?:'d-none'}} flex-column"
                                            id="recurring_day_div">
                                            <label class="fw-bold">Recurring Days</label>
                                            <select id="type" class="form-select" name="recurring_days">
                                                <option
                                                    value="every_day" {{$offering->event?->recurring_days === 'every_day' ? 'selected':''}}>
                                                    Every day
                                                </option>
                                                <option
                                                    value="every_monday" {{$offering->event?->recurring_days === 'every_monday' ? 'selected':''}}>
                                                    Every monday
                                                </option>
                                                <option
                                                    value="every_tuesday" {{$offering->event?->recurring_days === 'every_tuesday' ? 'selected':''}}>
                                                    Every tuesday
                                                </option>
                                                <option
                                                    value="every_wednesday" {{$offering->event?->recurring_days === 'every_wednesday' ? 'selected':''}}>
                                                    Every wednesday
                                                </option>
                                                <option
                                                    value="every_thursday" {{$offering->event?->recurring_days === 'every_thursday' ? 'selected':''}}>
                                                    Every thursday
                                                </option>
                                                <option
                                                    value="every_friday" {{$offering->event?->recurring_days === 'every_friday' ? 'selected':''}}>
                                                    Every friday
                                                </option>
                                                <option
                                                    value="weekend_every_saturday_sunday" {{$offering->event?->recurring_days === 'weekend_every_saturday_sunday' ? 'selected':''}}>
                                                    Weekends only - Every
                                                    Sat & Sundays
                                                </option>
                                            </select>
                                        </div>
                                        <div class="my-4">
                                            <label for="booking-duration" class="fw-bold">Duration of event</label>
                                            <select id="event-duration" name="event_duration" class="form-select">
                                                <option
                                                    value="15 minutes" {{$offering->event?->event_duration === '15 minutes' ? 'selected':''}} >
                                                    15 minutes
                                                </option>
                                                <option
                                                    value="20 minutes" {{$offering->event?->event_duration === '20 minutes' ? 'selected':''}}>
                                                    20 minutes
                                                </option>
                                                <option
                                                    value="30 minutes" {{$offering->event?->event_duration === '30 minutes' ? 'selected':''}}>
                                                    30 minutes
                                                </option>
                                                <option
                                                    value="45 minutes" {{$offering->event?->event_duration === '45 minutes' ? 'selected':''}}>
                                                    45 minutes
                                                </option>
                                                <option
                                                    value="50 minutes" {{$offering->event?->event_duration === '50 minutes' ? 'selected':''}}>
                                                    50 minutes
                                                </option>
                                                <option
                                                    value="1 hour" {{$offering->event?->event_duration === '1 hour' ? 'selected':''}}>
                                                    1 hour
                                                </option>
                                                <option
                                                    value="1:15 hour" {{$offering->event?->event_duration === '1:15 hour' ? 'selected':''}}>
                                                    1:15 hour
                                                </option>
                                                <option
                                                    value="1:30 hour" {{$offering->event?->event_duration === '1:30 hour' ? 'selected':''}}>
                                                    1:30 hour
                                                </option>
                                                <option
                                                    value="1:45 hour" {{$offering->event?->event_duration === '1:45 hour' ? 'selected':''}}>
                                                    1:45 hour
                                                </option>
                                                <option
                                                    value="1:50 hour" {{$offering->event?->event_duration === '1:50 hour' ? 'selected':''}}>
                                                    1:50 hour
                                                </option>
                                                <option
                                                    value="2 hour" {{$offering->event?->event_duration === '2 hour' ? 'selected':''}}>
                                                    2 hours
                                                </option>
                                                <option
                                                    value="3 hour" {{$offering->event?->event_duration === '3 hour' ? 'selected':''}}>
                                                    3 hour
                                                </option>
                                                <option
                                                    value="4 hour" {{$offering->event?->event_duration === '4 hour' ? 'selected':''}}>
                                                    4 hour
                                                </option>
                                                <option
                                                    value="1 Month" {{$offering->event?->event_duration === '1 Month' ? 'selected':''}}>
                                                    1 Month
                                                </option>
                                                <option
                                                    value="2 Month" {{$offering->event?->event_duration === '2 Month' ? 'selected':''}}>
                                                    2 Months
                                                </option>
                                                <option
                                                    value="3 Month" {{$offering->event?->event_duration === '3 Month' ? 'selected':''}}>
                                                    3 Months
                                                </option>
                                                <option
                                                    value="4 Month" {{$offering->event?->event_duration === '4 Month' ? 'selected':''}}>
                                                    4 Months
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="sports" class="fw-bold">How many sports are
                                                available</label>
                                            <input type="text" id="sports" class="form-control"
                                                   placeholder="Type the available spots in numbers" name="sports"
                                                   value="{{$offering->event?->sports}}">
                                        </div>

                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Client price</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Please add the price for your offering"
                                                       name="client_price_event"
                                                       value="{{$offering->event?->client_price}}">
                                            </div>
                                            <div class=" col mb-4">
                                                <label for="tax" class="fw-bold">Tax</label>
                                                <input type="text" class="form-control"
                                                       placeholder="Enter the applicable tax percentage for your offering"
                                                       name="tax_amount" value="{{$offering->event?->tax_amount}}">
                                                <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Scheduling window (How far in
                                                    advance
                                                    they can book)</label>
                                                <select id="type" class="form-select" name="scheduling_window">
                                                    <option
                                                        value="15 minutes" {{$offering->event?->scheduling_window === '15 minutes' ? 'selected':''}} >
                                                        15 minutes
                                                    </option>
                                                    <option
                                                        value="20 minutes" {{$offering->event?->scheduling_window === '20 minutes' ? 'selected':''}}>
                                                        20 minutes
                                                    </option>
                                                    <option
                                                        value="30 minutes" {{$offering->event?->scheduling_window === '30 minutes' ? 'selected':''}}>
                                                        30 minutes
                                                    </option>
                                                    <option
                                                        value="45 minutes" {{$offering->event?->scheduling_window === '45 minutes' ? 'selected':''}}>
                                                        45 minutes
                                                    </option>
                                                    <option
                                                        value="50 minutes" {{$offering->event?->scheduling_window === '50 minutes' ? 'selected':''}}>
                                                        50 minutes
                                                    </option>
                                                    <option
                                                        value="1 hour" {{$offering->event?->scheduling_window === '1 hour' ? 'selected':''}}>
                                                        1 hour
                                                    </option>
                                                    <option
                                                        value="1:15 hour" {{$offering->event?->scheduling_window === '1:15 hour' ? 'selected':''}}>
                                                        1:15 hour
                                                    </option>
                                                    <option
                                                        value="1:30 hour" {{$offering->event?->scheduling_window === '1:30 hour' ? 'selected':''}}>
                                                        1:30 hour
                                                    </option>
                                                    <option
                                                        value="1:45 hour" {{$offering->event?->scheduling_window === '1:45 hour' ? 'selected':''}}>
                                                        1:45 hour
                                                    </option>
                                                    <option
                                                        value="1:50 hour" {{$offering->event?->scheduling_window === '1:50 hour' ? 'selected':''}}>
                                                        1:50 hour
                                                    </option>
                                                    <option
                                                        value="2 hour" {{$offering->event?->scheduling_window === '2 hour' ? 'selected':''}}>
                                                        2 hours
                                                    </option>
                                                    <option
                                                        value="3 hour" {{$offering->event?->scheduling_window === '3 hour' ? 'selected':''}}>
                                                        3 hour
                                                    </option>
                                                    <option
                                                        value="4 hour" {{$offering->event?->scheduling_window === '4 hour' ? 'selected':''}}>
                                                        4 hour
                                                    </option>
                                                    <option
                                                        value="1 Month" {{$offering->event?->scheduling_window === '1 Month' ? 'selected':''}}>
                                                        1 Month
                                                    </option>
                                                    <option
                                                        value="2 Month" {{$offering->event?->scheduling_window === '2 Month' ? 'selected':''}}>
                                                        2 Months
                                                    </option>
                                                    <option
                                                        value="3 Month" {{$offering->event?->scheduling_window === '3 Month' ? 'selected':''}}>
                                                        3 Months
                                                    </option>
                                                    <option
                                                        value="4 Month" {{$offering->event?->scheduling_window === '4 Month' ? 'selected':''}}>
                                                        4 Months
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <div class="d-flex justify-content-between">
                                                    <label for="service-hours" class="fw-bold">Email
                                                        template</label>

                                                    <p>Maximum length of 500 words</p>
                                                </div>
                                                <textarea class="form-control" name="email_template"
                                                          id="email_template"
                                                          placeholder="">{{$offering->event?->email_template}}</textarea>
                                                <p id="word-count">0 / 500 words</p>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Intake form
                                                    (Optional)</label>
                                                <input type="text" class="form-control" name="intake_form"
                                                       placeholder="enter your link"
                                                       value="{{$offering->event?->intake_form}}">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input"
                                                       id="can-be-cancelled"
                                                       data-type="hide" data-id="cancellation_time"
                                                       name="is_cancelled" {{$offering->event?->is_cancelled ? 'checked' : ''}}>
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Cancellation (How far in advance can
                                                    this
                                                    be cancelled)</label>
                                            </div>
                                            <div
                                                class="col-md-6 mb-4 {{$offering->event?->is_cancelled ?'' : 'd-none' }}"
                                                id="cancellation_time">
                                                <label class="fw-bold">Cancellation time</label>
                                                <select id="type" class="form-select" name="cancellation_time_slot">
                                                    <option
                                                        value="15 minutes" {{$offering->event?->cancellation_time_slot ==='15 minutes' ?'selected' : '' }}>15 minutes</option>
                                                    <option value="30 minutes">30 minutes</option>
                                                    <option value="45 minutes">45 minutes</option>
                                                    <option value="1 hour">1 hour</option>
                                                    <option value="2 hour">2 hour</option>
                                                    <option value="4 hour">4 hour</option>
                                                    <option value="8 hour">8 hour</option>
                                                    <option value="12 hour">12 hour</option>
                                                    <option value="24 hour">24 hour</option>
                                                    <option value="48 hour">48 hour</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-check offering-check">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                   name="is_confirmation">
                                            <label class="form-check-label mb-3 fw-bold"
                                                   for="can-be-cancelled">Requires Confirmation</label>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="package_offering" role="tabpanel"
                                         aria-labelledby="package-offering-tab" tabindex="0">
                                        <h5>Coming soon</h5>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex" style="gap: 20px;">
                            <button class="update-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(document).on('change', '[data-type="change"]', function (e) {
            let targetOneValue = $(this).data('target-one');
            let matchOneValue = $(this).data('match-one');

            let targetTwoValue = $(this).data('target-two');
            let matchTwoValue = $(this).data('match-two');

            if ((targetOneValue && targetOneValue.length > 0) && (matchOneValue && matchOneValue.length > 0)) {
                $(this).val() == matchOneValue ? $(`#${targetOneValue}`).removeClass('d-none').addClass('d-flex') : $(`#${targetOneValue}`).addClass('d-none').removeClass('d-flex')
            }

            if ((targetTwoValue && targetTwoValue.length > 0) && (matchTwoValue && matchTwoValue.length > 0)) {
                $(this).val() == matchTwoValue ? $(`#${targetTwoValue}`).removeClass('d-none').addClass('d-flex') : $(`#${targetTwoValue}`).addClass('d-none').removeClass('d-flex')
            }


        });
    </script>
@endsection

