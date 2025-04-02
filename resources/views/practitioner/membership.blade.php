@extends('layouts.app')

@section('content')

    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-lg-5">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv">
                    <div class="container">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="personal" data-bs-toggle="tab"
                                        data-bs-target="#personalInformation" type="button" role="tab"
                                        aria-controls="home-tab-pane" aria-selected="true">
                                    Personal & Contact Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Membership-tab" data-bs-toggle="tab"
                                        data-bs-target="#membershipDetail" type="button" role="tab"
                                        aria-controls="profile-tab-pane" aria-selected="false">
                                    Membership Details
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="Professional-tab" data-bs-toggle="tab"
                                        data-bs-target="#professionalInformation" type="button" role="tab"
                                        aria-controls="contact-tab-pane" aria-selected="false">
                                    Professional & Service Information
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="community_engagement_tab" data-bs-toggle="tab"
                                        data-bs-target="#community" type="button" role="tab"
                                        aria-controls="contact-tab-pane" aria-selected="false">
                                    Community & Engagement
                                </button>
                            </li>

                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="personalInformation" role="tabpanel"
                                 aria-labelledby="home-tab" tabindex="0">
                                <div class="row my-2">
                                    <div class="col-md-12">
                                        <form method="post" action="{{route('membershipPersonalInformation')}}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('POST')
                                            <input type="hidden" class="form-control" id="membership_id"
                                                   name="membership_id" value="{{ $membership?->id ?? '' }}">

                                            <div class="mb-3">
                                                <label class="form-label">Full Name <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="name" required
                                                       value="{{ $membership?->name ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Preferred Name</label>
                                                <input type="text" class="form-control" name="preferred_name"
                                                       value="{{ $membership?->preferred_name ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Pronouns</label>
                                                <select class="form-select" name="pronouns">
                                                    <option
                                                        value="he/him" {{ $membership?->pronouns == 'he/him' ? 'selected':'' }}>
                                                        He/him
                                                    </option>
                                                    <option
                                                        value="she/her" {{ $membership?->pronouns == 'she/her' ? 'selected':'' }}>
                                                        She/her
                                                    </option>
                                                    <option
                                                        value="they/them" {{ $membership?->pronouns == 'they/them' ? 'selected':'' }}>
                                                        They/them
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Email Address <span
                                                        class="text-danger">*</span></label>
                                                <input type="email" class="form-control" name="email" required
                                                       value="{{ $membership?->email ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Birthday</label>
                                                <input type="date" class="form-control" name="birthday"
                                                       value="{{ $membership?->birthday ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Phone Number <span
                                                        class="text-danger">*</span></label>
                                                <input type="tel" class="form-control" name="phone_number" required
                                                       value="{{ $membership?->phone_number ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Location (City, Country, Time Zone) <span
                                                        class="text-danger">*</span></label>
                                                <select name="location" class="form-control" required>
                                                    @foreach($defaultLocations as $id => $location)
                                                        <option
                                                            value="{{$id }}" {{ (!empty($membership->location) && $membership->location == $id) ? 'selected' : '' }}>
                                                            {{ $location }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Website/Social Media Links</label>
                                                <input type="url" class="form-control" name="website_social_media_link">
                                            </div>

                                            <button class="update-btn">Save</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="membershipDetail" role="tabpanel"
                                 aria-labelledby="profile-tab" tabindex="0">

                                <div class="container mt-5">
                                    @if($user->subscribed('default'))
                                    <form>
                                        <div class="mb-4">
                                            <label class="form-label ">Membership Start Date: <span class="fw-bold">{{date('M d, Y', strtotime($user->subscription('default')->created_at))}}</span></label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label ">Membership Type: <span class="fw-bold">{{$userPlan? $userPlan->name: null}}</span></label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label ">Payment Status: <span class="fw-bold">{{$user->subscription('default')->stripe_status === 'active'? "Paid": "Unpaid"}}</span></label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label ">Subscription Status: <span class="fw-bold">{{$user->subscription('default')->stripe_status}}</span></label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label ">Renewal Date: <span class="fw-bold">{{date('M d, Y', strtotime($user->subscription('default')->ends_at))}}</span></label>
                                        </div>

                                        {{-- <div class="mb-4">
                                            <label class="form-label ">Cancellation Date:</label>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold">Cancellation Reason:</label>
                                        </div> --}}

                                    </form>
                                    @else
                                    <div class="row membership-plans">
                                        @forEach($plans as $p)
                                        <div class="col-md-3">
                                            <div class="card">
                                                <div class="card-body">
                                                    <form action="{{route('membership.buy')}}" method="POST">
                                                        @csrf
                                                        <h4>{{$p->name}}</h4>
                                                        <p>${{$p->price}} (+{{$p->tax_percentage}}% Tax) /{{$p->interval}}</p>
                                                        <input type="hidden" name="plan_id" value="{{$p->id}}">
                                                        <button type="submit">Buy Now</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>

                            </div>


                            <div class="tab-pane fade" id="professionalInformation" role="tabpanel"
                                 aria-labelledby="contact-tab" tabindex="0">
                                <div class="container mt-5">
                                    <form action="{{route('professionalServiceInformation')}}" method="post"
                                          enctype="multipart/form-data">
                                        @csrf
                                        @method('POST')
                                        <input type="hidden" class="form-control" id="membership_id"
                                               name="membership_id" value="{{ $membership?->id ?? '' }}">

                                        <div class="mb-3">
                                            <label for="businessName" class="form-label">Business Name (if
                                                applicable)</label>
                                            <input type="text" class="form-control" id="businessName"
                                                   placeholder="Enter business name" name="business_name">
                                        </div>

                                        <div class="mb-4 select2-div">
                                            <label for="type" class="fw-bold">Modality/Practice</label>

                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <select id="modalityPractice" name="modality_practice[]"
                                                            class="form-select" data-type="multiselect"
                                                            multiple>
                                                        @php
                                                            $selectedTerms = explode(',', $membership->modality_practice ?? '');
                                                        @endphp
                                                        @foreach($membershipModality as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }}>{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <button class="update-btn mb-2 addterm"
                                                            data-type="modalityPractice">Add New
                                                        Term
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="modalityPractice-container">

                                        </div>
                                        <div class="mb-4 mt-4">
                                            <div class="d-lg-flex">
                                                <label for="media" class="fw-bold">Certifications & Credentials Upload
                                                    (If
                                                    applicable)</label>
                                                <div class="ms-3">
                                                    <label class="add-media-btn" for="media-upload">
                                                        <i class="fas fa-plus"></i>
                                                        Add media
                                                    </label>
                                                    <input type="file" id="media-upload" name="certificates_images[]"
                                                           class="hidden"
                                                           accept="image/*" multiple>
                                                </div>
                                            </div>


                                            <div class="media-container" id="media-container">
                                                @if(count($mediaImages) > 0)
                                                    @foreach ($mediaImages as $image)
                                                        <div class="media-item">
                                                            @php
                                                                $imageUrl = asset(env('media_path') . '/practitioners/' . $user->id . '/membership_certificate/' . $image) ;
                                                            @endphp
                                                            <img
                                                                src="{{ $imageUrl}}"
                                                                alt="Practitioner Image"
                                                                style="width: 100px; height: 100px; object-fit: cover; display: block;">
                                                            <i class="fas fa-times text-danger" style="cursor: pointer;"
                                                               data-image="{{ $image }}"
                                                               data-user-id="{{ $user->id }}"
                                                               data-image-url="{{ $imageUrl }}"
                                                               data-name="{{ $image }}"
                                                               data-certificate-image="true"
                                                               onclick="removeImage(this);"></i>

                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No images available</p>
                                                @endif
                                            </div>
                                        </div>


                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox" type="checkbox"
                                                       name="confirm_necessary_certifications_credentials" {{ $membership?->confirm_necessary_certifications_credentials ? 'checked' : ''}}>
                                                <label class="form-check-label" for="certificationConfirmation">
                                                    I confirm that I hold all necessary certifications, credentials, and
                                                    qualifications required to offer the modalities and services I
                                                    provide through The Hira Collective. I understand that I am solely
                                                    responsible for the accuracy and validity of my credentials.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox" type="checkbox"
                                                       name="acknowledge_the_hira_collective_practitioner_agreement" {{ $membership?->acknowledge_the_hira_collective_practitioner_agreement ? 'checked' : ''}}>
                                                <label class="form-check-label">
                                                    I acknowledge that, as per The Hira Collective’s Practitioner
                                                    Agreement, Terms & Conditions, and Privacy Policy, The Hira
                                                    Collective assumes no responsibility for the verification,
                                                    legitimacy, or delivery of my services. I take full accountability
                                                    for my practice and offerings.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input form-check-input input_checkbox"
                                                       type="checkbox" name="understand_declaration_serves"
                                                       id="complianceDeclaration" {{ $membership?->understand_declaration_serves ? 'checked' : ''}}>
                                                <label class="form-check-label" for="complianceDeclaration">
                                                    I understand that my declaration serves as confirmation of my
                                                    compliance, and any false or misleading information may result in
                                                    the termination of my membership.
                                                </label>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="yearsOfExperience" class="form-label">Years of
                                                Experience</label>
                                            <div class="row align-items-center">
                                                <div class="col-11 col-md-4">
                                                    <input type="number" class="form-control" id="yearsOfExperience"
                                                           placeholder="Enter years of experience"
                                                           name="years_of_experience"
                                                           value="{{ $membership->years_of_experience ?? '' }}">
                                                </div>
                                                <div class="col-1 col-md-8">
                                                    <span>Years</span>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="mb-3">
                                            <label for="licenseNumber" class="form-label">License/Certification Number
                                                (If applicable)</label>
                                            <input type="text" class="form-control" id="licenseNumber"
                                                   placeholder="Enter license/certification number"
                                                   name="license_certification_number"
                                                   value="{{ $membership->license_certification_number ?? '' }}">
                                        </div>

                                        <button class="update-btn">Save</button>
                                    </form>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="community" role="tabpanel" aria-labelledby="contact-tab"
                                 tabindex="0">
                                <form method="post" action="{{route('communityEngagement')}}">
                                    @csrf
                                    @method('POST')
                                    <input type="hidden" class="form-control" id="membership_id"
                                           name="membership_id" value="{{ $membership->id ?? '' }}">
                                    <div class="container mt-5">

                                        @php
                                            $selectedOptions = json_decode($membership->blogs_workshops_events ?? '[]', true);
                                        @endphp

                                        <div class="mb-4">
                                            <h5>Are you interested in contributing to blogs, workshops, or events?</h5>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox"
                                                       name="blogs_workshops_events[]"
                                                       type="checkbox" id="blog" value="blog"
                                                    {{ in_array('blog', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="blog">Blog</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox"
                                                       name="blogs_workshops_events[]"
                                                       type="checkbox" id="igLive" value="ig_live"
                                                    {{ in_array('ig_live', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="igLive">IG Live</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox"
                                                       name="blogs_workshops_events[]"
                                                       type="checkbox" id="podcast" value="podcast"
                                                    {{ in_array('podcast', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="podcast">Podcast</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox"
                                                       name="blogs_workshops_events[]"
                                                       type="checkbox" id="workshop" value="workshop"
                                                    {{ in_array('workshop', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="workshop">Workshop</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox"
                                                       name="blogs_workshops_events[]"
                                                       type="checkbox" id="communityEvent" value="community_event"
                                                    {{ in_array('community_event', $selectedOptions) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="communityEvent">Community
                                                    Event</label>
                                            </div>
                                        </div>


                                        @php
                                            $referralProgram = old('referral_program', $membership->referral_program ?? null);
                                        @endphp

                                        <div class="mb-4">
                                            <h5>Referral Program Participation</h5>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox" type="radio"
                                                       name="referral_program" id="referralYes" value="1"
                                                    {{ $referralProgram == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="referralYes">Yes</label>
                                            </div>

                                            <div class="form-check">
                                                <input class="form-check-input input_checkbox" type="radio"
                                                       name="referral_program" id="referralNo" value="0"
                                                    {{ $referralProgram == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label" for="referralNo">No</label>
                                            </div>
                                        </div>


                                        <div class="mb-4">
                                            <h5>Collaboration Interests</h5>
                                            <textarea class="form-control" id="collaborationInterests" rows="4"
                                                      name="collaboration_interests"
                                                      placeholder="Enter your collaboration interests here...">{{$membership->collaboration_interests ?? ''}}</textarea>
                                        </div>

                                        <button class="update-btn">Save</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
