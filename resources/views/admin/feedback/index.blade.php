@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.nav')
    <div class="container-fluid page-body-wrapper">
        @include('admin.layouts.sidebar')

        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title m-0">Feedback</h4>
                                    {{-- <a href="{{ route('admin.feedback.create') }}" class="btn btn-primary">Add Feedback</a> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Admin</th>
                                            <th>Practitioner</th>
                                            <th>Name</th>
                                            <th>Offering</th>
{{--                                            <th>Comment</th>--}}
                                            <th>Rating</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!$feedbacks->isEmpty())
                                            @foreach($feedbacks as $feedback)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $feedback->admin->name }}</td>
                                                    <td>{{ $feedback->user ? $feedback->user->name : '-' }}</td>
                                                    <td>{{ $feedback->name ? $feedback->name : '-' }}</td>
                                                    <td>{{ $feedback->offering ? $feedback->offering->name : '-' }}</td>
{{--                                                    <td>{{ Str::limit(strip_tags($feedback->comment), 50) }}</td>--}}

                                                    <td>
                                                        @if($feedback->rating)
                                                            <span class="badge bg-warning">
                                                                 {!! str_repeat('⭐', $feedback->rating) !!}
                                                              </span>
                                                        @else
                                                            -
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <div class="action-btn-container d-flex gap-2">
                                                            <a href="{{ route('admin.feedback.edit', $feedback->id) }}"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-sm btn-danger delete-btn"
                                                               data-id="{{ $feedback->id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>

                                                            <form id="delete-form-{{ $feedback->id }}"
                                                                  action="{{ route('admin.feedback.destroy', $feedback->id) }}"
                                                                  method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center">No Feedback Found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-end">
                                <div class="d-flex justify-content-end">
                                    {!! $feedbacks->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('custom_scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $(".delete-btn").click(function () {
                let feedbackId = $(this).data("id");

                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById("delete-form-" + feedbackId).submit();
                    }
                });
            });
        });
    </script>
@endpush
