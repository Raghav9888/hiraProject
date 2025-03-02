@extends('layouts.app')
@section('content')
    <section class="contact-us-wrrpr">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="contact-us-left-dv">
                        <img src="{{ url('./assets/images/hira-collective.svg') }}" alt="hira-collective">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="contact-us-right-dv">
                        <h3>CONTACT US</h3>
                        <form method="post" action="{{route('sendContactMail')}}">
                            @csrf()
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="first_name"
                                              name="first_name" aria-describedby="emailHelp" placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               aria-describedby="emailHelp" placeholder="Last name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter a valid email address">
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" name="subject"
                                       placeholder="Enter subject of your query/message">
                            </div>
                            <div class="mb-3">
                                <label for="message">Message</label>
                                <textarea class="form-control" placeholder="Type your message or query here"
                                          id="message" name="message"></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="send_yourself_copy" name="send_yourself_copy">
                                <label class="form-check-label mb-0 ms-2" for="exampleCheck1">Send yourself a
                                    copy</label>
                            </div>
                            <button type="submit">Search</button>
                        </form>
                        <img class="star-2" src="{{ url('./asserts/images/Star 2.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
