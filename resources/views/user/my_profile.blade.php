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
                                                <p style="text-align: start;" class="text">Image</p>
                                                <input type="file" id="fileInput" name="image" class="hidden"
                                                       accept="image/*"
                                                       onchange="previewImage(event)" style="display: none;">

                                                @if(isset($image))
                                                    @php
                                                        $imageUrl = asset(env('media_path') . '/practitioners/' . $userDetails->id . '/profile/' . $image);

                                                    @endphp
                                                    <label class="image-preview" id="imagePreview"
                                                           style="border-radius: 50%; background-image: url('{{$imageUrl}}'); background-size: cover; background-position: center center;">
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

                                                <div class="preview-div">
                                                    <img src="{{ url('/assets/images/Laptop.svg') }}" alt="">
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
                                            <select id="location" name="location[]" class="form-select select2"
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
                                        <select name="tags[]" multiple="multiple" class="form-select select2">
                                            <option value="156">energybalancing</option>
                                            <option value="2991">ASD</option>
                                        </select>
                                        <hr>
                                        <div class="mb-4 mt-4">
                                            <label for="media" class="fw-bold">Media</label>
                                            <label class="add-media-btn" for="media-upload">
                                                <i class="fas fa-plus"></i>
                                                Add media
                                            </label>
                                            <input type="file" id="media-upload" name="media_images[]" class="hidden"
                                                   accept="image/*" multiple>

                                            <div class="media-container" id="media-container">
                                                @if(count($mediaImages) > 0)
                                                    @foreach ($mediaImages as $image)
                                                        <div class="media-item">
                                                            <img
                                                                src="{{ asset(env('media_path') . '/practitioners/' . $userDetails->id . '/media/' . $image) }}"
                                                                alt="Practitioner Image"
                                                                style="width: 100px; height: 100px; object-fit: cover; display: block;">
                                                            <i class="fas fa-times text-danger" style="cursor: pointer;"
                                                               data-image="{{ $image }}"
                                                               data-user-id="{{ $userDetails->id }}"
                                                               onclick="removeImage(this);"></i>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No images available</p>
                                                @endif
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
                                            <label for="IHelpWith" class="fw-bold">I help with:</label>
                                            <select id="IHelpWith" name="IHelpWith[]" class="form-select select2"
                                                    multiple>
                                                @php
                                                    $selectedTerms = explode(',', $userDetails->IHelpWith ?? '');
                                                @endphp
                                                @foreach($IHelpWith as $term)
                                                    <option
                                                        value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }} >{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2 addterm" data-type="IHelpWith">Add New Term
                                        </button>
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
                                        <div class="mb-4">
                                            <label for="type" class="fw-bold">How I help:</label>
                                            <select id="HowIHelp" name="HowIHelp[]" class="form-select select2"
                                                    multiple>
                                                @php
                                                    $selectedTerms = explode(',', $userDetails->HowIHelp ?? '');
                                                @endphp
                                                @foreach($HowIHelp as $term)
                                                    <option
                                                        value="{{$term->id}}" {{ in_array($term->id, $selectedTerms) ? 'selected' : '' }} >{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <hr>
                                        <button class="update-btn mb-2 addterm" data-type="HowIHelp">Add New Term
                                        </button>
                                        <div id="HowIHelp-container">

                                        </div>
                                        <div class="mb-4">
                                            <label for="specialities" class="fw-bold">Categories</label>
                                            <select id="specialities" class="form-control form-select select2"
                                                    multiple="multiple"
                                                    name="specialities[]">
                                                @foreach($Categories as $term)
                                                    <option
                                                        value="{{$term->id}}" {{ in_array($term->id, json_decode($userDetails->specialities)) ? 'selected' : '' }}>{{$term->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <hr>
                                        <div class="mb-4">

                                            <label class="form-check-label" for="amentities">Amentities</label>
                                            <select id="amentities" class="form-control form-select select2"
                                                    name="amentities" multiple="multiple">
                                                <option>Select</option>
                                                <option>Neurolinguistic Programming</option>
                                            </select>
                                        
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
    <script>
        $('.addterm').on('click', function (e) {
            e.preventDefault();
            var termType = $(this).data('type'); // Get the data-type attribute value

            $.ajax({
                url: '{{route("add_term")}}', // Change this to your server-side script
                type: 'POST',
                data: {
                    type: termType,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('#' + termType + '-container').html(response.inputField);
                    } else {
                        alert('Error: ' + response.message);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        $(document).on('click', '.save_term', function (e) {
            e.preventDefault();
            var termType = $(this).data('type'); // Get the data-type attribute value
            var name = $('.' + termType + '_term').val();
            $.ajax({
                url: '{{route("save_term")}}', // Change this to your server-side script
                type: 'POST',
                data: {
                    type: termType,
                    name: name,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        var selectElement = $("#" + termType);

                        // Append the new option
                        var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                        selectElement.append(newOption);

                        // Get previously selected values and add the new one
                        var selectedValues = selectElement.val() || [];
                        selectedValues.push(response.term.id);

                        // Reapply selected values
                        selectElement.val(selectedValues).trigger('change');
                        alert('Term added successfully');
                    } else {
                        alert('Error: ' + response.message);
                    }
                    $('#' + termType + '-container').html('');
                },
                /*  success: function (response) {
                     if (response.success) {
                         $('#' + termType + '-container').html('');
                         var newOption = `<option value="${response.term.id}" selected>${response.term.name}</option>`;
                         $("#" + termType).append(newOption).trigger('change');
                         alert('term add sucessfully');

                     } else {
                         alert('Error: ' + response.message);
                     }
                 }, */
                error: function (xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });

        /*** media upload */
        document.getElementById('media-upload').addEventListener('change', function (event) {
            const container = document.getElementById('media-container');
            const files = event.target.files;

            for (let file of files) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    const div = document.createElement('div');
                    div.classList.add('media-item');

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.width = "100px";
                    img.style.height = "100px";
                    img.style.objectFit = "cover";
                    img.style.display = "block";

                    const removeBtn = document.createElement('i');
                    removeBtn.classList.add('fas', 'fa-times');
                    removeBtn.style.cursor = "pointer";

                    removeBtn.addEventListener('click', function () {
                        div.remove();
                    });

                    div.appendChild(img);
                    div.appendChild(removeBtn);
                    container.appendChild(div);
                };

                reader.readAsDataURL(file);
            }
        });

        function removeImage(element) {
            const imageName = $(element).data('image');
            const userId = $(element).data('user-id');
            const profileImage = $(element).data('profile-image');

            $.ajax({
                url: '/delete/image',
                type: 'POST',
                data: {
                    image: imageName,
                    user_id: userId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    // Check if the profile image is being deleted
                    if (profileImage) {
                        // Remove the existing image preview
                        $('#imagePreview').remove();

                        // Add the new label for image upload
                        const uploadLabel = `
                    <label onclick="document.getElementById('fileInput').click();" class="image-preview" id="imagePreview" style="border-radius: 50%;">
                        <span>+</span>
                    </label>
                `;

                        $('#imageDiv').append(uploadLabel);
                    } else {
                        $(element).parent().remove();
                    }

                    console.log('Image removed successfully', response);
                },
                error: function (xhr, status, error) {
                    // Handle error
                    console.error('Error removing image:', error);
                }
            });

        }


    </script>
@endsection

