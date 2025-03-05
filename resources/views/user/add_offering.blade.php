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
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label fw-bold">Offering Name</label>
                            <input type="text" class="form-control" name="name" id="exampleInputEmail1"
                                   aria-describedby="emailHelp" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Short Description</label>
                            <textarea class="form-control" name="short_description"
                                      placeholder="please add a short description here"
                                      id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea" class="fw-bold">Description</label>
                            <textarea class="form-control" name="long_description"
                                      placeholder="please add a full description here"
                                      id="floatingTextarea"></textarea>
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
                            <label for="exampleInputEmail1" class="form-label fw-bold">Location</label>
                            <select name="location" class="form-control">
                                @foreach($locations as $location)
                                    <option value="{{$location->id}}">
                                        {{$location->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
{{--                        <div class="mb-3">--}}
{{--                            <label for="exampleInputPassword1" class="form-label fw-bold">I help with</label>--}}

{{--                            <select name="help[]" multiple="multiple" class="form-control select2">--}}
{{--                                @foreach($IHelpWith as $term)--}}
{{--                                    <option value="{{$term->id}}">{{$term->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label fw-bold">Categories - Specifies the
                                type of
                                service/offering you're providing (e.g. massage is the category and a
                                specific treatment
                                would be Ayuvedic massage and hot stone massage)
                                Practitioner Offerings
                            </label>
                            <select name="categories[]" multiple="multiple" class="form-control category-select2" id="">
                                @foreach($categories as $term)
                                    <option value="{{$term->id}}">{{$term->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label fw-bold">Tags - Used to highlight
                                specific
                                features of a service/offering and help get found in search, e.g., [related
                                to services
                                of massage as the category] Ayuvedic, hot stone, back ache, back pain,
                                muscle tension
                            </label>
                        </div>
                        <div class="form-group">
                            <select name="tags[]" multiple="multiple" class="form-control select2" id="">
                                <option value="156">energybalancing</option>
                                <option value="2991">ASD</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="pt-4 featured-image-tag fw-bold">Featured Image</label>
                            <input type="file" id="fileInput" name="featured_image" class="hidden" accept="image/*"
                                   onchange="previewImage(event)" style="display: none;">
                            <label for="fileInput" class="image-preview" id="imagePreview">
                                <span>+</span>
                            </label>
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
                                                <label for="service-hours" class="fw-bold mb-4">Service hours</label>
                                                <div class="d-flex" style="gap: 20px;">
                                                    <div>
                                                        <label for="service-hours" class="fw-bold">From</label>
                                                        <input type="datetime-local" class="form-control"
                                                               name="from_date" placeholder="">
                                                    </div>
                                                    <div>
                                                        <label for="service-hours" class="fw-bold">To</label>
                                                        <input type="datetime-local" class="form-control" name="to_date"
                                                               placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="availability">Availability</label><br>
                                                <select id="type" class="form-select" name="availability_type">
                                                    <option>Monday</option>
                                                    <option>Tuesday</option>
                                                    <option>Wednesday</option>
                                                    <option>Thursday</option>
                                                    <option>Friday</option>
                                                    <option>All week days</option>
                                                    <option>Weekends only</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Client price</label>
                                                <input type="text" class="form-control" placeholder=""
                                                       name="client_price">
                                            </div>
                                            <div class=" col mb-4">
                                                <label for="tax" class="fw-bold">what % of tax</label>
                                                <input type="text" class="form-control" placeholder=""
                                                       name="tax_amount">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Scheduling window</label>
                                                <select id="type" class="form-select" name="scheduling_window">
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
                                            <div class="col mb-4">
                                                <label for="type" class="fw-bold">Buffer time between
                                                    appointment</label>
                                                <input type="datetime-local" class="form-control" placeholder=""
                                                       name="buffer_time">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Email template</label>
                                                <textarea class="form-control" name="email_template"></textarea>
                                            </div>
                                            <div class="col mb-4">
                                                <label for="service-hours" class="fw-bold">Intake form</label>
                                                <input type="text" class="form-control" name="intake_form"
                                                       placeholder="enter your link">
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                       data-type="hide" data-id="cancellation_time" name="is_cancelled">
                                                <label class="form-check-label mb-3 fw-bold"
                                                       for="can-be-cancelled">Cancellation</label>
                                            </div>
                                            <div class="col-md-6 mb-4 d-none" id="cancellation_time">
                                                <label class="fw-bold">Cancellation time</label>
                                                <input type="datetime-local" name="cancellation_time_slot"
                                                       class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-check offering-check">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled"
                                                   name="is_confirmation">
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
{{--                                        <div class="my-4">--}}
{{--                                            <label for="booking-duration" class="fw-bold">Specific</label>--}}
{{--                                            <select id="booking-duration" class="form-select">--}}
{{--                                                <option>1 time event or reoccuring</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <label for="service-hours" class="fw-bold">Date and time</label>--}}
{{--                                            <input type="datetime-local" class="form-control" placeholder="" name="">--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <label for="booking-duration" class="fw-bold">How many sports are--}}
{{--                                                available</label>--}}
{{--                                            <select id="booking-duration" class="form-select"  >--}}
{{--                                                <option>1</option>--}}
{{--                                                <option>2</option>--}}
{{--                                                <option>3</option>--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                        <div class="row mb-4">--}}
{{--                                            <div class="col">--}}
{{--                                                <label for="service-hours" class="fw-bold mb-4">Service hours</label>--}}
{{--                                                <div class="d-flex" style="gap: 20px;">--}}
{{--                                                    <div>--}}
{{--                                                        <label for="service-hours" class="fw-bold">From</label>--}}
{{--                                                        <input type="number" class="form-control" placeholder="">--}}
{{--                                                    </div>--}}
{{--                                                    <div>--}}
{{--                                                        <label for="service-hours" class="fw-bold">To</label>--}}
{{--                                                        <input type="number" class="form-control" placeholder="">--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                            <div class="col">--}}
{{--                                                <div class="form-check offering-check">--}}
{{--                                                    <input type="checkbox" class="form-check-input"--}}
{{--                                                           id="can-be-cancelled">--}}
{{--                                                    <label class="form-check-label mb-3 fw-bold"--}}
{{--                                                           for="can-be-cancelled">Availability</label><br>--}}
{{--                                                      <input type="radio" id="hours" name="fav_language" value="hours">--}}
{{--                                                      <label for="hours">Following store hours</label><br>--}}
{{--                                                      <input type="radio" id="date" name="fav_language" value="date">--}}
{{--                                                      <label for="date">Specific date and time</label><br>--}}
{{--                                                      <input type="radio" id="monday" name="fav_language"--}}
{{--                                                             value="monday">--}}
{{--                                                      <label for="monday">Every (Monday)</label>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col mb-4">--}}
{{--                                                <label for="service-hours" class="fw-bold">Client price</label>--}}
{{--                                                <input type="number" class="form-control" placeholder="">--}}
{{--                                            </div>--}}
{{--                                            <div class=" col mb-4">--}}
{{--                                                <label for="tax" class="fw-bold">what % of tax</label>--}}
{{--                                                <input type="text" class="form-control" placeholder="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col mb-4">--}}
{{--                                                <label for="type" class="fw-bold">Scheduling window</label>--}}
{{--                                                <select id="type" class="form-select">--}}
{{--                                                    <option>60 days advanced</option>--}}
{{--                                                    <option>24 hours before</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="col mb-4">--}}
{{--                                                <label for="type" class="fw-bold">Buffer time between--}}
{{--                                                    appointment</label>--}}
{{--                                                <input type="number" class="form-control" placeholder="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="row">--}}
{{--                                            <div class="col mb-4">--}}
{{--                                                <label for="service-hours" class="fw-bold">Email template</label>--}}
{{--                                                <input type="number" class="form-control" placeholder="">--}}
{{--                                            </div>--}}
{{--                                            <div class="col mb-4">--}}
{{--                                                <label for="service-hours" class="fw-bold">Intake form</label>--}}
{{--                                                <input type="number" class="form-control" placeholder="">--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-4">--}}
{{--                                            <div class="form-check offering-check">--}}
{{--                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled">--}}
{{--                                                <label class="form-check-label mb-3 fw-bold"--}}
{{--                                                       for="can-be-cancelled">Cancellation</label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="form-check offering-check">--}}
{{--                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled">--}}
{{--                                            <label class="form-check-label mb-3 fw-bold"--}}
{{--                                                   for="can-be-cancelled">Requires Confirmation</label>--}}
{{--                                        </div>--}}
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

