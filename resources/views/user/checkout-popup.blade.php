
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
        <h2 class="h5 mb-0">Review Your Booking</h2>
        <span type="button" class="btn-white close-modal"  aria-label="Close" data-bs-dismiss="modal">
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
                                <p class="mb-0 text-muted small"><span>Booking Date:</span> {{ \Carbon\Carbon::parse($booking['booking_date'])->format('F j, Y') }}</p>
                                <p class="mb-0 text-muted small"><span>Booking Time:</span> {{ \Carbon\Carbon::parse($booking['booking_time'])->format('h:i A') }}</p>
                                <p class="mb-0 text-muted small">Time Zone:</span> Asia/Calcutta</p>
                            </div>
                        </div>
                    </td>
                    <td class="text-end">${{$product->client_price}}</td>
                </tr>
                <tr>
                    <td class=" fw-bold">Subtotal</td>
                    <td class="text-end">${{$product->client_price}}</td>
                </tr>
                <?php
                $taxAmount = 0;
                ?>
                @if($product->tax_amount)
                <?php 
                 $taxPercentage = $product->tax_amount; // Assuming this is stored in the vendor model
                 $taxAmount = $product->client_price * ($taxPercentage / 100);
                 ?>
                <tr>
                    <td class=" fw-bold">Tax</td>
                    <td class="text-end">${{$taxAmount}} ({{$taxPercentage}}%)</td>
                </tr>
                @endif
                <tr>
                    <td class=" fw-bold">Total</td>
                    <td class="text-end">${{$product->client_price + $taxAmount}}</td>
                </tr>
            </tbody>
        </table>
        <input type="hidden" name="total_amount" class="total_amount" value="{{$product->client_price + $taxAmount}}">
        <input type="hidden" name="tax_amount" value="{{$taxAmount}}" class="tax_amount">
        
        <div class="d-flex justify-content-end mb-3">
            <button class="place-order">Place Order</button>
        </div>
    </div>

</div>

<script>
    
    $('.close-modal').on('click', function(){
        $('.booking-container').show();
        $('.billing-container').hide();
        $('.checkout-container').hide();
        $('.login-container').hide();
    })
    $('.place-order').on('click', function(){
        const total_amount = $('.total_amount').val()
        const tax_amount = $('.tax_amount').val()
        console.log(total_amount, tax_amount);
        
        $.ajax({
            type:"POST",
            url: "{{route('storeCheckout')}}",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data:{
                total_amount: total_amount,
                tax_amount: tax_amount
            },
            success:function(response){
                if(!response.success){
                    alert(response.data);
                }
                console.log(response);
                window.location.href = response.data;
            },
            error:function(error){
                alert("Something went wrong!")
            }
        })
    })
</script>
