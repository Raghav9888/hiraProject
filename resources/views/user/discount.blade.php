@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container my-5">
            @include('layouts.partitioner_sidebar')
            <div class="row my-5">
                @include('layouts.partitioner_nav')
                <div class="discount-dv mt-4">
                    <a href="{{route('addDiscount')}}" style="width: 200px; text-decoration: none;" class="export-btn ">Add Discount</a>
                    <h3 class="no-request-text mt-4">No request found.</h3>

                </div>
            </div>
        </div>
    </section>
@endsection
