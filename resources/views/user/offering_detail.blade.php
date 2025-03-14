@extends('layouts.app')

@section('content')
<section class="test-my-offer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="cart-test-left-dv">
                    @php
                        $imageUrl = isset($offeringDetail->featured_image) && $offeringDetail->featured_image?asset(env('media_path') . '/practitioners/' . $user->id . '/offering/' . $offeringDetail->featured_image) :asset(env('local_path').'/images/no_image.png');
                    @endphp
                    <img src="{{ $imageUrl }}" alt="{{ $offeringDetail->featured_image }}">
                </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="cart-test-right-dv">
                    <h4>{{$offeringDetail->name}}</h4>
                    <h6>{{$offeringDetail->cost}}</h6>
                    <div class="custom-select w-50">
                        <select class="form-select">
                            <option>CAD</option>
                            <option>USA</option>
                        </select>
                    </div>
                <p class="smal-text">{{$offeringDetail->short_description}}</p>
               <h6 class="offer-text">{{$offeringDetail->name}}</h6>
            </div>
            <div class="card calendar-card mt-5 mb-5">
                <div class="card-body">
                    <!-- <div id="calendar"></div> -->
                   <form method="post" action="{{route('storeBooking')}}">
                    @csrf
                    <div id="booking_calendar"></div>
                    <input type="hidden" name="offering_id" class="form-control product_id" value="{{$offeringDetail->id}}">
                    <input type="hidden" name="booking_date" class="form-control booking_date">
                    <!-- <input type="time" name="booking_time" class="form-control"> -->
                    <div class="mt-4 text-center">
                        <h4>Available Time Slots</h4>
                        <div id="showTimeSlot">
                            no time slots available
                        </div>
                    </div>
                    <input type="submit" value="Book" class="btn btn-primary mt-2">
                    <!-- <a href="{{route('checkout')}}" class="btn btn-primary booking" >Book </a> -->
                    </form>
                </div>
            </div>
            </div>
            <div class="container mb-4">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#description">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#service-ratings">Service Ratings</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="description">
                        <h2 class="h4">Description</h2>
                        <p>{{$offeringDetail->long_description}}</p>
                    </div>
                    <div class="tab-pane fade" id="service-ratings">
                        <p>No ratings have been submitted for this product yet.</p>
                    </div>
                </div>
            </div>
            <h3 class="related-text">Related Offerings </h3>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="cart-item">
                    <img src="../../../public/assets/images/person.png" alt="">
                    <h3>Shawn Test</h3>
                    <p>Free</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="cart-item">
                    <img src="../../../public/assets/images/person.png" alt="">
                    <h3>Shawn Test</h3>
                    <p>Free</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="cart-item">
                    <img src="../../../public/assets/images/person.png" alt="">
                    <h3>Shawn Test</h3>
                    <p>Free</p>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="cart-item">
                    <img src="../../../public/assets/images/person.png" alt="">
                    <h3>Shawn Test</h3>
                    <p>Free</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
