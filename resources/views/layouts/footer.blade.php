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
                            <li><i class="fa-brands fa-youtube"></i></li>
                            <li><i class="fa-brands fa-pinterest"></i></li>
                            <li><i class="fa-brands fa-facebook-f"></i></li>
                            <li><i class="fa-brands fa-instagram"></i></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <h4>Company</h4>
                        <ul>
                            <li>Press</li>
                            <li><a href="{{route('contact')}}">Contact Us</a></li>
                            <li>Our story</li>
                            <li>Our Vision</li>
                            <li>Core Values</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <h4>Support</h4>
                        <ul>
                            <li>FAQs Join as Practitioner</li>
                            <li>Terms and Conditions</li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-3 mb-4">
                    <div class="footer-lists">
                        <h4>Our Registered Office</h4>
                        <ul>
                            <li>Tower of London, London EC3N 4AB, United Kingdom.</li>
                            <li>(+84) 123 567 712</li>
                            <li>abstractjewels@gmail.com</li>
                        </ul>
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
                    <button><i class="fa-solid fa-globe"></i>English</button>
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
  notes[key].push({ time, text: noteText });

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

if(resetBtn){

    resetBtn.addEventListener("click", resetCalendar);
    monthSelect.addEventListener("change", (e) => {
    currentMonth = parseInt(e.target.value);
    renderCalendar(currentMonth);
    });
}

if(closeModal){

    closeModal.addEventListener("click", closeModalFunc);
    window.addEventListener("click", (event) => {
    if (event.target == noteModal) closeModalFunc();
    });
}

// renderCalendar(currentMonth);
});
</script>
