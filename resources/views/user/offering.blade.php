@extends('layouts.app')

@section('content')
    <section class="practitioner-profile">
        @include('layouts.partitioner_sidebar')
        <div class="container">
            <div class="row">
                @include('layouts.partitioner_nav')
            </div>
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
                <p style="text-align: start;" class="mb-3">All offering must be shared on your Hira collective
                    profile.</p>
                <div class="offering-btn-drop mb-4">
                    <a href="{{ route('add_offering') }}" class="category-load-more">Add Offering</a>
                    <div class="dropdown">
                        <button class="dropdown-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                           Discount
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">All offering</a></li>
                            <li><a class="dropdown-item" href="#">Specific offering</a></li>
                        </ul>
                    </div>
                </div>

                <div class="earning-wrrpr mt-5">
                    <div class="container">
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
                                                <h4>{{ $offering->name  }}</h4>
                                                <div class="wcv_mobile_status wcv_mobile">Online</div>
                                                <div class="wcv_mobile_price wcv_mobile">
                                                        <span class="woocommerce-Price-amount amount">
                                                            <bdi><span class="woocommerce-Price-currencySymbol">$</span>{{ $offering->cost ?? 0 }}</bdi>
                                                        </span>
                                                </div>
                                                <div class="cat_tags">
                                                    Categories:
                                                    <a href="https://thehiracollective.com/product-category/offerings/"
                                                       rel="tag">{{ $offering->categories }}</a>
                                                    <br>
                                                    Tags:
                                                    <a href="https://thehiracollective.com/product-tag/egg/"
                                                       rel="tag">{{$offering->tags}}</a>
                                                </div>
                                                <div class="row-actions row-actions-product">
                                                    <a href="{{route('update_offering',$offering->id)}}">Edit</a>
                                                    <a href="https://thehiracollective.com/dashboard/product/duplicate/9694">Duplicate</a>
                                                    <a href="https://thehiracollective.com/dashboard/product/delete/9694"
                                                       class="confirm_delete"
                                                       data-confirm_text="Delete product?">Delete</a>
                                                    <a href="{{route('show_offering', $offering->id)}}"
                                                       target="_blank">View</a>
                                                </div>
                                            </td>
                                            <td class="price">
                                                    <span class="woocommerce-Price-amount amount">
                                                        <bdi><span class="woocommerce-Price-currencySymbol">$</span>{{ $offering->cost ?? 0 }}</bdi>
                                                    </span>
                                            </td>
                                            <td class="status">
                                                <span class="status online">Online</span><br>
                                                <span class="product_type bookable-product">Bookable Product</span><br>
                                                <span
                                                    class="product_date">{{ $offering->created_at->format('F j, Y') }}</span><br>
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
                <button type="submit" class="category-load-more">Submit</button>
            </div>
        </div>
    </section>
@endsection
