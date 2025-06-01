@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add New Event</h4>
                                <form class="forms-sample" method="POST" action="{{ route('store_offering',['isAdmin' => true]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3 justify-content-center d-flex flex-column align-items-center">
                                        <label class="pt-4 featured-image-tag fw-bold">Featured Image</label>
                                        <input type="file" id="fileInput" name="featured_image"
                                               class="hidden  rounded-4"
                                               accept="image/*"
                                               onchange="previewImage(event)" style="display: none;">
                                        <label for="fileInput" class="image-preview rounded-4" id="imagePreview">
                                            <span>+</span>
                                        </label>
                                        <p style="text-align: start;" class="text">Set featured image</p>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-6 my-2">
                                            <label for="exampleInputEmail1" class="form-label fw-bold">Name</label>
                                            <input type="text" class="form-control" name="name"
                                                   id="exampleInputEmail1"
                                                   aria-describedby="emailHelp" placeholder="Enter event name">
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <label for="floatingTextarea" class="form-label fw-bold">Short
                                                Description</label>
                                            <input class="form-control" name="short_description"
                                                   placeholder="Please add a short description here"
                                                   id="floatingTextarea">
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <label for="floatingTextarea" class="form-label fw-bold">Description</label>
                                            <textarea name="long_description" class="form-control"
                                                      placeholder="Please add a full description here"
                                                      id="floatingTextarea"></textarea>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <label for="type" class="form-label fw-bold">Type of offering</label>
                                            <select id="type" name="offering_type" class="form-select"
                                                    data-type="change"
                                                    data-target-one="location"
                                                    data-add-one-class="d-block"
                                                    data-match-one="in-person">
                                                <option value="">Select Offering Type</option>
                                                <option value="virtual">Virtual Offering</option>
                                                <option value="in-person">In person Offering</option>
                                            </select>

                                            <div class="my-2 d-none" id="location">
                                                <label for="exampleInputEmail1" class="fw-bold">Location</label>
                                                <input type="text" class="form-control" name="location" id="location">
                                            </div>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <label for="exampleInputPassword1"
                                                   class="form-label fw-bold">Categories</label>
                                            <select name="categories[]" multiple="multiple" class="form-select"
                                                    data-type="multiselect"
                                                    id="categories" data-maxshow="3">
                                                @foreach($categories as $term)
                                                    <option value="{{$term->id}}">{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-6 my-2">
                                            <div class="row align-items-center">
                                                <label for="type" class="form-label fw-bold">Tags
                                                    <span data-bs-toggle="tooltip"
                                                          data-bs-placement="top"
                                                          data-bs-title="To add multiple new Tags at once, separate each with a comma (,)">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </span>
                                                </label>
                                                <div class="col-md-6">
                                                    <div class="select2-div">
                                                        <select name="tags[]" id="tags" multiple="multiple"
                                                                class="form-select" data-type="multiselect">
                                                            @foreach($practitionerTag as $term)
                                                                <option value="{{$term->id}}">{{$term->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <button class="btn btn-primary btn-sm addterm" data-type="tags">Add
                                                        New Term
                                                    </button>
                                                </div>
                                            </div>
                                            <div id="tags-container" class="col-md-6">
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="col-md-12">
                                        <label for="type" class="fw-bold">Select the event type</label>
                                        <select name="offering_event_type" class="form-select mb-4">
                                            <option value="offering">Offering</option>
                                            <option value="event">Event</option>
                                        </select>
                                    </div>
                                    <div class="row my-2">
                                        <div class="col-md-12">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="offering-tab" data-bs-toggle="tab" data-bs-target="#offering-content" type="button" role="tab" aria-controls="offering-tab" aria-selected="true">Offering</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="events-tab" data-bs-toggle="tab" data-bs-target="#event-content" type="button" role="tab" aria-controls="events-tab" aria-selected="false">Event</button>
                                                </li>
                                            </ul>
                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="offering-content" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                                                    <div class="my-4">
                                                        <label for="booking-duration" class="fw-bold">Duration of
                                                            offering</label>
                                                        <select id="booking-duration" name="booking_duration_offering"
                                                                class="form-select">
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
                                                    </div>
                                                    <div class="row mb-4">
                                                        <div class="col-md-6">
                                                            <label for="service-hours" class="fw-bold mb-4">Service
                                                                hours</label>
                                                            <select class="form-select"
                                                                    name="availability_type_offering" data-type="change"
                                                                    data-target-one="custom_hours"
                                                                    data-match-one="own_specific_date">
                                                                <option value="following_store_hours">Following store
                                                                    hours
                                                                </option>
                                                                <option value="every_day">Every day</option>
                                                                <option value="every_monday">Every monday</option>
                                                                <option value="every_tuesday">Every tuesday</option>
                                                                <option value="every_wednesday">Every wednesday</option>
                                                                <option value="every_thursday">Every thursday</option>
                                                                <option value="every_friday">Every friday</option>
                                                                <option value="weekend_every_saturday_sunday">Weekends
                                                                    only
                                                                    -
                                                                    Every
                                                                    Sat & Sundays
                                                                </option>
                                                                <option value="own_specific_date">Choose your own
                                                                    specific
                                                                    dates...
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="d-none mt-2" id="custom_hours" style="gap: 20px;">
                                                            <div>
                                                                <label for="service-hours" class="fw-bold">From</label>
                                                                <input type="datetime-local" class="form-control"
                                                                       name="from_date_offering" placeholder="">
                                                            </div>
                                                            <div>
                                                                <label for="service-hours" class="fw-bold">To</label>
                                                                <input type="datetime-local" class="form-control"
                                                                       name="to_date_offering"
                                                                       placeholder="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="service-hours" class="fw-bold">Client
                                                                price</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Please add the price for your offering"
                                                                   name="client_price_offering">
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="tax" class="fw-bold">Tax</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Enter the applicable tax percentage for your offering"
                                                                   name="tax_amount_offering">
                                                            <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="row">
                                                            <div class="col-md-6 mb-4">
                                                                <label for="scheduling_window_offering" class="fw-bold">Scheduling
                                                                    window (How far
                                                                    in
                                                                    advance
                                                                    they can book)</label>

                                                                <div class="row mb-3">
                                                                    <div class="col-md-6 mt-2">
                                                                        <input type="text"
                                                                               id="scheduling_window_offering"
                                                                               class="form-control me-2"
                                                                               name="scheduling_window_offering"
                                                                               placeholder="Please add the price for your offering">
                                                                    </div>
                                                                    <div class="col-md-6 mt-2">
                                                                        <select class="form-select"
                                                                                name="scheduling_window_offering_type">
                                                                            <option value="minute">minute</option>
                                                                            <option value="hour">hour</option>
                                                                            <option value="day">day</option>
                                                                            <option value="month">month</option>
                                                                        </select>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-12 mb-4">
                                                            <label for="buffer_time_offering" class="fw-bold">Buffer
                                                                time
                                                                between
                                                                appointment</label>
                                                            <select id="buffer_time_offering" class="form-select"
                                                                    name="buffer_time_offering">
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
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="d-lg-flex justify-content-between">
                                                                <label for="email_template" class="fw-bold">Email
                                                                    template
                                                                    <span data-bs-toggle="tooltip"
                                                                          data-bs-placement="top"
                                                                          data-bs-title="Google meets link will be auto generated and can share a new link when in meet with them - and make this box to fill out much longer and not optional">
                                                                    <i class="fa-solid fa-circle-info"></i>
                                                                </span>
                                                                </label>


                                                            </div>
                                                            <textarea class="form-control"
                                                                      name="email_template_offering"
                                                                      id="email_template" placeholder=""></textarea>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <label for="intake_form_offering" class="fw-bold">Intake
                                                                form
                                                                (Optional)</label>
                                                            <input type="text" class="form-control"
                                                                   name="intake_form_offering"
                                                                   placeholder="enter your link">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-check offering-check">
                                                            <input type="checkbox" class="form-check-input ms-0"
                                                                   id="can-be-cancelled"
                                                                   data-type="hide" data-id="cancellation_time"
                                                                   name="is_cancelled_offering">
                                                            <label class="form-check-label mb-3 fw-bold"
                                                                   for="can-be-cancelled">Cancellation (How far in
                                                                advance
                                                                can
                                                                this
                                                                be cancelled)</label>
                                                        </div>
                                                        <div class="col-md-6 mb-4 d-none" id="cancellation_time">
                                                            <label class="fw-bold">Cancellation time</label>
                                                            <select id="type" class="form-select"
                                                                    name="cancellation_time_slot_offering">
                                                                <option value="24 hour">24 hours</option>
                                                                <option value="48 hour">48 hours</option>
                                                                <option value="72 hour">72 hours</option>
                                                                <option value="1 week">1 weeks</option>
                                                                <option value="2 week">2 weeks</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-check offering-check">
                                                        <input type="checkbox" class="form-check-input ms-0"
                                                               id="can-be-cancelled"
                                                               name="is_confirmation_offering">
                                                        <label class="form-check-label mb-3 fw-bold"
                                                               for="can-be-cancelled">Requires Confirmation</label>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="event-content" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                                    <div class="my-4">
                                                        <label for="specify" class="fw-bold">Specify</label>
                                                        <select id="specify" name="specify_event" class="form-select"
                                                                data-type="change"
                                                                data-target-one="date_and_time_div"
                                                                data-match-one="one_time_event"
                                                                data-match-two="recurring_event"
                                                                data-target-two="recurring_day_div">
                                                            <option value="">Select the event type</option>
                                                            <option value="one_time_event">One time event</option>
                                                            <option value="recurring_event">Recurring event</option>
                                                        </select>
                                                    </div>

                                                    <div class="mb-4 d-none flex-column" id="date_and_time_div">
                                                        <label for="service-hours" class="fw-bold">Date and time</label>
                                                        <input type="datetime-local" class="form-control" placeholder=""
                                                               name="date_and_time_event">
                                                    </div>

                                                    <div class="mb-4 d-none flex-column" id="recurring_day_div">
                                                        <label class="fw-bold">Recurring Days</label>
                                                        <select id="type" class="form-select"
                                                                name="recurring_days_event">
                                                            <option value="every_day">Every day</option>
                                                            <option value="every_monday">Every monday</option>
                                                            <option value="every_tuesday">Every tuesday</option>
                                                            <option value="every_wednesday">Every wednesday</option>
                                                            <option value="every_thursday">Every thursday</option>
                                                            <option value="every_friday">Every friday</option>
                                                            <option value="weekend_every_saturday_sunday">Weekends only
                                                                -
                                                                Every
                                                                Sat & Sundays
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="my-4">
                                                        <label for="booking-duration" class="fw-bold">Duration of
                                                            event</label>
                                                        <select id="event-duration" name="event_duration_event"
                                                                class="form-select">
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
                                                    </div>
                                                    <div class="mb-4">
                                                        <label for="sports" class="fw-bold">How many sports are
                                                            available</label>
                                                        <input type="text" id="sports" class="form-control"
                                                               placeholder="Type the available spots in numbers"
                                                               name="sports_event">
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-6 mb-4">
                                                            <label for="service-hours" class="fw-bold">Client
                                                                price</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Please add the price for your offering"
                                                                   name="client_price_event">
                                                        </div>
                                                        <div class="col-md-6 mb-4">
                                                            <label for="tax" class="fw-bold">Tax</label>
                                                            <input type="text" class="form-control"
                                                                   placeholder="Enter the applicable tax percentage for your offering"
                                                                   name="tax_amount_event">
                                                            <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12 mb-4">
                                                            <label for="scheduling_window_event" class="fw-bold">Scheduling
                                                                window (How far in
                                                                advance
                                                                they can book)</label>

                                                            <div class="d-flex mb-3">
                                                                <input type="text" class="form-control me-2"
                                                                       name="scheduling_window_event"
                                                                       id="scheduling_window_event"
                                                                       placeholder="Please add the price for your offering">
                                                                <select class="form-select"
                                                                        name="scheduling_window_event_type">
                                                                    <option value="minute">minute</option>
                                                                    <option value="hour">hour</option>
                                                                    <option value="day">day</option>
                                                                    <option value="month">month</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-lg-6 mb-4">
                                                            <div class="d-lg-flex justify-content-between">
                                                                <label for="service-hours" class="fw-bold">Email
                                                                    template
                                                                    <span data-bs-toggle="tooltip"
                                                                          data-bs-placement="top"
                                                                          data-bs-title="Google meets link will be auto generated and can share a new link when in meet with them - and make this box to fill out much longer and not optional">
                                                                    <i class="fa-solid fa-circle-info"></i>
                                                                </span>
                                                                </label>
                                                            </div>
                                                            <textarea class="form-control" name="email_template_event"
                                                                      id="email_template"
                                                                      placeholder=""></textarea>
                                                        </div>
                                                        <div class="col-lg-6 mb-4">
                                                            <label for="intake_form_event" class="fw-bold">Intake form
                                                                (Optional)</label>
                                                            <input type="text" class="form-control"
                                                                   name="intake_form_event"
                                                                   placeholder="enter your link">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4">
                                                        <div class="form-check offering-check">
                                                            <input type="checkbox" class="form-check-input ms-0"
                                                                   id="can-be-cancelled"
                                                                   data-type="hide" data-id="cancellation_time_event"
                                                                   name="is_cancelled_event">
                                                            <label class="form-check-label mb-3 fw-bold"
                                                                   for="can-be-cancelled">Cancellation (How far in
                                                                advance
                                                                can
                                                                this
                                                                be cancelled)</label>
                                                        </div>
                                                        <div class="col-md-6 mb-4 d-none" id="cancellation_time_event">
                                                            <label class="fw-bold">Cancellation time</label>
                                                            <select id="type" class="form-select"
                                                                    name="cancellation_time_slot_event">
                                                                <option value="15 minutes">15 minutes</option>
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
                                                        <input type="checkbox" class="form-check-input ms-0"
                                                               id="can-be-cancelled"
                                                               name="is_confirmation_event">
                                                        <label class="form-check-label mb-3 fw-bold"
                                                               for="can-be-cancelled">Requires Confirmation</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center" style="gap: 20px;">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const offeringSelect = document.querySelector('select[name="offering_event_type"]');
            const offeringTab = document.getElementById("offering-tab");
            const eventTab = document.getElementById("events-tab");
            const offeringContent = document.getElementById("offering-content");
            const eventContent = document.getElementById("event-content");

            function toggleTabs() {
                const value = offeringSelect.value;

                if (value === "offering") {
                    // Enable Offering, disable Events
                    offeringTab.classList.remove("disabled");
                    eventTab.classList.add("disabled");

                    // Activate Offering tab
                    offeringTab.classList.add("active");
                    eventTab.classList.remove("active");

                    // Show Offering content only
                    offeringContent.classList.add("show", "active");
                    eventContent.classList.remove("show", "active");

                } else if (value === "event") {
                    // Enable Events, disable Offering
                    eventTab.classList.remove("disabled");
                    offeringTab.classList.add("disabled");

                    // Activate Events tab
                    eventTab.classList.add("active");
                    offeringTab.classList.remove("active");

                    // Show Event content only
                    offeringContent.classList.remove("show", "active");
                    eventContent.classList.add("show", "active");
                } else {
                    // If nothing selected, reset both
                    offeringTab.classList.remove("disabled", "active");
                    eventTab.classList.remove("disabled", "active");

                    offeringContent.classList.remove("show", "active");
                    eventContent.classList.remove("show", "active");
                }
            }

            // Initial state
            toggleTabs();

            // Listen for changes
            offeringSelect.addEventListener("change", toggleTabs);
        });
    </script>


@endsection
