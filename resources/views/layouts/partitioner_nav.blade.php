<h1 style="text-transform: capitalize;" class="home-title mb-5">
    Welcome,<span style="color: #ba9b8b;"> {{ $user->first_name ?? 'User' }}  {{ $user->last_name ?? '' }}</span>
</h1>
<div class="col-sm-12 col-lg-5"></div>

<ul class="practitioner-profile-btns">
    <li class="{{ Request::is('my-profile') ? 'active' : '' }}">
        <a href="{{ route('my_profile') }}">
            My Profile
        </a>
    </li>
    <li class="offering {{ Request::is('offering') ? 'active' : '' }} {{ Request::is('discount') ? 'active' : '' }}">
        <a href="{{ route('offering') }}">
            Offerings
        </a>
    </li>
    <li class="{{ Request::is('appointment') ? 'active' : '' }}">
        <a href="{{ route('appointment') }}">
            Appointments
        </a>
    </li>
    <li class="{{ Request::is('calendar') ? 'active' : '' }}">
        <a href="{{ route('calendar') }}">
            Calendar
        </a>
    </li>
    <li class="offering {{ Request::is('earning') ? 'active' : '' }}">
        <a href="{{ route('accounting') }}">
            Accounting
        </a>
    </li>
</ul>
