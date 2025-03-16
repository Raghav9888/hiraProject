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
                                <h4 class="card-title">Add New Plan</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data" action="{{ route('admin.plans.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="exampleInputName1">Name</label>
                                        <input type="text" class="form-control" name="name" required
                                            id="exampleInputName1" value="{{old("name")}}" placeholder="Name">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Price (USD)</label>
                                                <input type="text" class="form-control" name="price" required
                                                    id="exampleInputName1" value="{{old("price")}}" placeholder="1.00">
                                                @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleInputName1">Tax (in %)</label>
                                                <input type="text" class="form-control" name="tax_percentage" required
                                                    id="exampleInputName1" value="{{old("tax_percentage")}}" placeholder="1.00">
                                                @error('tax_percentage')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputName1">Billing Interval</label>
                                        <select class="form-control" name="interval">
                                            <option value="month">Monthly</option>
                                            <option value="year">Yearly</option>
                                            <option value="two_years">Two-Yearly</option>
                                        </select>
                                        @error('interval')
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
    </script>
@endpush
