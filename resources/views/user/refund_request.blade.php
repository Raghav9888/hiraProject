@extends('layouts.app')
@section('content')

    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container">
            <div class="row">
                <h1 style="text-transform: capitalize;" class="home-title mb-5">Welcome,<span
                        style="color: #ba9b8b;">Reema</span></h1>
                <div class="col-sm-12 col-lg-5"></div>
                <ul class="practitioner-profile-btns">
                    <li class="active">
                        <a href="./my-profile.html">
                            My Profile
                        </a>
                    </li>
                    <li class="offering">
                        <a href="">
                            Offering
                        </a>
                        <div class="dropdown">
                            <a href="./discount.html">
                                Discount
                            </a>
                        </div>
                    </li>
                    <li>
                        <a href="./appoinement.html">
                            Appointment
                        </a>
                    </li>
                    <li>
                        <a href="./calendar.html">
                            Calendar
                        </a>
                    </li>
                    <li class="offering">
                        <a href="">
                            Accounting
                        </a>
                        <div class="dropdown">
                            <a href="./earning.html">
                                Earnings
                            </a>
                            <a href="./refund-request.html">
                                Refund request
                            </a>
                        </div>
                    </li>
                </ul>
                <h3 class="no-request-text">No request found.</h3>
            </div>
        </div>
    </section>

@endsection
