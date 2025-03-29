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
                    <form method="POST" action="{{ route('store_offering') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3 justify-content-center d-flex flex-column align-items-center">
                            <label class="pt-4 featured-image-tag fw-bold">Featured Image</label>
                            <input type="file" id="fileInput" name="featured_image" class="hidden  rounded-4"
                                   accept="image/*"
                                   onchange="previewImage(event)" style="display: none;">
                            <label for="fileInput" class="image-preview rounded-4" id="imagePreview">
                                <span>+</span>
                            </label>
                            <p style="text-align: start;" class="text">Set featured image</p>
                        </div>

                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bold">Offering Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Short Description</label>
                            <textarea class="form-control" name="short_description"
                                      placeholder="Please add a short description here"
                                      id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Description</label>
                            <textarea class="form-control" name="long_description"
                                      placeholder="Please add a full description here" id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-4">
                            <label for="type" class="fw-bold">Type of offering</label>
                            <select id="type" name="offering_type" class="form-select">
                                <option value="">Select Offering Type</option>
                                <option value="virtual">Virtual Offering</option>
                                <option value="in-person">In person Offering</option>
                            </select>
                        </div>
                        <div class="mb-3 d-none" id="location">
                            <label for="exampleInputEmail1" class="fw-bold">Location</label>
                            <select name="location" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}">
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
                            <select name="categories[]" multiple="multiple" class="form-control" data-type="multiselect"
                                    id="categories" data-maxshow="3">
                                @foreach($categories as $term)
                                    <option value="{{$term->id}}">{{$term->name}}</option>
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
                                <div class="form-group select2-div">
                                    <select name="tags[]" id="tags" multiple="multiple"
                                            class="form-select" data-type="multiselect">
                                        @foreach($practitionerTag as $term)
                                            <option value="{{$term->id}}">{{$term->name}}</option>
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
                            <div class="row">
                                <div class="col-md-12">
                                    <label for="type" class="fw-bold">Select the event type</label>
                                    <select name="offering_event_type" class="form-select mb-4">
                                        <option value="offering">Offering</option>
                                        <option value="event">Event</option>
                                    </select>
                                </div>
                                <hr>

                                <div class="col-md-12">
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="offering-tab"
                                                    data-bs-toggle="tab" data-bs-target="#offering" type="button"
                                                    role="tab"
                                                    aria-controls="offering-tab-pane" aria-selected="true">Offering
                                            </button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="events-tab" data-bs-toggle="tab"
                                                    data-bs-target="#events" type="button" role="tab"
                                                    aria-controls="events-tab-pane" aria-selected="false">Events
                                            </button>
                                        </li>
                                        {{--                                    <li class="nav-item" role="presentation">--}}
                                        {{--                                        <button class="nav-link" id="package-offering-tab" data-bs-toggle="tab"--}}
                                        {{--                                                data-bs-target="#package_offering" type="button" role="tab"--}}
                                        {{--                                                aria-controls="package-offering-tab-pane" aria-selected="false">Package--}}
                                        {{--                                            offering--}}
                                        {{--                                        </button>--}}
                                        {{--                                    </li>--}}

                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="offering" role="tabpanel"
                                             aria-labelledby="offering-tab" tabindex="0">
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
                                                <div class="col">
                                                    <label for="service-hours" class="fw-bold mb-4">Service
                                                        hours</label>
                                                    <select class="form-select"
                                                            name="availability_type_offering" data-type="change"
                                                            data-target-one="custom_hours"
                                                            data-match-one="own_specific_date">
                                                        <option value="following_store_hours">Following store hours
                                                        </option>
                                                        <option value="every_day">Every day</option>
                                                        <option value="every_monday">Every monday</option>
                                                        <option value="every_tuesday">Every tuesday</option>
                                                        <option value="every_wednesday">Every wednesday</option>
                                                        <option value="every_thursday">Every thursday</option>
                                                        <option value="every_friday">Every friday</option>
                                                        <option value="weekend_every_saturday_sunday">Weekends only -
                                                            Every
                                                            Sat & Sundays
                                                        </option>
                                                        <option value="own_specific_date">Choose your own specific
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
                                                <div class="col mb-4">
                                                    <label for="service-hours" class="fw-bold">Client price</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Please add the price for your offering"
                                                           name="client_price_offering">
                                                </div>
                                                <div class=" col mb-4">
                                                    <label for="tax" class="fw-bold">Tax</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Enter the applicable tax percentage for your offering"
                                                           name="tax_amount_offering">
                                                    <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="row">
                                                    <div class="col-6 mb-4">
                                                        <label for="type" class="fw-bold">Scheduling window (How far in
                                                            advance
                                                            they can book)</label>

                                                        <div class="d-flex mb-3">
                                                            <input type="text" class="form-control me-2"
                                                                   name="scheduling_window_offering"
                                                                   placeholder="Please add the price for your offering">
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
                                                <div class="col mb-4">
                                                    <label for="type" class="fw-bold">Buffer time between
                                                        appointment</label>
                                                    <select id="type" class="form-select" name="buffer_time_offering">
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
                                                <div class="col mb-4">
                                                    <div class="d-flex justify-content-between">
                                                        <label for="service-hours" class="fw-bold">Email
                                                            template</label>

                                                        <p>Maximum length of 500 words</p>
                                                    </div>
                                                    <textarea class="form-control" name="email_template_offering"
                                                              id="email_template"
                                                              placeholder=""></textarea>
                                                    <p id="word-count">0 / 500 words</p>
                                                </div>
                                                <div class="col mb-4">
                                                    <label for="service-hours" class="fw-bold">Intake form
                                                        (Optional)</label>
                                                    <input type="text" class="form-control" name="intake_form_offering"
                                                           placeholder="enter your link">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="form-check offering-check">
                                                    <input type="checkbox" class="form-check-input"
                                                           id="can-be-cancelled"
                                                           data-type="hide" data-id="cancellation_time"
                                                           name="is_cancelled_offering">
                                                    <label class="form-check-label mb-3 fw-bold"
                                                           for="can-be-cancelled">Cancellation (How far in advance can
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
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       name="is_confirmation_offering">
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Requires Confirmation</label>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="events" role="tabpanel"
                                             aria-labelledby="events-tab"
                                             tabindex="0">

                                            <div class="my-4">
                                                <label for="specify" class="fw-bold">Specify</label>
                                                <select id="specify" name="specify_event" class="form-select"
                                                        data-type="change"
                                                        data-target-one="date_and_time_div"
                                                        data-match-one="one_time_event" data-match-two="recurring_event"
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
                                                <select id="type" class="form-select" name="recurring_days_event">
                                                    <option value="every_day">Every day</option>
                                                    <option value="every_monday">Every monday</option>
                                                    <option value="every_tuesday">Every tuesday</option>
                                                    <option value="every_wednesday">Every wednesday</option>
                                                    <option value="every_thursday">Every thursday</option>
                                                    <option value="every_friday">Every friday</option>
                                                    <option value="weekend_every_saturday_sunday">Weekends only - Every
                                                        Sat & Sundays
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="my-4">
                                                <label for="booking-duration" class="fw-bold">Duration of event</label>
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
                                                <div class="col mb-4">
                                                    <label for="service-hours" class="fw-bold">Client price</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Please add the price for your offering"
                                                           name="client_price_event">
                                                </div>
                                                <div class=" col mb-4">
                                                    <label for="tax" class="fw-bold">Tax</label>
                                                    <input type="text" class="form-control"
                                                           placeholder="Enter the applicable tax percentage for your offering"
                                                           name="tax_amount_event">
                                                    <span>Tax rates vary based on your location and business registration. If unsure, please consult your local tax regulations or a tax professional.</span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 mb-4">
                                                    <label for="type" class="fw-bold">Scheduling window (How far in
                                                        advance
                                                        they can book)</label>

                                                    <div class="d-flex mb-3">
                                                        <input type="text" class="form-control me-2"
                                                               name="scheduling_window_event"
                                                               placeholder="Please add the price for your offering">
                                                        <select class="form-select" name="scheduling_window_event_type">
                                                            <option value="minute">minute</option>
                                                            <option value="hour">hour</option>
                                                            <option value="day">day</option>
                                                            <option value="month">month</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col mb-4">
                                                    <div class="d-flex justify-content-between">
                                                        <label for="service-hours" class="fw-bold">Email
                                                            template</label>

                                                        <p>Maximum length of 500 words</p>
                                                    </div>
                                                    <textarea class="form-control" name="email_template_event"
                                                              id="email_template"
                                                              placeholder=""></textarea>
                                                    <p id="word-count">0 / 500 words</p>
                                                </div>
                                                <div class="col mb-4">
                                                    <label for="service-hours" class="fw-bold">Intake form
                                                        (Optional)</label>
                                                    <input type="text" class="form-control" name="intake_form_event"
                                                           placeholder="enter your link">
                                                </div>
                                            </div>
                                            <div class="mb-4">
                                                <div class="form-check offering-check">
                                                    <input type="checkbox" class="form-check-input"
                                                           id="can-be-cancelled"
                                                           data-type="hide" data-id="cancellation_time_event"
                                                           name="is_cancelled_event">
                                                    <label class="form-check-label mb-3 fw-bold"
                                                           for="can-be-cancelled">Cancellation (How far in advance can
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
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       name="is_confirmation_event">
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Requires Confirmation</label>
                                            </div>
                                        </div>
                                        {{--                                    <div class="tab-pane fade" id="package_offering" role="tabpanel"--}}
                                        {{--                                         aria-labelledby="package-offering-tab" tabindex="0">--}}
                                        {{--                                        <div class="my-4">--}}
                                        {{--                                            <label for="duration-session-package-offering" class="fw-bold">Duration of each session</label>--}}
                                        {{--                                            <select id="duration-session-package-offering" name="duration_session_package_offering" class="form-select">--}}
                                        {{--                                                <option value="15 minutes">15 minutes</option>--}}
                                        {{--                                                <option value="20 minutes">20 minutes</option>--}}
                                        {{--                                                <option value="30 minutes">30 minutes</option>--}}
                                        {{--                                                <option value="45 minutes">45 minutes</option>--}}
                                        {{--                                                <option value="50 minutes">50 minutes</option>--}}
                                        {{--                                                <option value="1 hour">1 hour</option>--}}
                                        {{--                                                <option value="1:15 hour">1:15 hour</option>--}}
                                        {{--                                                <option value="1:30 hour">1:30 hour</option>--}}
                                        {{--                                                <option value="1:45 hour">1:45 hour</option>--}}
                                        {{--                                                <option value="1:50 hour">1:50 hour</option>--}}
                                        {{--                                                <option value="2 hour">2 hours</option>--}}
                                        {{--                                                <option value="3 hour">3 hour</option>--}}
                                        {{--                                                <option value="4 hour">4 hour</option>--}}
                                        {{--                                                <option value="1 Month">1 Month</option>--}}
                                        {{--                                                <option value="2 Month">2 Months</option>--}}
                                        {{--                                                <option value="3 Month">3 Months</option>--}}
                                        {{--                                                <option value="4 Month">4 Months</option>--}}
                                        {{--                                            </select>--}}
                                        {{--                                        </div>--}}

                                        {{--                                        <div class="my-4">--}}
                                        {{--                                            <label for="number-session-package-offering" class="fw-bold">Number of session</label>--}}
                                        {{--                                            <input type="number" class="form-control mt-2" name="number_session_package_offering" placeholder="Enter the number of sessions">--}}
                                        {{--                                        </div>--}}

                                        {{--                                        <div class="my-4">--}}
                                        {{--                                            <label for="time-period-package-offering" class="fw-bold">Number of session</label>--}}
                                        {{--                                            <input type="number" class="form-control mt-2" name="time_period_package_offering" placeholder="Enter the number of sessions">--}}
                                        {{--                                        </div>--}}

                                        {{--                                    </div>--}}

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


        document.addEventListener("DOMContentLoaded", function () {
            const offeringSelect = document.querySelector('select[name="offering_event_type"]');
            const offeringTab = document.getElementById("offering-tab");
            const eventTab = document.getElementById("events-tab");
            const offeringContent = document.getElementById("offering");
            const eventContent = document.getElementById("events");

            function toggleTabs() {
                if (offeringSelect.value === "offering") {
                    eventTab.classList.add("disabled");
                    offeringTab.classList.remove("disabled");

                    // Activate Offering tab
                    offeringTab.classList.add("active");
                    eventTab.classList.remove("active");

                    // Show Offering content and hide Events content
                    offeringContent.classList.add("show", "active");
                    eventContent.classList.remove("show", "active");

                } else if (offeringSelect.value === "event") {
                    offeringTab.classList.add("disabled");
                    eventTab.classList.remove("disabled");

                    // Activate Events tab
                    eventTab.classList.add("active");
                    offeringTab.classList.remove("active");

                    // Show Events content and hide Offering content
                    eventContent.classList.add("show", "active");
                    offeringContent.classList.remove("show", "active");

                } else {
                    offeringTab.classList.remove("disabled");
                    eventTab.classList.remove("disabled");

                    // Default state (no tab selected)
                    offeringContent.classList.remove("show", "active");
                    eventContent.classList.remove("show", "active");
                }
            }

            // Initial state on page load
            toggleTabs();

            // Listen for changes in the select field
            offeringSelect.addEventListener("change", toggleTabs);
        });



    </script>

@endsection

