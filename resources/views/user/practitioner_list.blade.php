@extends('layouts.app')

@section('content')
    <section class="featured-section">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 class="home-title">Practitioners</h1>
                </div>
{{--                <div class="col-md-4">--}}
{{--                    <select class="form-select" id="category" aria-label="Default select example"--}}
{{--                            style="border-radius: 30px !important;padding: 10px 15px 10px 40px;text-align: start;">--}}
{{--                        <option class="selected-category">Select by Categories</option>--}}
{{--                        @foreach($categories as $category)--}}
{{--                            <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
{{--                            <option>--}}
{{--                                <hr>--}}
{{--                            </option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                </div>--}}
            </div>

            <div class="row" id="practitionersList">
                @foreach($users as $user)

                    @php
                        $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
                        $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
                        $imageUrl = $image  ? asset(env('media_path') . '/practitioners/' . $user->userDetail->id . '/profile/' . $image) : asset(env('local_path').'/images/no_image.png');
                    @endphp

                    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                        <div class="featured-dv">
                            <a href="{{route('practitioner_detail', $user->id)}}">
                                <img src="{{ $imageUrl }}" alt="person">
                                {{--                                <label for="">0.4 Km Away</label>--}}
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h4>{{  $user->name }}</h4>
                                    <i class="fa-regular fa-heart"></i>
                                </div>
                                <h5>

                                    @php
                                        $locations = isset($user->location) && $user->location ? json_decode($user->location, true) : null;
                                    @endphp
                                    @if($locations)
                                        @foreach($locations as $location)
                                            <i class="fa-solid fa-location-dot"></i>  {{ $location .',' }}
                                        @endforeach
                                    @endif
                                </h5>
{{--                                <p>Alternative and Holistic Health Practitioner</p>--}}
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                        <i class="fa-regular fa-gem"></i>
                                    </div>
                                    <h6>5.0 Ratings</h6>
                                </div>
                            </a>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        {{--        <div class="d-flex justify-content-center mt-2">--}}
        {{--            <button class="category-load-more">Load More</button>--}}
        {{--        </div>--}}
    </section>
@endsection
