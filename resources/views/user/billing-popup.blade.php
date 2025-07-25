@php
        $mediaPath = config('app.media_path', 'uploads');
        $localPath = config('app.local_path', 'assets');
        $images = isset($offering->user->userDetail->images) ? json_decode($offering->user->userDetail->images, true) : null;
        $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
        $imageUrl = $image
            ? asset($mediaPath . '/practitioners/' . @$offering->user->userDetail->id . '/profile/' . $image)
            : asset($localPath . '/images/no_image.png');

@endphp

<div class="container my-3">
    <div
        class="alert alert-green fade show d-flex justify-content-between align-items-center f-5"
        role="alert">
        <h2 class="h5 mb-0">Your Booking</h2>
        <span type="button" class="btn-white close-modal" aria-label="Close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </span>
    </div>

    <div class="bg-light p-3 rounded mb-4">
        <div class="d-flex gap-3 align-items-center">
            <div class="practition-img-container">
                <img src="{{$imageUrl}}" alt="" class="img-fluid">
            </div>
            <div class="practition-detail-container">
                <h4 class="practition-name">{{@$offering->user->name}}</h4>
                <span
                    class="practition-des">{{@$offering->user->userDetail->company ?? "Alternative Health Practitioner"}}</span>
                <span class="booking-date-container">
                    {{date('M d, Y', strtotime($bookingDate))}} | {{date("H:i", strtotime($bookingTime))}} | {{$bookingUserTimezone}}
                </span>
            </div>
        </div>
    </div>

    <form id="billingForm" method="post">
        @csrf
        <div class="form-container">
            <h4 class="form-title">Enter Billing Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">First Name</label>
                        <input type="text" class="form-control" required name="first_name" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter First Name"
                        value="{{$user->first_name ?? ''}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Last Name</label>
                        <input type="text" class="form-control" required name="last_name" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter Last Name"
                               value="{{$user->last_name ?? ''}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1"  class="form-label mb-2">Email Address</label>
                        <input type="email" class="form-control" name="billing_email" required id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter a valid email address"
                               value="{{$user?->email ?? ''}}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Phone Number</label>
                        <input type="text" class="form-control" required name="billing_phone" id="exampleInputEmail1"
                               aria-describedby="emailHelp" placeholder="Enter Phone Number"
                        value="{{$user->userDetail->phone ?? ''}}">
                    </div>
                </div>
                @if(!$user)
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="password" class="form-label mb-2">Password</label>
                            <input type="text" class="form-control" required name="password" id="password"
                                   aria-describedby="emailHelp" placeholder="Enter your password"
                            >
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label mb-2">Confirm Password</label>
                            <input type="text" class="form-control" required name="confirm_password" id="confirm_password"
                                   aria-describedby="emailHelp" placeholder="Confirm your password">
                        </div>
                    </div>
                @endif

{{--                <div class="col-md-12">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="exampleInputEmail1" class="form-label mb-2">Street Address</label>--}}
{{--                        <input type="text" class="form-control" required name="billing_address" id="exampleInputEmail1"--}}
{{--                               aria-describedby="emailHelp" placeholder="Enter address line 1"--}}
{{--                               value="{{$user->userDetail->address_line_1 ?? ''}}">--}}
{{--                    </div>--}}
{{--                    <div class="mb-3">--}}
{{--                        <input type="text" class="form-control" required name="billing_address2" id="exampleInputEmail1"--}}
{{--                               aria-describedby="emailHelp" placeholder="Enter address line 2">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="exampleInputEmail1" class="form-label mb-2">City</label>--}}
{{--                        <input type="text" class="form-control" required name="billing_city" id="exampleInputEmail1"--}}
{{--                               aria-describedby="emailHelp" placeholder="Enter city"--}}
{{--                               value="{{$user->userDetail->city ?? ''}}">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="exampleInputEmail1" class="form-label mb-2">State</label>--}}
{{--                        <input type="text" class="form-control" required name="billing_state" id="exampleInputEmail1"--}}
{{--                               aria-describedby="emailHelp" placeholder="Enter state"--}}
{{--                               value="{{$user->userDetail->state ?? ''}}">--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="col-md-6">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="exampleInputEmail1" class="form-label mb-2">Postcode</label>--}}
{{--                        <input type="text" class="form-control" required name="billing_postcode" id="exampleInputEmail1"--}}
{{--                               aria-describedby="emailHelp" placeholder="Enter postcode"--}}
{{--                               value="{{$user->userDetail->postcode ?? ''}}">--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-md-6">--}}
{{--                    <div class="mb-3">--}}
{{--                        <label for="exampleInputEmail1" class="form-label mb-2">Country</label>--}}
{{--                        <select class="form-select" required name="billing_country" id="country">--}}
{{--                            <option value="">Select Country</option>--}}
{{--                            @foreach($countries as $country)--}}
{{--                                <option value="{{$country->name}}" {{isset($user->userDetail->country) && $user->userDetail->country == $country->name ? 'selected': ''}}>{{$country->name}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
            {{--            <div class="or-container text-center mb-3">OR</div>--}}
            {{--            <div class="d-flex justify-content-center mb-3">--}}
            {{--                <button class="creat-account">Create An Account</button>--}}
            {{--            </div>--}}
        </div>
        <div class="bottom-container">
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="privacy" required value="privacy" style="width: 20px; height: 20px; margin-right: 10px">
                <label class="form-check-label" for="privacy">I agree to to The Hira Collective’s
                   <a href="{{route('terms_conditions')}}">Terms of Service </a> and <a href="{{route('privacy_policy')}}">Privacy Policy.</a></label>
            </div>
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="subscribe" value="yes" style="width: 20px; height: 20px; margin-right: 10px">
                <label class="form-check-label" for="inlineCheckbox2">Yes, I want to receive emails from The Hira
                    Collective!</label>
            </div>
            <div class="form-check align-items-center">
                <input class="form-check-input" type="checkbox" id="websiteUse" name="websiteUse" value="yes" style="width: 20px; height: 20px">
                <label class="form-check-label" for="websiteUse">Use of this website, content, and products are for informational purposes only. TheHiraCollective does
                    not provide medical advice, diagnosis, or treatment.</label>
            </div>
            <div class="col-12 text-center">
                <button class="confirm-booking" type="submit">Confirm Booking</button>
            </div>
        </div>
    </form>
</div>
<script>

    $("#billingForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "{{route('preCheckout')}}",
            data: formData,
            success: function (response) {
                if (!response.success) {
                    alertify.error(response.data);
                }
                $('.booking-container').hide();
                $('.billing-container').hide();
                $('.checkout-container').show();
                $('.checkout-container').html(response.html);
            },
            error: function (error) {
                alertify.error("Something went wrong!")
            }
        })
    })

    $('.close-modal').on('click', function () {
        $('.booking-container').show();
        $('.billing-container').hide();
        $('.checkout-container').hide();
        $('.login-container').hide();
    })

    $(".creat-account").on('click', function () {
        $('.booking-container').hide();
        $('.billing-container').hide();
        $('.checkout-container').hide();
        $('.login-container').show();
    })
</script>
