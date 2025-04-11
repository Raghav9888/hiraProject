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
                                <h4 class="card-title">Edit Community</h4>
                                <form action="{{ route('admin.community.update',$community) }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-12 mt-3">
                                            <label class="form-label" id="title">Title</label>
                                            <input type="text" placeholder="Enter community title" name="title"
                                                   class="form-control" id="title" value="{{$community->title}}">
                                        </div>

                                        <div class="col-md-12 mt-3">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="4">{{$community->description}}</textarea>
                                            @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-12 mt-3">
                                            <div class="form-group">
                                                <label>File upload</label>
                                                <input type="file" name="image" class="file-upload-default">
                                                <div class="input-group col-xs-12">
                                                    <input type="text" class="form-control file-upload-info" disabled
                                                           placeholder="Upload Image">
                                                    <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary"
                                                        type="button">Upload</button>
                                            </span>
                                                </div>
                                                <div class="old_img my-3">
                                                        <?php
                                                        $imageUrl = asset(env('media_path') . '/admin/community/' . $community->image);
                                                        ?>
                                                    <img src="{{ $imageUrl }}" alt="community Image" width="100">
                                                </div>
                                                @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <a href="{{ route('admin.community.index') }}" class="btn btn-secondary">Cancel</a>
                                </form>
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
        ClassicEditor.create(document.querySelector('#description'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush

