<!-- footer start -->
<div class="footer">
    <img class="footer-butterfly" src="{{url('./assets/images/footer-butterfly.svg')}}" alt="">
    <div class="footer-list-wrrpr">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <img src="{{url('./assets/images/footer-logo.svg')}}" alt="logo">
                        <h4>Follow Us</h4>
                        <ul class="footer-social-media-icon">
                            <li><a href="https://www.youtube.com/@TheHiraCollective" class="mb-0"> <i
                                        class="fa-brands fa-youtube"></i></a></li>
                            <li><a href="https://pin.it/3b7V2zHvv" class="mb-0"><i
                                        class="fa-brands fa-pinterest"></i></a></li>
                            {{--                            <li><i class="fa-brands fa-facebook-f"></i></li>--}}
                            <li><a href="https://www.instagram.com/thehiracollective/" class="mb-0"> <i
                                        class="fa-brands fa-instagram"></i></a></li>
                        </ul>
                    </div>
                    <form class="pt-4" id="subscribe" action="{{route('subscribe')}}">
                        @csrf
                        <div class="form-group row align-items-center">
                            <div class="col-md-9">
                                <input type="email" name="email" class="form-control rounded-4" placeholder="Enter your email" id="email" required>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-light rounded-4">Subscribe</button>
                            </div>
                        </div>
                    </form>
                    <div id="subscribe-message" class="mt-2"></div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <h4>Company</h4>
                        <ul>
                            <li>Press</li>
                            <li><a href="{{route('contact')}}">Contact Us</a></li>
                            <li><a href="{{route('our_story')}}">Our Story </a></li>
                            <li><a href="{{route('our_vision')}}">Our Vision</a></li>
                            <li><a href="{{route('core_values')}}">Core Values</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <h4>Support</h4>
                        <ul>
                            <li>
                                <a href="{{route('terms_conditions')}}">
                                    Terms and Conditions
                                </a>
                            </li>
                            <li>
                                <a href="{{route('privacy_policy')}}"> Privacy Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="position-relative mb-2">
                        <h5 class="position-absolute z-2">
                            <a href="{{route('acknowledgement') }}" class="text-white" style="font-size: 20px;
    font-weight: 600;">
                                Our Land Acknowledgement
                            </a>
                        </h5>
                    </div>
                    <div class="footer-lists pt-4">
                        <p class="text-white pt-3">
                            The Hira Collective acknowledges that we are created, built, and operating on lands that
                            have long been home to Indigenous Peoples, including the Anishi...
                        </p>
                    </div>
                </div>
            </div>
            <div class="language-translator-dv">
                <div class="row">
                    <div class="col-sm-12 col-md-10 col-lg-10">
                        <p>Use of this website, content, and products are for informational purposes only.
                            TheHiraCollective does not provide medical advice, diagnosis, or treatment.</p>
                    </div>
                    <div class="col-sm-12 col-md-2 col-lg-2">
                        <button class="mt-2"><i class="fa-solid fa-globe"></i>English</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-botom-dv-wrrpr">
        <div class="container">
            <div class="footer-botom-dv">
                <p>2025 - All Rights Reserved. <a href="#">www.thehiracollective.com</a></p>
                <ul>
                    <li>Privacy Policy</li>
                    <li>Cookie Policy</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- footer end -->
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function () {
            const output = document.getElementById('imagePreview');
            output.style.backgroundImage = `url(${reader.result})`;
            output.style.backgroundSize = 'cover';
            output.style.backgroundPosition = 'center';
            output.innerHTML = '';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const calendarGrid = document.querySelector(".calendar-grid");
        const noteModal = document.getElementById("noteModal");
        const closeModal = document.querySelector(".close");
        const selectedDateEl = document.getElementById("selectedDate");
        const timeInput = document.getElementById("time");
        const noteInput = document.getElementById("note");
        const saveNoteBtn = document.getElementById("saveNote");
        const resetBtn = document.getElementById("resetCalendar");
        const monthSelect = document.getElementById("monthSelect");
        let currentMonth = 0;
        const notes = {};

        function daysInMonth(month, year) {
            return new Date(year, month + 1, 0).getDate();
        }

        function renderCalendar(month) {
            calendarGrid.innerHTML = "";
            const days = daysInMonth(month, 2025);

            for (let i = 1; i <= days; i++) {
                const day = document.createElement("div");
                day.classList.add("day");
                day.textContent = i;
                day.setAttribute("data-day", i);

                const noteDisplay = document.createElement("div");
                noteDisplay.classList.add("note");
                day.appendChild(noteDisplay);

                day.addEventListener("click", () => openModal(month, i));
                calendarGrid.appendChild(day);

                if (notes[`${month}-${i}`]) {
                    updateNotesDisplay(month, i);
                }
            }
        }

        function openModal(month, day) {
            selectedDateEl.textContent = `Day: ${day}, ${monthSelect.options[month].text}`;
            timeInput.value = "";
            noteInput.value = "";

            noteModal.style.display = "flex";
            saveNoteBtn.onclick = () => saveNote(month, day);
        }

        function closeModalFunc() {
            noteModal.style.display = "none";
        }

        function saveNote(month, day) {
            const time = timeInput.value;
            const noteText = noteInput.value;
            const key = `${month}-${day}`;

            if (time && noteText) {
                if (!notes[key]) notes[key] = [];
                notes[key].push({time, text: noteText});

                updateNotesDisplay(month, day);
                closeModalFunc();
            } else {
                alert("Please fill out both time and note.");
            }
        }

        function updateNotesDisplay(month, day) {
            const key = `${month}-${day}`;
            const dayCell = document.querySelector(`.day[data-day='${day}'] .note`);
            dayCell.innerHTML = "";

            notes[key].forEach((note, index) => {
                const noteEntry = document.createElement("div");
                noteEntry.classList.add("note-entry");
                noteEntry.textContent = `🕒 ${note.time} - ${note.text}`;
                if (index > 0) noteEntry.style.borderTop = "1px solid #ddd";
                dayCell.appendChild(noteEntry);
            });
        }

        function resetCalendar() {
            for (let key in notes) delete notes[key];
            renderCalendar(currentMonth);
        }

        if (resetBtn) {

            resetBtn.addEventListener("click", resetCalendar);
            monthSelect.addEventListener("change", (e) => {
                currentMonth = parseInt(e.target.value);
                renderCalendar(currentMonth);
            });
        }

        if (closeModal) {

            closeModal.addEventListener("click", closeModalFunc);
            window.addEventListener("click", (event) => {
                if (event.target == noteModal) closeModalFunc();
            });
        }

// renderCalendar(currentMonth);
    });
</script>
