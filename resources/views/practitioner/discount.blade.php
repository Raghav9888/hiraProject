@extends('layouts.app')
@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row ms-md-5">
                <div class="col-12">
                    @include('layouts.partitioner_nav')
                </div>

                <div class="col-12">
                    <div class="offering-wrrpr">
                        <div class="d-flex mb-5" style="gap: 20px;">
                            <div class="search-container">
                                <input type="text" class="search-input"
                                       placeholder="">
                                <button class="search-button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                            <button class="category-load-more">Search</button>
                        </div>

                        <div class="earning-wrrpr my-5 py-5">
                            <div class="container">
                                <a href="{{route('add_discount')}}" style="text-decoration: none;"
                                   class="d-inline-block export-btn mb-3">Add Discount</a>
                                @if($discounts->isNotEmpty())
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="thead-light">
                                            <tr>
                                                <th class="tn"><i class="wcv-icon wcv-icon-image"></i></th>
                                                <th scope="col">Apply To</th>
                                                <th scope="col">Discount Type</th>
                                                <th scope="col">Coupon Amount</th>
                                                <th scope="col">Offerings</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($discounts as $discount)

                                                <tr>
                                                    <td class="tn"></td>
                                                    <td class="details">
                                                        <h4>{{ $discount->apply_to === 'all'? 'All': 'Specific' }}</h4>
                                                        <div>
                                                            <a href="{{route('edit_discount', $discount->id)}}">Edit</a>
                                                            /
                                                            <form method="post" class="d-inline-block"
                                                                  action="{{route('delete_discount', $discount->id)}}">@csrf
                                                                <button type="submit"
                                                                        style="font-weight:700;cursor: pointer; border: none; background: none;color: #000;">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td class="details">
                                                        <h4>{{ $discount->discount_type }}</h4>
                                                    </td>
                                                    <td class="details">
                                                        <h4>{{ $discount->coupon_amount }}</h4>
                                                    </td>
                                                    <td class="details">
                                                            <?php
                                                            $selectedOfferings = is_string($discount->offerings) ? json_decode($discount->offerings, true) : $discount->offerings;
                                                            $selectedOfferings = is_array($selectedOfferings) ? $selectedOfferings : (is_numeric($selectedOfferings) ? [(int)$selectedOfferings] : []);
                                                            ?>
                                                        @if(!empty($selectedOfferings))
                                                            @foreach($offerings as $offering)
                                                                @if(in_array($offering->id, $selectedOfferings))
                                                                    <h4>{{ $offering->name }}</h4>
                                                                @endif
                                                            @endforeach
                                                        @endif
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
                        {{--                <button type="submit" class="category-load-more">Submit</button>--}}
                    </div>

                    <div class="offering-wrrpr">

                        <div class="earning-wrrpr ">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
