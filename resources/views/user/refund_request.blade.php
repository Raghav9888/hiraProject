@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container">
            <div class="row">
                <h1 style="text-transform: capitalize;" class="home-title mb-5">Welcome,<span
                        style="color: #ba9b8b;">Reema</span></h1>
                @include('layouts.partitioner_nav')
                <h3 class="no-request-text">No request found.</h3>
            </div>
        </div>
    </section>
@endsection
