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
                                               name="first_name" placeholder="First name">
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-6 col-lg-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                               placeholder="Last name">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       placeholder="Enter a valid email address">
                            </div>
                            <div class="mb-3">
                                <label for="support_type" class="form-label">Support Type</label>
                                <select name="support_type" id="support_type" class="form-select">
                                    <option value="booking_support">Booking support</option>
                                    <option value="technical_support">Technical support</option>
                                </select>
                            </div>
                            <div class="mb-3" id="support_category_section">
                                <label class="form-label">Support Category</label>

                                <select name="support_booking_category" class="form-select d-none" id="subject_booking_input_category">
                                    <option value=" ">Select booking category</option>
                                    <option value="booking_link">Booking link</option>
                                    <option value="email">Email</option>
                                </select>

                                <select name="support_technical_category" class="form-select d-none" id="support_technical_category">
                                    <option value=" ">Select technical category</option>
                                    <option value="whatsapp_number">Whatsapp Number</option>
                                    <option value="email">Email</option>
                                </select>
                            </div>
                            <div class="mb-3 d-none" id="booking_link_section">
                                <label class="form-label">Booking Link</label>
                            </div>
                            <div class="mb-3 d-none" id="whatsapp_link_section">
                                <label class="form-label">WhatsApp Number</label>
                            </div>
                            <div class="mb-3 d-none" id="subject_section">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" name="subject" placeholder="Enter subject">
                            </div>
                            <div class="mb-3 d-none" id="message_section">
                                <label for="message">Message</label>
                                <textarea class="form-control" placeholder="Type your message here" name="message"></textarea>
                            </div>
                            <div class="mb-3 form-check d-none" id="copy_section">
                                <input type="checkbox" class="form-check-input" name="send_yourself_copy">
                                <label class="form-check-label">Send yourself a copy</label>
                            </div>
                            <button type="submit" class="d-none" id="submit_section"> Send message</button>
                        </form>
                        <img class="star-2" src="{{ url('./assets/images/Star 2.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const supportType = document.getElementById("support_type");
            const bookingCategory = document.getElementById("subject_booking_input_category");
            const technicalCategory = document.getElementById("support_technical_category");
            const bookingLinkSection = document.getElementById("booking_link_section");
            const whatsappLinkSection = document.getElementById("whatsapp_link_section");
            const subjectSection = document.getElementById("subject_section");
            const messageSection = document.getElementById("message_section");
            const copySection = document.getElementById("copy_section");
            const submitSection = document.getElementById("submit_section");

            function resetFields() {
                bookingCategory.classList.add("d-none");
                technicalCategory.classList.add("d-none");
                bookingLinkSection.classList.add("d-none");
                whatsappLinkSection.classList.add("d-none");
                subjectSection.classList.add("d-none");
                messageSection.classList.add("d-none");
                copySection.classList.add("d-none");
                submitSection.classList.add("d-none");

                // Reset dropdown selections when switching categories
                bookingCategory.value = " ";
                technicalCategory.value = " ";
            }

            function updateFields() {
                resetFields();

                if (supportType.value === "booking_support") {
                    bookingCategory.classList.remove("d-none");
                } else if (supportType.value === "technical_support") {
                    technicalCategory.classList.remove("d-none");
                }
            }

            function updateDetails() {
                const selectedBookingCategory = bookingCategory.value;
                const selectedTechnicalCategory = technicalCategory.value;

                // Reset all sections before applying new logic
                bookingLinkSection.classList.add("d-none");
                whatsappLinkSection.classList.add("d-none");
                subjectSection.classList.add("d-none");
                messageSection.classList.add("d-none");
                copySection.classList.add("d-none");
                submitSection.classList.add("d-none");

                if (selectedBookingCategory === "email" || selectedTechnicalCategory === "email") {
                    subjectSection.classList.remove("d-none");
                    messageSection.classList.remove("d-none");
                    copySection.classList.remove("d-none");
                    submitSection.classList.remove("d-none");
                } else if (selectedBookingCategory === "booking_link") {
                    bookingLinkSection.classList.remove("d-none");
                } else if (selectedTechnicalCategory === "whatsapp_number") {
                    whatsappLinkSection.classList.remove("d-none");
                }
            }

            supportType.addEventListener("change", function () {
                updateFields();
                updateDetails(); // Ensure correct categories are handled
            });

            bookingCategory.addEventListener("change", updateDetails);
            technicalCategory.addEventListener("change", updateDetails);

            updateFields(); // Initialize correctly on page load
        });
    </script>

@endsection
