@extends('layouts.app')
@section('content')
    <section class="payment">
        <div class="container">
            <div class="row">
    <script src="https://js.stripe.com/v3/"></script>
    <style>
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            text-align: center;
        }
        button {
            background-color: #6772E5;
            color: white;
            border: none;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            border-radius: 5px;
        }
    </style>

    <h2>Complete Your Payment</h2>
    <p><strong>Booking ID:</strong> {{ $order->id }}</p>
    <p><strong>Amount:</strong> ${{ number_format($order->total_amount, 2) }}</p>

    <form action="{{ route('stripe.payment') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">
        
        <div id="card-element"></div>
        
        <button type="submit" id="submit-button">Pay Now</button>
    </form>

    <div id="payment-message"></div>


<script>
    var stripe =Stripe("{{ env('STRIPE_PUBLIC_KEY') }}");
    var elements = stripe.elements();
    var card = elements.create("card");
    card.mount("#card-element");

    var form = document.getElementById("payment-form");
    form.addEventListener("submit", function(event) {
        event.preventDefault();
        stripe.createToken(card).then(function(result) {
            if (result.error) {
                document.getElementById("payment-message").innerText = result.error.message;
            } else {
                var hiddenInput = document.createElement("input");
                hiddenInput.setAttribute("type", "hidden");
                hiddenInput.setAttribute("name", "stripeToken");
                hiddenInput.setAttribute("value", result.token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        });
    });
</script>

</body>
</html>

            </div>
        </div>
    </section>
@endsection