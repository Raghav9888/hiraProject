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
            
            <div class="you-are-here-container">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12 mb-5">
                        <h4 class="container-title">You Are Here. And That Is Everything.</h4>
                        <p class="container-p">This choice—to care for yourself—is an act of love.<br>
                            This moment—this choice—is a revolution.<br>
                            When you nurture your well-being, you create space for more ease, more connection, more possibility. Healing is not just personal; it’s a ripple, reaching far beyond you.<br>
                            Take a breath. Feel that? You are exactly where you need to be.<br>
                            While you wait for your session, we invite you to explore and nourish yourself further:</p>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/youtube-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Gentle Guidance and Meditations</h6>
                            <p>Grounding practices and wisdom from our practitioners on YouTube. </p>
                            <a href="#" class="theme-btn">Go to Youtube</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-5">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/book-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Read, Reflect, Expand</h6>
                            <p>Explore articles & blogs on healing, growth, and transformation. </p>
                            <a href="#" class="theme-btn">Read Our Articles</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/flower-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Our Heartbeat</h6>
                            <p>Learn more about the vision and values that guide us. </p>
                            <a href="#" class="theme-btn">Read Our Story</a>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6 col-lg-6 mb-3">
                        <div class="choose-us-dv ">
                            <div class="choose-us-img-dv">
                                <img src="{{url('/assets/images/insta-icon.svg')}}" alt="">
                            </div>
                            <h6 class="mb-2">Come sit with us</h6>
                            <p>Find us on Instagram, where we gather, uplift, and grow together. </p>
                            <a href="#" class="theme-btn">View Our Instagram</a>
                        </div>
                    </div>
                    <div class="col-12">
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
