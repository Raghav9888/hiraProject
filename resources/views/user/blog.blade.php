@extends('layouts.app')
@section('content')
    <div class="blog-section">
        <div class="blog-banner">
            <h2>Holistic Wellness Resources:</br>
                Articles, Blogs & Videos</h2>
            <p>THE COLLECTIVE SHELF-CARE</p>
            <div class="search-container location-input">
                <input type="text" class="search-input" placeholder="Search Articles, Blogs and Videos">
                <button class="search-button">
                    <i class="fas fa-search"></i>
                </button>
                <button class="blog-search-btn">Search</button>
            </div>
        </div>
        <div class="recent-resources">
            <div class="container">
                <h1 class="home-title mb-3">Recent Resources</h1>

                <div class="row">
                    <div class="col-md-12 text-center">
                        <h3>Coming soon...</h3>
                    </div>
{{--                    @if(!$blogs->isEmpty())--}}
{{--                        @foreach($blogs as $blog)--}}

{{--                            <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                                <a href="{{route('blogDetail', $blog->slug)}}" style="text-decoration: none;"--}}
{{--                                   class="resources-body">--}}
{{--                                    <div class="row g-0">--}}
{{--                                        <div class="col-md-4 px-2">--}}
{{--                                            @php--}}
{{--                                                $mediaPath = config('app.media_path', 'uploads');--}}
{{--                                                $localPath = config('app.local_path', 'assets');--}}

{{--                                                $imageUrl = $blog->image--}}
{{--                                                    ? asset("$mediaPath/admin/blog/{$blog->image}")--}}
{{--                                                    : asset("$localPath/images/no_image.png");--}}

{{--                                            @endphp--}}



{{--                                            <img src="{{$imageUrl}}" alt="calm" height="160" width="160" class="rounded-4">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-8">--}}
{{--                                            <div class="card-body">--}}
{{--                                                <h5>{{$blog->name}}</h5>--}}
{{--                                                <button>{{@$blog->category->name}}</button>--}}
{{--                                                <p>{{date('M d, Y', strtotime($blog->date))}}</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}

{{--                                </a>--}}
{{--                            </div>--}}
{{--                        @endforeach--}}
{{--                    @else--}}
{{--                        <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                            <p class="text-center">No Blogs found..</p>--}}
{{--                        </div>--}}
{{--                    @endif--}}
{{--                     <div class="d-flex justify-content-center">--}}
{{--                        <button class="home-blog-btn">Load More</button>--}}
{{--                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="blog-category-wrrpr blog-section">
        <div class="container">
            <h1 class="home-title mb-3">Categories</h1>
            <div class="owl-carousel">
                <div class="item">Yoga Tips</div>
                <div class="item">Health & Fitness</div>
                <div class="item">Spirituality</div>
                <div class="item active-dv">All Blogs & Articles</div>
                <div class="item">Meditation</div>
                <div class="item">Nutrition</div>
                <div class="item">Energy Healing</div>
            </div>
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3>Coming soon...</h3>
                </div>

{{--                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                    <div class="resources-body">--}}
{{--                        <img src="{{url('assets/images/calm.png')}}" alt="calm">--}}
{{--                        <div>--}}
{{--                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>--}}
{{--                            <button>Spirituality</button>--}}
{{--                            <p>February 3, 2025</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                    <div class="resources-body">--}}
{{--                        <img src="{{url('assets/images/calm.png')}}" alt="calm">--}}
{{--                        <div>--}}
{{--                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>--}}
{{--                            <button>Spirituality</button>--}}
{{--                            <p>February 3, 2025</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                    <div class="resources-body">--}}
{{--                        <img src="{{url('assets/images/calm.png')}}" alt="calm">--}}
{{--                        <div>--}}
{{--                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>--}}
{{--                            <button>Spirituality</button>--}}
{{--                            <p>February 3, 2025</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">--}}
{{--                    <div class="resources-body">--}}
{{--                        <img src="{{url('assets/images/calm.png')}}" alt="calm">--}}
{{--                        <div>--}}
{{--                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>--}}
{{--                            <button>Spirituality</button>--}}
{{--                            <p>February 3, 2025</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="d-flex justify-content-center">--}}
{{--                    <button class="home-blog-btn">Load More</button>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
<!-- footer start --

@endsection
