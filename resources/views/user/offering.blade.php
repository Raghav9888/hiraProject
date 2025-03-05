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
                    <a href="{{ route('discount') }}" class="category-load-more">Add Discount</a>
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
                                                <div class="cat_tags">
                                                    Categories:@foreach($categories as $term)
                                                        @if(isset($offering->categories) && in_array($term->id, json_decode($offering->categories)))
                                                            {{ $term->name }} ,
                                                        @endif
                                                    @endforeach
                                                    <br>

                                                    Tags:
                                                    @foreach([['id' => '156', 'name' => 'energybalancing'], ['id' => '2991', 'name' => 'ASD']] as $tag)
                                                        @if(isset($offering->tags) && in_array($tag['id'], json_decode($offering->tags)))
                                                            {{ $tag['name'] }}{{ !$loop->last ? ', ' : '' }}
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <div class="row-actions row-actions-product">
                                                    <div class="d-flex">
                                                        <a href="{{route('edit_offering',$offering->id)}}">Edit</a>
                                                        <form method="post" action="{{route('duplicate_offering',$offering->id)}}">@csrf
                                                            <button type="submit" style="cursor: pointer; border: none; background: none;color: #000;">Duplicate</button>
                                                        </form>
                                                        {{--                                                    <a href="https://thehiracollective.com/dashboard/product/duplicate/9694">Duplicate</a>--}}
                                                        <form method="post" action="{{route('delete_offering', $offering->id)}}">@csrf
                                                            <button type="submit" style="cursor: pointer; border: none; background: none;color: #000;">Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>{{ $offering->client_price ?? 0 }}</bdi>
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
                {{--                <button type="submit" class="category-load-more">Submit</button>--}}
            </div>
        </div>
    </section>

    <script>
        function deleteOffering(id) {
            if (confirm("Are you sure you want to delete this?")) {
                fetch(`/offering/delete/${id}/`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    }
                }).then(response => response.json())
                    .then(data => {
                        location.reload();
                    }).catch(error => console.error("Error:", error));
            }
        }

    </script>
@endsection
