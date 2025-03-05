@extends('layouts.app')
@section('content')
    <section class="practitioner-profile vh-100">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>
            <div class="appointment-wrrpr justify-content-start align-items-start mt-5">
                <p class="text-center mt-2">
                        <span
                            class="fw-bold">For Tech Help: Please reach out to our technical support specialist:</span>
                    <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>
                </p>
                <p class="text-center mt-2">
                        <span class="fw-bold">
                        For Business help: Please reach out here:
                        </span>
                    <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>
                </p>
            </div>
        </div>
    </section>
@endsection
