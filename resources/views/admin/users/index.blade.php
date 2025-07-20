@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.nav')

    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">
                                    <?php
                                    if (isset($type) && $type) {

                                        echo match ($type) {
                                            '4' => 'Delete Users',
                                            '3' => 'List of Users',
                                            '2' => 'New Users',
                                            default => 'List of Practitioners',
                                        };
                                    }

                                    ?>
                                </h4>

                                @if(count($users) > 0)
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th> Name</th>
                                                <th> Email</th>
                                                <th> Role</th>
                                                <th> Has Strip account</th>
                                                <th> Status</th>
                                                <th> Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($users as $user)
                                                <tr>
                                                    <td>{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->email}}</td>
                                                    <td>
                                                            <?php
                                                            echo match ($user->role) {
                                                                0 => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                                1 => '<span class="badge text-bg-success rounded">Practitioner</span>',
                                                                default => '<span class="badge text-bg-primary rounded">User</span>',
                                                            };
                                                            ?>
                                                    </td>
                                                    <td>
                                                            <?php
                                                            if ($user->stripe_id) {
                                                                echo '<span class="badge text-bg-success rounded">Yes</span>';
                                                            } else {
                                                                echo '<span class="badge text-bg-danger rounded">No</span>';
                                                            }
                                                            ?>
                                                    </td>
                                                    <td>
                                                            <?php
                                                            echo match ($user->status) {
                                                                0 => '<span class="badge text-bg-danger rounded">Inactive</span>',
                                                                1 => '<span class="badge text-bg-success rounded">active</span>',
                                                                2 => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                                3 => '<span class="badge text-bg-danger rounded">Delete</span>',
                                                                default => '<span class="badge text-bg-danger rounded">Not defined</span>',
                                                            };
                                                            ?>
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="text-dark" type="button" data-bs-toggle="dropdown"
                                                               aria-expanded="false">
                                                                <span class="mdi mdi-dots-vertical"></span>
                                                            </a>
                                                            <ul class="dropdown-menu">
                                                                @if($user->status == 2)

                                                                    @if($user->waitlist)
                                                                        <li>
                                                                            <a class="dropdown-item"
                                                                               href="{{route('admin.user.waitlist', ['id' => $user->id])}} "
                                                                            >Wait list detail</a>
                                                                        </li>
                                                                    @endif
                                                                        <li>
                                                                            <a href="#"
                                                                               class="dropdown-item"
                                                                               data-bs-toggle="modal"
                                                                               data-bs-target="#interviewModal"
                                                                               data-user-id="{{ $user->id }}"
                                                                               data-user-email="{{ $user->email }}"
                                                                               data-user-name="{{ $user->name }}">
                                                                                Send Interview Link
                                                                            </a>
                                                                        </li>

                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('admin.user.approve', ['id' => $user->id])}} "
                                                                           data-type="alert" data-title="Are you sure?"
                                                                           data-text="Are you sure you want to approve this user!"
                                                                           data-icon-type="warning"
                                                                           data-confirm-text="approved"
                                                                           data-cancel-text="cancel"
                                                                        >Approve user</a>
                                                                    </li>
                                                                @endif

                                                                <li>
                                                                    <a class="dropdown-item"
                                                                       href="{{route('admin.user.edit', ['id' => $user->id,'type' =>$type])}}"
                                                                       data-action="bootbox_form"
                                                                       data-title="Edit User"
                                                                       data-submit="Save Changes"
                                                                       data-size="large"
                                                                       data-table="usersTable">Edit</a>
                                                                </li>
                                                                @if(!in_array($user->status,['2','3']))
                                                                    <li>
                                                                        <a class="dropdown-item"
                                                                           href="{{route('admin.bookings', ['userId' => $user->id,'userType' =>$type])}}"
                                                                           data-action="bootbox_form"
                                                                           data-title="Edit User"
                                                                           data-submit="Save Changes"
                                                                           data-size="large"
                                                                           data-table="usersTable">Bookings</a>
                                                                    </li>
                                                                @endif
                                                                <li>
                                                                    <a class="dropdown-item login_as"
                                                                       data-id="{{$user->id}}"
                                                                       href="javascript:void(0);">Login as</a>
                                                                </li>
                                                                @if($user->status != 3)
                                                                    <li>
                                                                        <a class="dropdown-item" data-type="alert"
                                                                           data-title="Are you sure?"
                                                                           data-text="Are you sure you want to delete this record?"
                                                                           data-icon-type="warning"
                                                                           data-confirm-text="delete"
                                                                           data-cancel-text="cancel"
                                                                           href="{{route('admin.user.delete', ['id' => $user->id,'type' =>$type])}}">Delete</a>
                                                                    </li>
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </td>

                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="alert alert-primary" role="alert">
                                        <p>No users found</p>
                                    </div>
                                @endif
                            </div>
                            <div class="card-footer bg-white text-end">
                                <div class="d-flex justify-content-end">
                                    {!! $users->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Interview Modal -->
    <div class="modal fade" id="interviewModal" tabindex="-1" aria-labelledby="interviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="interviewForm">
                @csrf
                <input type="hidden" name="user_id" id="modal_user_id">
                <input type="hidden" name="user_email" id="modal_user_email">
                <input type="hidden" name="user_name" id="modal_user_name">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Schedule Interview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Start Time</label>
                            <input type="datetime-local" class="form-control" name="start_time" id="start_time" required>
                        </div>
                        <div class="mb-3">
                            <label>End Time</label>
                            <input type="datetime-local" class="form-control" name="end_time" id="end_time" required>
                        </div>
                        <div id="meetLinkBox" class="d-none">
                            <label>Google Meet Link</label>
                            <div class="form-control" id="generatedLink"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="sendInviteBtn">Send Interview</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@push('custom_scripts')

    <script>
        $('.login_as').on('click', function () {
            const userId = $(this).data('id');
            $.ajax({
                url: "{{route('admin.login.as')}}",
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: userId
                },
                success: function (response) {
                    if (!response.success) {
                        toastr.error("Someting went wrong!");
                    }
                    toastr.success(response.data);

                    if (response.redirect) {
                        window.location.href = response.redirect;
                    } else {
                        window.location.reload();
                    }

                },
                error: function (error) {
                    toastr.error("Someting went wrong!");
                }
            })
        })

        // When modal opens, set user data
        document.querySelectorAll('[data-bs-target="#interviewModal"]').forEach(el => {
            el.addEventListener('click', function () {
                selectedUserId = this.dataset.userId;
                document.getElementById('modal_user_id').value = this.dataset.userId;
                document.getElementById('modal_user_email').value = this.dataset.userEmail;
                document.getElementById('modal_user_name').value = this.dataset.userName;
            });
        });

        // On form submit
        document.getElementById('interviewForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const btn = document.getElementById('sendInviteBtn');
            btn.disabled = true;
            btn.textContent = 'Sending...';

            const formData = new FormData(this);

            fetch("{{ route('admin.user.interview.send.ajax') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
                .then(res => res.json())
                .then(data => {
                    btn.disabled = false;
                    btn.textContent = 'Send Interview';

                    if (data.status === 'success') {
                        document.getElementById('meetLinkBox').classList.remove('d-none');
                        document.getElementById('generatedLink').textContent = data.link;
                        toastr.success("Interview link sent!");
                    } else {
                        toastr.error(data.message || 'Something went wrong!');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.textContent = 'Send Interview';
                    toastr.error('Error occurred while sending invite.');
                });
        });


    </script>

@endpush
