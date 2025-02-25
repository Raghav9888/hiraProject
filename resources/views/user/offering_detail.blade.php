@extends('layouts.app')

@section('content')

<section class="test-my-offer">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-lg-6">
                <div class="cart-test-left-dv">
                <img src="../../../public/assets/images/HiraLogo_424E3E-600x600.webp" alt="">
            </div>
            </div>
            <div class="col-sm-12 col-lg-6">
                <div class="cart-test-right-dv">
                    <h4>Test my offer</h4>
                    <h6>Free</h6>
                    <div class="custom-select w-50">
                        <select class="form-select">
                            <option>CAD</option>
                            <option>USA</option>
                        </select>
                    </div>
                <p class="smal-text">Converted prices are based on the current exchange rate, are an estimate, and may be subject to fluctuations. Fees from your payment provider may apply. All charges are in CAD.</p>
               <h6 class="offer-text">Test my offer</h6>
            </div>
            <div class="card calendar-card mt-5 mb-5">
                <div class="card-body">
                    <div id="booking_calendar"></div>
                    <div class="mt-4 text-center">
                        <h4>Available Time Slots</h4>
                        <div id="showTimeSlot">
                            no time slots available
                        </div>
                    </div>
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
                        <p>Test my offer</p>
                    </div>
                    <div class="tab-pane fade" id="service-ratings">
                        <p>No ratings have been submitted for this product yet.</p>
                    </div>
                </div>
            </div>
            <h3 class="related-text">Related Offerings & Products</h3>
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

</section>

@endsection
