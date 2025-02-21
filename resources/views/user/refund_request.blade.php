@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row py-5">
                @include('layouts.partitioner_nav')
                <h3 class="no-request-text">No request found.</h3>
            </div>
        </div>
    </section>
@endsection
