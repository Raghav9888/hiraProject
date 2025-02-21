@extends('layouts.app')
@section('content')
    <div class="blog-section">
        <div class="blog-banner">
            <h2>Holistic Wellness Resources:</br>
                Articles, Blogs & Videos</h2>
            <p>The Collective Shelf-Care</p>
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
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                        <a href="blog-detail.html" style="text-decoration: none;">
                            <div class="resources-body">
                                <img src="../../../public/assets/images/calm.png" alt="calm">
                                <div>
                                    <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety
                                    </h5>
                                    <button>Spirituality</button>
                                    <p>February 3, 2025</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                        <div class="resources-body">
                            <img src="../../../public/assets/images/calm.png" alt="calm">
                            <div>
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                                <button>Spirituality</button>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                        <div class="resources-body">
                            <img src="../../../public/assets/images/calm.png" alt="calm">
                            <div>
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                                <button>Spirituality</button>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                        <div class="resources-body">
                            <img src="../../../public/assets/images/calm.png" alt="calm">
                            <div>
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                                <button>Spirituality</button>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button class="home-blog-btn">Load More</button>
                    </div>
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
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="resources-body">
                        <img src="../../../public/assets/images/calm.png" alt="calm">
                        <div>
                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                            <button>Spirituality</button>
                            <p>February 3, 2025</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="resources-body">
                        <img src="../../../public/assets/images/calm.png" alt="calm">
                        <div>
                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                            <button>Spirituality</button>
                            <p>February 3, 2025</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="resources-body">
                        <img src="../../../public/assets/images/calm.png" alt="calm">
                        <div>
                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                            <button>Spirituality</button>
                            <p>February 3, 2025</p>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6 mb-4">
                    <div class="resources-body">
                        <img src="../../../public/assets/images/calm.png" alt="calm">
                        <div>
                            <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                            <button>Spirituality</button>
                            <p>February 3, 2025</p>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    <button class="home-blog-btn">Load More</button>
                </div>
            </div>
        </div>
    </div>
<!-- footer start --

@endsection
