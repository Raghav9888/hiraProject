@extends('layouts.app')
@section('content')
<section class="practitioner-profile">
    <div class="container">
        <div class="row">
            <h1 style="text-transform: capitalize;" class="home-title mb-5">Welcome,<span
                    style="color: #ba9b8b;">Reema</span></h1>
            <div class="col-sm-12 col-lg-5"></div>
            <ul class="practitioner-profile-btns">
                <li class="active">
                    <a href="/my-profile.html">
                        My Profile
                    </a>
                </li>
                <li class="offering">
                    <a href="">
                        Offering
                    </a>
                    <div class="dropdown">
                        <a href="/discount.html">
                            Discount
                        </a>
                    </div>
                </li>
                <li>
                    <a href="/appoinement.html">
                        Appointment
                    </a>
                </li>
                <li>
                    <a href="/calendar.html">
                        Calendar
                    </a>
                </li>
                <li class="offering">
                    <a href="">
                        Accounting
                    </a>
                    <div class="dropdown">
                        <a href="/earning.html">
                            Earnings
                        </a>
                        <a href="/refund-request.html">
                            Refund request
                        </a>
                    </div>
                </li>
            </ul>

            <div class="add-offering-dv">
                <div class="container">
                    <div class="mb-4 mt-4">
                        <ul class="nav nav-tabs" id="tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                    role="tab" aria-controls="general" aria-selected="true">My Profile</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="availability-tab" data-bs-toggle="tab" href="#availability"
                                    role="tab" aria-controls="availability" aria-selected="false">My Payment
                                    Integration</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="costs-tab" data-bs-toggle="tab" href="#costs" role="tab"
                                    aria-controls="costs" aria-selected="false">My Calendar Integration</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="clint-tab" data-bs-toggle="tab" href="#client" role="tab"
                                    aria-controls="client" aria-selected="false">Client Policy</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">
                            <!-- General Tab Content -->
                            <div class="tab-pane fade show active" id="general" role="tabpanel"
                                aria-labelledby="general-tab">

                                <div class="mb-3">
                                    <label for="floatingTextarea">First Name</label>
                                    <input type="text" class="form-control" id="base-cost">
                                </div>
                                <div class="mb-3">
                                    <label for="floatingTextarea">Last Name</label>
                                    <input type="text" class="form-control" id="base-cost">
                                </div>
                                <div class="mb-3">
                                    <label for="floatingTextarea">Company Name</label>
                                    <input type="text" class="form-control" id="base-cost">
                                    <p style="text-align: start;">Your shop name is public and must be unique.</p>
                                </div>
                                <div class="mb-3">
                                    <label for="floatingTextarea">Short Bio</label>
                                    <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">Location</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <label for="type" class="fw-bold">Tags</label>
                                <p style="text-align: start;">These are keywords used to help identify more specific versions of something. For example, a good tag for a massage could be "Deep Tissue".</p>
                                <hr>
                                <div class="mb-3">
                                    <p style="text-align: start;" class="text">Images</p>
                                    <input type="file" id="fileInput" class="hidden" accept="image/*"
                                        onchange="previewImage(event)" style="display: none;">
                                    <label for="fileInput" class="image-preview" id="imagePreview">
                                        <span>+</span>
                                    </label>
                                </div>
                                <div class="mb-3">
                                    <label for="floatingTextarea">About Me</label>
                                    <p>Maximum length of 500 words</p>
                                    <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">I help with:</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <button class="update-btn mb-2">Add New Term</button>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">I help with:</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <button class="update-btn mb-2">Add New Term</button>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">How I help:</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <button class="update-btn mb-2">Add New Term</button>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">Specialities</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <div class="form-check offering-check">
                                        <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                        <label class="form-check-label" for="can-be-cancelled">Amentities</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">Certifications</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <button class="update-btn mb-2">Add New Term</button>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">Endorsements</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                </div>
                                <hr>
                                <div class="mb-4">
                                    <label for="type" class="fw-bold">Timezone</label>
                                    <select id="type" class="form-select">
                                        <option>Select</option>
                                    </select>
                                    <p style="text-align: start;">select your timezone</p>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check offering-check">
                                        <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                        <label class="form-check-label" for="can-be-cancelled">Enable opening hours</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check offering-check">
                                        <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                        <label class="form-check-label" for="can-be-cancelled">Enable notice</label>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <div class="form-check offering-check">
                                        <input type="checkbox" class="form-check-input" id="can-be-cancelled">
                                        <label class="form-check-label" for="can-be-cancelled">Enable Google Analytics</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Availability Tab Content -->
                            <div class="tab-pane fade" id="availability" role="tabpanel"
                                aria-labelledby="availability-tab">
                                <h4 class="stripe-text">Connect with Stripe</h4>
                                <h5 class="stripe-label">Your account is not yet connected with Stripe.</h5>
                                <button class="stripe-btn mt-3">Connect with stripe</button>
                            </div>

                            <!-- Costs Tab Content -->
                            <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                <div class="d-flex justify-content-end mb-4">
                                <button class="update-btn">Google calendar setting</button>
                            </div>
                                <div class="calendar">
                                    <div class="controls">
                                        <select id="monthSelect">
                                        <option value="0">January</option>
                                        <option value="1">February</option>
                                        <option value="2">March</option>
                                        <option value="3">April</option>
                                        <option value="4">May</option>
                                        <option value="5">June</option>
                                        <option value="6">July</option>
                                        <option value="7">August</option>
                                        <option value="8">September</option>
                                        <option value="9">October</option>
                                        <option value="10">November</option>
                                        <option value="11">December</option>
                                        </select>
                                        <button id="resetCalendar">Reset Calendar</button>
                                    </div>
                                    <div class="calendar-grid">
                                    </div>
                                    </div>
                                    <div id="noteModal" class="modal">
                                    <div class="modal-content">
                                        <span class="close">&times;</span>
                                        <h3>Add Note</h3>
                                        <p id="selectedDate"></p>
                                        <label for="time">Select Time:</label>
                                        <input type="time" id="time" required>
                                        <label for="note">Note:</label>
                                        <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>
                                        <button id="saveNote">Save Note</button>
                                    </div>
                                    </div>
                            </div>
                            <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="clint-tab">
                                <div class="mb-3">
                                    <label for="floatingTextarea">Privacy Policy</label>
                                    <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="floatingTextarea">Terms & Condition</label>
                                    <textarea class="form-control" placeholder="" id="floatingTextarea"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex" style="gap: 20px;">
                        <button class="update-btn m-0">Add Offering</button>
                        <button class="update-btn">Save Draft</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="positioned-dv">
            <ul>
                <li>
                    <img src="{{url('./assets/images/User.svg')}}" alt="">
                    <p>Account</p>
                </li>
                <li>
                    <img src="{{url('./assets/images/grid.svg')}}" alt="">
                    <p>Dashboard</p>
                </li>
                <li>
                    <img src="{{url('./assets/images/calendar.svg')}}" alt="">
                    <p>Calendar</p>
                </li>
                <li>
                    <img src="{{url('./assets/images/Shopping List.svg')}}" alt="">
                    <p>Bookings</p>
                </li>
                <li>
                    <img src="{{url('./assets/images/Chat.svg')}}" alt="">
                    <p>Community</p>
                </li>
                <li>
                    <img src="{{url('./assets/images/business.svg')}}" alt="">
                    <p>Business<br />
                        Referals</p>
                </li>
            </ul>
        </div>
    </div>
</section>
@endsection