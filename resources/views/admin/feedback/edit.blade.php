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
                                <h4 class="card-title">Edit Feedback</h4>

                                <form action="{{ route('admin.feedback.update', $feedback->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Comment:</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="4">{{ old('comment', strip_tags($feedback->comment)) }}</textarea>
                                        @error('comment')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Feedback Type:</label>
                                            <div class="col-sm-4">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="practitionerFeedback">
                                                        <input type="radio" class="form-check-input" name="feedback_type" id="practitionerFeedback" value="practitioner"
                                                            {{ old('feedback_type', $feedback->feedback_type) == 'practitioner' ? 'checked' : '' }}>
                                                        Practitioner Feedback
                                                        <i class="input-helper"></i>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-sm-5">
                                                <div class="form-check">
                                                    <label class="form-check-label" for="offeringFeedback">
                                                        <input type="radio" class="form-check-input" name="feedback_type" id="offeringFeedback" value="offering"
                                                            {{ old('feedback_type', $feedback->feedback_type) == 'offering' ? 'checked' : '' }}>
                                                        Feedback for Offering
                                                        <i class="input-helper"></i></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="userSection" class="mb-3" style="display: none;">
                                        <label class="form-label">User:</label>
                                        <select name="user_id" id="userSelect" class="form-control">
                                            <option value="">Select User</option>
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}" {{ old('user_id', $feedback->user_id) == $user->id ? 'selected' : '' }}>
                                                    {{ $user->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div id="offeringSection" class="mb-3" style="display: none;">
                                        <label class="form-label">Offering:</label>
                                        <select name="offering_id" id="offeringSelect" class="form-control">
                                            <option value="">Select Offering</option>
                                            @foreach($offerings as $offering)
                                                <option value="{{ $offering->id }}" {{ old('offering_id', $feedback->offering_id) == $offering->id ? 'selected' : '' }}>
                                                    {{ $offering->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Rating:</label>
                                        <select name="rating" class="form-control">
                                            <option value="">Select Rating</option>
                                            @for ($i = 1; $i <= 5; $i++)
                                                <option value="{{ $i }}" {{ old('rating', $feedback->rating) == $i ? 'selected' : '' }}>
                                                    {{ $i }} Star
                                                </option>
                                            @endfor
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Feedback</button>
                                    <a href="{{ route('admin.feedback.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- End of content-wrapper -->
        </div> <!--
