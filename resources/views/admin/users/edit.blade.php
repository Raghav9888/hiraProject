@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
                <form method="POST" action="{{ route('admin.users.update', array_filter(['id' => $userData->id, 'cardHeaderText' => $cardHeaderText ?? ''])) }}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Edit User</h4>
                                    <p class="card-description"> User Information </p>
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name"
                                               value="{{ $userData->name }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               value="{{ $userData->email }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="role">Role</label>
                                        {{--    role 0 = pending, role 1 = practitioner, role 2 = Admin--}}
                                        <select class="form-control" id="role" name="role">
                                            <option value="">Select role</option>
                                            <option value="0" {{ $userData->role == 0 ? 'selected' : '' }}>Pending
                                            </option>
                                            <option value="1" {{ $userData->role == 1 ? 'selected' : '' }}>
                                                Practitioner
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="role">Status</label>
                                        {{-- default status  0 = Inactive, status 1 = Active, status 2 = pending --}}
                                        <select class="form-control" id="status" name="status">
                                            <option value="">Select status</option>
                                            <option value="0" {{ $userData->status == 0 ? 'selected' : '' }}>In Active
                                            </option>
                                            <option value="1" {{ $userData->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="2" {{ $userData->status == 2 ? 'selected' : '' }}>Pending
                                            </option>
                                        </select>
                                    </div>


                                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                    <a href="{{ isset($cardHeaderText) && $cardHeaderText ? route('admin.users.new') : route('admin.users.index') }}"
                                       class="btn btn-light">Cancel</a>

                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
