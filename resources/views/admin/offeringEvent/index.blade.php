@extends('admin.layouts.app')

@section('content')
    @include('admin.layouts.nav')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('admin.layouts.sidebar')
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4 class="card-title m-0">Offering Events</h4>

                                    <a href="{{route('admin.offering.create')}}" class="btn btn-primary">Add New</a>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                        <tr>
                                            <th class="tn"><i class="wcv-icon wcv-icon-image"></i></th>
                                            <th scope="col">Detail</th>
                                            <th class="price">Offering price</th>
                                            <th scope="col">Type</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($offerings as $offering)
                                            <tr>
                                                <td class="tn"></td>
                                                <td class="details">
                                                    <h4>{{ $offering->name  }}</h4>
                                                    <div
                                                        class="wcv_mobile_status wcv_mobile">{{$offering->offering_type}}</div>
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
                                                        <div class="d-flex my-4">
                                                            <a href="{{route('admin.offering.edit',$offering->id)}}" class="text-decoration-none"
                                                               style="cursor: pointer; border: none; background: none;color: #000;">Edit</a>
                                                            <form method="post"
                                                                  action="{{route('delete_offering', ['id' => $offering->id,'isAdmin' => true])}}">@csrf
                                                                <button type="submit"
                                                                        style="cursor: pointer; border: none; background: none;color: #000;">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="price">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi><span class="woocommerce-Price-currencySymbol">$</span>
                                                        {{$offering?->offering_event_type == 'event'? ( $offering?->event?->client_price ?? 0) : $offering?->client_price ?? 0 }}</bdi>
                                                </span>
                                                </td>
                                                <td>
                                                    {{$offering?->offering_event_type == 'event' ? 'Event' : 'Offering'}}
                                                </td>

                                                <td class="status">
                                                    <span class="status online">Online</span><br>
                                                    <span
                                                        class="product_type bookable-product">Bookable Product</span><br>
                                                    <span
                                                        class="product_date">{{ $offering->created_at->format('F j, Y') }}</span><br>
                                                    <span class="stock_status"></span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer bg-white text-end">
                                <div class="d-flex justify-content-end">
                                    {!! $offerings->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
