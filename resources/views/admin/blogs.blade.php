@extends('admin.layouts.app')

@section('content')  
      
@include('admin.layouts.nav')
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_sidebar.html -->
            @include('admin.layouts.sidebar')
            <!-- partial -->
            <div class="main-panel">
                Blogs list

            </div>
        </div>
 @endsection        