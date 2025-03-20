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
                                <h4 class="card-title">Add New Blog</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('admin.blogs.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">Title</label>
                                        <input type="text" class="form-control" name="name" required
                                            id="exampleInputName1" value="{{old("name")}}" placeholder="Title">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Category</label>
                                                <select name="category" class="form-control" id="">
                                                    <option value="0" disabled>Select Category</option>
                                                    @foreach($categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                    @endforeach
                                                </select>
                                                @error('category')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tags</label>
                                                <input type="text" class="form-control" name="tags"
                                                    id="exampleInputName1" value="{{old("tags")}}" placeholder="tag, tags">
                                                <small><i>Comma separated</i></small>
                                                @error('tags')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Author</label>
                                                <input type="text" class="form-control" name="author"
                                                    id="exampleInputName1" value="{{old("author")}}" placeholder="author">
                                                @error('author')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Date</label>
                                                <input type="date" class="form-control" name="date"
                                                    id="exampleInputName1" value="{{old("date")}}" placeholder="Title">
                                                @error('date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleTextarea1">Description</label>
                                        <textarea class="form-control" id="editor" name="description" rows="4">{{old('description')}}</textarea>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
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
                                        @error('image')
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

@push('custom_scripts')
    <script>
        ClassicEditor.create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
