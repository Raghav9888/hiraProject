@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-5">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv my-5">
                    <h3 class="no-request-text mb-4">Edit Discount</h3>
                    <form method="POST" action="{{route('update_discount', $discount->id)}}">
                        @csrf
                        <div class="mb-4">
                            <label for="booking-duration">Apply To</label>
                            <select id="apply_to" class="form-select apply_to" name="apply_to">
                                <option value="all" {{$discount->apply_to === 'all'? 'selected': ''}}>All Offerings</option>
                                <option value="specific" {{$discount->apply_to === 'specific'? 'selected': ''}}>Specific Offerings</option>
                            </select>
                        </div>
                        <div class="mb-4 select2-div offerings-select-container" style="{{$discount->apply_to === 'specific'? '': 'display: none;'}}">
                            <?php
                            $selectedOfferings = is_string($discount->offerings) ? json_decode($discount->offerings, true) : $discount->offerings;
                            $selectedOfferings = is_array($selectedOfferings) ? $selectedOfferings : (is_numeric($selectedOfferings) ? [(int)$selectedOfferings] : []);
                            ?>
                            <label for="offerings">Select Offering</label>
                            <select id="offerings" multiple class="form-control select2" name="offerings[]">
                                <option></option>
                                @foreach($offerings as $offering)
                                    <option value="{{ $offering->id }}" {{ in_array($offering->id, $selectedOfferings) ? 'selected' : '' }}>
                                        {{ $offering->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="mb-4">
                            <label for="booking-duration">Discount type</label>
                            <select id="discount_type" class="form-select" name="discount_type">
                                <option value="fixed" {{$discount->discount_type === 'fixed'? 'selected': ''}}>Fixed discount</option>
                                <option value="percentage" {{$discount->discount_type === 'percentage'? 'selected': ''}}>Percentage discount</option>
                            </select>
                        </div>
                        <div class="col mb-4">
                            <label for="coupne-amount">Discount Amount</label>
                            <input type="number" class="form-control" value="{{$discount->coupon_amount}}" placeholder="0" name="coupon_amount" id="coupon_amount">
                        </div>
                        <div class="d-flex" style="gap: 20px;">
                            <button class="update-btn m-0">Update Discount</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('custom_scripts')
<script>
    $(".apply_to").on("change", function(){
        const val = $(this).val()
        if(val === "specific"){
            $('.offerings-select-container').show()
        }else{
            $('.offerings-select-container').hide()
        }
    })
    $('.offering-select').select2({
        placeholder: "Select options", // Placeholder text
        allowClear: true // Enables clear button
    });
</script>
@endpush
