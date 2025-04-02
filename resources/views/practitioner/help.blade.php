@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container-fluid vh-100">
            <div class="row ms-4">
                <!-- Sidebar (Collapsible for Mobile) -->
                <div class="col-lg-2 col-md-3">
                    @include('layouts.partitioner_sidebar')
                </div>

                <!-- Main Content -->
                <div class="col-lg-10 col-md-9 col-12">
                    @include('layouts.partitioner_nav')

                    <div class="row mt-5">
                        <div class="col-12 col-md-8">
                            <div class="appointment-wrrpr ps-3 ps-md-0">
                                <p class="mt-2  text-start">
                                <span class="fw-bold">
                                    For Tech Help: Please reach out to our technical support specialist:
                                </span>
                                    <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>
                                </p>
                                <p class="mt-2  text-start">
                                <span class="fw-bold">
                                    For Business help: Please reach out here:
                                </span>
                                    <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
