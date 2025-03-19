@extends('layouts.app')

@section('content')

    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv">
                    <div class="container">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal" data-bs-toggle="tab" data-bs-target="#personalInformation" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">
                                    Personal & Contact Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Membership-tab" data-bs-toggle="tab" data-bs-target="#membershipDetail" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">
                                    Membership Details
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Professional-tab" data-bs-toggle="tab" data-bs-target="#professionalInformation" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                                    Professional & Service Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="community_engagement_tab" data-bs-toggle="tab" data-bs-target="#community" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">
                                    Community & Engagement
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="personalInformation" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                               <div class="row my-2">
                                   <div class="col-md-12">
                                       <form method="post" action="" enctype="multipart/form-data">
                                           <input type="hidden" class="form-control" id="membership_id" name="membership_id"
                                                  value="{{ $membership->id ?? '' }}">
                                           <div style="position: relative;"
                                                class="d-flex justify-content-center flex-column align-items-center">
                                               <div class="mb-4" id="imageDiv">
                                                   <p style="text-align: start;" class="text-center fw-bold">Profile
                                                       Image</p>
                                                   <input type="file" id="fileInput" name="image" class="hidden"
                                                          accept="image/*"
                                                          onchange="previewImage(event)" style="display: none;">

                                                   @if(isset($image))
                                                       @php
                                                           $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/profile/' . $image);
                                                       @endphp
                                                       <label class="image-preview rounded-5 " id="imagePreview"
                                                              style=" background-image: url('{{$imageUrl}}'); background-size: cover; background-position: center center;">
                                                           <i class="fas fa-trash text-danger fs-3"
                                                              data-image="{{ $image }}"
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

                                                   {{-- <div class="preview-div">--}}
                                                   {{-- <img src="{{ url('/assets/images/Laptop.svg') }}" alt="">--}}
                                                   {{-- <p>preview</p>--}}
                                                   {{-- </div>--}}
                                               </div>
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                               <input type="text" class="form-control" name="full_name" required>
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Preferred Name</label>
                                               <input type="text" class="form-control" name="preferred_name">
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Pronouns</label>
                                               <input type="text" class="form-control" name="pronouns">
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                               <input type="email" class="form-control" name="email" required>
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Birthday</label>
                                               <input type="date" class="form-control" name="birthday">
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                               <input type="tel" class="form-control" name="phone" required>
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Location (City, Country, Time Zone) <span class="text-danger">*</span></label>
                                               <input type="text" class="form-control" name="location" required>
                                           </div>
                                           <div class="mb-3">
                                               <label class="form-label">Website/Social Media Links <span class="text-danger">*</span></label>
                                               <input type="url" class="form-control" name="website" required>
                                           </div>

                                           <button type="submit" class="btn btn-primary">Submit</button>
                                       </form>
                                   </div>
                               </div>
                            </div>
                            <div class="tab-pane fade" id="membershipDetail" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">

                                <div class="container mt-5">
                                    <form>
                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Membership Start Date:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label  class="form-label fw-bold">Membership Type:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label  class="form-label fw-bold">Payment Status:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label  class="form-label fw-bold">Subscription Status:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Renewal Date:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label  class="form-label fw-bold">Cancellation Date:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label  class="form-label fw-bold">Cancellation Reason:</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>

                            </div>


                            <div class="tab-pane fade" id="professionalInformation" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                                <div class="container mt-5">
                                    <form>
                                        <div class="mb-3">
                                            <label for="businessName" class="form-label">Business Name (if applicable)</label>
                                            <input type="text" class="form-control" id="businessName" placeholder="Enter business name">
                                        </div>

                                        <div class="mb-3">
                                            <label for="primaryModality" class="form-label">Primary Modality/Practice</label>
                                            <select class="form-select" id="primaryModality" required>
                                                <option selected disabled>Select primary modality</option>
                                                <option value="Reiki">Reiki</option>
                                                <option value="Yoga">Yoga</option>
                                                <option value="Counseling">Counseling</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="mt-2">
                                                <input type="text" class="form-control" id="customModality" placeholder="Enter custom modality">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Additional Modalities</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" >
                                                <label class="form-check-label">Meditation</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label">Life Coaching</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label" >Acupuncture</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label" >Other</label>
                                            </div>
                                            <div class="mt-4">
                                                <input type="text" class="form-control" placeholder="Specify other modality" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Certifications & Credentials Upload (If applicable)</label>
                                            <input class="form-control" type="file">
                                        </div>


                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" >
                                                <label class="form-check-label" for="certificationConfirmation">
                                                    I confirm that I hold all necessary certifications, credentials, and qualifications required to offer the modalities and services I provide through The Hira Collective. I understand that I am solely responsible for the accuracy and validity of my credentials.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label" >
                                                    I acknowledge that, as per The Hira Collective’s Practitioner Agreement, Terms & Conditions, and Privacy Policy, The Hira Collective assumes no responsibility for the verification, legitimacy, or delivery of my services. I take full accountability for my practice and offerings.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox">
                                                <label class="form-check-label" for="complianceDeclaration">
                                                    I understand that my declaration serves as confirmation of my compliance, and any false or misleading information may result in the termination of my membership.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="yearsOfExperience" class="form-label">Years of Experience</label>
                                            <select class="form-select" id="yearsOfExperience" required>
                                                <option selected disabled>Select years of experience</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label for="licenseNumber" class="form-label">License/Certification Number (If applicable)</label>
                                            <input type="text" class="form-control" id="licenseNumber" placeholder="Enter license/certification number">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="community" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">community
                                <div class="container mt-5">

                                    <div class="mb-4">
                                        <h5>Are you interested in contributing to blogs, workshops, or events?</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="blog">
                                            <label class="form-check-label" for="blog">Blog</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="igLive">
                                            <label class="form-check-label" for="igLive">IG Live</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="podcast">
                                            <label class="form-check-label" for="podcast">Podcast</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="workshop">
                                            <label class="form-check-label" for="workshop">Workshop</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="communityEvent">
                                            <label class="form-check-label" for="communityEvent">Community Event</label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h5>Referral Program Participation</h5>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="referral" id="referralYes" value="yes">
                                            <label class="form-check-label" for="referralYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="referral" id="referralNo" value="no">
                                            <label class="form-check-label" for="referralNo">No</label>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <h5>Collaboration Interests</h5>
                                        <textarea class="form-control" id="collaborationInterests" rows="4" placeholder="Enter your collaboration interests here..."></textarea>
                                    </div>

                                        <button type="submit" class="btn btn-primary">Submit</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script>
        // Show/hide "Other" input fields when "Other" is selected
        document.getElementById('primaryModality').addEventListener('change', function() {
            let otherInput = document.getElementById('otherPrimaryModality');
            otherInput.classList.toggle('d-none', this.value !== 'Other');
        });

        document.getElementById('modalityOther').addEventListener('change', function() {
            let otherInput = document.getElementById('otherModalityInput');
            otherInput.classList.toggle('d-none', !this.checked);
        });
    </script>
@endsection
