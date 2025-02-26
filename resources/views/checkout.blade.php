@extends('layouts.app')

@section('content')

<form id="payment-form" method="post" action="{{ route('create.payment') }}">
    @csrf
        <div id="card-element"></div>
        <button type="submit" id="pay-btn">Pay ₹100</button>
    </form>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe("{{ env('STRIPE_PUBLISHABLE_KEY') }}");
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
                        payment_method_id: result.paymentMethod.id
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