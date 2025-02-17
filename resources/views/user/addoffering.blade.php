@extends('layouts.app')
@section('content')

<section class="practitioner-profile">
        <div class="container">
            <div class="row">
                
                @include('layouts.partitioner_nav')
                <section class="practitioner-profile">
        <div class="container">
            <div class="row">
                <h1 style="text-transform: capitalize;" class="home-title mb-5">Welcome,<span
                        style="color: #ba9b8b;">Reema</span></h1>
                <div class="col-sm-12 col-lg-5"></div>
                <ul class="practitioner-profile-btns">
                    <li class="active">
                        <a href="./my-profile.html">
                            My Profile
                        </a>
                    </li>
                    <li class="offering">
                        <a href="">
                            Offering
                        </a>
                        <div class="dropdown">
                            <a href="./discount.html">
                            Discount
                        </a>
                        </div>
                    </li>
                    <li>
                        <a href="./appoinement.html">
                            Appointment
                        </a>
                    </li>
                    <li>
                        <a href="./calendar.html">
                            Calendar
                        </a>
                    </li>
                    <li class="offering">
                        <a href="">
                            Accounting
                        </a>
                        <div class="dropdown">
                            <a href="./earning.html">
                            Earnings
                        </a>
                        <a href="./refund-request.html">
                            Refund request
                        </a>
                        </div>
                    </li>
                </ul>
                <h3 class="no-request-text mb-4">Add Offering</h3>
                <p style="text-align: start;">Remember, when creating services, you must create separate services for
                    virtual and in-person. This will allow ease for YOU and your potential clients. Feel free to “copy
                    and paste” descriptions from each service offering.</p>
                <div class="add-offering-dv">
                    <form>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Description</label>
                            <textarea class="form-control" placeholder="please add a full description here"
                                id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Shoret Description</label>
                            <textarea class="form-control" placeholder="please add a full description here"
                                id="floatingTextarea"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Location</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                                placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">I help with:</label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Categories - Specifies the type of
                                service/offering you're providing (e.g. massage is the category and a specific treatment
                                would be Ayuvedic massage and hot stone massage)
                                Practitioner Offerings
                            </label>
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Tags - Used to highlight specific
                                features of a service/offering and help get found in search, e.g., [related to services
                                of massage as the category] Ayuvedic, hot stone, back ache, back pain, muscle tension)
                            </label>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="exampleInputPassword1" placeholder="Search or add a tag">
                            <div id="tags-container"></div>
                        </div>
                        
                        <h4 class="mb-4 featured-image-tag">Featured Image</h4>
                        <div class="mb-3">
                            <input type="file" id="fileInput" class="hidden" accept="image/*"
                                onchange="previewImage(event)" style="display: none;">
                            <label for="fileInput" class="image-preview" id="imagePreview">
                                <span>+</span>
                            </label>
                            <p style="text-align: start;" class="text">Set featured image</p>
                        </div>
                        <hr>
                        <div class="container">
                            <div class="mb-4">
                                <label for="type" class="fw-bold">Type</label>
                                <select id="type" class="form-select">
                                    <option>Bookable Product</option>
                                </select>
                            </div>
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                            role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="availability-tab" data-bs-toggle="tab"
                                            href="#availability" role="tab" aria-controls="availability"
                                            aria-selected="false">Availability</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="costs-tab" data-bs-toggle="tab" href="#costs" role="tab"
                                            aria-controls="costs" aria-selected="false">Costs</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <!-- General Tab Content -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel"
                                        aria-labelledby="general-tab">
                                        <div class="mb-4">
                                            <label for="booking-duration" class="fw-bold">Booking duration</label>
                                            <select id="booking-duration" class="form-select">
                                                <option>Fixed blocks of</option>
                                            </select>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <input type="text" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <select class="form-select">
                                                    <option>Month(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="calendar-display-mode" class="fw-bold">Calendar display
                                                mode</label>
                                            <select id="calendar-display-mode" class="form-select">
                                                <option>Display calendar on click</option>
                                            </select>
                                            <small class="form-text text-muted">Choose how the calendar is displayed on
                                                the booking form.</small>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input"
                                                    id="requires-confirmation">
                                                <label class="form-check-label" for="requires-confirmation">Requires
                                                    confirmation?</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the booking requires
                                                admin approval/confirmation. Payment will not be taken during
                                                checkout.</small>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                                <label class="form-check-label" for="can-be-cancelled">Can be
                                                    cancelled?</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the booking can be
                                                cancelled by the customer after it has been purchased. A refund will not
                                                be sent automatically.</small>
                                        </div>
                                    </div>

                                    <!-- Availability Tab Content -->
                                    <div class="tab-pane fade" id="availability" role="tabpanel"
                                        aria-labelledby="availability-tab">
                                        <div class="col mb-3">
                                            <label for="booking">Max bookings per block</label>
                                            <input type="number" class="form-control" placeholder="">
                                            <p style="text-align: start;">The maximum bookings allowed for each block. Can be overridden at resource level.</p>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="minimum">Minimum block bookable</label>
                                                <input type="text" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label for="into-future">Into the future</label>
                                                <select class="form-select">
                                                    <option>Month(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <div class="col">
                                                <label for="maximum">Maximum block bookable</label>
                                                <input type="text" class="form-control" placeholder="">
                                            </div>
                                            <div class="col">
                                                <label for="into-future">Into the future</label>
                                                <select class="form-select">
                                                    <option>Month(s)</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col mb-3">
                                            <label for="booking">Require a buffer period between bookings</label>
                                            <input type="number" class="form-control" placeholder="">
                                           
                                        </div>
                                        <div class="col- mb-3">
                                            <label for="dates">All dates are...</label>
                                            <select class="form-select">
                                                <option>available by default</option>
                                                <option>not-available by default</option>
                                                <p>This option affects how you use the rules below.</p>
                                            </select>
                                        </div>
                                        <div class="col- mb-3">
                                            <label for="dates">Check rules against...</label>
                                            <select class="form-select">
                                                <option>All blocks being booked</option>
                                                <option>The sgtarting block only</option>
                                                <p>This option affects how bookings are checked for availability.</p>
                                            </select>
                                        </div>
                                        <div class="form-check offering-check mb-3">
                                            <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                            <label class="form-check-label" for="can-be-cancelled">Restrict start days?</label>
                                        </div>
                                        <div class=" mb-4">
                                            <label for="minimum">First block starts at...</label>
                                            <input type="tdateext" class="form-control" placeholder="">
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Range type</th>
                                                        <th scope="col">Range</th>
                                                        <th scope="col">Bookable</th>
                                                        <th scope="col">Priority</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><button class="export-btn">
                                                            Add Range
                                                        </button></td>
                                                        <td colspan="3" class="bg-custom "> Rules with lower numbers will execute first. Rules further down this table with the same priority will also execute first.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <!-- Costs Tab Content -->
                                    <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                                        <div class="mb-3">
                                            <label for="base-cost" class="form-label">Base Cost</label>
                                            <input type="text" class="form-control" id="base-cost">
                                            <div class="form-text">One-off cost for the booking as a whole.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="block-cost" class="form-label">Block Cost</label>
                                            <input type="text" class="form-control" id="block-cost">
                                            <div class="form-text">This is the cost per block booked. All other costs
                                                (for resources and persons) are added to this.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="display-cost" class="form-label">Display Cost</label>
                                            <input type="text" class="form-control" id="display-cost">
                                            <div class="form-text">The cost is displayed to the user on the frontend.
                                                Leave blank to have it calculated for you. If a booking has varying
                                                costs, this will be prefixed with the word "from:".</div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col">Range type</th>
                                                        <th scope="col">Range</th>
                                                        <th scope="col">Base cost <i
                                                                class="fas fa-question-circle text-muted"></i></th>
                                                        <th scope="col">Block cost <i
                                                                class="fas fa-question-circle text-muted"></i></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><button class="export-btn">
                                                                Add Range
                                                            </button></td>
                                                        <td colspan="3" class="bg-custom ">All matching rules will be
                                                            applied to the booking.</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex" style="gap: 20px;">
                                <button class="update-btn m-0">Add Offering</button>
                                <button class="update-btn">Save Draft</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="positioned-dv">
            <ul>
                <li>
                    <img src="./asserts/User.svg" alt="">
                    <p>Account</p>
                </li>
                <li>
                    <img src="./asserts/grid.svg" alt="">
                    <p>Dashboard</p>
                </li>
                <li>
                    <img src="./asserts/calendar.svg" alt="">
                    <p>Calendar</p>
                </li>
                <li>
                    <img src="./asserts/Shopping List.svg" alt="">
                    <p>Bookings</p>
                </li>
                <li>
                    <img src="./asserts/Chat.svg" alt="">
                    <p>Community</p>
                </li>
                <li>
                    <img src="./asserts/business.svg" alt="">
                    <p>Business<br />
                        Referals</p>
                </li>
            </ul>
        </div>
    </section>
            </div>
        </div>
</section>

@endsection