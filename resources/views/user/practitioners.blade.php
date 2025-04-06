@extends('layouts.app')

@section('content')
    <section class="featured-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="home-title">Practitioners</h1>
                </div>
            </div>

            <div class="row" id="practitionersList">
                @include('user.practitioner_list_xml_request')
            </div>
        </div>
    </section>
@endsection
