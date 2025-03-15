@extends('admin.layouts.app')

@section('content')

    @include('admin.layouts.nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <div class="main-panel">
            <div class="content-wrapper">
            </div>
        </div>
    </div>
@endsection
