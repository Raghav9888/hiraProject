@if($endorsedUsers)
    @foreach($endorsedUsers as $endorsedUser)
        @php
            $images = isset($endorsedUser->userDetail->images) ? json_decode($endorsedUser->userDetail->images, true) : null;
            $image = isset($images['profile_image']) && $images['profile_image'] ? $images['profile_image'] : null;
            $imageUrl = $image  ? asset(env('media_path') . '/practitioners/' . $endorsedUser->userDetail->id . '/profile/' . $image) : asset(env('local_path').'/images/no_image.png');
        @endphp

        <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
            <div class="featured-dv">
                <a href="{{route('practitioner_detail', $endorsedUser->id)}}">
                    <img src="{{ $imageUrl }}" alt="person" class="img-fluid">
                    {{--                                <label for="">0.4 Km Away</label>--}}
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h4>{{  $endorsedUser->name }}</h4>
                        <i class="fa-regular fa-heart"></i>
                    </div>
                    <h5>

                        @php
                            $endorsedUserLocations = isset($endorsedUser->location) && $endorsedUser->location ? json_decode($endorsedUser->location, true) : [];
                        @endphp

                        @if(!empty($endorsedUserLocations))
                            @foreach($endorsedUserLocations as $endorsedUserLocation)
                                @foreach($defaultLocations as $key => $defaultLocation)
                                    @if(in_array($key, $endorsedUserLocations))
                                        <i class="fa-solid fa-location-dot"></i> {{ $defaultLocation }}
                                        ,
                                    @endif
                                @endforeach
                            @endforeach
                        @endif


                    </h5>
                    <p style="display: inline; text-align: center">{{$endorsedUser->userDetail->company}}</p>
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
@endif
