@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container my-5">
            @include('layouts.partitioner_sidebar')
            <div class="row my-5">
                @include('layouts.partitioner_nav')
                <div class="discount-dv mt-4">
                    <a href="{{route('add_discount')}}" style="width: 200px; text-decoration: none;"
                       class="export-btn ">Add Discount</a>

                    <div class="earning-wrrpr mt-5">
                        <div class="container">
                            @if($discounts->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="thead-light">
                                        <tr>
                                            <th class="tn"><i class="wcv-icon wcv-icon-image"></i></th>
                                            <th scope="col">Coupon</th>
                                            <th scope="col">Discount Type</th>
                                            <th scope="col">Coupon Amount</th>
                                            <th scope="col">Coupon Description</th>
                                            <th scope="col">Offerings </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($discounts as $discount)

                                            <tr>
                                                <td class="tn"></td>
                                                <td class="details">
                                                    <h4>{{ $discount->coupon_code }}</h4>
                                                    <div>
                                                        <a href="#">Edit</a>
                                                        /
                                                        <a href="#"> Delete</a>
                                                    </div>
                                                </td>
                                                <td class="details">
                                                    <h4>{{ $discount->discount_type }}</h4>
                                                </td>
                                                <td class="details">
                                                    <h4>{{ $discount->coupon_amount }}</h4>
                                                </td>
                                                <td class="details">
                                                    <h4>{{ $discount->coupon_description }}</h4>
                                                </td>
                                                <td class="details">

                                                    @foreach($offerings as $offering)
                                                        @if(in_array($offering->id, explode(',', $discount->offerings)))
                                                            <h4>{{ $offering->name }}</h4>
                                                        @endif
                                                    @endforeach
                                                </td>

                                            </tr>
                                            <tr>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <h3 class="no-request-text my-5 py-5">No request found.</h3>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
