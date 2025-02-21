@extends('layouts.app')
@section('content')
    <section class="contact-us-wrrpr">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="contact-us-left-dv">
                        <img src="./asserts/hira-collective.svg" alt="hira-collective">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="contact-us-right-dv">
                        <h3>Contact US</h3>
                        <form>
                            <div class="row">
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="exampleInputEmail1" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1"
                                               aria-describedby="emailHelp" placeholder="Last name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Email</label>
                                <input type="email" class="form-control" id="exampleInputPassword1"
                                       placeholder="Enter a valid email address">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">Subject</label>
                                <input type="email" class="form-control" id="exampleInputPassword1"
                                       placeholder="Enter Subject of your query/message">
                            </div>
                            <div class="mb-3">
                                <label for="floatingTextarea">Message</label>
                                <textarea class="form-control" placeholder="Type your message or query here"
                                          id="floatingTextarea"></textarea>
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                <label class="form-check-label mb-0 ms-2" for="exampleCheck1">Send yourself a
                                    copy</label>
                            </div>
                            <button type="submit">Search</button>
                        </form>
                        <img class="star-2" src="./asserts/Star 2.svg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
