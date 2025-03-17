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
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title m-0">Blogs</h4>
                                    <a href="{{route('admin.blogs.create')}}" class="btn btn-primary">Add New</a>
                                </div>
                                </p>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th> Image</th>
                                            <th> Name</th>
                                            <th> Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(!$blogs->isEmpty())
                                            @foreach($blogs as $blog)
                                                    <?php
                                                    $imageUrl = asset(env('media_path') . '/admin/blog/' . $blog->image);
                                                    ?>
                                                <tr>
                                                    <td>{{ ($blogs->currentPage() - 1) * $blogs->perPage() + $loop->iteration }}</td>

                                                    <td><img src="{{ $imageUrl}}" alt="Blog Image"
                                                             width="100"></td>
                                                    <td>{{$blog->name}}</td>
                                                    <td>
                                                        <div class="action-btn-container d-flex gap-2">
                                                            <a href="{{route('admin.blogs.edit', $blog->id)}}"
                                                               class="btn btn-sm btn-primary">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a href="javascript:void(0);"
                                                               class="btn btn-sm btn-danger  delete-btn"
                                                               data-id="{{ $blog->id }}">
                                                                <i class="fa-solid fa-trash-can"></i>
                                                            </a>
                                                            <form id="delete-form-{{ $blog->id }}"
                                                                  action="{{ route('admin.blogs.destroy', $blog->id) }}"
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
                                                <td colspan="4" class="text-center">No Data Found</td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                    <div class="custom_pagination">
                                        {!! $blogs->links() !!}
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

@push('custom_scripts')
 <script>
  document.addEventListener("DOMContentLoaded", function() {
      $(".delete-btn").click(function() {
          let blogId = $(this).data("id");

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
                  document.getElementById("delete-form-" + blogId).submit();
              }
          });
      });
  });
</script>
 @endpush
