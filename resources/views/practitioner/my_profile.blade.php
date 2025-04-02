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

                                    <form method="post" action="{{ route('update_profile') }}"
                                          enctype="multipart/form-data">
                                        @csrf
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
                                                           data-image-url="{{ $image }}"
                                                           data-user-id="{{ $userDetails->id }}"
                                                           data-profile-image="true"
                                                           data-name="{{ $image }}"
                                                           onclick="removeImage(this);" style="cursor: pointer;"></i>
                                                    </label>
                                                @else
                                                    <label onclick="document.getElementById('fileInput').click();"
                                                           class="image-preview rounded-5" id="imagePreview"
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
                                        <div class="row">
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="first_name" class="fw-bold">First Name</label>
                                                <input type="text" class="form-control" id="first_name"
                                                       name="first_name"
                                                       value="{{ $user->first_name ?? '' }}">
                                                <input type="hidden" class="form-control" id="id" name="id"
                                                       value="{{ $user->id ?? '' }}">
                                            </div>
                                            <div class="col-sm-12 col-lg-6 mb-3">
                                                <label for="last_name" class="fw-bold">Last Name</label>
                                                <input type="text" class="form-control" id="last_name" name="last_name"
                                                       value="{{ $user->last_name ?? '' }}">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="company_name">Title Name</label>
                                            <input type="text" class="form-control" id="company" name="company"
                                                   value="{{ $userDetails->company ?? 'Alternative Health Practitioner' }}">
                                            <p style="text-align: start;">Your title name is public and must be
                                                unique.</p>
                                        </div>

                                        {{-- <div class="mb-3">
                                                        <label for="bio">Short Bio</label>
                                                        <textarea class="form-control" id="bio"
                                                                  name="bio">{{ $userDetails->bio ?? '' }}</textarea>
                                    </div> --}}

                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between">
                                                <label for="bio" class="fw-bold">Short Bio</label>
                                                <p>Maximum length of 500 words</p>
                                            </div>
                                            <textarea class="form-control" name="bio" id="bio"
                                                      placeholder="">{{$userDetails->bio ?? ''}}</textarea>
                                            <p id="word-count">0 / 500 words</p>
                                        </div>

                                        <div class="mb-4 select2-div">
                                            <label for="location" class="fw-bold">Location</label>
                                            <select name="location[]" multiple="multiple" id="location"
                                                    class="form-control" data-type="multiselect">
                                                @foreach($locations as $location)
                                                    <option value="{{ $location->id }}"
                                                            @if(!empty($user->location) && in_array($location->id, json_decode($user->location, true)))
                                                                selected
                                                        @endif>
                                                        {{ $location->name }}
                                                    </option>
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
                                                    $selectedTags = json_decode($userDetails->tags ?? '[]', true);
                                                @endphp

                                                <div class="form-group select2-div">
                                                    <select name="tags[]" id="tags" multiple="multiple"
                                                            class="form-select" data-type="multiselect">
                                                        @foreach($practitionerTag as $tag)
                                                            <option value="{{$tag->id}}"
                                                                {{ in_array($tag->id, $selectedTags) ? 'selected' : '' }}>
                                                                {{$tag->name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <button class="update-btn mb-2 addterm" data-type="tags">Add
                                                    New Term
                                                </button>
                                            </div>
                                        </div>
                                        <div id="tags-container">

                                        </div>

                                        <div class="mb-4 mt-4" id="mediaDiv">
                                            <div class="d-flex">
                                                <label for="media" class="fw-bold">Galley of images</label>
                                                <div class="ms-3">
                                                    <label class="add-media-btn" for="media-upload">
                                                        <i class="fas fa-plus"></i>
                                                        Add media
                                                    </label>
                                                    <input type="file" id="media-upload" name="media_images[]"
                                                           class="hidden"
                                                           accept="image/*" multiple>
                                                </div>
                                            </div>


                                            <div class="media-container" id="media-container">
                                                @if(count($mediaImages) > 0)
                                                    @foreach ($mediaImages as $image)
                                                        <div class="media-item">
                                                            @php
                                                                $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/media/' . $image) ;
                                                            @endphp
                                                            <img
                                                                src="{{ $imageUrl }}"
                                                                alt="Practitioner Image"
                                                                style="width: 100px; height: 100px; object-fit: cover; display: block;">
                                                            <i class="fas fa-times text-danger" style="cursor: pointer;"
                                                               data-image="{{ $image }}"
                                                               data-user-id="{{ $user->id }}"
                                                               data-image-url="{{ $imageUrl }}"
                                                               data-name="{{ $image }}"
                                                               data-media-image="true"
                                                               data-html-render="mediaDiv"
                                                               onclick="removeImage(this);"></i>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No images available</p>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="mb-4 pt-2">
                                            <label for="IHelpWith" class="fw-bold">I help with</label>
                                            <div class="row align-items-center">
                                                <div class="col-md-6 select2-div">
                                                    <select id="IHelpWith" name="IHelpWith[]"
                                                            class="form-select" data-type="multiselect"
                                                            multiple>
                                                        @php
                                                            $selectedTerms = explode(',', $userDetails->IHelpWith ?? '');
                                                        @endphp
                                                        @foreach($IHelpWith as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }}>{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <button class="update-btn mb-2 addterm" data-type="IHelpWith">Add
                                                        New Term
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                        <div id="IHelpWith-container">

                                        </div>
                                        <!-- <div class="mb-4">
                                            <label for="type" class="fw-bold">I help with:</label>
                                            <select id="term" name="term" class="form-select select2"
                                                    multiple="multiple">
                                                <option>Select</option>
                                                @foreach($HowIHelp as $term)
                                            <option value="{{$term->id}}">{{$term->name}}</option>

                                        @endforeach
                                        </select>
                                    </div>
                                    <hr>
                                    <button class="update-btn mb-2">Add New Term</button> -->
                                        <div class="mb-4 select2-div">
                                            <label for="type" class="fw-bold">How I help</label>

                                            <div class="row align-items-center">
                                                <div class="col-md-6">
                                                    <select id="HowIHelp" name="HowIHelp[]"
                                                            class="form-select" data-type="multiselect" multiple>
                                                        @php
                                                            $selectedTerms = explode(',', $userDetails->HowIHelp ?? '');
                                                        @endphp
                                                        @foreach($HowIHelp as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }}>{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <button class="update-btn mb-2 addterm" data-type="HowIHelp">Add New
                                                        Term
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="HowIHelp-container">

                                        </div>

                                        <div class="mb-4 select2-div">
                                            <label for="specialities" class="fw-bold">Categories (only select 3)</label>
                                            <select id="specialities" class="form-control form-select"
                                                    multiple="multiple" data-type="multiselect" data-maxshow="3"
                                                    name="specialities[]">
                                                @foreach($Categories as $term)
                                                    <option
                                                        value="{{$term->id}}" {{ (isset($userDetails->specialities) && in_array($term->id, json_decode($userDetails->specialities))) ? 'selected' : '' }}>{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <?php
                                        $amenities = $userDetails->amenities ? json_decode($userDetails->amenities) : [];
                                        ?>
                                        <div class="mb-4 amenties-checkbox-container">
                                            <label class="form-label fw-bold">Amenities</label>
                                            <div class="row">
                                                <?php
                                                $allAmenities = [
                                                    "Virtual offerings",
                                                    "Library/Reading Area",
                                                    "Office-based sessions",
                                                    "Bathrooms",
                                                    "Bike racks",
                                                    "Home visits",
                                                    "Flexible packages",
                                                    "Herbal Tea/beverages",
                                                    "Sauna",
                                                    "Outdoor sessions",
                                                    "Payment plans",
                                                    "Resource library access",
                                                    "Private room",
                                                    "Steam room",
                                                    "Natural light rooms",
                                                    "Public transit accessible",
                                                    "Waiting area",
                                                    "Massage chairs",
                                                    "Spa facilities",
                                                    "Accessible Transportation Options"
                                                ];

                                                foreach ($allAmenities as $index => $amenity) {
                                                    $checked = in_array($amenity, $amenities) ? 'checked' : '';
                                                    ?>
                                                <div class="col-md-3">
                                                    <div class="form-check">
                                                        <input type="checkbox"
                                                               class="form-check-input amentities-checkbox"
                                                               id="amenity<?= $index + 1; ?>" name="amenities[]"
                                                               value="<?= $amenity; ?>" <?= $checked; ?>>
                                                        <label class="form-check-label"
                                                               for="amenity<?= $index + 1; ?>"><?= $amenity; ?></label>
                                                    </div>
                                                </div>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                        <div class="mb-4 select2-div">
                                            <label for="certifications" class="fw-bold">Certifications</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <select id="certifications" class="form-select"
                                                            name="certifications[]" multiple data-type="multiselect">
                                                        @php
                                                            $selectedTerms = explode(',', $userDetails->certifications ?? '');
                                                        @endphp
                                                        @foreach($certifications as $term)
                                                            <option
                                                                value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }}>{{$term->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mt-2">
                                                    <button class="update-btn mb-2 addterm" data-type="certifications">
                                                        Add New Term
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="certifications-container">

                                        </div>

                                        <div class="mb-4 select2-div">
                                            <label for="timezone1" class="fw-bold">Timezone</label>
                                            <select id="timezone1" name="timezone" class="form-select" data-type="multiselect">
                                                <option value="">Select</option>
                                                @foreach ($timezones as $timezone)
                                                    <option
                                                        value="{{ $timezone['id'] }}" {{ old('timezone', $userDetails->timezone) === $timezone['id'] ? 'selected' : '' }}>
                                                        {{ $timezone['name'] }}
                                                    </option>
                                                @endforeach
                                            </select>

                                            <p style="text-align: start;">Select your timezone</p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 store_hours-checkbox-container">
                                                <label for="service-hours" class="fw-bold">Store Hours Availability</label>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <?php
                                                    $storeAvailabilities = $userDetails->store_availabilities ? json_decode($userDetails->store_availabilities, true) : [];
                                                    $availabilities = [
                                                        'Every Day',
                                                        'Every Monday',
                                                        'Every Tuesday',
                                                        'Every Wednesday',
                                                        'Every Thursday',
                                                        'Every Friday',
                                                        'Weekends only - Every Sat & Sundays'
                                                    ];

                                                    foreach ($availabilities as $index => $availability) {
                                                        // Convert to a proper key (e.g., 'every_day', 'every_monday', etc.)
                                                        $key = strtolower(str_replace(' ', '_', $availability));

                                                        // Retrieve stored values if available
                                                        $fromValue = isset($storeAvailabilities[$key]['from']) ? $storeAvailabilities[$key]['from'] : '';
                                                        $toValue = isset($storeAvailabilities[$key]['to']) ? $storeAvailabilities[$key]['to'] : '';

                                                        // Check if checkbox should be selected
                                                        $checked = isset($storeAvailabilities[$key]['enabled']) ? 'checked' : '';
                                                        ?>
                                                    <div class="col-md-4 col-sm-6 col-12 mb-3">
                                                        <div class="form-check">
                                                            <input type="checkbox"
                                                                   class="form-check-input input_checkbox store_availabilities-checkbox"
                                                                   id="store_availabilities<?= $index + 1; ?>"
                                                                   name="store_availabilities[<?= $key; ?>][enabled]"
                                                                   value="1" <?= $checked; ?>>
                                                            <label class="form-check-label"
                                                                   for="store_availabilities<?= $index + 1; ?>"><?= $availability; ?></label>
                                                        </div>

                                                        <!-- Time Selection (Shown only if checkbox is checked) -->
                                                        <div class="store-time-input" id="store_time_<?= $index + 1; ?>"
                                                             style="display: <?= $checked ? 'block' : 'none'; ?>;">
                                                            <div class="row">
                                                                <div class="col-6">
                                                                    <label class="fw-bold">From</label>
                                                                    <input type="time" class="form-control"
                                                                           name="store_availabilities[<?= $key; ?>][from]"
                                                                           value="<?= htmlspecialchars($fromValue); ?>">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label class="fw-bold">To</label>
                                                                    <input type="time" class="form-control"
                                                                           name="store_availabilities[<?= $key; ?>][to]"
                                                                           value="<?= htmlspecialchars($toValue); ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-flex" style="gap: 20px;">
                                            <button type="submit" class="update-btn ms-0">Save Changes</button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Availability Tab Content -->
                                <div class="tab-pane fade" id="availability" role="tabpanel"
                                     aria-labelledby="availability-tab">
                                    <div class="container-fluid calendar-integration practitioner-profil">
                                        <div class="integration-wrrpr">
                                            <h4 class="stripe-text m-2">Connect with Stripe</h4>
                                            <h5 class="stripe-label m-2">{{($stripeAccount && $stripeAccount->stripe_access_token && $stripeAccount->stripe_refresh_token) ?'Successfully authenticated.': 'Your account is not yet connected
                                                with Stripe.'}}</h5>
                                            <div class="border-1 border-bottom"></div>
                                            <div class="integration-header">
                                                <h4>Authorization</h4>
                                                <div class="form-group flex-column d-flex align-items-start">
                                                    @if($stripeAccount && $stripeAccount->stripe_access_token && $stripeAccount->stripe_refresh_token)
                                                        <a href="{{ route('disconnect_to_stripe') }}"
                                                           class="export-btn">Disconnect</a>
                                                    @else
                                                        <a href="{{ route('stripe_connect') }}" class="export-btn">Connect</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Costs Tab Content -->
                                <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                                    <div class="container-fluid calendar-integration practitioner-profil">
                                        <div class="integration-wrrpr">
                                            <h4 class="stripe-text m-2">Connect with Google Account</h4>
                                            <h5 class="stripe-label m-2">{{($googleAccount && $googleAccount->access_token && $googleAccount->refresh_token) ? 'Successfully authenticated.': 'Your account is not yet connected
                                                with Google.'}}</h5>
                                            <div class="border-1 border-bottom"></div>
                                            <div class="integration-header">
                                                <h4>Authorization</h4>
                                                <div class="form-group flex-column d-flex align-items-start">
                                                    @if($googleAccount && $googleAccount->access_token && $googleAccount->refresh_token)
                                                        <a href="{{ route('disconnect_to_google') }}"
                                                           class="export-btn">Disconnect</a>
                                                    @else
                                                        <a href="{{ route('redirect_to_google') }}" class="export-btn">Connect</a>
                                                    @endif
                                                </div>
                                            </div>

                                            {{-- <div class="form-group">--}}
                                            {{-- <div>--}}
                                            {{-- <label>Calendar</label>--}}
                                            {{-- <p>Enter with your Calendar.</p>--}}
                                            {{-- </div>--}}
                                            {{-- <select>--}}
                                            {{-- <option>mohitmmv02@gmail.com</option>--}}
                                            {{-- </select>--}}
                                            {{-- </div>--}}
                                            {{-- <div class="form-group" style="border: none;">--}}
                                            {{-- <div>--}}
                                            {{-- <label>Sync Preference <i--}}
                                            {{-- class="fas fa-question-circle icon"></i></label>--}}
                                            {{-- <p>Manage the sync flow between your Store calendar and Google--}}
                                            {{-- calendar.</p>--}}
                                            {{-- </div>--}}
                                            {{-- <select>--}}
                                            {{-- <option>Sync both ways - between Store and Google calendar--}}
                                            {{-- </option>--}}
                                            {{-- </select>--}}
                                            {{-- </div>--}}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="client" role="tabpanel" aria-labelledby="clint-tab">
                                    <form method="post" action="{{ route('update_client_policy') }}">
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

                                        <div class="mb-3">
                                            <label for="floatingTextarea">Cancellation Policy</label>
                                            <textarea class="form-control" name="cancellation_policy" placeholder=""
                                                      id="floatingTextarea">{{ $userDetails->cancellation_policy ?? '' }}</textarea>
                                        </div>
                                        <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                                        <div class="d-flex" style="gap: 20px;">
                                            <button class="update-btn">Save</button>
                                        </div>
                                        @csrf
                                    </form>

                                </div>
                            </div>
                        </div>
                        {{-- <div class="d-flex" style="gap: 20px;">--}}
                        {{-- <button class="update-btn m-0">Add Offering</button>--}}
                        {{-- <button class="update-btn">Save Draft</button>--}}
                        {{-- </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll(".store_availabilities-checkbox").forEach(function(checkbox) {
                checkbox.addEventListener("change", function() {
                    let inputDiv = document.getElementById("store_time_" + this.id.replace("store_availabilities", ""));
                    if (this.checked) {
                        inputDiv.style.display = "block";
                    } else {
                        inputDiv.style.display = "none";
                        inputDiv.querySelectorAll("input").forEach(input => input.value = ""); // Clear values when unchecked
                    }
                });
            });
        });
    </script>
@endsection
