@extends('layouts.app')

@section('content')
    <section class="practitioner-profile vh-100">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>
            <div class="row justify-content-start ms-4 ps-1">
                <div class="col-md-12">
                    <p class="text-start fw-bold">
                        Please join our Community <a href="#">here</a>:
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection
