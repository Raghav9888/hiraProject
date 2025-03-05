@extends('layouts.app')
@section('content')
    <section class="practitioner-profile vh-100">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="appointment-wrrpr justify-content-start align-items-start">
                    <p class="text-start mt-2">
                        For Tech Help: Please reach out to our technical support specialist: <a href="mailto:technicalsupport@thehiracollective.com">technicalsupport@thehiracollective.com</a>
                    </p>
                    <p class="text-start mt-2">
                        For Business help: Please reach out here: <a href="mailto:community@thehiracollective.com">community@thehiracollective.com</a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
