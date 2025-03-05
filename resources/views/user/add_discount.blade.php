@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="add-offering-dv my-5">
                    <h3 class="no-request-text mb-4">Add Discount</h3>
                    <form method="POST" action="{{route('store_discount')}}">
                        @csrf
                        <div class="mb-4">
                            <label for="booking-duration">Apply To</label>
                            <select id="apply_to" class="form-select apply_to" name="apply_to">
                                <option value="all">All Offerings</option>
                                <option value="specific">Specific Offerings</option>
                            </select>
                        </div>
                        <div class="mb-4 select2-div offerings-select-container" style="display: none;">
                            <label for="offerings">Select Offering</label>
                            <select id="offerings" multiple class="form-control select2" name="offerings[]">
                                <option></option>
                                @forEach($offerings as $offering)
                                <option value="{{$offering->id}}">{{$offering->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="booking-duration">Discount type</label>
                            <select id="discount_type" class="form-select" name="discount_type">
                                <option value="fixed">Fixed discount</option>
                                <option value="percentage">Percentage discount</option>
                            </select>
                        </div>
                        <div class="col mb-4">
                            <label for="coupne-amount">Discount Amount</label>
                            <input type="number" class="form-control" placeholder="0" name="coupon_amount" id="coupon_amount">
                        </div>
                        <div class="d-flex" style="gap: 20px;">
                            <button class="update-btn m-0">Add Discount</button>
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
