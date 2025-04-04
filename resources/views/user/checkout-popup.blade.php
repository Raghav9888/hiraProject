@php
    use Carbon\Carbon;
          $mediaPath = config('app.media_path', 'uploads');
          $localPath = config('app.local_path', 'assets');
         $images = isset($offering->user->userDetail->images) ? json_decode($offering->user->userDetail->images, true) : null;
         $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
         $imageUrl = $image
             ? asset($mediaPath. '/practitioners/' . @$offering->user->userDetail->id . '/profile/' . $image)
             : asset($localPath . '/images/no_image.png');



         $productPrice = (float) ($product->offering_event_type == 'event' ? $product->event->client_price : $product->client_price);
         $taxPercentage = (float)($product->offering_event_type == 'event' ? $product->event->tax_amount : $product->tax_amount);
         $taxAmount = $taxPercentage ? ($productPrice * ($taxPercentage / 100)) : 0;
         $totalAmount = $productPrice + $taxAmount;
@endphp

<div class="container my-3">
    <div class="alert alert-green fade show d-flex justify-content-between align-items-center f-5" role="alert">
        <h2 class="h5 mb-0">Review Your Booking</h2>
        <span type="button" class="btn-white close-modal" aria-label="Close" data-bs-dismiss="modal">
            <i class="fa-solid fa-xmark"></i>
        </span>
    </div>

    <div class="order-container">
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
                            <p class="mb-0 text-muted small">
                                <span>Booking Date:</span> {{ Carbon::parse($booking['booking_date'])->format('F j, Y') }}
                            </p>
                            <p class="mb-0 text-muted small">
                                <span>Booking Time:</span> {{ Carbon::parse($booking['booking_time'])->format('h:i A') }}
                            </p>
                            <p class="mb-0 text-muted small">Time Zone: Asia/Calcutta</p>
                        </div>
                    </div>
                </td>
                <td class="text-end">${{ number_format($productPrice, 2) }}</td>
            </tr>

            <tr>
                <td class="fw-bold">Subtotal</td>
                <td class="text-end">${{ number_format($productPrice, 2) }}</td>
            </tr>

            @if($taxAmount > 0)
                <tr>
                    <td class="fw-bold">Tax ({{ $taxPercentage }}%)</td>
                    <td class="text-end">${{ number_format($taxAmount, 2) }}</td>
                </tr>
            @endif

            <tr>
                <td class="fw-bold">Total</td>
                <td class="text-end">${{ number_format($totalAmount, 2) }}</td>
            </tr>
            </tbody>
        </table>

        <input type="hidden" name="total_amount" class="total_amount" value="{{ $totalAmount }}">
        <input type="hidden" name="tax_amount" value="{{ $taxAmount }}" class="tax_amount">

        <div class="d-flex justify-content-end mb-3">
            <button class="place-order btn btn-green">Place Order</button>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.close-modal', function () {
        $('.booking-container, .billing-container, .checkout-container, .login-container').hide();
    });

    $(document).on('click', '.place-order', function () {
        const total_amount = $('.total_amount').val();
        const tax_amount = $('.tax_amount').val();

        $.ajax({
            type: "POST",
            url: "{{ route('storeCheckout') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {total_amount, tax_amount},
            success: function (response) {
                if (!response.success) {
                    alert(response.data);
                } else {
                    console.log(response);
                    window.location.href = response.data;
                }
            },
            error: function (xhr) {
                alert("Something went wrong: " + xhr.responseJSON?.message || "Unknown error");
            }
        });
    });
</script>
