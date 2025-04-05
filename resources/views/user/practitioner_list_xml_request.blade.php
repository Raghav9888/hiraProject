@foreach($practitioners as $user)

    @php
        $mediaPath = config('app.media_path', 'uploads');
                                   $localPath = config('app.local_path', 'assets');
           $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
           $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
           $imageUrl = $image  ? asset($mediaPath . '/practitioners/' . $user->userDetail->id . '/profile/' . $image) : asset($localPath.'/images/no_image.png');
           $userLocations = isset($user->location) && $user->location ? json_decode($user->location, true) : [];
    @endphp

    <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
        <div class="featured-dv">
            <a href="{{route('practitioner_detail', $user->id)}}">
                <img src="{{ $imageUrl }}" alt="person" class="img-fit">
                {{--                                <label for="">0.4 Km Away</label>--}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h4>{{  $user->name }}</h4>
                    <i class="fa-regular fa-heart"></i>
                </div>
                <h5>
                    @if(!empty($userLocations))
                        @foreach($defaultLocations as $defaultLocationId => $defaultLocation)

                            @if(in_array($defaultLocationId, $userLocations))
                                <i class="fa-solid fa-location-dot"></i>
                                {{ $defaultLocation }} ,
                            @endif
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
@if(count($totalPractitioners) > 8)
    <!-- Load More Button (Only if there are practitioners) -->
    <div class="d-flex justify-content-center mt-2">
        <button class="category-load-more loadPractitioner" data-count="{{$buttonHitCount}}"
                data-render="practitionerRowDiv" data-is-practitioner="1">Load More
        </button>
    </div>
@endif
