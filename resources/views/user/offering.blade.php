@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        <div class="container">
            @include('layouts.partitioner_sidebar')
            <div class="row">
                @include('layouts.partitioner_nav')
                <div class="earning-wrrpr mt-5">
                    <div class="container">
                        <div class="d-flex mb-3" style="gap: 20px;">
                            <a href="{{ route('addOffering') }}" class="export-btn">Add Offering</a>
                        </div>
                        @if($offerings->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="thead-light">
                                    <tr>
                                        <th class="tn"><i class="wcv-icon wcv-icon-image"></i></th>
                                        <th scope="col">Detail</th>
                                        <th class="price"><i class="wcv-icon wcv-icon-shopping-cart"></i></th>
                                        <th scope="col">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($offerings as $offering)
                                        <tr>
                                            <td class="tn"></td>
                                            <td class="details">
                                                <h4>Test my offer</h4>
                                                <div class="wcv_mobile_status wcv_mobile">Online</div>
                                                <div class="wcv_mobile_price wcv_mobile">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi><span class="woocommerce-Price-currencySymbol">$</span>0.00</bdi>
                                                        </span>
                                                </div>
                                                <div class="cat_tags">
                                                    Categories:
                                                    <a href="https://thehiracollective.com/product-category/offerings/" rel="tag">Practitioner Offerings</a>
                                                    <br>
                                                    Tags:
                                                    <a href="https://thehiracollective.com/product-tag/egg/" rel="tag">Egg</a>
                                                </div>
                                                <div class="row-actions row-actions-product">
                                                    <a href="https://thehiracollective.com/dashboard/product/edit/9694">Edit</a>
                                                    <a href="https://thehiracollective.com/dashboard/product/duplicate/9694">Duplicate</a>
                                                    <a href="https://thehiracollective.com/dashboard/product/delete/9694" class="confirm_delete" data-confirm_text="Delete product?">Delete</a>
                                                    <a href="https://thehiracollective.com/product/test-my-offer/" target="_blank">View</a>
                                                </div>
                                            </td>
                                            <td class="price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi><span class="woocommerce-Price-currencySymbol">$</span>0.00</bdi>
                                                    </span>
                                            </td>
                                            <td class="status">
                                                <span class="status online">Online</span><br>
                                                <span class="product_type bookable-product">Bookable Product</span><br>
                                                <span class="product_date">January 26, 2025</span><br>
                                                <span class="stock_status"></span>
                                            </td>
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
    </section>
@endsection
