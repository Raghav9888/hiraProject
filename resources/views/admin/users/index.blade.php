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
                                <h4 class="card-title">{{ $cardHeaderText ?? 'List of Users' }}</h4>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> Name</th>
                                            <th> Email</th>
                                            <th> Role</th>
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
                                                        echo match ($user->status) {
                                                            0 => '<span class="badge text-bg-danger rounded">Inactive</span>',
                                                            1 => '<span class="badge text-bg-success rounded">active</span>',
                                                            2 => '<span class="badge text-bg-warning rounded">Pending</span>',
                                                            default => '<span class="badge text-bg-danger rounded">Not defined</span>',
                                                        };
                                                    ?>
                                                </td>
                                                <td>
                                                    <div class="dropdown">
                                                        <a class="text-dark"  type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                            <span class="mdi mdi-dots-vertical"></span>
                                                        </a>
                                                        <ul class="dropdown-menu">
                                                            <li><a class="dropdown-item" href="#">Edit</a></li>
                                                            <li><a class="dropdown-item" href="#">Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="custom_pagination">
                                        {!! $users->links() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
