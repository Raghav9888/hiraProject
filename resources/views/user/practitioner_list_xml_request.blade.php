@foreach($practitioners as $user)

    @php
        $mediaPath = config('app.media_path', 'uploads');
                                   $localPath = config('app.local_path', 'assets');
           $images = isset($user->userDetail->images) ? json_decode($user->userDetail->images, true) : null;
           $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
           $imageUrl = $image  ? asset($mediaPath . '/practitioners/' . $user->userDetail->id . '/profile/' . $image) : asset($localPath.'/images/no_image.png');
           $userLocations = isset($user->location) && $user->location ? json_decode($user->location, true) : [];
        $averageProfileRating = $user->get()->isNotEmpty() ? number_format($user->feedback->pluck('rating')->avg(), 1) : '0.0';

    @endphp

    <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 mb-4">
        <div class="featured-dv">
            {{-- Book Now Overlay --}}
            <div class="book-now-overlay">
                <a href="{{route('practitioner_detail', $user->slug)}}">
                    <button class="book-now-btn">Book Now</button>
                </a>
            </div>

            <img src="{{ $imageUrl }}" class="img-fit" alt="person">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <h4>{{ $user->name }}</h4>
                <i class="fa-regular fa-heart"></i>
            </div>

            <h5>
                @if(!empty($userLocations))
                    @foreach($defaultLocations as $defaultLocationId => $defaultLocation)

                        @if(in_array($defaultLocationId, $userLocations))
                            <i class="fa-solid fa-location-dot"></i>
                            {{ $defaultLocation }} ,
                            @break
                        @endif
                    @endforeach
                @endif
            </h5>
            <p>{{ implode(' ', array_slice(explode(' ', strip_tags($user->userDetail->company ?? 'Alternative and Holistic Health Practitioner')), 0, 5)) . '...' }}</p>

            <div class="d-flex justify-content-between align-items-center">
                <div>
                    @for ($i = 0; $i < 5; $i++)
                        <i class="fa-regular fa-gem"></i>
                    @endfor
                </div>
                <h6>5.0 Ratings</h6>
            </div>
        </div>
    </div>
@endforeach

@if($pendingResult)
    <!-- Load More Button (Only if there are practitioners) -->
    <div class="d-flex justify-content-center mt-2">
        <button class="category-load-more loadMore"
                data-page="{{ $page + 1 }}"
                data-render="practitionerRowDiv"
                data-is-practitioner="1">
            Load More
        </button>
    </div>
@endif
