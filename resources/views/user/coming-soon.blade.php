@extends('layouts.app')
@section('content')
<section class="coming-soon-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="content-inner">
                    <h2 class="coming-title">Let’s Transform The Way We Access Holistic Practitioners</h2>
                    <h5 class="coming-subtitle">The Hira Collective is creating ease in the way we seek holistic practitioners, heal in community & honour traditional modalities.</h5>
                    <h5 class="coming-subtitle fw-bold">Change is long overdue.</h5>
                    <p class="coming-content">
                        The Hira Collective Empowers you to <span class="fw-bold">Access over 50+ Trusted Holistic, Wellness, Mystic Arts Practitioners and Coaches</span> who Honor the Ancestral Roots and Lineage of the Modalities they share.
                    </p>
                    <p class="coming-content">
                        Using our user-friendly platform, you can search by modality, ailment or symptom to book with a practitioner and find resources, simplifying your journey to support that is aligned.
                    </p>
                    <p class="coming-content fw-bold">
                        Our community fosters a deep sense of belonging, connection, empowerment and growth.
                    </p>
                    <div class="coming-form-container">
                        <form method="POST" id="coming-form">
                            <h3 class="form-title">Let's Raise Consciousness</h3>
                            <div class="form-group">
                                <input type="text" class="form-control" name="first_name" placeholder="First Name">
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email">
                            </div>
                            <p class="form-text">You can unsubscribe anytime. For more details, review our <a href="https://thehiracollective.com/privacy-policy/" target="_blank">Privacy Policy</a>.</p>
                            <button class="theme-btn" type="submit">Subscribe</button>
                        </form>
                    </div>
                    <div class="apply-practitioner-btn-container">
                        <a href="https://thehiracollective.my.canva.site/information-page" target="_blank" class="apply-prac-btn">Apply To Be a Practitioner</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="coming-content-img">
                    <img src="{{asset('assets/images/coming-soon.png')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('custom_scripts')
<script>
    $(document).ready(function() {
        $("#coming-form").submit(function(e) {
            e.preventDefault(); // Prevent default form submission

            let formData = $(this).serialize(); // Serialize form data

            $.ajax({
                url: "{{route('subscribe')}}", // Replace with your actual endpoint
                type: "POST",
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if(response.success){
                        alert("Subscribed successfully!"); // Success message
                        $("#coming-form")[0].reset(); // Reset form fields
                    }
                },
                error: function(xhr, status, error) {
                    alert("Something went wrong. Please try again."); // Error message
                }
            });
        });
    });
</script>
    
@endpush