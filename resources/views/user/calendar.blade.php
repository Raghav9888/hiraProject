
@extends('layouts.app')
@section('content')
<section class="practitioner-profile">
        <div class="container">
            <div class="row">
            @include('layouts.partitioner_nav')
                <h5 class="practitioner-profile-text mb-2 mt-5">Booking Calendar</span></h5>
                <div class="calendar">
                    <div class="controls">
                      <select id="monthSelect">
                        <option value="0">January</option>
                        <option value="1">February</option>
                        <option value="2">March</option>
                        <option value="3">April</option>
                        <option value="4">May</option>
                        <option value="5">June</option>
                        <option value="6">July</option>
                        <option value="7">August</option>
                        <option value="8">September</option>
                        <option value="9">October</option>
                        <option value="10">November</option>
                        <option value="11">December</option>
                      </select>
                      <button id="resetCalendar">Reset Calendar</button>
                    </div>
                    <div class="calendar-grid">
                    </div>
                  </div>
                
                  <div id="noteModal" class="modal">
                    <div class="modal-content">
                      <span class="close">&times;</span>
                      <h3>Add Note</h3>
                      <p id="selectedDate"></p>
                      <label for="time">Select Time:</label>
                      <input type="time" id="time" required>
                      <label for="note">Note:</label>
                      <textarea id="note" rows="2" placeholder="Enter your note..."></textarea>
                      <button id="saveNote">Save Note</button>
                    </div>
                  </div>
            </div>
        </div>
        <div class="positioned-dv">
            <ul>
                <li>
                    <img src="./asserts/User.svg" alt="">
                    <p>Account</p>
                </li>
                <li>
                    <img src="./asserts/grid.svg" alt="">
                    <p>Dashboard</p>
                </li>
                <li>
                    <img src="./asserts/calendar.svg" alt="">
                    <p>Calendar</p>
                </li>
                <li>
                    <img src="./asserts/Shopping List.svg" alt="">
                    <p>Bookings</p>
                </li>
                <li>
                    <img src="./asserts/Chat.svg" alt="">
                    <p>Community</p>
                </li>
                <li>
                    <img src="./asserts/business.svg" alt="">
                    <p>Business<br />
                        Referals</p>
                </li>
            </ul>
        </div>
    </section>

    @endsection