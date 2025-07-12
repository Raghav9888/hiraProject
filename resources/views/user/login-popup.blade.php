
@php
    $images = isset($offering->user->userDetail->images) ? json_decode($offering->user->userDetail->images, true) : null;
    $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
    $imageUrl = $image
        ? asset(env('media_path') . '/practitioners/' . @$offering->user->userDetail->id . '/profile/' . $image)
        : asset(env('local_path') . '/images/no_image.png');

@endphp
<div class="container my-3">
    <div
        class="alert alert-green fade show d-flex justify-content-between align-items-center f-5"
        role="alert">
        <h2 class="h5 mb-0">Create An Account</h2>
        <span type="button" class="btn-white close-modal" aria-label="Close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </span>
    </div>
    <form id="loginForm" method="post">
        @csrf
        <div class="form-container">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">First Name</label>
                        <input type="text" class="form-control" required name="first_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter First Name">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Last Name</label>
                        <input type="text" class="form-control" required name="last_name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Last Name">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" required class="form-label mb-2">Email Address</label>
                        <input type="email" class="form-control" name="billing_email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter a valid email address">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Phone Number</label>
                        <input type="text" class="form-control" required name="billing_phone" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Phone Number">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <div class="flex items-center space-x-2 age-container">
                            <label class="text-gray-700 font-medium mb-2">Age</label>
                            <div class="border border-gray-300 flex items-center rounded-lg age-container-inner">
                                <a href="javascript:void(0);" onclick="decrease()" class="bg-gray-100 justify-center rounded-full text-gray-600">−</a>
                                <input id="ageInput" type="text" value="26" name="age" class="text-center border-none outline-none bg-transparent" readonly>
                                <a href="javascript:void(0);" onclick="increase()" class="bg-gray-100 justify-center rounded-full text-gray-600">+</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Street Address</label>
                        <input type="text" class="form-control" required name="billing_address" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter address line 1">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" required name="billing_address2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter address line 2">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">City</label>
                        <input type="text" class="form-control" required name="billing_city" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter city">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">State</label>
                        <input type="text" class="form-control" required name="billing_state" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter state">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Postcode</label>
                        <input type="text" class="form-control" required name="billing_postcode" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter postcode">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Country</label>
                        <select class="form-select" required name="billing_country" id="country">
                            <option value="India">India</option>
                            <option value="Canada">Canada</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-12 bg-light p-3 rounded mb-4">
                    <p class="seeking_for">Seeking For <span>(Optional)</span></p>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" name="nutritional_support">
                                    <label class="form-check-label" for="inlineCheckbox1">Nutritional Support</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" name="women_wellness" >
                                    <label class="form-check-label" for="inlineCheckbox2">Women’s Wellness</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" name="womb_healing" >
                                    <label class="form-check-label" for="inlineCheckbox3">Womb Healing</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" name="mindset_coaching" >
                                    <label class="form-check-label" for="inlineCheckbox4">Mindset  Coaching</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox5" name="transformation_coachin" >
                                    <label class="form-check-label" for="inlineCheckbox5">Transformation Coaching</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-check ">
                                    <input class="form-check-input" type="checkbox" name="health_practitioner" id="inlineCheckbox6" >
                                    <label class="form-check-label" for="inlineCheckbox6">Health Practitioner</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="bottom-container">
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox7" required value="privacy">
                <label class="form-check-label fw-bold" for="inlineCheckbox7">I agree to to The Hira Collective’s Terms of Service and Privacy Policy.</label>
            </div>
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox8" name="subscribe"  value="true">
                <label class="form-check-label fw-bold" for="inlineCheckbox8">Yes, I want to receive emails from The Hira Collective!</label>
            </div>
            <div class="bottom-line my-2" >
                By checking this box, you consent to receive emails from The Hira Collective, including care-packages, resources, updates, promotions, practitioner spotlights, and community offerings. You can unsubscribe at any time by clicking the link in our emails.<br>The Hira Collective | info@thehiracollective.com
            </div>
            <button class="confirm-booking w-100" type="submit">Create Account And Proceed To Checkout</button>
        </div>
    </form>
</div>
<script>
    function increase() {
        let input = document.getElementById("ageInput");
        input.value = parseInt(input.value) + 1;
    }
    function decrease() {
        let input = document.getElementById("ageInput");
        if (parseInt(input.value) > 0) {
            input.value = parseInt(input.value) - 1;
        }
    }
    $("#loginForm").on("submit", function (e) {
        e.preventDefault(); // Prevent default form submission

        let formData = $(this).serialize();
        $.ajax({
            type:"POST",
            url: "{{route('preCheckout.register')}}",
            data:formData,
            success:function(response){
                if(!response.success){
                    alertify.error(response.data);
                }
                $('.booking-container').hide();
                $('.billing-container').hide();
                $('.login-container').hide();
                $('.checkout-container').show();
                $('.checkout-container').html(response.html);
            },
            error:function(error){
                alertify.error("Something went wrong!")
            }
        })
    })

    $('.close-modal').on('click', function(){
        $('.booking-container').show();
        $('.billing-container').hide();
        $('.checkout-container').hide();
        $('.login-container').hide();
    })

    $(".creat-account").on('click', function(){
        $('.booking-container').hide();
        $('.billing-container').hide();
        $('.checkout-container').hide();
        $('.login-container').show();
    })
</script>
