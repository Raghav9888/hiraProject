<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'thehiracollective') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ url('./assets/images/header-logo.svg') }}">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?time={{ now()->timestamp }}">
    <link rel="stylesheet" href="{{ asset('assets/css/calendar.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="{{ asset('assets/plugin/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugin/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css') }}">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.css"/>
    <!-- Add the slick-theme.css if you want default styling -->
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick-theme.css"/>
    <script type="text/javascript" src="//cdn.jsdelivr.net/gh/kenwheeler/slick@1.8.1/slick/slick.min.js"></script>
    <script src="{{ asset('assets/plugin/OwlCarousel2-2.3.4/dist/owl.carousel.js') }}"></script>
    {{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}
</head>
<body>
@include('layouts.header')
<div id="app">
    <main class="">
        @yield('content')
    </main>
</div>
<!-- Popup Modal -->
<div class="modal fade" id="userPopup" tabindex="-1" aria-labelledby="userPopupLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userPopupLabel">Welcome To Hira Collective News Letter</h5>
            </div>
            <div class="modal-body">
                <form id="popupForm">
                    @csrf
                    <div class="mb-3">
                        <label for="popupName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="popupName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="popupEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="popupEmail" name="email" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="cancelPopup" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="popupForm" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

@include('layouts.footer')
@stack('custom_scripts')
<script type="module">

    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            items: 6,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 3000,
            nav: true,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 2
                },
                1000: {
                    items: 6
                }
            }
        });

        // Ensure manual click on navigation arrows works
        $(".owl-prev").click(function() {
            $(".owl-carousel").trigger('prev.owl.carousel');
        });

        $(".owl-next").click(function() {
            $(".owl-carousel").trigger('next.owl.carousel');
        });
    });



    $(".select2").select2({
        /* maximumSelectionLength: 2 */
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const select = document.getElementById("timezone");
        const timezones = Intl.supportedValuesOf("timeZone"); // Get all supported timezones

        if(select){
            timezones.forEach(zone => {
                let option = document.createElement("option");
                option.value = zone;
                option.textContent = zone;
                select.appendChild(option);
            });
            // Auto-select user's timezone
            select.value = Intl.DateTimeFormat().resolvedOptions().timeZone;
        }
    });


</script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.loadingScreen.addPageLoading();
    });
</script>

<script>
    // Optional: Clear all cookies (only use in dev/testing)
    // document.cookie.split(";").forEach(cookie => {
    //     const eqPos = cookie.indexOf("=");
    //     const name = eqPos > -1 ? cookie.substr(0, eqPos).trim() : cookie.trim();
    //     document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;path=/";
    // });

    // Get a cookie by name
    function getCookie(name) {
        return document.cookie
            .split('; ')
            .find(row => row.startsWith(name + '='))?.split('=')[1];
    }

    // Set cookie with ISO timestamp value and 10-year expiry
    function setNewsLetterCookie() {
        const now = new Date().toISOString(); // Current time in ISO format
        const expires = new Date();
        expires.setFullYear(expires.getFullYear() + 10); // 10 years ahead
        document.cookie = `newsLetters=${now}; expires=${expires.toUTCString()}; path=/`;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Show popup if 'newsLetter' cookie is not set
        if (!getCookie('newsLetter')) {
            const myModal = new bootstrap.Modal(document.getElementById('userPopup'));
            myModal.show();
        }

        // Handle newsletter form submission
        const form = document.getElementById('popupForm');
        if (form) {
            form.addEventListener('submit', async function (e) {
                e.preventDefault();

                const name = document.getElementById('popupName').value;
                const email = document.getElementById('popupEmail').value;

                try {
                    const response = await fetch('/news-letter', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ name, email })
                    });

                    const result = await response.json();

                    // Set the cookie
                    setNewsLetterCookie();

                    // Hide modal
                    const modalInstance = bootstrap.Modal.getInstance(document.getElementById('userPopup'));
                    modalInstance.hide();
                } catch (error) {
                    console.error('Error submitting form:', error);
                }
            });
        }

        // Handle cancel button
        const cancelBtn = document.getElementById('cancelPopup');
        if (cancelBtn) {
            cancelBtn.addEventListener('click', function () {
                setNewsLetterCookie();

                const modalInstance = bootstrap.Modal.getInstance(document.getElementById('userPopup'));
                modalInstance.hide();
            });
        }
    });
</script>







<script  src="{{ asset('assets/js/loader.js') }}"></script>
<script  src="{{ asset('assets/js/script.js') }}"></script>
<script src="{{ asset('assets/js/calendar.js') }}"></script>
<script src="{{ asset('assets/js/booking_calendar.js') }}"></script>
<script src="{{ asset('assets/js/search.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/6.0.0/bootbox.min.js" integrity="sha512-oVbWSv2O4y1UzvExJMHaHcaib4wsBMS5tEP3/YkMP6GmkwRJAa79Jwsv+Y/w7w2Vb/98/Xhvck10LyJweB8Jsw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        window.loadingScreen.removeLoading();
    });
</script>
</body>
</html>
