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
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title"> Edit Blog</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data"
                                      action="{{ route('admin.location.update',$location->id) }}">
                                    @csrf

                                    <div class="form-group">
                                        <label for="exampleInputName1">Title</label>
                                        <input type="text" class="form-control" name="name" required
                                               id="exampleInputName1" value="{{ $location->name }}" placeholder="Title">
                                        @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary me-2">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
