@php
    use Carbon\Carbon;
    $mediaPath = config('app.media_path', 'uploads');
    $localPath = config('app.local_path', 'assets');
    $images = isset($offering->user->userDetail->images) ? json_decode($offering->user->userDetail->images, true) : null;
    $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
    $imageUrl = $image
        ? asset($mediaPath. '/practitioners/' . @$offering->user->userDetail->id . '/profile/' . $image)
        : asset($localPath . '/images/no_image.png');

    $taxPercentage = (float)($product->offering_event_type == 'event' ? $product->event->tax_amount : $product->tax_amount);
    $taxAmount = $taxPercentage ? ($price * ($taxPercentage / 100)) : 0;

    // Calculate discount amount
    $discountAmount = 0;
    if (!empty($discount)) {
        if ($discount['discount_type'] === 'fixed') {
            $discountAmount = (float)$discount['amount'];
            $discountDisplay = $currencySymbol . ' ' . number_format($discount['amount'], 2);
        } else {
            $discountAmount = ($price * ((float)$discount['amount'] / 100));
            $discountDisplay = $discount['amount'] . '%';
        }
    }

    $totalAmount = ($price + $taxAmount - $discountAmount);
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
                            <p id="user-timezone" class="mb-0 text-muted small">Time Zone: </p>
                        </div>
                    </div>
                </td>
                <td class="text-end">{{$currencySymbol .' '. number_format($price, 2)}}</td>
            </tr>

            <tr>
                <td class="fw-bold">Subtotal</td>
                <td class="text-end">{{$currencySymbol . ' '. number_format($price, 2) }}</td>
            </tr>

            @if($taxAmount > 0)
                <tr>
                    <td class="fw-bold">Tax ({{ $taxPercentage }}%)</td>
                    <td class="text-end">{{$currencySymbol .' '. number_format($taxAmount, 2) }}</td>
                </tr>
            @endif

            @if(!empty($discount))
                <tr>
                    <td class="fw-bold">Discount ({{ $discountDisplay }})</td>
                    <td class="text-end">- {{$currencySymbol .' '. number_format($discountAmount, 2) }}</td>
                </tr>
            @endif

            <tr>
                <td class="fw-bold">Total</td>
                <td class="text-end">{{ $currencySymbol .' '. number_format($totalAmount, 2) }}</td>
            </tr>
            </tbody>
        </table>

        <input type="hidden" name="total_amount" class="total_amount" value="{{ $totalAmount }}">
        <input type="hidden" name="tax_amount" value="{{ $taxAmount }}" class="tax_amount">
        @if(!empty($discount))
            <input type="hidden" name="discount_amount" value="{{ $discountAmount }}" class="discount_amount">
        @endif

        <div class="d-flex justify-content-end mb-3">
            <button class="place-order btn btn-green">Place Order</button>
        </div>
    </div>
</div>

<script>
    $(document).on('click', '.close-modal', function () {
        $('.booking-container, .billing-container, .checkout-container, .login-container').hide();
    });

    $(document).on('click', '.place-order', function (e) {
        e.preventDefault();
        const total_amount = $('.total_amount').val();
        const tax_amount = $('.tax_amount').val();

        $.ajax({
            type: "POST",
            url: "{{ route('storeCheckout') }}",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {total_amount, tax_amount},
            success: function (response) {
                if (!response.success) {
                    alertify.error(response.data);
                } else {
                    console.log(response);
                    window.location.href = response.data;
                }
            },
            error: function (xhr) {
                alertify.error("Something went wrong: " + xhr.responseJSON?.message || "Unknown error");
            }
        });
    });


    $(document).ready(function () {
        const timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        document.getElementById("user-timezone").textContent = "Time Zone: " + timezone;
        console.log(timezone)
    })
    // Place this once in your main JS file or inline script
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

</script>
