@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.nav')
    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Add Feedback</h4>

                                <form action="{{ route('admin.feedback.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf


                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Feedback Type:</label>
                                            <div class="col-sm-4">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="practitionerFeedback">
                                                        <input type="radio" class="form-check-input" name="feedback_type" id="practitionerFeedback" value="practitioner" checked >
                                                      Practitioner Feedback
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="offeringFeedback">
                                                        <input type="radio" class="form-check-input" name="feedback_type" id="offeringFeedback" value="offering" >
                                                        Feedback for Offering
                                                        <i class="input-helper"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="userSection" class="mb-3 d-none">
                                        <label class="form-label">Practitioner:</label>
                                        <select name="practitioner_id" id="practitionerSelect" class="form-control">
                                            <option value="">Select Practitioner</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="offeringSection" class="mb-3 d-none">
                                        <label class="form-label">Offering:</label>
                                        <select name="offering_id" id="offeringSelect" class="form-control">
                                            <option value="">Select Offering</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Name</label>
                                        <input type="text" placeholder="Enter user name" name="name" class="form-control">
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-group">
                                            <label>Image upload</label>
                                            <input type="file" name="image" class="file-upload-default" accept="image/*">
                                            <div class="input-group col-xs-12">
                                                <input type="text" class="form-control file-upload-info" disabled
                                                       placeholder="Upload Image">
                                                <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary"
                                                        type="button">Upload</button>
                                            </span>
                                            </div>
                                            @error('image')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Rating:</label>
                                        <select name="rating" class="form-control">
                                            <option value="">Select Rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}">{{ $i }} Star</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Comment:</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4">{{old('comment')}}</textarea>
                                        @error('comment')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>


                                    <button type="submit" class="btn btn-primary">Submit Feedback</button>
                                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End of content-wrapper -->
        </div> <!-- End of main-panel -->
    </div> <!-- End of container-fluid -->
@endsection

@push('custom_scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const practitionerFeedback = document.getElementById("practitionerFeedback");
            const offeringFeedback = document.getElementById("offeringFeedback");
            const userSection = document.getElementById("userSection");
            const offeringSection = document.getElementById("offeringSection");
            const userSelect = document.getElementById("practitionerSelect");
            const offeringSelect = document.getElementById("offeringSelect");

            function toggleSections() {
                // Show user section if either checkbox is checked
                userSection.classList.toggle("d-none", !(practitionerFeedback.checked || offeringFeedback.checked));

                // Show offering section only if offeringFeedback is checked
                offeringSection.classList.toggle("d-none", !offeringFeedback.checked);
            }

            // Event listeners for checkboxes
            practitionerFeedback.addEventListener("change", toggleSections);
            offeringFeedback.addEventListener("change", toggleSections);

            // Fetch offerings dynamically when user is selected
            userSelect.addEventListener("change", function () {
                if (this.value) {
                    fetch("{{ url('/admin/feedback/get-offerings') }}/" + this.value)
                        .then(response => response.json())
                        .then(data => {
                            offeringSelect.innerHTML = '<option value="">Select Offering</option>';
                            data.forEach(offering => {
                                offeringSelect.innerHTML += `<option value="${offering.id}">${offering.name}</option>`;
                            });
                        })
                        .catch(error => console.error("Error fetching offerings:", error));
                }
            });

            // Initialize correct visibility on page load
            toggleSections();
        });
    </script>

    <script>
        ClassicEditor.create(document.querySelector('#comment'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

