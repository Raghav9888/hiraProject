@extends('layouts.app')

@section('content')
    <!-- choose us section start -->
    <section>
        <div class="container">
            <div class="why-us-wrrpr">
                <a href="{{asset('')}}" class="go-home"><i class="fa-solid fa-arrow-left-long"></i> Go to Homepage</a>
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-5">
                        <div class="choose-us-dv session-confirm-container">
                            <div class="choose-us-img-dv">
                                <img src="{{ url('./assets/images/dark-logo.svg') }}" alt="">
                            </div>
                            <h6>Your session is confirmed.</h6>
                            <p>A confirmation of your booking has been sent to your email address. </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h4 class="container-title">While you wait for your session, we invite you to explore and nourish yourself further:</h4>
                </div>
            </div>
            <div class="upcoming-event-container position-relative">
                <h4>Upcoming Events</h4>
                <div class="upcoming-event-inner upcoming-events-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>1 Wisdom of Mindfulness Practice for Anxiety</h5>
                                <p>February 3, 2025 5:00PM</p>
                                <a href="#">Notify Me</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>2 Wisdom of Mindfulness Practice for Anxiety</h5>
                                <p>February 3, 2025 5:00PM</p>
                                <a href="#">Notify Me</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>3 Wisdom of Mindfulness Practice for Anxiety</h5>
                                <p>February 3, 2025 5:00PM</p>
                                <a href="#">Notify Me</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>4 Wisdom of Mindfulness Practice for Anxiety</h5>
                                <p>February 3, 2025 5:00PM</p>
                                <a href="#">Notify Me</a>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>5 Wisdom of Mindfulness Practice for Anxiety</h5>
                                <p>February 3, 2025 5:00PM</p>
                                <a href="#">Notify Me</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev-event"><i class="fa-solid fa-arrow-left-long"></i></div>
                <div class="swiper-button-next-event"><i class="fa-solid fa-arrow-right-long"></i></div>
            </div>
            <div class="upcoming-event-container position-relative">
                <h4>Related Articles</h4>
                <div class="upcoming-event-inner related-article-slider">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                                <a href="#">Meditation</a>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>Embarking on a Sacred Journey: How to Start Your Holistic Healing Adventure </h5>
                                <a href="#">Meditation</a>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety</h5>
                                <a href="#">Meditation</a>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="slider-img">
                                <img src="{{asset('assets/images/blog.png')}}" alt="calm" class="img-fluid">
                            </div>
                            <div class="card-body">
                                <h5>Finding Calm in Chaos: The Ancient Wisdom of Mindfulness Practices for Anxiety<</h5>
                                <a href="#">Meditation</a>
                                <p>February 3, 2025</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="swiper-button-prev"><i class="fa-solid fa-arrow-left-long"></i></div>
                <div class="swiper-button-next"><i class="fa-solid fa-arrow-right-long"></i></div>
            </div>
            
            <div class="you-are-here-container">
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-5">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/youtube-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Gentle Guidance and Meditations</h6>
                            <p>Grounding practices and wisdom from our practitioners on YouTube. </p>
                            <a href="#" class="theme-btn">Go to Youtube</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/flower-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Our Heartbeat</h6>
                            <p class="mb-4">Learn more about the vision and values that guide us. </p>
                            <a href="#" class="theme-btn">Read Our Story</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4 mb-3">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/insta-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Come sit with us</h6>
                            <p class="mb-3">Find us on Instagram, where we gather, uplift, and grow together. </p>
                            <a href="#" class="theme-btn">View Our Instagram</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-12 ">
                        <p class="container-p">This choice—to care for yourself—is an act of love.<br>
                            This moment—this choice—is a revolution.<br><br>
                            When you nurture your well-being, you create space for more ease, more connection, more possibility. Healing is not just personal; it’s a ripple, reaching far beyond you.<br><br>
                            Take a breath. Feel that? You are exactly where you need to be.<br><br></p>
                            <p class="container-p">You are seen. You are supported. You are part of something beautiful.<br>
                                This is your time. And we are honoured to witness you in it.<br><br>
                                
                                With love,<br>
                                <span>The Hira Collective</span>
                                </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- choose us section end -->
@endsection

@push('custom_scripts')
<script>
    var swiper = new Swiper(".upcoming-events-slider", {
        spaceBetween: 30,
        slidesPerGroup: 1, // Moves 2 slides at a time
        loop: true, // Enables infinite looping
        autoplay: {
            delay: 3000, // Auto slide every 3 seconds
            disableOnInteraction: false, // Keep autoplay running after interaction
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 2.5,
                spaceBetween: 30,
            },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next-event",
            prevEl: ".swiper-button-prev-event",
        },
    });
    var swiper = new Swiper(".related-article-slider", {
        spaceBetween: 30,
        slidesPerGroup: 1, // Moves 2 slides at a time
        loop: true, // Enables infinite looping
        // autoplay: {
        //     delay: 3000, // Auto slide every 3 seconds
        //     disableOnInteraction: false, // Keep autoplay running after interaction
        // },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 30,
            },
            1024: {
                slidesPerView: 2.5,
                spaceBetween: 30,
            },
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
    });
</script>
    
@endpush
