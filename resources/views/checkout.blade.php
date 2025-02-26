@extends('layouts.app')

@section('content')

<section class="checkout-section">
        <main class="container">
            <h1 class="mb-4 home-title">Checkout</h1>
            <div class="coupon p-3 mb-4">
                <a href="#">Have a coupon? Click here to enter your code</a>
            </div>
            <form id="payment-form" method="post" action="{{ route('create.payment') }}">
                @csrf
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h4 class="checkout-title">Billing details</h4>
                        <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="first-name"  class="form-label">First name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="first_name" class="form-control" id="first-name" placeholder="Mohit">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="last-name" class="form-label">Last name <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="last_name" class="form-control" id="last-name" placeholder="Kumar">
                        </div>
                    </div>
                        <div class="mb-3">
                            <label for="company-name" class="form-label">Company name (optional)</label>
                            <input type="text" name="company" class="form-control" id="company-name">
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country / Region <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" name="country" id="country">
                                <option>India</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="street-address" class="form-label">Street address <span
                                    class="text-danger">*</span></label>
                                    <input type="text" class="form-control mb-3" name="address1" id="street-address" placeholder="Ludhiana">
                                     <input type="text" class="form-control" name="address2" id="street-address" placeholder="Shaheed bhagat singh nagar">
                        </div>
                        <div class="mb-3">
                            <label for="town-city" class="form-label">Town / City <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="city" id="town-city" placeholder="Ludhiana">
                        </div>
                        <div class="mb-3">
                            <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="state" id="state" placeholder="Punjab">
                        </div>
                        <div class="mb-3">
                            <label for="pin-code" class="form-label">PIN Code <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="zip" id="pin-code" placeholder="11234">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="984674323">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address <span
                                    class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="mohit@gmail.com">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h2 class="checkout-title">Additional information</h2>
                        <div class="mb-3">
                            <label for="appointment-notes" class="form-label">Appointment notes (optional)</label>
                            <textarea class="form-control" name="notes" id="appointment-notes" rows="8" placeholder="Write something here"></textarea>
                        </div>
                    </div>
                </div>
                <div class="mb-4">
                    <h2 class="checkout-title">Your order</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th scope="col">Product</th>
                                <th scope="col" class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                       
                                        <div>
                                            <p class="mb-0">{{$product->name}}</p>
                                            <p class="mb-0 text-muted small"><span>Booking Date:</span> {{ \Carbon\Carbon::parse($booking['booking_date'])->format('F j, Y') }}</p>
                                            <p class="mb-0 text-muted small"><span>Booking Time:</span> {{ \Carbon\Carbon::parse($booking['booking_time'])->format('h:i A') }}</p>
                                            <p class="mb-0 text-muted small"<span>Time Zone:</span> Asia/Calcutta</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-end">${{$product->client_price}}</td>
                            </tr>
                            <tr>
                                <td class=" fw-bold">Subtotal</td>
                                <td class="text-end">${{$product->client_price}}</td>
                            </tr>
                            <tr>
                                <td class=" fw-bold">Total</td>
                                <td class="text-end">${{$product->client_price}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="mb-4">
                    <p class="text-p">Your personal data will be used to process your order, support your
                        experience throughout this website, and for other purposes described in our privacy policy.</p>
                    <div class="form-check checkbox-dv">
                        <input class="form-check-input" name="terms" type="checkbox" id="terms">
                        <label class="form-check-label text-muted small" for="terms">
                            I have read and agree to the website terms and conditions *
                        </label>
                    </div>
                </div>
                <div id="card-element"></div>
                <div class="d-flex justify-content-end">
                <button type="submit" class="export-btn"  id="pay-btn">Place order</button>
            </div>
            </form>
        </main>
    </section>
<!-- <div class="container">
    <div class="row">
        <div class="col-md-6">
            <form id="payment-form" method="post" action="{{ route('create.payment') }}">
                @csrf
                    <div id="card-element"></div>
                    <button type="submit" id="pay-btn">Pay ₹100</button>
            </form>
        </div>
    </div>
</div> -->
<script src="https://js.stripe.com/v3/"></script>

<script>
     var stripe = Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
    var elements = stripe.elements();
    var card = elements.create("card");
    card.mount("#card-element");

    $("#payment-form").submit(function (e) {
        e.preventDefault();

        stripe.createPaymentMethod({
            type: "card",
            card: card
        }).then(function (result) {
            if (result.error) {
                alert(result.error.message);
            } else {
                $.ajax({
                    url: "{{ route('create.payment') }}",
                    method: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        payment_method : result.paymentMethod.id
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            alert("Payment Successful!");
                        } else {
                            alert("Payment Failed: " + response.message);
                        }
                    },
                    error: function (xhr) {
                        console.error(xhr.responseText);
                        alert("An error occurred. Please try again.");
                    }
                });
            }
        });
    }); 
</script>

@endsection