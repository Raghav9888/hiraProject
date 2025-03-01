@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv my-5">
                    <h3 class="no-request-text mb-4">Add Discount</h3>
                    <form method="POST" action="{{route('store_discount')}}">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Coupon code</label>
                            <input type="text" class="form-control" id="coupon_code" name="coupon_code" aria-describedby="emailHelp" placeholder="Coupon code">
                        </div>
                        <div class="mb-3">
                            <label for="floatingTextarea">Coupon description</label>
                            <textarea class="form-control" placeholder="Coupon description" name="coupon_description" id="coupon_description"></textarea>
                        </div>
                        <div class="container">
                            <div class="mb-4">
                                <ul class="nav nav-tabs" id="tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="general-tab" data-bs-toggle="tab" href="#general"
                                           role="tab" aria-controls="general" aria-selected="true">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="availability-tab" data-bs-toggle="tab"
                                           href="#availability" role="tab" aria-controls="availability"
                                           aria-selected="false">Usage restriction</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="costs-tab" data-bs-toggle="tab" href="#costs" role="tab"
                                           aria-controls="costs" aria-selected="false">Usage limits</a>
                                    </li>
                                </ul>
                                <div class="tab-content mt-3" id="myTabContent">
                                    <!-- General Tab Content -->
                                    <div class="tab-pane fade show active" id="general" role="tabpanel"
                                         aria-labelledby="general-tab">
                                        <div class="mb-4">
                                            <label for="booking-duration">Discount type</label>
                                            <select id="discount_type" class="form-select" name="discount_type">
                                                <option>Fixed discount</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="apply_all_services" name="apply_all_services">
                                                <label class="form-check-label" for="can-be-cancelled">Apply to all my services</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the booking can be
                                                Check this box if the discount applies to all your services.</small>
                                        </div>
                                        <div class="col mb-4">
                                            <label for="coupne-amount">Coupon amount</label>
                                            <input type="number" class="form-control" placeholder="0" name="coupon_amount" id="coupon_amount">
                                        </div>
                                    </div>

                                    <!-- Availability Tab Content -->
                                    <div class="tab-pane fade" id="availability" role="tabpanel"
                                         aria-labelledby="availability-tab">
                                        <div class="mb-4">
                                            <label for="booking-duration">Discount type</label>
                                            <select id="discount_type" class="form-select" name="discount_type">
                                                <option>Fixed discount</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label for="coupne-amount">Minimum spend</label>
                                            <input type="text" class="form-control" placeholder="No minimum" name="minimum_spend" id="minimum_spend">
                                        </div>
                                        <div class="mb-4">
                                            <label for="coupne-amount">Maximum spend</label>
                                            <input type="text" class="form-control" placeholder="No maximum" name="maximum_spend" id="maximum_spend">
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="individual_use_only" name="individual_use_only">
                                                <label class="form-check-label" for="individual_use_only">Individual use only</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the coupon cannot be used in conjunction with other coupons.</small>
                                        </div>
                                        <div class="mb-4">
                                            <div class="form-check offering-check">
                                                <input type="checkbox" class="form-check-input" id="exclude_sale_items" name="exclude_sale_items">
                                                <label class="form-check-label" for="exclude_sale_items">Exclude sale items</label>
                                            </div>
                                            <small class="form-text text-muted">Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are no sale items in the cart</small>
                                        </div>
                                        <div class="mb-4">
                                            <label for="coupne-amount">Offerings</label>
                                            <select name="offerings" class="form-select">
                                                @foreach($offerings as $offering)
                                                    <option value="{{$offering->id}}">{{$offering->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="coupne-amount">Exclude services</label>
                                            <input type="text" class="form-control" placeholder="" id="exclude_services" name="exclude_services">
                                        </div>
                                        <div class="mb-4">
                                            <label for="coupne-amount">Email Restrictions</label>
                                            <input type="text" class="form-control" placeholder="no restrictions" id="email_restrictions" name="email_restrictions">
                                            <p>List of allowed emails to check against the customer's billing email when an order is placed. Separate email addresses with commas.</p>
                                        </div>
                                    </div>

                                    <!-- Costs Tab Content -->
                                    <div class="tab-pane fade" id="costs" role="tabpanel" aria-labelledby="costs-tab">
                                        <div class="col mb-3">
                                            <label for="booking">Usage limit per coupon</label>
                                            <input type="number" class="form-control" placeholder="Unlimited usage" name="usage_limit_per_coupon" id="usage_limit_per_coupon">
                                        </div>
                                        <div class="col mb-3">
                                            <label for="booking">Usage limit to x items</label>
                                            <input type="number" class="form-control" placeholder="Unlimited usage" name="usage_limit_to_x_items" id="usage_limit_to_x_items">
                                        </div>
                                        <div class="col mb-3">
                                            <label for="booking">Usage limit per user</label>
                                            <input type="number" class="form-control" placeholder="Unlimited usage" name="usage_limit_per_user" id="usage_limit_per_user">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="d-flex" style="gap: 20px;">
                            <button class="update-btn m-0">Add Discount</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
