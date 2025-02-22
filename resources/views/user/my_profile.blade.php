@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
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

                                    <form method="post" action="{{ route('updateProfile') }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div style="position: relative;"
                                             class="d-flex justify-content-center flex-column align-items-center">
                                            <div class="mb-4">
                                                <p style="text-align: start;" class="text">Images</p>
                                                <input type="file" id="fileInput" class="hidden" accept="image/*"
                                                       onchange="previewImage(event)" style="display: none;">
                                                <label style="border-radius: 50%;" for="fileInput" class="image-preview"
                                                       id="imagePreview">
                                                    <span>+</span>
                                                </label>
                                                <div class="preview-div">
                                                    <img src="../../../public/assets/images/Laptop.svg" alt="">
                                                    <p>preview</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="first_name">First Name</label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name"
                                                       value="{{ $user->first_name ?? '' }}">
                                                <input type="hidden" class="form-control" id="id" name="id"
                                                       value="{{ $user->id ?? '' }}">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       value="{{ $user->last_name ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="company_name">Company Name</label>
                                            <input type="text" class="form-control" id="company" name="company"
                                                   value="{{ $userDetails->company ?? '' }}">
                                            <p style="text-align: start;">Your shop name is public and must be
                                                unique.</p>
                                        </div>

                                        <div class="mb-3">
                                            <label for="bio">Short Bio</label>
                                            <textarea class="form-control" id="bio"
                                                      name="bio">{{ $userDetails->bio ?? '' }}</textarea>
                                        </div>

                                        <div class="mb-4">
                                            <label for="location" class="fw-bold">Location</label>
                                            <select id="location" name="location" class="form-select select2"
                                                    multiple="multiple">
                                                <option>Select</option>
                                                <option
                                                    value="New York" {{ (isset($userDetails->location) && $userDetails->location == 'New York') ? 'selected' : '' }}>
                                                    New York
                                                </option>
                                                <option
                                                    value="Los Angeles" {{ (isset($userDetails->location) && $userDetails->location == 'Los Angeles') ? 'selected' : '' }}>
                                                    Los Angeles
                                                </option>
                                                <option
                                                    value="Chicago" {{ (isset($userDetails->location) && $userDetails->location == 'Chicago') ? 'selected' : '' }}>
                                                    Chicago
                                                </option>
                                            </select>
                                        </div>
                                        <hr>
                                        <label for="type" class="fw-bold">Tags</label>
                                        <p style="text-align: start;">These are keywords used to help identify more
                                            specific
                                            versions of something. For example, a good tag for a massage could be "Deep
                                            Tissue".</p>
                                        <select name="tags" multiple="multiple" class="form-select select2"></select>
                                        <hr>
                                        <div class="mb-4 mt-4">
                                            <label for="media" class="fw-bold">Media</label>
                                            <label class="add-media-btn" for="media-upload">
                                                <i class="fas fa-plus"></i>
                                                Add media
                                            </label>
                                            <input type="file" id="media-upload" class="hidden" accept="image/*"
                                                   multiple="">
                                            <div class="media-container" id="media-container">
                                                <div class="media-item">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                                <div class="media-item">
                                                    <i class="fas fa-times"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea">About Me</label>
                                            <p>Maximum length of 500 words</p>
                                            <textarea class="form-control" name="about_me" placeholder=""
                                                      id="floatingTextarea">{{$userDetails->about_me ?? ''}}</textarea>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <label for="type" class="fw-bold">I help with:</label>
                                            <select id="type" name="type" class="form-select select2"
                                                    multiple="multiple">
                                                <option>Select</option>
                                                <option value="Lack of confidence">Lack of confidence</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2">Add New Term</button>
                                        <div class="mb-4">
                                            <label for="type" class="fw-bold">I help with:</label>
                                            <select id="term" name="term" class="form-select select2"
                                                    multiple="multiple">
                                                <option>Select</option>
                                                <option value="Transitions Coaching">Transitions Coaching</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2">Add New Term</button>
                                        <div class="mb-4">
                                            <label for="type" class="fw-bold">How I help:</label>
                                            <select id="help" name="help" class="form-select">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2">Add New Term</button>
                                        <div class="mb-4">
                                            <label for="specialities" class="fw-bold">Specialities</label>
                                            <select id="specialities" class="form-select select2" multiple="multiple"
                                                    name="specialities">
                                                <option>Select</option>
                                                <option>Complimentary initial consultations</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <label class="form-check-label" for="amentities">Amentities</label>
                                                <select id="amentities" class="form-select select2" name="amentities">
                                                    <option>Select</option>
                                                    <option>Neurolinguistic Programming</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="certifications" class="fw-bold">Certifications</label>
                                            <select id="certifications" class="form-select" name="certifications">
                                                <option>Select</option>
                                                <option>Neurolinguistic Programming</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2">Add New Term</button>
                                        <div class="mb-4">
                                            <label for="endorsements" class="fw-bold">Endorsements</label>
                                            <select id="endorsements" name="endorsements" class="form-select">
                                                <option>Select</option>
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="mb-4">
                                            <label for="timezone" class="fw-bold">Timezone</label>
                                            <select id="timezone" name="timezone" class="form-select">
                                                <option>Select</option>
                                            </select>
                                            <p style="text-align: start;">select your timezone</p>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_opening_hours"
                                                       name="is_opening_hours">
                                                <label class="form-check-label" for="is_opening_hours">Enable opening
                                                    hours</label>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_notice"
                                                       name="is_notice">
                                                <label class="form-check-label" for="is_notice">Enable notice</label>
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="is_google_analytics"
                                                       name="is_google_analytics">
                                                <label class="form-check-label" for="is_google_analytics">Enable Google
                                                    Analytics</label>
                                            </div>
                                        </div>
                                        <div class="d-flex" style="gap: 20px;">

                                            <button type="submit" class="update-btn">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Availability Tab Content -->
                                <div class="tab-pane fade" id="availability" role="tabpanel"
                                     aria-labelledby="availability-tab">
                                    <h4 class="stripe-text">Connect with Stripe</h4>
                                    <h5 class="stripe-label">Your account is not yet connected with Stripe.</h5>
                                    <a href="{{ route('stripe.connect') }}" class="stripe-btn mt-3">Connect with
                                        stripe</a>
                                </div>

                                <!-- Costs Tab Content -->
                                <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                                    <div class="container-fluid calendar-integration practitioner-profil">
                                        <div class=" integration-wrrpr">
                                            <div class="integration-header">
                                                <h4>Authorization</h4>
                                                <div class="form-group flex-column d-flex align-items-start">
                                                    <a href="{{route('redirectToGoogle')}}"
                                                       class="export-btn">Connect</a>
{{--                                                    <h6>Successfully authenticated.</h6>--}}
{{--                                                    <button class="export-btn" >Disconnect</button>--}}
                                                </div>
                                            </div>
{{--                                            <div class="form-group">--}}
{{--                                                <div>--}}
{{--                                                    <label>Calendar</label>--}}
{{--                                                    <p>Enter with your Calendar.</p>--}}
{{--                                                </div>--}}
{{--                                                <select>--}}
{{--                                                    <option>mohitmmv02@gmail.com</option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-group" style="border: none;">--}}
{{--                                                <div>--}}
{{--                                                    <label>Sync Preference <i--}}
{{--                                                            class="fas fa-question-circle icon"></i></label>--}}
{{--                                                    <p>Manage the sync flow between your Store calendar and Google--}}
{{--                                                        calendar.</p>--}}
{{--                                                </div>--}}
{{--                                                <select>--}}
{{--                                                    <option>Sync both ways - between Store and Google calendar--}}
{{--                                                    </option>--}}
{{--                                                </select>--}}
{{--                                            </div>--}}
                                        </div>
{{--                                        <button class="export-btn mt-4" style="margin-left: 50px;">Save Changes--}}
{{--                                        </button>--}}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="clint-tab">
                                    <form method="post" action="{{ route('updateClientPolicy') }}">
                                        <div class="mb-3">
                                            <label for="floatingTextarea">Privacy Policy</label>
                                            <textarea class="form-control" placeholder="" name="privacy_policy"
                                                      id="floatingTextarea">{{ $userDetails->privacy_policy ?? '' }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="floatingTextarea">Terms & Condition</label>
                                            <textarea class="form-control" name="terms_condition" placeholder=""
                                                      id="floatingTextarea">{{ $userDetails->terms_condition ?? '' }}</textarea>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                                        <div class="d-flex" style="gap: 20px;">
                                            <button class="update-btn m-0">Add Offering</button>
                                            <button class="update-btn">Save Draft</button>
                                        </div>
                                        @csrf
                                    </form>

                                </div>
                            </div>
                        </div>
                        {{--                        <div class="d-flex" style="gap: 20px;">--}}
                        {{--                            <button class="update-btn m-0">Add Offering</button>--}}
                        {{--                            <button class="update-btn">Save Draft</button>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

