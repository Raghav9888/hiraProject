<form method="POST" action="{{ route('waitList') }}" id="waitlist-form" enctype="multipart/form-data">
    @csrf
    <div class="modal-body form-container">


        {{-- Basic Info --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label>First Name</label>
                <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Last Name</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Business Name</label>
                <input type="text" name="business_name" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Website</label>
                <input type="url" name="website" class="form-control" required>
            </div>
        </div>

        {{-- Practice Info --}}
        <div class="mb-3">
            <label>Which best describes your current practice?</label>
            <input type="text" name="current_practice" class="form-control">
        </div>

        {{-- Referral --}}
        <div class="mb-3">
            <label>How did you hear about us?</label><br>
            <div class="form-check"><input type="checkbox" name="heard_from[]" value="instagram"
                                           class="form-check-input input_checkbox"> Instagram
            </div>
            <div class="form-check"><input type="checkbox" name="heard_from[]" value="facebook"
                                           class="form-check-input input_checkbox"> Facebook
            </div>
            <div class="form-check">
                <input type="checkbox" name="heard_from[]" value="referral" class="form-check-input input_checkbox"
                       id="referral_check">
                Referral – Who referred you?
                <input type="text" name="referral_name" id="referral_name" class="form-control mt-1 d-none" style="height: 46px;
    padding: 17px 21px;">
            </div>
            <div class="form-check"><input type="checkbox" name="heard_from[]" value="event"
                                           class="form-check-input input_checkbox"> Attended an Event
            </div>
            <div class="form-check"><input type="checkbox" name="heard_from[]" value="google"
                                           class="form-check-input input_checkbox"> Google/Search
            </div>
            <div class="form-check">
                <input type="checkbox" name="heard_from[]" value="other" class="form-check-input input_checkbox"
                       id="other_check">
                Other:
                <input type="text" name="other_source" id="other_source" class="form-control mt-1 d-none">
            </div>
        </div>

        {{-- Open Questions --}}
        <div class="mb-3">
            <label>What called you to join the waitlist?</label>
            <textarea name="called_to_join" class="form-control" rows="2"></textarea>
        </div>
        <div class="mb-3">
            <label>Tell us about your practice and values</label>
            <textarea name="practice_values" class="form-control" rows="4"></textarea>
        </div>
        <div class="mb-3">
            <label>What excites you about being part of The Hira Collective?</label>
            <textarea name="excitement_about_hira" class="form-control" rows="3"></textarea>
        </div>

        {{-- File Upload --}}
        <div class="mb-3">
            <label>Upload (Max 2 files)</label>
            <input type="file" name="uploads[]" class="form-control" id="fileUpload" multiple
                   accept=".pdf,.doc,.docx,.png,.jpg,.jpeg,.mp4,.mov">
            <div id="filePreview" class="mt-3 d-flex flex-wrap gap-3"></div>
        </div>

        {{-- Optional Questions --}}
        <div class="mb-3 amenties-checkbox-container">
            <label>Are you open to a brief call if space becomes available?</label><br>
            <div class="form-check"><input type="radio" name="call_availability" value="yes"
                                           class="form-check-input input_checkbox"> Yes
            </div>
            <div class="form-check"><input type="radio" name="call_availability" value="no"
                                           class="form-check-input input_checkbox"> Not right now
            </div>
        </div>

        <div class="mb-3 amenties-checkbox-container">
            <label>Would you like to receive our newsletter?</label><br>
            <div class="form-check"><input type="radio" name="newsletter" value="yes"
                                           class="form-check-input input_checkbox"> Yes please
            </div>
            <div class="form-check"><input type="radio" name="newsletter" value="no"
                                           class="form-check-input input_checkbox"> Not right now
            </div>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password">Password</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                <span class="input-group-text toggle-password" data-target="password">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
        </div>
        <div class="mb-3">
            <label for="password_confirmation">Confirm Password</label>
            <div class="input-group">
                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                       placeholder="Confirm Password">
                <span class="input-group-text toggle-password" data-target="password_confirmation">
                    <i class="fas fa-eye"></i>
                </span>
            </div>
            <p class="text-white pt-2">Create a password that is a minimum of 8 characters</p>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-green rounded-pill" id="waitListRegister">Register</button>
    </div>
</form>




