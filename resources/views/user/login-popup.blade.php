
@php
    $images = isset($offering->user->userDetail->images) ? json_decode($offering->user->userDetail->images, true) : null;
    $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
    $imageUrl = $image
        ? asset(env('media_path') . '/practitioners/' . @$offering->user->userDetail->id . '/profile/' . $image)
        : asset(env('local_path') . '/images/no_image.png');

@endphp
<div class="container my-3">
    <div
        class="alert alert-green alert-dismissible fade show d-flex justify-content-between align-items-center f-5"
        role="alert">
        <h2 class="h5 mb-0">Your Booking</h2>
        <span type="button" class="btn-white" aria-label="Close" onclick="closePopup()">
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
                <span class="practition-des">{{@$offering->user->userDetail->company ?? "Alternative Health Practitioner"}}</span>
                <span class="booking-date-container">
                    {{date('M d, Y', strtotime($bookingDate))}} | {{date("H:i", strtotime($bookingTime))}}
                </span>
           </div>
        </div>
    </div>
    
    <form method="POST" action="{{route('preCheckout')}}">
        @csrf                       
        <div class="form-container">
            <h4 class="form-title">Enter Email Address && Full Name</h4>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Full Name</label>
                        <input type="text" class="form-control" name="name" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Full Name">
                    </div>                      
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label mb-2">Email Address</label>
                        <input type="email" class="form-control" name="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter a valid email address">
                    </div>
                    <div class="or-container text-center mb-3">OR</div>
                    <div class="d-flex justify-content-center mb-3">
                        <button class="creat-account">Create An Account</button>
                    </div>
        </div>
        <div class="bottom-container">
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox1" required value="privacy">
                <label class="form-check-label" for="inlineCheckbox1">I agree to to The Hira Collective’s Terms of Service and Privacy Policy.</label>
            </div>
            <div class="form-check ">
                <input class="form-check-input" type="checkbox" id="inlineCheckbox2" required  value="yes">
                <label class="form-check-label" for="inlineCheckbox2">Yes, I want to receive emails from The Hira Collective!</label>
            </div>
            <button class="confirm-booking w-100" type="submit">Confirm Booking</button>
            <div class="bottom-line">
                Use of this website, content, and products are for informational purposes only. TheHiraCollective does not provide medical advice, diagnosis, or treatment.
            </div>
        </div>
    </form>
</div>
